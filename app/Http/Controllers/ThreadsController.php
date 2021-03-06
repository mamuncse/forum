<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Resources\ThreadsCollection;
use App\Http\Resources\ThreadsResource;
use App\Thread;
use Illuminate\Http\Request;
//use Laravel\Scout\Searchable;


class ThreadsController extends Controller
{
//    use Searchable;
//    public function searchableAs()
//    {
//        return 'title';
//    }

//
//    public function search()
//    {
//        $threads = Thread::search()->get(); return $threads;
//
//        return view('threads.search', compact('threads'));
//    }

    public function __construct()
    {

        $this->middleware('auth')->only(['create', 'store']);
    }


    public function index(Channel $channel)
    {

       if ($channel->exists)
       {
           $threads = $channel->threads()->latest()->get();

       }
       else
       {
           $threads = Thread::latest()
               ->filter(request()->only(['month', 'year']))
               ->get();

       }

        $archives = Thread::selectRaw('year (created_at) year, monthname(created_at) month , count(*) published')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at)desc')
            ->get()
            ->toArray();


        return view('threads.index', compact('threads','archives'));

    }


    public function create()
    {
        return view('threads.create');
    }


    public function store(Request $request)
    {

        $this->validate($request, [

            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'  //channel id goes to channel table

        ]);

        $thread = Thread::create([

            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),

        ]);

        return redirect($thread->path());


    }


    public function show($channelId, Thread $thread)
    {

        return view('threads.show', compact('thread'));
    }

//    public function show(Thread $thread)
//    {
//        return view('threads.show', compact('thread'));
//    }

    public function edit(Thread $thread)
    {
        //
    }


    public function update(Request $request, Thread $thread)
    {
        //
    }


    public function destroy(Thread $thread)
    {
        //
    }

    public function apiindex()
    {
        return ThreadsCollection::collection(Thread::all());
    }

    public function apishow($channelId, Thread $thread)
    {
        return new ThreadsResource($thread);
    }

}
