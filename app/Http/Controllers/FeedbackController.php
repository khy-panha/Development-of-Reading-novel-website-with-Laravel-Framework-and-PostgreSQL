<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Show the contact form
    public function showForm()
    {
        return view('home');
    }
    public function index()
    {
        // Fetch all feedbacks
        $feedbacks = Feedback::all();

        // Pass the feedbacks to the Blade view
        return view('feedback.admin.dashbord', compact('feedbacks'));
    }
    // Handle form submission
    public function submitForm(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Create a new Feedback entry in the database
        Feedback::create([
            'name' => $validated['name'],
            'email' => $validated['email_address'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);


        return back()->with('success', 'Your message has been sent!');
    }
}
