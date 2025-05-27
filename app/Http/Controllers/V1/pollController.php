<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
class pollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polls = Poll::with('choices')->withCount('votes')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return response()->json($polls);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'choices' => 'required|array|min:2',
        ]);
        $poll = Poll::create([
            'question' => $request->question,
            'user_id' => Auth::user()->id,
        ]);
        foreach ($request->choices as $choice) {
            $poll->choices()->create([
                'value' => $choice,
            ]);
        }
        return response()->json($poll->load('choices'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $poll = Poll::with('choices')->withCount('votes')->findOrFail($id);
        return response()->json($poll);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $poll = Poll::findOrFail($id);
        $poll->update([
            'question' => $request->question,
        ]);
        $poll->choices()->delete();
        foreach ($request->choices as $choice) {
            $poll->choices()->create([
                'value' => $choice,
            ]);
        }
        return response()->json($poll->load('choices'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poll = Poll::where('user_id', Auth::user()->id)->findOrFail($id);
        $poll->choices()->delete();
        $poll->delete();
        return response()->json([
            'message' => 'Poll deleted successfully',
            'poll' => $poll
        ]);
    }
}
