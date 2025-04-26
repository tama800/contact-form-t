<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;


class ContactController extends Controller
{
    public function index()
        {
            return view('index');
        }

    public function confirm(ContactRequest $request)
        {
          $contact=$request->only(['last_name', 'first_name', 'gender', 'email', 'tel', 'address', 'building', 'category_id','detail']);
          return view('confirm', compact('contact'));
        }
    
    public function store(ContactRequest $request)
        {
          $contact=$request->only(['last_name', 'first_name', 'gender', 'email', 'tel', 'address', 'building', 'category_id','detail']);
          Contact::create($contact);
          return view('thanks');

        }

    public function register()
        {
            return view('register');
        }
    public function login()
        {
            return view('login');
        }
    public function admin()
        {
            return view('admin');
        }
    public function thanks()
        {
            return view('thanks');
        }

}
