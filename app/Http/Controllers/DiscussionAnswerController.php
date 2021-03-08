<?php

namespace App\Http\Controllers;

use App\Discussion_answer;
use App\Discussion_ask;
use Illuminate\Http\Request;

class DiscussionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_answer()
    {
        return view('discussion_answer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discussion_answer = new Discussion_answer;
        $discussion_answer->answer = $request->answer_content;
        $discussion_answer->user_id = $request->user_id;
        $discussion_answer->discussion_ask_id = $request->discussion_ask_id;
        $discussion_answer->save();
        return redirect('discussion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_answer($id)
    {
        $ask = Discussion_ask::find($id);
        return view('discussion_answer',[
            'ask'=>$ask,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
