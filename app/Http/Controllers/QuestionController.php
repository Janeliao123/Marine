<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Section;
use App\Chapter;
use DB;
use Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $question = Question::where('admin_id',$admin_id)->get();
        return view('admin/question.index', ['question'=>$question]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = Section::all();
        $chapter = Chapter::all();
        return view('admin/question.create_question',[
          'section'=>$section,
          'chapter'=>$chapter
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question;
        $question->section_id = $request->section_id;
        $question->title = $request->title;
        $question->content = $request->content;
        $question->hint = $request->hint;
        $question->difficulty = $request->difficulty;
        $question->type = $request->type;
        $question->include = $request->include;
        $question->admin_id = $request->admin_id;
        $question->is_public = $request->is_public;
        $question->answer = $request->answer;
        $question->input_student = $request->input_student;
        $question->output_student = $request->output_student;
        $question->input_admin = $request->input_admin;
        $question->output_admin = $request->output_admin."\n";
        $question->save();
        return redirect('/admin/question');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title,$id)
    {
        $question = Question::find($id);
        $section = Section::find($question->section_id);
        $questionAll = Question::all();
        return view('question',['question'=>$question,'s_title'=>$title,'section'=>$section,'questionAll'=>$questionAll]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        $section = Section::all();
        $chapter = Chapter::all();
        return view('admin/question.edit_question',['question'=>$question,
        'section'=>$section,
        'chapter'=>$chapter
      ]);
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
        $question=Question::find($id);
        $question->section_id = $request->section_id;
        $question->title = $request->title;
        $question->content = $request->content;
        $question->hint = $request->hint;
        $question->difficulty = $request->difficulty;
        $question->type = $request->type;
        $question->include = $request->include;
        $question->is_public = $request->is_public;
        $question->answer = $request->answer;
        $question->input_student = $request->input_student;
        $question->output_student = $request->output_student;
        $question->input_admin = $request->input_admin;
        $question->output_admin = $request->output_admin."\n";
        $question->save();
        return redirect('/admin/question');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Question::destroy($id);
      return back();
    }
}
