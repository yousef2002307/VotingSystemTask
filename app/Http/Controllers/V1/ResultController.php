<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
class ResultController extends Controller
{
    public function index($id){
        $poll = Poll::with(['choices' => function($query) {
            $query->withCount('votes');
        }])
        ->withCount('votes')
        ->findOrFail($id);
    
       
    
        return response()->json($poll);
    }
}
