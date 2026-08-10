<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Page;
use App\Services\MailerService;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{

    protected int $limit = 2;

    protected int $decay = 60;
    protected MailerService $mailerService;

    public function __construct(
        MailerService $mailerService
    ) {
        parent::__construct();
        $this->mailerService = $mailerService;

    }

    public function index()
    {
        $page = Page::where('slug', 'home')->first();

        $profile = $this->users->profile()->first();

        //dd($profile);

        $email = $profile->direct_email;
        $phone = $profile->direct_phone;

        return view('contact', compact('page', 'email', 'phone'));
    }

    public function create(ContactRequest $contactRequest) {

        $ip = $contactRequest->ip();
        $userAgent = $contactRequest->userAgent();
        $result = $contactRequest->validated();
        $ipKey = 'contact:ip:' . $ip;

        $userAgentKey = 'contact:ua:' . sha1($userAgent);

        $emailKey = 'contact:email:' . sha1(trim(strtolower($result['email'])));

        // Check IP

    if (RateLimiter::tooManyAttempts($ipKey, $this->limit)) {

        return response()->json([

            'success' => false,

            'message' => 'Too many submissions from this IP. Please try again later.',

        ], 429);

    }

    // Check User-Agent

    if (RateLimiter::tooManyAttempts($userAgentKey, $this->limit)) {

        return response()->json([

            'success' => false,

            'message' => 'Too many requests from this client. Please try again later.',

        ], 429);

    }

    // Check Email

    if (RateLimiter::tooManyAttempts($emailKey, $this->limit)) {

        return response()->json([

            'success' => false,

            'message' => 'Too many submissions from this email. Please try again later.',

        ], 429);

    }

    RateLimiter::hit($ipKey, $this->decay);

    RateLimiter::hit($userAgentKey, $this->decay);

    RateLimiter::hit($emailKey, $this->decay);
        
        

        $profile = $this->users->profile()->first();

        $data = [
            'name' => $result['name'],
            'email' => $result['email'],
            'subject' => $result['subject'],
            'message' => $result['message'],
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ];

        $contact = new Contact($data);
        $final = $contact->save();

        if ($final) {

            //send mail
            $this->mailerService->send(
                $profile->direct_email,
                'contact_form_email',
                [
                'subject' => $result['subject'] . ' from ' . ucfirst($result['name']),
                'message' => $result['message']
                ],
                $result['email'],
                ucfirst($result['name'])
            );

            return response()->json([
                'success' => true,
                'message' => 'Contact form submitted successfully.'
            ], 201);
        }
        

        return response()->json([
                'success' => false,
                'message' => 'Failed to submit contact form.'
        ], 500);
        


        


    }
}
