<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<style type="text/css">
.check{
    border:1px solid red;
}
*{
    font-weight:bold;
}
select{
    height: 28px;
}
option{
    font-size:14px;
}
.col-xs-2{
    padding-left:2px;
}
label{
    min-width:130px;
}
.radio-inline{
    min-width:50px;
}
.box{
    min-height: 540px;
    margin-bottom: 0px;
    padding-bottom: 30px;
}
.box-body{
    margin:0 20px; 
    padding:40px;
    padding-left: 5%; 
    border:2px solid #56ABAB; 
    border:1px solid #C6C6C6;
    min-width:810px;
    min-height: 450px;
    background-color: #f9f9f9;
}
.row{
    min-height:56px;
}
input[type="text"]{
    height:30px;
    border:1px solid #969696;
}
input:focus{
    box-shadow: 0 1px 1px rgba(0,0,0,0.075) inset;
    border-color:#4c9ed9;
    transition: border-color ease-in-out .10s,box-shadow ease-in-out .10s;
    -moz-transition: border-color ease-in-out .10s,box-shadow ease-in-out .10s;
    -o-transition: border-color ease-in-out .10s,box-shadow ease-in-out .10s;
    -webkit-transition: border-color ease-in-out .10s,box-shadow ease-in-out .10s;
}
</style>
<link rel="stylesheet" type="text/css" href="<?=Url::base()?>/component/time/jquery.datetimepicker.css"/>
<?php $this->endBlock(); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-22">
            <div class="box" >
                <div class="box-header" >
                    <h3 class="box-title">考试计划管理->添加考试计划</h3>
                </div>
                <h1></h1>

                <div class="box-body">
                    <?php  ActiveForm::begin(['id' => 'examPlanAdd', 'class' => 'form-horizontal' ,'action' => '' ,'method' => 'post'])?>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label">计划类型：</label>
                            <div class="col-xs-2">
                                <select id="plan-choice" class="form-group" style="width:99%;" name="Examplan[Type]" id="collegeChose">
                                    <option value="0">请选择</option>
                                    <option value="1">期末考试</option>
                                    <option value="2">过程化考核</option>
                                    <option value="3">其他</option>
                                </select>
                            </div>

                             <label for="inputEmail3" class="col-sm-1 control-label">计划名称：</label>
                            <div class="col-xs-2">
                                 <input type="text" id="moduleName01" name="Examplan[ExamPlanName]">
                            </div>

                            <label for="inputEmail3" class="col-sm-1 control-label">答卷时间：</label>
                            <div class="col-xs-2">
                                <input type="text" id="moduleName01" class="NeedTime" name="Examplan[ExamTime]">
                            </div>
                        </div>
                    </div>

                  <!--   <h1></h1> -->
                    <div class="row" id="row-plan" style="display: none;">
                        <div class="form-group" id="plan-detail">

                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label">所属学期：</label>
                            <div class="col-xs-2">
                                <select class="form-group" style="width:99%;" name="Examplan[Term]" id="termChose">
                                    <option value="0">请选择</option>
                                    <?php
                                    foreach($term as $key=>$data){
                                        echo "<option value='" . $data->CuitMoon_DictionaryName . "'>". $data->CuitMoon_DictionaryName."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-xs-1" style="width: 130px;">
                                <button class="btn btn-warning btn-sm" type="button" id="classChose">选择考试班级</button>
                            </div>
                          <!--   <label for="inputEmail3" class="col-xs-1 control-label">考试班级：</label> -->
                            <div class="col-xs-3" id="teachingClass"></div>

                            <div class="col-xs-1">
                                <label class="inputEmail3">总人数：</label>
                            </div>
                            <div class="col-xs-1" id="student-num">
                            </div>
                        </div>
                    </div>

                    <!-- <h1></h1> -->
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label">权值：</label>
                            <div class="col-xs-2">
                                <input type="text" id="moduleName" name="Examplan[Weights]">
                            </div>

                            <label for="inputEmail3" class="col-sm-1 control-label">考试通过分值：</label>
                            <div class="col-xs-2">
                                <input type="text" id="moduleName" name="Examplan[PassScore]">
                            </div>


                        </div>
                    </div>

                   <!--  <h1></h1> -->
                    <div class="row">
                        <div class="form-group">

                            <label for="inputEmail3" class="col-sm-1 control-label">是否需要预约：</label>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="Examplan[IsFixedPlace]" id="inlineRadio1" value="1"> 是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="Examplan[IsFixedPlace]" id="inlineRadio2" value="0" checked> 否
                                </label> 
                            </div>
                        </div>
                    </div>

                    <!-- <h1></h1> -->
                    <div class="row" style="margin-top: 30px;">
                        <div class="form-group">
                            <div class="col-xs-22">
                                <button id="questionSubmit" type="button" class="btn btn-primary">提交</button>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="edit_close">×</button>
                <h3>教学班级选择</h3>
            </div>
            <div class="modal-body" id="checkClass">

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal" id="edit_close">关闭</a>
                <a id="edit_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('footer');  ?>
<script src="<?=Url::base()?>/component/time/jquery.datetimepicker.full.min.js"></script>
<script>
    //ajax请求教学班级
    $('#classChose').click(function () {
        var PlanChoice = $('#plan-choice').val();
        if (PlanChoice == '0') {
            alert('请选择考试计划类型');
        } else if (PlanChoice == '1'){
            $.ajax({
                type:'post',
                url:'<?=Url::toRoute('exam-plan/get-class')?>',
                dataType:'json',
                data:{
                    'CourseID':'<?=$project?>',
                    'Term':$('#termChose').val(),
                    'Department':'<?=$college?>',
                },
                success:function (value) {
                    $('#checkClass').empty();
                    for(var tmp in value){
                        $('#checkClass').append("<div class='checkbox'><label><input type='checkbox' name='class'  value='"+ value[tmp]['TeachingClassID'] +"|"+ value[tmp]['TeachingName'] +"'>"+ value[tmp]['TeachingName'] +"</input></label></div>")
                    }
                }
            });
            $('#edit_dialog').modal('show');
        } else {
            $.ajax({
                type:'post',
                url:'<?=Url::toRoute('exam-plan/get-class-one')?>',
                dataType:'json',
                data:{
                    'CourseID':'<?=$project?>',
                    'Term':$('#termChose').val(),
                    'Department':'<?=$college?>',
                },
                success:function (value) {
                    $('#checkClass').empty();
                    for(var tmp in value){
                        $('#checkClass').append("<div class='checkbox'><label><input type='checkbox' name='class'  value='"+ value[tmp]['TeachingClassID'] +"|"+ value[tmp]['TeachingName'] +"'>"+ value[tmp]['TeachingName'] +"</input></label></div>")
                    }
                }
            });
            $('#edit_dialog').modal('show');
        }

    });

    $('#edit_close').click(function () {
        $('div').remove('.checkbox');
    });

    $('#plan-choice').change(function (e) {
        $('#plan-detail').empty();
        $('#row-plan').show();
        e.preventDefault();
        switch ($(this).val())
        {
            case '1':
                $('#plan-detail').append('<div id="choose" style="width:100%; height:50px;">' +
                    '<label class="col-sm-1 control-label" id="TotalTime">共几场考试：</label>' +
                    '<div class="col-xs-2">' +
                    '<input type="text" class="checkNum" id="TestNum" name="ExamNum">' +
                    '</div>' +
                    '<label class="col-sm-1 control-label">每场考试人数：</label>' +
                    '<div class="col-xs-2">' +
                    '<input type="text" class="checkNum1" id="ExamStuNUm" name="ExamStuNum">'+
                    '</div>'+
                    '<button type="button" id="Time1" class="btn btn-info btn-sm" style="margin-left:15px;">确定</button>'+
                    // '<input type="button" id="Time1" value="确定">'+
                    '</div>'
                    );
                  $('#Time1').click(function(){
                     var isExit=$(".lab2").length;
                     if(isExit>0){
                                $(".lab1").remove();
                                $(".lab2").remove();
                        }
                     for(var i=$("#TestNum").val();i>=1;i--)
                     {
                        var class1 = "hello"+i;
                        var text1='<div id="form-group"><div class="lab2" style="margin:5px; margin-buttom:10px; height:30px; width:72%; float:left;">开始时间：<input type="text" style="margin-right:20px;" class="tab1 addClass" id="GetClass" name="StartTime[]">结束时间：<input class="tab2 addClass" type="text" id="TheClass" name="EndTime[]"><br></div></div>';
                        var text2='<div class="lab1" style="margin:5px; margin-left:10%; height:30px; width:15%; float:left;font-weight:bold">第'+i+'场考试——</div>';
                            $("#choose").after(text2,text1);
                            $("#GetClass").addClass(class1);
                           // $("#TheClass").addClass(class1);
                      }
                      $(".lab1").css('color','#ff2121');
                      $(".lab1").last().css('margin-bottom','25px');
                      $(".lab2").last().css('margin-bottom','25px');
                      //时间选择框插件
                       $('.tab1').datetimepicker();
                      $('.tab2').datetimepicker();
                    $.datetimepicker.setLocale('ch');//设置中文

                    //输入框失去焦点，自动添加结束时间
                    jQuery.addTime = function(obj1){
                        $(obj1).blur(function(e){
                        var needTime = Number($(".NeedTime").val());  //获取考试所需时间
                        var start=$(obj1).val();
                        var Date1=start.split(" ")[0];
                        var startTime1=start.split(" ")[1];
                        var hours1 = Number(startTime1.split(":")[0]);  //小时
                        var minues1 = Number(startTime1.split(":")[1]); //分钟
                        var k1=parseInt(needTime/60);
                        var k2=needTime%60;
                        var hours2=hours1+k1;
                        var minues2=minues1+k2;

                            if(minues2>=60){
                                hours2 +=1;
                                minues2 = minues2-60;
                            }
                            if(minues2>60){
                                minues2 -=60;
                                hours2 +=1;
                            }
                            if(hours1<10){
                                hours2="0"+hours2;
                            }
                            if(minues2<10){
                                minues2="0"+minues2;
                            }
                            $(this).siblings('input').val(Date1+" "+hours2+":"+minues2);
                        });
                    };
                        var totalTest = $("#TestNum").val();
                        for(var i=1;i<=totalTest ;i++){
                            $.addTime(".hello"+i);
                        }

                  });

                  $(document).ready(function(){
                        jQuery.checkNumber = function(obj){
                        $(obj).blur(function(){
                                var num2 = $(this).val();
                                if(isNaN(num2))
                                {
                                    alert("请输入正整数！");
                                    $(this).addClass("check");
                                    $(this).focusin();
                                }else{
                                    $(this).removeClass("check");
                                }
                        });
                      };
                         $.checkNumber(".checkNum");
                         $.checkNumber(".checkNum1");
                         $.checkNumber(".checkNum2");
                         $.checkNumber(".checkNum3");
                         $.checkNumber(".NeedTime");

                  });

                break;
            case '2':
                $('#plan-detail').append('<div class="row" style="margin-left: 0;"><label class="col-sm-1 control-label">第几次考试：</label>' +
                    '<div class="col-xs-2">' +
                    '<input type="text" checkNum3" name="ExamNum">' +
                    '</div> ' +
                    '<label class="col-sm-1">开始时间：</label> ' +
                    '<div class="col-xs-2">' +
                    '<input id="datetimepicker" type="text" name="StartTime">' +
                    '</div>' +
                    '<label class="col-sm-1">结束时间：</label>' +
                    '<div class="col-xs-2">' +
                    '<input id="datetimepicker1" type="text" name="EndTime"></div></div>');

                $('#datetimepicker').datetimepicker();
                $('#datetimepicker1').datetimepicker();
                $.datetimepicker.setLocale('ch');

                $("#datetimepicker").blur(function(){
                    var needTime = Number($(".NeedTime").val());
                    var start=$("#datetimepicker").val();
                    var Date1=start.split(" ")[0];
                    var startTime1=start.split(" ")[1];
                    var hours1 = Number(startTime1.split(":")[0]);
                    var minues1 = Number(startTime1.split(":")[1]);
                    var k1=parseInt(needTime/60);
                    var k2=needTime%60;
                    var hours2=hours1+k1;
                    var minues2=minues1+k2;
                     if(minues2>=60){
                        hours2 +=1;
                        minues2 = minues2-60;
                    }
                     if(hours1<10){
                        hours2="0"+hours2;
                        }
                    if(minues2<10){
                        minues2="0"+minues2;
                    }
                    $("#datetimepicker1").val(Date1+" "+hours2+":"+minues2);
                });

                $(".checkNum3").blur(function CheckNum(){
                        var num1 = $(".checkNum3").val();
                        if(isNaN(num1))
                        {
                            alert("请输入正整数！");
                            $(".checkNum3").addClass("check");
                            $(".checkNum3").focus();
                        }else{
                            $(".checkNum3").removeClass("check");
                        }
                  });
                break;
            case '3':
             var text =  '<label class="col-sm-1 col-sm-offset-1">开始时间</label> ' +
                    '<input class="col-sm-1" id="datetimepicker" type="text" name="StartTime" style="width:155px;">' +
                    '<label class="col-sm-1 col-sm-offset-1">结束时间</label>' +
                    '<input class="col-sm-1" id="datetimepicker1" type="text" name="EndTime" style="width:155px;">';
             $('#plan-detail').append(text);

                $('#datetimepicker').datetimepicker();
                $('#datetimepicker1').datetimepicker();
                $.datetimepicker.setLocale('ch');

                $("#datetimepicker").blur(function(){
                    var needTime = Number($(".NeedTime").val());
                    var start=$("#datetimepicker").val();
                    var Date1=start.split(" ")[0];
                    var startTime1=start.split(" ")[1];
                    var hours1 = Number(startTime1.split(":")[0]);
                    var minues1 = Number(startTime1.split(":")[1]);
                    var k1=parseInt(needTime/60);
                    var k2=needTime%60;
                    var hours2=hours1+k1;
                    var minues2 = minues1+k2;
                    if(minues2>=60){
                        hours2 +=1;
                        minues2 = minues2-60;
                    }
                     if(hours1<10){
                        hours2="0"+hours2;
                        }
                    if(minues2<10){
                    //    alert(1);
                         minues2="0"+minues2;
                    }
                    $("#datetimepicker1").val(Date1+" "+hours2+":"+minues2);
                });
                break;
        }
    });

    //将选中的教学班级添加到页面上
    $('#edit_dialog_ok').click(function () {
        $('#edit_dialog').modal('hide');
        var classIDs = [];
        $('input[name="class"]:checked').each(function (i) {
            classIDs.push($(this).val());
        });
        for(var tmp in classIDs) {
            var Tmp_One = false;
            var TmpData = classIDs[tmp].split("|");
            $('#teachingClass').children().each(function (i) {
                if ($(this).children().val() == TmpData[0]) {
                    Tmp_One = true;
                    return false;
                }
            });
            if (Tmp_One != true) {
                $('#teachingClass').append("<div><button class='btn btn-danger btn-xs' id='classDelete'>x</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='teachingClass[]' value='" + TmpData[0] + "'/>" + TmpData[1] + "<div>");
            }
            $('div').remove('.checkbox');
        }
        getSudentNum();
    });

    function getSudentNum() {
        var classIDs = [];
        $('#teachingClass').find('input').each(function (i) {
            classIDs.push($(this).val());
        });
        $.ajax({
            type:'get',
            url:'<?=Url::toRoute('exam-plan/get-student-num')?>',
            dataType:'json',
            data:{ids:classIDs},
            success:function (value) {
                $('#student-num').text(value);
            }
        });
    }

    $(document).on("click","button#classDelete",function () {
        $(this).parent().remove();
        getSudentNum();
    });

    //提交前检测
    $('#questionSubmit').click(function (e) {
        e.preventDefault();
        if ($('#teachingClass').html() != '') {
            if ($('#plan-choice').val() == '1') {
                var time = $('#TestNum').val();
                var num =  $('#ExamStuNUm').val();
                var total =  $('#student-num').text();
                if (time * num >= total) {
                    $('#examPlanAdd').submit();
                } else {
                    alert('期末考试计划中总人数必须必考试人数多');
                }
            } else {
                $('#examPlanAdd').submit();
                
            }
        } else {
            alert('班级不能为空啊');
        }

    });

    $('#examPlanAdd').bind('submit',function (e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type:'post',
            dataType:'json',
            url:'<?=Url::toRoute('exam-plan/create')?>',
            success:function (value) {
                if(value.error == 0){
                    admin_tool.alert('msg_info', '添加成功', 'success');
                    window.location.href = '<?=Url::toRoute('exam-plan/index')?>';
                } else {
                    alert(value.msg);
                }
            }
        })
    })


</script>

<?php $this->endBlock(); ?>
