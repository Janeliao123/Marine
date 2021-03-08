<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chapter;
use DB;
class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chapter = DB::table('chapters')
                ->join('admins','chapters.admin_id','=','admins.id')
                ->select('chapters.id','chapters.title','admins.name','chapters.admin_id')
                ->orderBy('chapters.id')->get();
        return view('admin/chapter.create_chapter', ['chapter'=>$chapter]);
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


        $chapter = new Chapter;
        $chapter->title = $request->title;
        $chapter->admin_id = $request->admin_id;
        $chapter->save();
        return back()->with('success', '新增成功');
    }

    /**
     * Display the specified resource.
 *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chapter=Chapter::find($id);
        return view('admin/chapter.edit_chapter', ["chapter"=>$chapter]);
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
        $chapter=Chapter::find($id);
        $chapter->title=$request->title;
        $chapter->save();
        return redirect('admin/chapter');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chapter::destroy($id);
        return back();
    }
}
