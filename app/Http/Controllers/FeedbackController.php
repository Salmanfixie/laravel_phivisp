<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    public function feedback_data(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('feedback')->where(function ($query) use ($request) {
                    return $query->where('email', $request->email);
                }),
            ],
            'comments' => 'required',
            'rating' => 'required',
            'improvement' => '',
        ]);
    
        $dummy = new Feedback();
        $dummy->name = $request->input('name');
        $dummy->email = $request->input('email');
        $dummy->comments = $request->input('comments');
        $dummy->rating = $request->input('rating');
        $dummy->improvement = $request->input('improvement');

        $dummy->save();

        return redirect()->intended('feedback')->with('success', 'Feedback is submitted');

    }
}
