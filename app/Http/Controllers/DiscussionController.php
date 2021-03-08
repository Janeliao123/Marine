<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion_ask;
use App\Discussion_answer;
use App\Chapter;
use App\User;



class DiscussionController extends Controller
{

   public function index(){
    $chapter = Chapter::all();
    foreach($chapter as $key_1 => $c){
        $count[$c->id] = Discussion_ask::where('chapter_id',$c->id)->count();
    }
    return view('discussion',compact('chapter','count'));

  }

   public function index_third(){
    return view('discussion_third');
  }

    public function index_personal(){
    return view('personal_discussion');
  }

  /**
      * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
      */
    public function create()
    {
        return View::make('discussion_ask');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_broad($id)
    {
        $ask = Discussion_ask::find($id);
        $answer = Discussion_answer::all();
        $user = User::find($ask->user_id);
        $answer_name = User::all();

        return view('discussion_broad',[
            'ask'=>$ask,
            'user'=>$user,
            'answer'=>$answer,
            'answer_name'=>$answer_name
        ]);
    }
    public function show_sec($id)
    {
        $chapter = Chapter::find($id);
        $ask = Discussion_ask::all();
        return view('discussion_sec',[
            'chapter'=>$chapter,
            'ask'=>$ask,
            'id'=>$id,
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
        //
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
