<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
class VoteController extends Controller
{
    public function AddVote(Request $request){
        $request->validate([
            'poll_id' => 'required|exists:polls,id',
            'choice_id' => 'required|exists:choices,id',
        ]);
     $oldvote =  Vote::where('user_id', Auth::user()->id)->where('poll_id', $request->poll_id)->delete();
          
        $vote = Vote::create([
            'user_id' => Auth::user()->id,
            'poll_id' => $request->poll_id,
            'choice_id' => $request->choice_id,
        ]);
        return response()->json($vote);
        
    }
}
