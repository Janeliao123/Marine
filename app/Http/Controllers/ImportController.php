<?php
namespace App\Http\Controllers;
use App\Course_user_list;
use App\Course_list;
use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ImportController extends Controller
{

    public function processImport(Request $request)
    {
      if($request->type==1){
        $name=pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext=pathinfo($request->file->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext == 'xlsx' || $ext =='xls'){
          $fname=time().$name.'.'.$ext;
          $request->file->move(public_path('exports'), $fname);
          $filePath = 'public/exports/'.$fname;
          $id = $request->course_list_id;
          Excel::load($filePath, function ($reader) use($id){
                foreach ($reader->toArray() as $key => $row) {
                  if($row['學號']==null){

                  }else {
                    $stu = new Course_user_list;
                    $stu->acct = $row['學號']; //!!注意 excel中的header名稱必須跟這邊的名稱相同為"學號"
                    $stu->name = $row['姓名']; //!!注意 excel中的header名稱必須跟這邊的名稱相同為"姓名"
                    $stu->course_list_id = $id;
                    $stu->save();
                  }


                }
            });
          // $data = Excel::load($filePath, function($reader) {} )->all();
          //   // dd($data);
          // $num = count($data);
          // dd($data);
          //  for ($i=0; $i < $num; $i++) {
          //    $stu = new Course_user_list;
          //    $stu->acct = $data[$i]->student_id; //!!注意 excel中的header名稱必須跟這邊的名稱相同為"student_id"
          //    $stu->name = $data[$i]->name; //!!注意 excel中的header名稱必須跟這邊的名稱相同為"name"
          //    $stu->course_list_id = $request->course_list_id;
          //    $stu->save();
          //  }
          unlink(public_path('exports').'/'.$fname);
          return back()->with('success','成功上傳')->with('name',$name.'.'.$ext);
        }else{
          return back()->with('alert', '上傳格式須為xlsx或xls，感謝您的配合!');
        }
           return redirect('admin/user_lists');
      }else {
        $stu = new Course_user_list;
        $stu->acct = $request->acct;
        $stu->name = $request->name;
        $stu->course_list_id = $request->course_list_id;
        $stu->save();
        return back()->with('success','成功上傳學生')->with('name',$request->name);
      }

    }

    //解析用fun但後沒用到了也許未來會加?
    // public function parseImport(CsvImportRequest $request)
    // {
    //     $course_list_id = $request->course_list_id;
    //     $path = $request->file('csv_file')->getRealPath();
    //     $name=pathinfo($request->csv_file->getClientOriginalName(), PATHINFO_FILENAME);
    //     $ext=pathinfo($request->csv_file->getClientOriginalName(), PATHINFO_EXTENSION);
    //     $fname=time().$name.'.'.$ext;
    //     if ($request->has('header')) {
    //         $data = Excel::load($path, function($reader) {})->get()->toArray();
    //     } else {
    //         $data = array_map('str_getcsv', file($path));
    //     }
    //     if (count($data) > 0) {
    //         if ($request->has('header')) {
    //             $csv_header_fields = [];
    //             foreach ($data[0] as $key => $value) {
    //                 $csv_header_fields[] = $key;
    //             }
    //         }
    //         $csv_data = array_slice($data, 0, 2);
    //         $csv_data_file = CsvData::create([
    //             'file_path' => 'csv/'.$fname,
    //             'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
    //             'csv_header' => $request->has('header'),
    //             'csv_data' => json_encode($data),
    //         ]);
    //
    //     } else {
    //         return redirect()->back();
    //     }
    //
    //     $request->csv_file->move(public_path('/csv'), $fname);
    //     return view('admin/import.import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file','file_path','course_list_id'));
    // }
    //
}
