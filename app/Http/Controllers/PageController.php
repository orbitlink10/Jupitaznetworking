<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact', [
            'supportPhone' => Setting::valueFor('support_phone'),
            'supportEmail' => Setting::valueFor('support_email'),
            'supportWhatsapp' => Setting::valueFor('support_whatsapp'),
            'supportAddress' => Setting::valueFor('support_address'),
        ]);
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        return back()->with('success', 'Thank you for your message. Our team will get back to you.');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function delivery()
    {
        return view('pages.delivery');
    }

    public function returns()
    {
        return view('pages.returns');
    }

    public function warranty()
    {
        return view('pages.warranty');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }
}
