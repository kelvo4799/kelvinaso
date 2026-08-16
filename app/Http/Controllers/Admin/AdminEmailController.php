<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use App\Models\EmailTemplate;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminEmailController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        // Auto-seed default templates if empty
        if (EmailTemplate::count() === 0) {
            EmailTemplate::create([
                'slug' => 'contact_reply',
                'subject' => 'Re: {{ subject }} - Reply from Keviloq Systems',
                'body_html' => "<p>Hi {{ name }},</p>\n<p>Thank you for contacting us. Here is our response to your inquiry:</p>\n<blockquote style=\"border-left: 3px solid #10b981; padding-left: 12px; color: #555;\">{{ reply_message }}</blockquote>\n<p>Best regards,<br><strong>{{ sender_name }}</strong><br>Keviloq Systems</p>",
                'is_active' => true,
            ]);

            EmailTemplate::create([
                'slug' => 'visitor_welcome',
                'subject' => 'Welcome to Keviloq Systems!',
                'body_html' => "<p>Hello {{ name }},</p>\n<p>Thank you for reaching out! We received your message regarding <strong>{{ subject }}</strong> and our team will get back to you shortly.</p>\n<p>Warm regards,<br>Keviloq Systems Team</p>",
                'is_active' => true,
            ]);
        }

        $templates = EmailTemplate::orderBy('created_at', 'desc')->get();
        $emailSetting = EmailSetting::first() ?? EmailSetting::create([
            'header_html' => '<div style="background-color: #0f1016; padding: 24px; text-align: center; border-radius: 8px 8px 0 0;"><h1 style="color: #6c8eff; margin: 0; font-family: sans-serif;">Keviloq Systems</h1></div>',
            'footer_html' => '<div style="background-color: #f8fafc; padding: 18px; text-align: center; font-size: 12px; color: #64748b; border-radius: 0 0 8px 8px;"><p style="margin: 0;">© ' . date('Y') . ' Keviloq Systems. All rights reserved.</p></div>',
        ]);

        return view('admin.emails', compact('page', 'profile', 'templates', 'emailSetting'));
    }

    public function create()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        return view('admin.email_detail', [
            'page' => $page,
            'profile' => $profile,
            'template' => new EmailTemplate(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:email_templates,slug',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'], '_');
        $validated['is_active'] = $request->has('is_active');

        EmailTemplate::create($validated);

        return redirect()->route('emails.admin')->with('success', 'Email template created successfully.');
    }

    public function edit($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $template = EmailTemplate::findOrFail($id);

        return view('admin.email_detail', [
            'page' => $page,
            'profile' => $profile,
            'template' => $template,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:email_templates,slug,' . $template->id,
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['slug'], '_');
        $validated['is_active'] = $request->has('is_active');

        $template->update($validated);

        return redirect()->route('emails.admin')->with('success', 'Email template updated successfully.');
    }

    public function destroy($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('emails.admin')->with('success', 'Email template deleted successfully.');
    }

    public function updateGlobal(Request $request)
    {
        $validated = $request->validate([
            'header_html' => 'nullable|string',
            'footer_html' => 'nullable|string',
        ]);

        $emailSetting = EmailSetting::first() ?? new EmailSetting();
        $emailSetting->header_html = $validated['header_html'] ?? '';
        $emailSetting->footer_html = $validated['footer_html'] ?? '';
        $emailSetting->save();

        return redirect()->back()->with('success', 'Global email header & footer updated successfully.');
    }

    public function sendTestEmail(Request $request)
    {
        $validated = $request->validate([
            'test_email' => 'required|email',
        ]);

        $emailSetting = EmailSetting::first();
        $header = $emailSetting ? $emailSetting->header_html : '';
        $footer = $emailSetting ? $emailSetting->footer_html : '';

        $testContent = "<div style=\"padding: 24px; font-family: sans-serif;\"><h3>Test Email Dispatch</h3><p>This is a test email sent from your Portfolio Admin Panel.</p><p>If you are receiving this message, your mail configuration is working perfectly! ✨</p></div>";
        $fullHtml = $header . $testContent . $footer;

        try {
            Mail::html($fullHtml, function ($message) use ($validated) {
                $message->to($validated['test_email'])
                    ->subject('Test Email from Keviloq Systems Admin');
            });

            return redirect()->back()->with('success', 'Test email sent successfully to ' . $validated['test_email']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
