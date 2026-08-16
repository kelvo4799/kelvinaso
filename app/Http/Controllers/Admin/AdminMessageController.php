<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminMessageController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        $query = Contact::query()->orderBy('created_at', 'desc');

        // Search Filter
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status') && in_array($request->input('status'), ['unread', 'read', 'replied'], true)) {
            $query->where('status', $request->input('status'));
        }

        $messages = $query->paginate(12)->withQueryString();

        $stats = [
            'countAll' => Contact::count(),
            'countUnread' => Contact::where('status', 'unread')->count(),
            'countRead' => Contact::where('status', 'read')->count(),
            'countReplied' => Contact::where('status', 'replied')->count(),
        ];

        return view('admin.messages', compact('page', 'profile', 'messages', 'stats'));
    }

    public function show($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        $message = Contact::with('replies')->findOrFail($id);

        // Auto mark unread message as read upon opening
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }

        return view('admin.message_detail', compact('page', 'profile', 'message'));
    }

    public function reply(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $adminUser = Auth::user();

        // 1. Create reply record in contact_replies table
        ContactReply::create([
            'contact_id' => $contact->id,
            'sender_type' => 'admin',
            'sender_name' => $adminUser->name ?? 'Portfolio Admin',
            'sender_email' => $adminUser->email ?? 'admin@portfolio.com',
            'message' => $validated['message'],
            'sent_via_email' => true,
        ]);

        // 2. Mark contact status as replied
        $contact->update([
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        // 3. Attempt email dispatch
        $sentEmail = false;
        try {
            $subject = 'Re: '.($contact->subject ?: 'Your inquiry');
            Mail::raw($validated['message'], function ($mail) use ($contact, $subject, $adminUser) {
                $mail->to($contact->email, $contact->name)
                     ->subject($subject);
                if ($adminUser && $adminUser->email) {
                    $mail->replyTo($adminUser->email, $adminUser->name);
                }
            });
            $sentEmail = true;
        } catch (\Exception $e) {
            logger()->error('Failed sending reply email: '.$e->getMessage());
        }

        $flashMsg = $sentEmail
            ? 'Reply sent via email and added to conversation history.'
            : 'Reply saved to conversation history.';

        return redirect()->route('messages.show.admin', $contact->id)->with('success', $flashMsg);
    }

    public function updateStatus(Request $request, $id)
    {
        $message = Contact::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $updateData = ['status' => $validated['status']];
        if ($validated['status'] === 'replied' && ! $message->replied_at) {
            $updateData['replied_at'] = now();
        }

        $message->update($updateData);

        return redirect()->back()->with('success', 'Message status updated successfully.');
    }

    public function destroy($id)
    {
        $message = Contact::findOrFail($id);
        $message->delete();

        return redirect()->route('messages.admin')->with('success', 'Message deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:read,unread,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id',
        ]);

        if ($validated['action'] === 'delete') {
            Contact::whereIn('id', $validated['ids'])->delete();
            $msg = 'Selected messages deleted successfully.';
        } else {
            Contact::whereIn('id', $validated['ids'])->update(['status' => $validated['action']]);
            $msg = 'Selected messages marked as '.ucfirst($validated['action']).'.';
        }

        return redirect()->back()->with('success', $msg);
    }
}
