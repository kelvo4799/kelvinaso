<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Settings;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingController extends Controller
{
    public function index(SettingService $settingService)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        $settings = $settingService->all();

        return view('admin.settings', compact('page', 'profile', 'settings'));
    }

    public function update(Request $request, SettingService $settingService)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_keywords' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'footer_copyright' => 'nullable|string|max:255',
            'footer_cta_title' => 'nullable|string|max:255',
            'footer_cta_description' => 'nullable|string',
            'footer_cta_button_text' => 'nullable|string|max:255',
            'footer_cta_button_url' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:50',
            'accent_color' => 'nullable|string|max:50',
            'secondary_color' => 'nullable|string|max:50',
            'groq_api_key' => 'nullable|string|max:255',
            'gemini_api_key' => 'nullable|string|max:255',
            'grok_api_key' => 'nullable|string|max:255',
            'google_analytics_id' => 'nullable|string|max:255',
            'custom_head_scripts' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
            'site_favicon' => 'nullable|image|mimes:png,ico,svg|max:2048',
            'enable_experiences' => 'nullable|string',
            'enable_snippets' => 'nullable|string',
            'enable_scheduler' => 'nullable|string',
            'enable_blog' => 'nullable|string',
            'enable_ai_chatbot' => 'nullable|string',
            'enable_github_sync' => 'nullable|string',
            'calendly_url' => 'nullable|string|max:255',
            'github_username' => 'nullable|string|max:255',
        ]);

        // Process checkboxes (set '0' if unchecked)
        $toggles = ['enable_experiences', 'enable_snippets', 'enable_scheduler', 'enable_blog', 'enable_ai_chatbot', 'enable_github_sync'];
        foreach ($toggles as $toggle) {
            $validated[$toggle] = $request->has($toggle) ? '1' : '0';
        }

        // Handle Site Logo Upload
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/settings');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['site_logo'] = 'uploads/settings/' . $filename;
        }

        // Handle Site Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/settings');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $validated['site_favicon'] = 'uploads/settings/' . $filename;
        }

        // Save each setting to settings database table
        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Settings::updateOrCreate(
                    ['key' => $key],
                    ['value' => is_array($value) ? json_encode($value) : $value]
                );
            }
        }

        // Flush settings cache so new values take effect immediately
        $settingService->flushCache();

        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }
}
