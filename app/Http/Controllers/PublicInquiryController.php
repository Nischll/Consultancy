<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\ConsultancyProfile;
use App\Mail\NewInquiryNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Public inquiry submission (website visitors).
 * Submissions appear in the admin Inquiries panel; admins respond via the system and can convert to student.
 */
class PublicInquiryController extends Controller
{
    public function showForm()
    {
        $profile = ConsultancyProfile::where('is_active', true)->first();
        $theme = session('home_theme', 'default');
        return view('public.inquiry', compact('profile', 'theme'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'type' => 'nullable|in:general,admission,visa,language,scholarship,accommodation,other',
            'source' => 'nullable|string|max:100',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please enter your message.',
        ]);

        $validated['type'] = $validated['type'] ?? 'general';
        $validated['priority'] = 'medium';
        $validated['status'] = 'new';
        $validated['source'] = $validated['source'] ?? 'Website';

        $inquiry = Inquiry::create($validated);

        $profile = ConsultancyProfile::where('is_active', true)->first();
        if ($profile && $profile->email) {
            try {
                Mail::to($profile->email)->send(new NewInquiryNotificationMail($inquiry));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('public.inquiry.thank-you')
            ->with('success', 'Thank you! Your inquiry has been submitted. We will get back to you soon.');
    }

    public function thankYou()
    {
        $profile = ConsultancyProfile::where('is_active', true)->first();
        $theme = session('home_theme', 'default');
        return view('public.inquiry-thank-you', compact('profile', 'theme'));
    }
}
