<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubscriberRequest;
use App\Subscriber;
use Flash;
use Mail;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return redirect('user/dashboard');
    }

    /**
     * Get request and process and return to site with a message.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(SubscriberRequest $request)
    {
        $request->request->add(['ip_address' => $request->getClientIp()]);
        $subscriber = new Subscriber;
        $subscriber->create($request->all());


        Mail::send('site.emails.demorequest',
        ['email' => $request->email,'ip_address' => $request->ip_address],function($message) use ($request)  {
        $message->to('info@cloudmlmsoftware.com')->from('opensource@cloudmlmsoftware.com')->subject('Demo request from '.$request->email);
        });

        Flash::overlay('Thank you! We will contact you soon', 'Request recieved!');
        return redirect('/');
    }
}
