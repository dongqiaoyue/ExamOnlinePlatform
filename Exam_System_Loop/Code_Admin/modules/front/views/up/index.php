<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>
<script src="<?=Url::base()?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- <link rel="stylesheet" href="<?=Url::base()?>/bootstrap/css/bootstrap.min.css"> -->
<style type="text/css">
@-moz-document url-prefix() {
  fieldset { display: table-cell; }
}
a{
  border:none;
  bblr:expression(this.onFocus=this.blur());/*IE使用*/
  outline-style:none;/*FF使用*/
}
a:link,a:hover,a:visited,a:active{
  outline-style:none;       /*解决bootstrap超链接点击时出现的虚边框*/
  text-decoration: none;
}
.top{
  border:1px solid red;
  height: 100px;
  width:100%;
  line-height: 100px;
  text-align: center;
  background-image: url(<?=Url::base()?>/front/img/top.png);
  background-repeat: no-repeat;
  background-size: cover;
  margin-bottom: 15px;
  margin-top: -5%;
  z-index: 999;
}
.topIfo{
  color:white;
  font-size: 30px;
  letter-spacing: 5px;
}
.wrap{
  width:100%;
  margin:0 auto;
  border:1px solid #E6E6E6;
  padding:10px;

}
.load{
  color:red;
}
.view1,.view1 th{
  text-align: center;
}
.view1 td a{
  background-image: url(<?=Url::base()?>/front/img/edit.gif);
  color:#0000ff;
  background-position:left;
  background-repeat: no-repeat;
  padding-left:10px;
}
.view1 td a:hover{
  text-decoration: none;
  color:red;
}
.view1 td{
  border:2px solid #fff;
}
.contain,.contain1,.contain2{
  padding:0;
  width:100%;
  min-height:500px;
  margin:0 auto;
  border:1px solid #EAEAEA;
  display: none;
  height:auto;
}
.contain2,.contain1{
  height:auto;
  padding-bottom: 10px;
}
.contain img,.contain1 img,.contain2 img{
  width:96%;
}
.head2{
  height: 30px;
  line-height: 30px;
  width: 100%;
  background-color: #F0F0F0;
  text-align: center;
  font-size: 14px;
  color:black;
  font-weight: bold;
}
.view{
  width:90%;
  margin:0 auto;
}
.view tr{
  height: 40px;
  line-height: 40px;
  padding: 20px;
  /*border:1px solid gray;*/
}
.view tr td{
  text-align:left;
}
#describe{
  width:68%;
  margin-left: 5%;
  min-height:300px;
  height:auto;
  padding:10px;
  border:1px solid gray;
}
#describe p img{
  max-width: 100%;
}
#checkTime,#abcd{
  color:red;
}
.work{
  width:90%;
  margin:0 auto;
  min-height: 102px;
  height:auto;
}
#selfAnswer,#homework{
  width:100%;
  padding:5px 10px;
  min-height: 100px;
  line-height: 30px;
  height:auto;
}
#selfAnswer p img,#homework p img{
  max-width: 100%;
  width: auto;
}
#myselfAnswer{
  width: 100%;
  min-height:100px;
  height:auto;
  padding:10px 16px;
  background-color: #fff;
  border:1px solid #e1e1e1;
}
#myselfAnswer p{
	width:100%;
	word-wrap:break-word;
	word-break:break-all;
	overflow: hidden;

}
input{
  width:80px;
  height:30px;
  line-height: 30px;
}

</style>
  </head>
  <div class="page-title">
  	<span class="title">作业提交</span>
  	<div class="description">
  				在这里你可以进入考试
  	</div>
  </div>
<div class="Bigbox">
<!-- <header class="top">
<span class="topIfo">成都信息工程大学作业管理平台</span>
</header> -->
<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">
<div class="wrap ">

<table id="myTable" class="table  table-hover  view1 table-bordered ">
    <!-- On rows -->
    <thead>
  <tr class="active">
      <th>序号</th>
      <th>作业名称</th>
      <th>所属班级</th>
      <th>截止时间</th>
      <th>是否截止</th>
      <th>上传状态</th>
      <th>作业内容</th>
      <th>个人答案</th>
      <th>操作</th>
  </tr>
  </thead>
</table>
</div>
<br>
<div class="contain">
  <header class="head2">
  平时作业详情
  </header>
  <table class="view">
    <tr><td>教师姓名：<span id="teachername"></span></td><td>教学班级：<span id="Class"></span></td></tr>
    <tr><td>作业名称：<span id="workname"></span></td><td>截止日期：<span id="endtime"></span></td></tr>
    <tr><td>是否可见：<span id="isview"></span></td><td>附件下载：<a id="download"></a></td></tr>
    <tr><td>作业内容描述：</td><td></td></tr>
  </table>
    <div id="describe">

    </div><!--describe结束 -->
</div><!--dcontain结束 -->
<br>
<div class="contain1">
  <header class="head2">
  个人答案详情
  </header>
  <table class="view">
    <tr><td>教师姓名：<span id="teachername1"></span></td><td>教学班级：<span id="Class1"></span></td></tr>
    <tr><td>作业名称：<span id="workname1"></span></td><td>上传日期：<span id="uptime1"></span></td></tr>
    <tr><td>作业等级：<span id="abcd"></span></td><td>批阅时间：<span id="checkTime">未批阅</span></td></tr>
    <tr><td>个人作业答案：</td><td></td></tr>
  </table>
  <!-- <div id="selfAnswer">
     <textarea id="homework">1234</textarea>
  </div> -->
  <div class="work">
      <div id="myselfAnswer"></div>
    <!-- <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
    <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
    <script type="text/javascript">
    //ueditor编辑器
    var upp = UE.getEditor('myselfAnswer');
    upp.setContent("hello");
    </script> -->
    </div>
</div><!--contain1结束-->
<br>
<div class="contain2">
  <header class="head2">
    学员上传作业
  </header>
  <table class="view">
    <tr><td>教师姓名：<span id="teachername2"></span></td><td>教学班级：<span id="Class2"></span></td></tr>
    <tr><td>作业名称：<span id="workname2"></span></td><td>截止日期：<span id="endtime2"></span></td></tr>
    <tr><td>作业内容：</td>
    <td>
    </td></tr>
  </table>
      <div class="work">
            <!-- <textarea id="homework">1234</textarea> -->
      <div id="homework"></div>
    <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
    <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
    <script type="text/javascript">
    //ueditor编辑器
    var ue = UE.getEditor('homework');
    </script>
    <input id="upLoad" type="submit" value="确认上传">
    </div>
</div><!--contain2结束-->

<div class="text"></div>

</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
     function num(s){
            return s<10 ? '0'+s:s;
           };

          var myDate = new Date();
          var year = myDate.getFullYear();
          var month = myDate.getMonth()+1;
          var date = myDate.getDate();
          var h = myDate.getHours();
          var m = myDate.getMinutes();
          var s = myDate.getSeconds();
          var now = year+'-'+num(month)+'-'+num(date)+' '+num(h)+':'+num(m)+':'+num(s);

        $(document).ready(function(){
          var addTr = '<tbody><tr class=""><td class=" num"></td><td class=" Name"></td><td class=" ClassNum"></td><td class=" date"></td><td class=" overdue">未截止</td><td class=" load"></td><td class=""><a class="look" href="#">详情</a></td><td class=""><a class="check" href="#">详情</a></td><td class=""><a class="upTo" href="#">上传</a></td></tr></tbody>';

          $.ajax({
            type:"GET",
            url:"<?=Url::toRoute('up/get-homeworks');?>",
            dataType:"json",
            cache:false,
            success:function(data){
              $.each(data,function(index,content){
                   $("#myTable").append(addTr);
                   $('.num:last').html(index+1);
                   $('.Name:last').html(content.HomeworkName);
                   $('.date:last').html(content.DeadTime);
                   $('.ClassNum:last').html(content.TeachingName);
                    $('.check:last').attr('name',content.HomeworkID);
                     $('.load:last').html(content.isUpload);
                   if(content.DeadTime<now){
                      $('.overdue:last').html("已截止");
                      $('.overdue:last').css('color','red');
                  }
              });

              //显示个人答案
              $(".check").click(function(){
              var i=0;
              var i = $(this).index(".check");
                $.ajax({
                  type:"get",
                  url:"<?=Url::toRoute('up/get-upload-homework');?>",
                  data:{"HomeworkID":$(this).attr('name')},
                  dataType:"json",
                  success:function(text){
                  $('.contain1').css('display','block');
                 $('.contain2').css('display','none');
                 $('.contain').css('display','none');
                 $('#teachername1').html(text.TeacherName);
                 $('#Class1').html(text.TeachClass);
                 $('#workname1').html(data[i].HomeworkName);
                 $('#uptime1').html(text.uploadTime);
                 $('#abcd').html(text.ScoreGrade);
                 if(text.MarkDate){
                  $('#checkTime').html(text.MarkDate);
                 }
                  var mama = text.WorkContent;
                  $('#myselfAnswer').html(' ');
                  $('#myselfAnswer').append(mama);
                  },
                  error:function(){
                    alert("数据获取失败！");
                  }
                });
              });

                    //显示作业说明
            $(".look").click(function(){
              var i=0;
              var i = $(this).index(".look");
             $('.contain').css('display','block');
             $('.contain1').css('display','none');
             $('.contain2').css('display','none');
             $('#teachername').html(data[i].TeacherName);
             $('#Class').html(data[i].TeacherName);
             $('#workname').html(data[i].HomeworkName);
             $('#endtime').html(data[i].DeadTime);
             $('#isview').html(data[i].IsStuSee);
             $('#download').html('下载');
             $('#describe').html(data[i].WorkDesc)
          });

              //显示上传
           $(".upTo").click(function(){
              var i=0;
              var i = $(this).index(".upTo");
              if(data[i].DeadTime<now){
                 alert("该作业已过期，你已不能提交！");
                 parent.location.reload();
              }else{
             $('.contain2').css('display','block');
             $('.contain1').css('display','none');
             $('.contain').css('display','none');
             $('.contain2').find('#upLoad').attr('name',data[i].HomeworkID);
             $('#teachername2').html(data[i].TeacherName);
             $('#Class2').html(data[i].TeacherName);
             $('#workname2').html(data[i].HomeworkName);
             $('#endtime2').html(data[i].DeadTime);
             $('#homeword').html(data[i].WorkContent);
            }
          });
            },
            error:function(xmlHttpRequest,textStatus,errorThrown){
              alert("发生错误："+xmlHttpRequest.readyState+textStatus);
            }
          });



           $("#upLoad").click(function(){
           // var serializeFile = $("#file").serialize();
           var homeworkId = $(this).attr('name');

              $.ajax({
                type:"POST",
                url:'<?=Url::toRoute('up/upload-homework');?>',
             //   data:serializeFile,
             data:{"HomeworkID":homeworkId,"WorkContent":ue.getContent()},
             cache:false,
                success:function(data){
                  alert("提交成功！");
                 parent.location.reload();
                },
                error:function(){
                  alert("提交失败，请稍后再试！");
                }
              })
           });

        })
        </script>
