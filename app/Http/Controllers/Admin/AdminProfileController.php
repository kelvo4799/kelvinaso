<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $page = Page::all();
        $user = Auth::user();
        $profile = $user->profile ?? Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => explode(' ', $user->name)[0] ?? '',
                'last_name' => explode(' ', $user->name)[1] ?? '',
                'direct_email' => $user->email,
            ]
        );

        $socialLinks = is_array($profile->social_links) ? $profile->social_links : [];

        return view('admin.profile', compact('page', 'user', 'profile', 'socialLinks'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? Profile::firstOrCreate(['user_id' => $user->id]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'bio_title' => 'nullable|string|max:255',
            'bio_header' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'direct_email' => 'nullable|email|max:255',
            'direct_phone' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg,heic|max:10240',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
            'github' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        // Update User account
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Handle Avatar Upload
        $avatarPath = $profile->avatar;
        if ($request->hasFile('avatar')) {
            $avatarPath = $profile->uploadImage($request->file('avatar'), 'profiles');
        }

        // Handle CV Upload
        $cvPath = $profile->cv;
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $filename = time().'_'.preg_replace('/[^A-Za-z0-9\._-]/', '', $file->getClientOriginalName());
            $destinationPath = public_path('uploads/cvs');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $cvPath = 'uploads/cvs/'.$filename;
        }

        $socialLinks = [
            'github' => $validated['github'] ?? '',
            'linkedin' => $validated['linkedin'] ?? '',
            'twitter' => $validated['twitter'] ?? '',
            'instagram' => $validated['instagram'] ?? '',
        ];

        // Update Profile
        $profile->update([
            'first_name' => $validated['first_name'] ?? '',
            'last_name' => $validated['last_name'] ?? '',
            'bio_title' => $validated['bio_title'] ?? '',
            'bio_header' => $validated['bio_header'] ?? '',
            'bio' => $validated['bio'] ?? '',
            'avatar' => $avatarPath,
            'cv' => $cvPath,
            'location' => $validated['location'] ?? '',
            'direct_email' => $validated['direct_email'] ?? $user->email,
            'direct_phone' => $validated['direct_phone'] ?? '',
            'social_links' => $socialLinks,
        ]);

        return redirect()->back()->with('success', 'Admin profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
