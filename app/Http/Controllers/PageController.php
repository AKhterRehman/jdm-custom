<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Mail\ContactMessageReceived;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about');
    }

    public function privacyPolicy(): View
    {
        return view('pages.privacy-policy');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'inquiry_type' => ['nullable', 'in:general,custom-order,existing-order,product-question,wholesale,other'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        if (config('mail.contact_recipient')) {
            Mail::to(config('mail.contact_recipient'))->send(new ContactMessageReceived($contactMessage));
        }

        return back()->with('status', "Thanks for reaching out — we'll get back to you soon.");
    }

    public function subscribeNewsletter(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('newsletter', [
            'email' => ['required', 'email', 'max:255'],
        ]);

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $validated['email']],
            ['is_active' => true],
        );

        if ($subscriber->wasRecentlyCreated && config('mail.contact_recipient')) {
            Mail::raw(
                "New newsletter subscriber: {$subscriber->email}",
                fn ($message) => $message->to(config('mail.contact_recipient'))->subject('New newsletter subscriber'),
            );
        }

        $status = $subscriber->wasRecentlyCreated
            ? 'Thanks for joining our newsletter!'
            : 'You are already subscribed to our newsletter.';

        return back()->with('newsletter_status', $status);
    }
}
