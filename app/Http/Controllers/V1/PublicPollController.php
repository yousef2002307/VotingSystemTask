<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
class PublicPollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polls = Poll::with(['choices' => function($query) {
            $query->withCount('votes');
        }])->withCount('votes')->orderBy('id', 'desc')->get();
        return response()->json($polls);
    }

}
