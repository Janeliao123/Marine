<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('sections')->delete();
      DB::table('sections')->insert(
        ['chapter_id' => '1','title' => '1-1、運算元','id' => '1']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '1','title' => '1-2、輸出','id' => '2']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '1','title' => '1-3、輸入','id' => '3']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '2','title' => '2-1、if','id' => '4']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '2','title' => '2-2、if-else','id' => '5']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '2','title' => '2-3、case','id' => '6']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '2','title' => '2-4、巢狀if','id' => '7']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '3','title' => '3-1、for','id' => '8']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '3','title' => '3-2、while','id' => '9']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '3','title' => '3-3、do while','id' => '10']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '3','title' => '3-4、巢狀迴圈','id' => '11']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '4','title' => '4-1、一維陣列','id' => '12']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '4','title' => '4-2、二維陣列','id' => '13']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '5','title' => '5-1、指標基本操作','id' => '14']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '5','title' => '5-2、指標與一維陣列','id' => '15']
      );
      DB::table('sections')->insert(
        ['chapter_id' => '5','title' => '5-3、指標與二維陣列','id' => '16']
      );

    }
}
