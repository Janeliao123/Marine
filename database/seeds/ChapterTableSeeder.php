<?php

use Illuminate\Database\Seeder;
class ChapterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('chapters')->delete();
      DB::table('chapters')->insert(
        ['title' => '第一章、基本語法','id' => '1']
      );
      DB::table('chapters')->insert(
        ['title' => '第二章、邏輯判斷','id' => '2']
      );
      DB::table('chapters')->insert(
        ['title' => '第三章、迴圈','id' => '3']
      );
      DB::table('chapters')->insert(
        ['title' => '第四章、陣列','id' => '4']
      );
      DB::table('chapters')->insert(
        ['title' => '第五章、指標','id' => '5']
      );

    }
}
