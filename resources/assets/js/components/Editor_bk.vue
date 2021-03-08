<template> 
<div>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div id="dismiss">
            <i class="fas fa-arrow-left"></i>
        </div>

        <div class="sidebar-header">
            <h3>{{chapters}}</h3>
        </div>
        <ul class="list-unstyled components">
            <li v-for="section in sections">
                <a :href="'#pageSubmenu'+section.id" data-toggle="collapse" aria-expanded="false">{{section.title}}</a>
                <ul class="collapse list-unstyled" :id="'pageSubmenu'+section.id" v-for="question in questions">
                    <li v-if="section.id==question.section_id">
                        <a :href="'/compiler?qid='+question.id">{{question.title}}</a>     
                    </li>
                </ul> 
            </li>               
        </ul>
        <!-- <ul class="list-unstyled CTAs">
            <li>
                <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
            </li>
            <li>
                <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
            </li>
        </ul> -->
    </nav>
    
    <!-- Page Content  -->
    <div id="content">       
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>本章題目</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">
                                <span class="glyphicon glyphicon-check"></span> 回首頁
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/userpage">
                                <span class="glyphicon glyphicon-user"></span> {{user_name}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/userhw">
                                <span class="glyphicon glyphicon-check"></span> Homework
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>        
    </div>
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel-group">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1"><i class="fas fa-book-open"></i> Question</a> 
                        <a href="#" v-if="isStarred" @click.prevent="unstarred(post)">
                            <i class="fas fa-star s_color pull-right"></i>
                        </a>
                        <a href="#" v-else @click.prevent="starred(post)">
                            <i class="far fa-star r_color pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse">
                    <div class="panel-body">
                    <!-- style="max-height:250px; overflow-y:scroll;"     -->
                        <h4 v-html="'題目：'+title"></h4>
                        <h4 v-html="'內容：'+content"></h4>
                    </div>
                    <!-- <div class="panel-footer">Panel Footer</div> -->
                </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse2"><i class="fas fa-bell"></i> Hint</a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse ">
                    <div class="panel-body">
                        <h4>提示：{{hint}}</h4>
                        <h4 v-if="difficulty===3">難易度：難</h4>
                        <h4 v-else-if="difficulty===2">難易度：中</h4>
                        <h4 v-else>難易度：易</h4>
                        <h4 v-if="type===1">型態：生活型</h4>
                        <h4 v-else>型態：學術型</h4>
                        <h4>包含章節：{{include}}</h4>
                    </div>
                    <!-- <div class="panel-footer">Panel Footer</div> -->
                </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse3"><i class="fas fa-code"></i> Sample</a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse ">
                    <div class="panel-body">
                        <h4 class="sample">Sample Input:</h4>
                        <h4><span v-html="input"></span></h4>
                        <h4 class="sample">Sample Output:</h4>
                        <h4><span v-html="output"></span></h4>
                    </div>
                    <!-- <div class="panel-footer">Panel Footer</div> -->
                </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="editorArea col-md-12">
                <div id="editor" ></div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#testModal" @click="initOutput()" >測試</button>
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#judgeModal"  @click="initOutput()">提交</button>
            </div>                
        </div>
        <!-- <div class="col-sm-4" style="background-color:lavenderblush;"></div> -->
    </div>
    </div>
    </div>
<!-- Test Modal -->
    <div id="testModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">傳送測試資料?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 form-group">
                    <textarea class="form-control" name="" id="" cols="30" rows="10" placeholder="輸入測試資料" v-model="test_input"></textarea>
                </div>
                <div class="col-md-6">
                    <h3>回傳值</h3>
                    <i class="fas fa-spinner" v-if="test_output=='?'"></i>
                    <span v-html="test_output" v-else></span>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="useSampleInput()">代入題目Sample input</button>
                <button type="button" class="btn btn-primary" @click="sendTestCode()">傳送</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
            </div>
            </div>
        </div>
    </div> 
    <!-- Judge Modal -->
        <div id="judgeModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">確認提交?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    
                </div>
                <div class="modal-body row">
                    <div class="col-md-6" style="margin:auto; width: 50%;">
                        <!-- <h3>回傳結果</h3> -->
                        <!-- <i class="fas fa-spinner" v-if="judge_output=='?'"></i>
                        <i class="fas fa-check-circle fa-lg text-success" v-else-if="judge_output=='AC'" v-html="' 解題成功 (AC)'"></i>
                        <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output=='RE'" v-html="' 運行時錯誤 (RE)'"></i>
                        <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output=='CE'" v-html="' 無法編譯 (CE)'"></i>
                        <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output=='WA'" v-html="' 答案錯誤 (WA)'"></i>
                        <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output!=''" v-html="' 解題失敗'"></i>
                        <br><br>
                        <a v-if="judge_output!='?' && judge_output!='' && recqid && qstatus=='AC'" :href="'/compiler?qid='+recqid" class="btn btn-primary btn-md active">推薦題目:{{recqid_detail}}<br>出題老師:{{recqid_adminname}}</a>
                        <a v-if="judge_output!='?' && judge_output!='' && recqid!=question_id && qstatus!='AC'" :href="'/compiler?qid='+recqid" class="btn btn-primary btn-md active">推薦題目:{{recqid_detail}}<br>出題老師:{{recqid_adminname}}</a>
                        <a v-if="judge_output!='?' && judge_output!='' && recqid && qstatus!='AC'" :href="'/compiler?qid='+question_id" class="btn btn-primary btn-md active">重新答題</a>
                        <span v-else></span> -->
                        <i class="fas fa-spinner" v-if="judge_output=='?'"></i>
                        <div class="card text-center" v-if="judge_output!='?'&& judge_output!=''">
                            <div class="card-header">
                                <i class="fas fa-check-circle fa-lg text-success" v-if="judge_output=='AC'" v-html="' 解題成功 (AC)'"></i>
                                <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output=='RE'" v-html="' 運行時錯誤 (RE)'"></i>
                                <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output=='CE'" v-html="' 無法編譯 (CE)'"></i>
                                <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output=='WA'" v-html="' 答案錯誤 (WA)'"></i>
                                <i class="fas fa-times-circle fa-lg text-danger" v-else-if="judge_output!=''" v-html="' 解題失敗'"></i>
                            </div>
                            <div class="card-body" v-if="judge_output!='?' && judge_output!='' && recqid && qstatus=='AC'">
                                <h5 class="card-title"><strong>推薦題目</strong><i class="far fa-hand-point-right"></i>&nbsp;<a :href="'/compiler?qid='+recqid" class="btn btn-success btn-md active">{{recqid_detail}}</a></h5>
                                <div class="alert alert-light" role="alert" style="display:inline-block;">
                                    出題老師：{{recqid_adminname}}
                                </div>
                            </div>
                            <div class="card-body" v-if="judge_output!='?' && judge_output!='' && recqid!=question_id && qstatus!='AC'">
                                <h5 class="card-title"><strong>推薦題目</strong><i class="far fa-hand-point-right"></i>&nbsp;<a :href="'/compiler?qid='+recqid" class="btn btn-danger btn-md active">{{recqid_detail}}</a></h5>
                                <div class="alert alert-light" role="alert" style="display:inline-block;">
                                    出題老師：{{recqid_adminname}}
                                </div>
                            </div>
                            <div class="card-footer text-muted" v-if="judge_output!='?' && judge_output!='' && recqid && qstatus!='AC'">
                                <a :href="'/compiler?qid='+question_id" class="btn btn-info btn-md active">重新答題</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="sendCode()">確認提交</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                </div>
                </div>

            </div>
        </div>   
</div>            
<div class="overlay"></div>

</div>
                     
</template>

<script>

export default {
    mounted(){
        var strUrl = location.search;
        var getPara, ParaVal;
        var aryPara = [];
        console.log(this.isStarred);
        if (strUrl.indexOf("?") != -1) {
            var getSearch = strUrl.split("?");
            getPara = getSearch[1].split("&");
            for (var i = 0; i < getPara.length; i++) {
            ParaVal = getPara[i].split("=");
            aryPara.push(ParaVal[0]);
            aryPara[ParaVal[0]] = ParaVal[1];
            }
            //console.log(aryPara["oldCode"]);
            axios.get('/compiler/getQuestion/'+aryPara["qid"]).then(response => {
                this.section_id = response.data.question.section_id;
                this.title = response.data.question.title;
                this.content = response.data.question.content;
                this.hint = response.data.question.hint;
                this.difficulty = response.data.question.difficulty;
                this.type = response.data.question.type;
                this.include = response.data.question.include;
                this.input = response.data.input;
                this.output = response.data.output;
                this.user_id = response.data.user.id;
                this.user_name = response.data.user.name;
                this.question_id = aryPara["qid"];
                this.raw_input = response.data.question.input_student;
                this.jud_output = response.data.question.output_admin;
                this.jud_input = response.data.question.input_admin;
                this.isStarred = response.data.isStarred;
                this.recqid = response.data.recqid;
		        this.qstatus =response.data.qstatus;
                this.ccid = response.data.ccid;
                this.chapters = response.data.chapters;
                this.sections = response.data.sections;
                this.questions = response.data.questions;
                console.log(this.chapters);
            });
            if(aryPara["oldCode"]!=null){
                axios.get('/compiler/getOldCode/'+aryPara["oldCode"]).then(response => {
                    //console.log(response.data);
                    var editor = ace.edit("editor");
                    editor.setValue(response.data);
                });
            }
        }
        this.post = aryPara["qid"];
    },
     data() {
            return {
                section_id:"" ,
                title: "",
                content: "",
                hint: "",
                difficulty: "",
                type: "",
                include: "",
                input:"",
                raw_input:"",
                output:"",
                jud_input:"",
                jud_output:"",
                test_input:"",
                test_output:"",
                code:"",
                user_id:"",
                user_name:"",
                question_id:"",
                judge_output:"",
                isStarred: "",
                recqid:"",
                qstatus:"",
                recqid_detail:"",
                recqid_adminname:"",
                ccid:"",
                chapters:"",
                sections:[],
                questions:[],
            }
     },
     methods:{
         initOutput(){
             this.judge_output = "";
             this.test_output = "";
         },
         sendCode(){
            this.judge_output = '?';
            var editor = ace.edit("editor");
            this.code = editor.getValue();
              axios.post('/compiler/judgeCode',{
                code : this.code,
                sample_input : this.jud_input,
                sample_output : this.jud_output,
                user_id : this.user_id,
                question_id : this.question_id
            }).then(response => {
                console.log(response);
                this.judge_output = response.data.returnva;
                this.recqid = response.data.recqid;
                this.recqid_detail = response.data.recqid_detail.title;
                this.recqid_adminname = response.data.recqid_adminname;
                this.qstatus = response.data.qstatus;
            }).catch(error =>{
                this.update_msg = "失敗";
                console.log(error);
            })
         },
         sendTestCode(){
            this.test_output = '?';
            var editor = ace.edit("editor");
            this.code = editor.getValue();
             axios.post('/compiler/sendTest',{
                code : this.code,
                test_input : this.test_input,
            }).then(response => {
                console.log(response);
                this.test_output = response.data;
            }).catch(error =>{
                this.update_msg = "失敗";
                console.log(error);
            })
         },
         useSampleInput(){
            this.test_input = this.raw_input;
         },
         starred(post){
             axios.post('/compiler/starred/'+post)
                    .then(response => {
                    console.log("star");     
                    console.log(post);    
                    console.log(response);
                    this.isStarred = true;
                    }).catch(response => console.log(response.data));
             
         },
         unstarred(post){
              axios.post('/compiler/unstarred/'+post)
                    .then(response => { 
                    console.log("unstar");
                    console.log(post);     
                    console.log(response);
                    this.isStarred = false;
                    }).catch(response => console.log(response.data));
         }
     }
}
</script>
<style>
.output{
    background-color:lightblue;
    height: 750px;
}
.sample{
    color:red;
}
.editorArea{
    height:630px;
}
#editor{
    width: 100%;
    height: 100%;
    position: absolute;
}
/* ---------------------------------------------------
            SIDEBAR STYLE
        ----------------------------------------------------- */

#sidebar {
    width: 350px;
    position: fixed;
    top: 0;
    left: -350px;
    height: 100vh;
    z-index: 999;
    background: #7386D5;
    color: #fff;
    transition: all 0.3s;
    overflow-y: scroll;
    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.2);
}

#sidebar.active {
    left: 0;
}

#dismiss {
    width: 35px;
    height: 35px;
    line-height: 35px;
    text-align: center;
    background: #7386D5;
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
}

#dismiss:hover {
    background: #fff;
    color: #7386D5;
}

.overlay {
    display: none;
    position: fixed;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.7);
    z-index: 998;
    opacity: 0;
    transition: all 0.5s ease-in-out;
}
.overlay.active {
    display: block;
    opacity: 1;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #6d7fcc;
}

#sidebar ul.components {
    padding: 10px 0;
    border-bottom: 1px solid #47748b;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
    text-decoration:none;
}

#sidebar ul li a:hover {
    color: #7386D5;
    background: #fff;
    text-decoration:none;
}

#sidebar ul li>a,
a[aria-expanded="true"] {
    color: #fff;
    background: #6d7fcc;
    text-decoration:none;
}

a[data-toggle="collapse"] {
    position: relative;
}

ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #6d7fcc;
    text-decoration:none;
}

/* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

#content {
    width: 100%;
    padding: 20px;
    min-height: 100vh;
    transition: all 0.3s;
    position: absolute;
    top: 0;
    right: 0;
}
</style>

