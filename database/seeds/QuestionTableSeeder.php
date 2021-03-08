<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('questions')->delete();

      DB::table('questions')->insert(
        ['section_id' => '1','title' => '算數','content' => '請運用程式語言計算63*54，並直接印出答案',
        'hint' => '運算元', 'difficulty' => '1', 'type' => '1', 'is_discuss' => '0',
        'include' => '1-1運算元', 'input_student' => '',
         'output_student' => '3402',
        'input_admin' => '', 'output_admin' => '3402',
         'id' => '1']
      );
      DB::table('questions')->insert(
        ['section_id' => '2','title' => 'HELLO WORLD','content' => '請列印出 HELLO WORLD',
        'hint' => 'printf', 'difficulty' => '1', 'type' => '1', 'is_discuss' => '0',
        'include' => '1-2輸出', 'input_student' => '', 'output_student' => 'HELLO WORLD',
        'input_admin' => '', 'output_admin' => 'HELLO WORLD',
         'id' => '2']
      );

      DB::table('questions')->insert(
        ['section_id' => '2','title' => '信件撰寫','content' => '今天小民想要用程式碼寫一封信給教授，
        由於收信人是教授，因此文中的標點符號語格式內容都不能有誤，請幫他完成(列印出)此封信，內容如下
        王教授您好:我叫王小民，不是”王建民”喔!很高興認識您。',
        'hint' => '特殊字元的printf', 'difficulty' => '3', 'type' => '2', 'is_discuss' => '0',
        'include' => '1-2輸出', 'input_student' => '',
         'output_student' => '王教授您好:我叫王小民，不是”王建民”喔!很高興認識您。',
        'input_admin' => '', 'output_admin' => '王教授您好:我叫王小民，不是”王建民”喔!很高興認識您。',
         'id' => '3']
      );

      DB::table('questions')->insert(
        ['section_id' => '3','title' => '自動計算加總程式','content' => '請撰寫自動計算程式，當使用者輸入¥，回印出1+...¥=(正確答案)，顯示如下
        6
        1+…6=21',
        'hint' => '1+...n=n*(n+1)/2', 'difficulty' => '2', 'type' => '1', 'is_discuss' => '0',
        'include' => '1-2輸出
        1-3輸入', 'input_student' => '3',
         'output_student' => '1+...3=6',
        'input_admin' => '11', 'output_admin' => '1+...11=66',
         'id' => '4']
      );
      DB::table('questions')->insert(
        ['section_id' => '3','title' => '數學小老師','content' => '你當選了數學小老師，要協助老師批改考卷，
        但由於你把解答弄丟了，因此必須自己計算答案，
        為了增加效率，你寫了一個程式，可以快速運算出”任意”兩個數字相乘後的答案，顯示方法如下
        25 31
        答案為775',
        'hint' => 'scanf', 'difficulty' => '3', 'type' => '2', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入', 'input_student' => '3 2',
         'output_student' => '6',
        'input_admin' => '8 15', 'output_admin' => '120',
         'id' => '5']
      );
      DB::table('questions')->insert(
        ['section_id' => '4','title' => '分數比較器','content' => '凱哥期末考考完了，發現自己考了84分，
        由於想要知道班上其他人跟他的分數差距，因此寫了一隻程式來執行下列功能，顯示方法如下
        請輸入該同學成績
        86
        比你高2分喔
        84
        跟你同分ㄟ
        80比你低4分',
        'hint' => 'scanf if', 'difficulty' => '2', 'type' => '2', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入 2-1if', 'input_student' => '86',
         'output_student' => '請輸入該同學成績 ; 比你高2分喔',
        'input_admin' => '98', 'output_admin' => '請輸入該同學成績 ; 比你高14分喔',
         'id' => '6']
      );



      DB::table('questions')->insert(
        ['section_id' => '4','title' => '比大小','content' => '請讓使用者輸入兩整數，並比較其大小關係，顯示方法如下:
        請輸入第一個數
        12
        請輸入第二個數
        7
        12>7',
        'hint' => 'scanf if', 'difficulty' => '1', 'type' => '1', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入 2-1if', 'input_student' => '12 ; 7',
        'output_student' => '請輸入第一個數 ; 請輸入第二個數 ; 12>7',
       'input_admin' => '4 ; 0', 'output_admin' => '請輸入第一個數 ; 請輸入第二個數 ; 4>0',
        'id' => '7']
     );



      DB::table('questions')->insert(
        ['section_id' => '4','title' => '數學題目','content' => '老王每天都會教兒子數學，
        他今天想了兩道題目，分別是5+8、8*7，為了讓兒子做題目時覺得更有趣，他寫了一支程式，
        讓兒子可以在電腦上作答，並直接顯示答對題數，顯示方法如下:
        第一題:5+8=?
        13
        第二題:8*7=?
        48
        你答對了1題，錯了1題',
        'hint' => 'if', 'difficulty' => '2', 'type' => '2', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入 2-1if', 'input_student' => '13 ; 48',
         'output_student' => '第一題:5+8=? ; 第二題:8*7=? ; 你答對了1題，錯了1題',
        'input_admin' => '13 ; 56', 'output_admin' => '第一題:5+8=? ; 第二題:8*7=? ; 你答對了2題，錯了0題',
         'id' => '8']
      );




      DB::table('questions')->insert(
        ['section_id' => '5','title' => '正負數','content' => '阿廖有一個剛5歲的弟弟，最近剛學了正負數，
        因此一直問阿廖某數是正數還是負數，為了出們跟朋友們玩但又可以讓弟弟學習，阿廖靈機一動，
        寫了一隻程式判斷使用者輸入的整數為正還是負，顯示方法如下(請用if、else if、else):
        弟弟，請輸入你想知道的整數
        [例1]
        16
        16是正數喔
        [例2]
        0
        0最特別，不是正數也不是負數喔，姐姐玩回來再跟你解釋',
        'hint' => 'else if', 'difficulty' => '1', 'type' => '2', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入 2-1if 2-2else if', 'input_student' => '5',
         'output_student' => '5是正數喔',
        'input_admin' => '-4', 'output_admin' => '-4是負數喔',
         'id' => '9']
      );







      DB::table('questions')->insert(
        ['section_id' => '5','title' => '排列','content' => '撰寫一程式，讓使用者輸入任意三位正整數，
        並將此三位數由小到大照順序印出，顯示方法如下
        請輸入三位正整數
        6 1 27
        答案為1 6 27',
        'hint' => 'else if', 'difficulty' => '3', 'type' => '1', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入 2-1if 2-2else if', 'input_student' => '6 1 27',
         'output_student' => '請輸入三位正整數 ; 1 6 27',
        'input_admin' => '20 5 76', 'output_admin' => '請輸入三位正整數 ; 答案為5 20 76',
         'id' => '10']
      );


      DB::table('questions')->insert(
          ['section_id' => '6','title' => '簡易計算機','content' => '請寫一個簡易的計算機，
          可讓使用者輸入兩整數，並選擇先要執行的計算元(+-*/)，並印出計算結果，顯示方法如下(請用case撰寫):
          請輸入第一個整數
          6
          請輸入第二個整數
          4
          請輸入要執行的運算元
          /
          6/4=1.5',
              'hint' => 'else if', 'difficulty' => '3', 'type' => '1', 'is_discuss' => '0',
              'include' => '1-1運算元 1-2輸出 1-3輸入 2-3case', 'input_student' => '6 ; 4 ; /',
               'output_student' => '請輸入第一個數 ; 請輸入第二個數 ; 請輸入要執行的運算元 ; 6/4=1.5',
              'input_admin' => '9 ; 15 ; -', 'output_admin' => '請輸入第一個數 ; 請輸入第二個數 ; 請輸入要執行的運算元 ; 9-15=-6',
               'id' => '11']
            );


      DB::table('questions')->insert(
          ['section_id' => '7','title' => '多益證書','content' => '小蔡最近剛考完多益，他的目標是875分，
          由於明天成績就要出來了，他想要事先寫好一個程式，告訴他結果與目標的差別，
          還有他能獲得到什麼證書(10-215橘、216-465棕、466-725綠、726-855藍、856-990金)，
          若輸入成績不合哩，需顯示，顯示方法如下:

          範例1:
          請輸入多益成績
          996
          輸入錯誤


          範例2:
          請輸入多益成績
          840
          成績低於目標35分
          你將獲得藍色證書

          範例3:
          請輸入多益成績
          900
          成績高於目標25分
          你將獲得金色證書',
              'hint' => 'nested if', 'difficulty' => '2', 'type' => '2', 'is_discuss' => '0',
              'include' => '1-1運算元 1-2輸出 1-3輸入 2-4巢狀if', 'input_student' => '840',
               'output_student' => '請輸入多益成績 ; 成績低於目標35分 ; 你將獲得藍色證書',
              'input_admin' => '99', 'output_admin' => '請輸入多益成績 ; 成績低於目標776分 ; 你將獲得橘色證書',
               'id' => '12']
               );

       DB::table('questions')->insert(
           ['section_id' => '8','title' => '找偶數','content' => '請運用for迴圈列印出(1~使用者輸入的正整)
           的所有偶數，顯示方法如下
           請輸入一正整數
           6
           1~6偶數為
           2
           4
           6 ',
          'hint' => 'for', 'difficulty' => '1', 'type' => '1', 'is_discuss' => '0',
          'include' => '1-1運算元 1-2輸出 1-3輸入 3-1for', 'input_student' => '6',
          'output_student' => '請輸入一正整數 ;
          1~6偶數為
          2
          4
          6 ',
          'input_admin' => '11', 'output_admin' => '請輸入一正整數 ;
          1~11偶數為
          2
          4
          6
          8
          10',
          'id' => '13']
                );
        DB::table('questions')->insert(
          ['section_id' => '8','title' => '階乘計算機','content' => '惠姊最近在學排列組合，為了加快寫作業速度，
          她寫了一支程式幫她快速算出階乘答案，此程式會先詢問使用者要算幾階乘，並直接顯示答案，顯示方法如下:
          請問要算幾階乘呢?
          5
          5!=120',
         'hint' => 'for', 'difficulty' => '2', 'type' => '2', 'is_discuss' => '0',
         'include' => '1-1運算元 1-2輸出 1-3輸入 3-1for', 'input_student' => '5',
         'output_student' => '請問要算幾階乘呢? ; 5!=120',
         'input_admin' => '6', 'output_admin' => '請問要算幾階乘呢? ; 6!=720',
         'id' => '14 ']
               );
       DB::table('questions')->insert(
         ['section_id' => '9','title' => '倒轉四位數','content' => '請撰寫一程式可讓使用者輸入一個四位數，
         並將此四位數倒過來成為新四位數(91344319)，最後計算出此兩位數的差，顯示方法如下
         [例1]
         請輸入四位數
         7612
         新四位數為2167
         新四位數比原四位數少5445
         [例2]
         請輸入四位數
         1234
         新四位數為4321
         新四位數比原四位數多3087

         [例3]
         請輸入四位數
         5555
         新四位數為5555
         新四位數與原四位數一樣',
        'hint' => 'while', 'difficulty' => '3', 'type' => '1', 'is_discuss' => '0',
        'include' => '1-1運算元 1-2輸出 1-3輸入 2-1if 3-2while', 'input_student' => ' 1234',
        'output_student' => '請輸入四位數 ; 新四位數為4321 ; 新四位數比原四位數多3087',
        'input_admin' => '6123', 'output_admin' => '請輸入四位數 ; 新四位數為3216 ; 新四位數比原四位數少2907',
        'id' => '15']
              );
      DB::table('questions')->insert(
        ['section_id' => '10','title' => 'Bingo','content' => '楊楊要帶一個營隊，她負責一個遊戲活動，
        由於不想要花時間跟金錢印彩卷，因次聰明的楊楊想到用新學的程式寫一個簡易遊戲系統，且預設中獎號碼為68，
        顯示結果如下
        請猜1-100的數
        62
        太小，請猜62-100的數
        80
        太大，請猜62-80的數
        85
        怎麼可能，請重新猜
        68
        恭喜猜中了喔',
       'hint' => 'do while', 'difficulty' => '3', 'type' => '2', 'is_discuss' => '0',
       'include' => '1-1運算元 1-2輸出 1-3輸入 3-3do while', 'input_student' => '',
       'output_student' => '',
       'input_admin' => '90 ; 92 ; 68', 'output_admin' => '請猜1-100的數 ; 太大，請猜1-90的數 ;
        怎麼可能，請重新猜 ; 恭喜猜中了喔',
       'id' => '16']
             );

     DB::table('questions')->insert(
       ['section_id' => '11','title' => '列印數串','content' => '請運用for迴圈，列印出以下數字排列:
       1111
       222
       33
       4',
      'hint' => '巢狀迴圈', 'difficulty' => '1', 'type' => '1', 'is_discuss' => '0',
      'include' => '1-1運算元 1-2輸出 3-4巢狀迴圈', 'input_student' => '',
      'output_student' =>
      '1111
      222
      33
      4',
      'input_admin' => '', 'output_admin' =>
      '1111
      222
      33
      4',
      'id' => '17']
            );


    }
}
