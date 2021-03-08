<?php

namespace App\Http\Controllers;

use App\NewReport;
use Illuminate\Http\Request;

class NewReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {

        $news = NewReport::orderBy('created_at', 'desc')
            ->get();
        return view ('NewsEdit',[
          'allnews'=>$news,
          'course_id'=>$course_id,
        ]);
    }

    public function show($id)
    {
        $news = NewReport::find($id);
        return view ('NewsEditSecond',[
          'data'=>$news
        ]);
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
      $news = new NewReport() ;
      $news->course_list_id	 = $request->course_id;
      $news->admin_id	 = $request->admin_id;
      $news->title = $request->title;
      $news->content = $request->content;
      $news->save();
      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewReport  $newReport
     * @return \Illuminate\Http\Response
     */
     public function edit_fin(Request $request,$id)
     {
       $news = NewReport::find($id);
       $news->title = $request->title;
       $news->content = $request->content;
       $news->save();
       return redirect('admin/newsedit');
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewReport  $newReport
     * @return \Illuminate\Http\Response
     */
     /*
    public function edit($id)
    {
      $news=NewReport::find($id);
      return view('admin/chapter.edit_chapter', ["chapter"=>$chapter]);
    }
       */




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewReport  $newReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $news=NewReport::find($id);
      $news->title=$request->title;
      $news->save();
      return redirect('admin/newsedit');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewReport  $newReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewReport $newReport)
    {
        //
    }
    public function delete($id)
    {
      $news = NewReport::find($id);
      $news->delete();
      return back();
    }

}
