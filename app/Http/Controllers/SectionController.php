<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Chapter;
use App\Question;
use App\Course_user_list;
use DB;
use Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $section = Section::all();
      $chapter = Chapter::all();
      $join = DB::table('sections')
              ->join('chapters','sections.chapter_id','=','chapters.id')
              ->join('admins','sections.admin_id','=','admins.id')
              ->select('sections.id as s_id','chapters.title as c_title','sections.title as s_title','admins.name','sections.admin_id')
              ->orderBy('sections.id')->get();
      return view('admin/section.create_section', [ 'section'=>$section,
                                                    'chapter'=>$chapter,
                                                    'join'=>$join]);
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


          $section = new Section;
          $section->title = $request->title;
          $section->chapter_id = $request->chapter_id;
          $section->admin_id = $request->admin_id;
          $section->save();
          return back()->with('success', '新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title,$c_id,$s_id)
    {
        $section=Section::find($s_id);
        $chapter=Chapter::find($c_id);
        $chapterAll = Chapter::all();
        $sectionAll = Section::all();
        if(Auth::guard('admin')->check()){ //如果是老師登入的話會看到其他老師公開的題目及自己的所有題目
          $admin_id = Auth::guard('admin')->user()->id;
          $question=Question::where(function ($query) use ($s_id) {
                                    $query->where('section_id',$s_id)
                                          ->where('is_public', '=', '1');
                                })
                                ->orWhere(function ($query) use ($admin_id,$s_id){
                                          $query->where('admin_id', $admin_id)
                                          ->where('section_id',$s_id)
                                          ->where('is_public', '=', '0');
                                })->orderBy('difficulty')->get();
        }elseif (Auth::check()) {  //如果是學生登入的話會看到自己曾經在的那個班的那個老師所新增的所有題目及其他老師的公開題目
          $auth_acct = Auth::user()->acct;
          $join_class = DB::table('course_user_lists') //參加了哪幾堂課
                ->where('acct',$auth_acct)
                ->leftJoin('course_lists', 'course_user_lists.course_list_id', '=', 'course_lists.id')
                ->get();
          $admin_id = array();
          foreach ($join_class as $key => $value) { //把那些課的admin_id存入array
            $admin_id[] = $value->admin_id;
          }
          $question=Question::where(function ($query) use ($s_id) {
                                    $query->where('section_id',$s_id)
                                          ->where('is_public', '=', '1');
                                })
                                ->orWhere(function ($query) use ($admin_id,$s_id){
                                          $query->whereIn('admin_id',$admin_id)
                                          ->where('section_id',$s_id)
                                          ->where('is_public', '=', '0');
                                })->orderBy('difficulty')->get();

        }else { //未登入者只會看到已公開的題目
          $question=Question::where('section_id',$s_id)
                              ->where('is_public','1')
                              ->orderBy('difficulty')
                              ->get();
        }
        return view('section',['section'=>$section,'question'=>$question,'chapter'=>$chapter,'chapterAll'=>$chapterAll,
        'sectionAll'=>$sectionAll]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $section=Section::find($id);
      return view('admin/section.edit_section', ["section"=>$section]);
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
      $section=Section::find($id);
      $section->title=$request->title;
      $section->save();
      return redirect('admin/section');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Section::destroy($id);
      return back();
    }
}
