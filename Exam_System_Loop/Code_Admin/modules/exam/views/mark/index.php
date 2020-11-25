
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$m_exam = new \app\models\teachplan\Examplan();
$session = Yii::$app->session;
?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<style>
.form-control{
    min-width: 150px;
    margin-right: 20px;
}
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">试卷批阅</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="view_btn" type="button" class="btn btn-xs btn-primary">自动批阅</button>
                            |
                            <button id="upGrade" type="button" onclick="upGrade('')" class="btn btn-xs btn-info">成绩上报</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="row">
                            <div class="col-sm-2">
                                <label>学期:&nbsp;</label>
                                <select class="form-control" id="term-choice">
                                    <?php foreach ($term as $value){?>
                                        <option value="<?=$value['CuitMoon_DictionaryName']?>" <?php if($value['CuitMoon_DictionaryName'] === $now_term){?>selected="selected" <?php }?>><?=$value['CuitMoon_DictionaryName']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>考试计划:&nbsp;</label>
                                <select class="form-control" id="teach-choice">

                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label>班级:&nbsp;</label>
                                <select class="form-control" id="class-choice">

                                </select>
                            </div>

                            <div class="col-sm-2">
                                <label>批阅情况:&nbsp;</label>
                                <select class="form-control" id="reviewing-situation">

                                </select>
                            </div>

                            <div class="col-sm-3" style="margin-top: 25px; margin-left: 30px;">
                                <input type="text" class="form-control" id="search">
                                <a onclick="searchAction()" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>搜索</a>
                            </div>
                        </div>


                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php

                                        echo '<th><button id="btn1" class="btn btn-default" type="submit">全部勾选</button>
                                        <button id="btn2" class="btn btn-default" type="submit">取消勾选</button></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'学号'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'姓名'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试开始时间'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试结束时间'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'座位IP'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试次数'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'试卷状态'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'修改状态'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending"  >'.'成绩'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'操作'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'异常处理'.'</th>';
                                        ?>

<!--                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>-->
                                    </tr>
                                    </thead>
                                    <tbody id="exam_paper_info">

                                    <?php
                                    if($choice['Term_Choice']) {
                                        $row = 0;
                                        if ($list){
                                            foreach ($list as $model) {
                                                echo '<tr id="rowid_' . $model->PaperID . '" class="option_sum">';
                                                echo '  <td><label><input name="checkbox" type="checkbox" value="' . $model->PaperID . '"></label></td>';
                                                echo '  <td>' . $model->StudentID . '</td>';
                                                echo '  <td>' . $model->StuName . '</td>';
                                                echo '  <td>' . $model->ExamBeginTime . '</td>';
                                                echo '  <td>' . $model->ExamEndTime . '</td>';
                                                echo '  <td>' . $model->MachineIP . '</td>';
                                                echo '  <td>' . $model->Memo . '</td>';
                                                switch ($model->DealState) {
                                                    case '0': $Tmp = '<span class="label label-danger">未批阅</span>';break;
                                                    case '1': $Tmp = '<span class="label label-primary">已批阅</span>';break;
                                                    case '2': $Tmp = '<span class="label label-success">已上报</span>';break;
                                                    case '3': $Tmp = '<span class="label label-warning">错误试卷</span>';break;
                                                    case '5': $Tmp = '<span class="label label-default">主观题待批</span>';break;
                                                    default:
                                                        $Tmp = '<span class="label label-danger">未批阅</span>';break;
                                                        break;
                                                }
                                                echo '  <td id="deal_stage_'.$model->PaperID.'">' . $Tmp . '</td>';
                                                echo '  <td>' . $model->ExamEndTime . '</td>';
                                                echo '  <td id="'.$model->PaperID.'-Score">' . $model->Score . '</td>';
                                                echo '  <td class="center">';
                                                $Tmp = $model->DealState ? '重新批阅' : '自动批阅';
                                                echo '      <a id="view_btn" onclick="markAction(' . "'$model->PaperID'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>'.$Tmp.'</a>';
                                                switch ($model->DealState) {
                                                    case '5':
                                                        echo '      <a id="edit_btn" onclick="markActionSelf(' . "'$model->PaperID'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>批阅主观题</a>';
                                                        break;

                                                    default:

                                                        break;
                                                }
                                                echo '      <a id="view_btn_1" onclick="correct(' . "'$model->PaperID'" . ')" class="btn btn-warning btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>答案修正</a>';

                                                // echo '      <a id="edit_btn" onclick="markActionSelf(' . "'$model->PaperID'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>手动批阅</a>';
                                                //
                                                //                                            if ($model->DealState == '1') {
                                                //                                                echo '      <a id="up_grade_'.$model->PaperID.'" onclick="upGrade(' . "'$model->PaperID'" . ')" class="btn btn-info btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>上报</a>';
                                                //                                            } else {
                                                //                                                echo '      <a iid="up_grade_'.$model->PaperID.'" onclick="upGrade(' . "'$model->PaperID'" . ')" class="btn btn-info btn-sm" disabled="disabled"  href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>上报</a>';
                                                //                                            }


                                                echo '  </td>';
                                                echo '  <td class="center">';
                                                switch ($model->ExamException) {
                                                    case '1':
                                                        echo ' <a onclick="exceptAction(\'' . $model->PaperID.' \')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看异常</a>';
                                                        break;
                                                    case '0':
                                                        echo ' <a onclick="exceptAction(\'' . $model->PaperID.' \')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>试卷正常</a>';
                                                        break;
                                                    default:
                                                        echo ' <a onclick="exceptAction(\'' . $model->PaperID.' \')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>未知</a>';
                                                        break;
                                                }
                                                echo '  </td>';
                                                echo '<tr/>';
                                            }
                                        }else{
                                            echo '';
                                        }


                                    }

                                    ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>
                    <!-- row end -->
                      <!--   <?php if(isset($pages)){?>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="data_table_info" role="status" aria-live="polite">
                                        <div class="infos">
                                            从<?= $pages->getPage() * $pages->getPageSize() + 1 ?>                   到 <?= ($pageCount = ($pages->getPage() + 1) * $pages->getPageSize()) < $pages->totalCount ?  $pageCount : $pages->totalCount?>                   共 <?= $pages->totalCount?> 条记录</div>
                                    </div> -->
                                <!-- </div>
                                <div class="col-sm-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="data_table_paginate">
                                        <?= LinkPager::widget([
                                            'pagination' => $pages,
                                            'nextPageLabel' => '»',
                                            'prevPageLabel' => '«',
                                            'firstPageLabel' => '首页',
                                            'lastPageLabel' => '尾页',
                                        ]); ?>

                                    </div>
                                </div>
                            </div>
                        <?php }?>  -->



                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<div class="modal fade" id="hint" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>批阅小提示(๑•̀ㅂ•́)و✧</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-module-form", "class"=>"form-horizontal", "action"=>Url::toRoute("module/create")]); ?>
                    <p align="center" font-size=20px >老师您先休息一会儿（*＾-＾*）我正在玩命的批阅中·····</p>
                    <p align="center">我已经为您批阅了总份数的<span id="count"></span>/<span  id="sum"></span></p>
                <?php ActiveForm::end(); ?>
                <div class="modal-footer">
                <a href="#" class="btn btn-default" id="only_refresh" data-dismiss="modal">关闭</a>
            </div>
            </div>


        </div>
    </div>
</div>

<div class="modal fade" id="except_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>异常报告</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-module-form", "class"=>"form-horizontal", "action"=>Url::toRoute("module/create")]); ?>

               <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">学生姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="StuName" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">学号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="StudentID" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">进入考试次数</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Memo" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">登录IP</label>
                    <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="MachineIP" name="Number" placeholder="必填" /> -->
                        <table class="table">
                            <thead>
                            <tr>
                                <th>登录ip</th>
                            </tr>
                            </thead>
                            <tbody id="MachineIP">
                                <tr>
                                    <td>127.0.0.1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">与此学生ip相同的学生</label>
                     <div class="col-sm-10">
                        <!-- <input type="text" style="height: 30px;" class="form-control" id="Except" name="Number" placeholder="无 " /> -->
                        <table class="table">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>姓名</th>
                            </tr>
                            </thead>
                            <tbody id="otherStu">
                                <tr>
                                    <td>127.0.0.1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>

                 <?php ActiveForm::end(); ?>

            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
            </div>
        </div>
    </div>
</div>
<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>
var global_num = 0;
    function correct(id) {

                window.location.href = '<?=Url::toRoute("mark/correct")?>'+'&term='+$("#term-choice").val()+'&examPlan='
                    +$("#teach-choice").val()+'&classID='+$('#class-choice').val()+'&id=' + id;

                window.location.href = '<?=Url::toRoute('mark/correct')?>' + '&id=' + id;

    }

    $('#only_refresh').click(function(){
         window.location.reload();
    });


    function markActionSelf(id) {
        window.location.href = '<?=Url::toRoute("mark/manual-mark")?>'+'&term='+$("#term-choice").val()+'&examPlan='
            +$("#teach-choice").val()+'&classID='+$('#class-choice').val()+'&id='+id;
    }

    //当点选完班级信息之后，开始启用当前事件
    function ajaxGetSituation(state) {
        $('#reviewing-situation').append('<option value="6" id="6"> 全部 </option>');
        $('#reviewing-situation').append('<option value="0" id="0"> 未批阅 </option>');
        $('#reviewing-situation').append('<option value="5" id="5"> 主观题待批 </option>');
        $('#reviewing-situation').append('<option value="1" id="1"> 已批阅 </option>');
        $('#reviewing-situation').append('<option value="2" id="2"> 已上报 </option>');
    }

    //
    $('#reviewing-situation').change(function (e) {
        e.preventDefault();
        window.location.href = '<?=Url::toRoute("mark/index")?>'+'&term='+$("#term-choice").val()+'&examPlan='
            +$("#teach-choice").val()+'&classID='+$("#class-choice").val()+'&dealState='+$(this).val();
    });

    //上报成绩
    function upGrade(id) {
        if (id == '') {
            var Class = $('#class-choice').val();
            if (Class != null) {
                console.log("1");
                var Teach = $('#teach-choice').val();
                $.ajax({
                    type: 'get',
                    url: '<?=Url::toRoute("mark/up-grade")?>',
                    data: {type: '0', Class: Class, ExamPlan: Teach},
                    dataType: "JSON",
                    success: function (value) {
                        //console.log(value);
                        alert(value.msg);
                        window.location.reload();
                    }
                })
            } else {
                alert('请选择班级');
            }
        } else {

        }
    }

    $(function (){
        var val = $('#term-choice').val();
        ajaxGetExamPlan(val,0);
    });
    
    $('#term-choice').change(function (e) {
        var val = $(this).val();
        e.preventDefault();
        ajaxGetExamPlan(val,0);
    });

    $('#teach-choice').change(function (e) {
        e.preventDefault();
        ajaxGetClass($(this).val(),0)
    });

    function ajaxGetExamPlan(val,examPlan) {
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("//common/get-exam-plan")?>',
            data:{term:val,type:1},
            dataType:"JSON",
            success:function (value) {
                $('#teach-choice').empty();
                $('#teach-choice').append('<option>请选择</option>')
                for(var Tmp in value){
                    if (value[Tmp]['ExamPlanBh'] == examPlan) {
                        $('#teach-choice').append('<option selected="selected" value="'+ value[Tmp]['ExamPlanBh'] +'">'+ value[Tmp]['ExamPlanName'] +'</option>');

                    } else {
                        $('#teach-choice').append('<option value="'+ value[Tmp]['ExamPlanBh'] +'">'+ value[Tmp]['ExamPlanName'] +'</option>');

                    }
                }
            }
        })
    }




    function ajaxGetClass(val,classId) {
        $.ajax({
            type:'get',
            url:'<?=Url::toRoute("//common/get-class")?>',
            data:{teach:val},
            dataType:"JSON",
            success:function (value) {
                $('#class-choice').empty();
                $('#class-choice').append('<option>请选择</option>');
                for(var Tmp in value.msg){
                    if (value.msg[Tmp].ID == classId) {
                        $('#class-choice').append('<option selected="selected" value="'+ value.msg[Tmp].ID +'">'+ value.msg[Tmp].ClassName +'</option>');
                    } else {
                        $('#class-choice').append('<option value="'+ value.msg[Tmp].ID +'">'+ value.msg[Tmp].ClassName +'</option>');
                    }
                }

            }
        })
    }





    $('#class-choice').change(function (e) {
        e.preventDefault();
        window.location.href = '<?=Url::toRoute("mark/index")?>'+'&term='+$("#term-choice").val()+'&examPlan='
            +$("#teach-choice").val()+'&classID='+$(this).val()+'&dealState='+'1';
    });

    //全选
    $("#btn1").click(function(){
    $("input[name='checkbox']").prop("checked","true");
    });
    //取消全选
    $("#btn2").click(function(){
    $("input[name='checkbox']").removeAttr("checked");
    });

    $(document).ready(function () {
        var term = '<?=$choice["Term_Choice"]?>';
        if (term != false) {
            var examChoice = '<?=$choice["ExamPlan_Choice"]?>';
            var classChoice = '<?=$choice["ClassID_Choice"]?>';
            var dealState = '<?=$choice["Deal_State"]?>';
            $('#term-choice option[value='+ term +']').attr('selected','selected');
            ajaxGetExamPlan(term,examChoice);
            ajaxGetClass(examChoice,classChoice);
            ajaxGetSituation(dealState);
            $('#reviewing-situation option[value='+ dealState +']').attr('selected','selected');
        }
    });

    function markAction(id) {
        var ids = [];
        //如果明确设置了变量的值（非null/undifined/0/""等值),结果就会根据变量的实际值来返回，如果没有设置，结果就会返回false。
        if(!!id == true){
            ids[0] = id;
        }
        else{
            var checkboxs = $('#data_table :checked');
            if(checkboxs.size() > 0){
                var c = 0;
                for(var i = 0; i < checkboxs.size(); i++){
                    var id = checkboxs.eq(i).val();
                    if(id != ""){
                        ids[c++] = id;
                    }
                }
            }
        }
        if(ids.length > 0){
        	if(2000302 == <?=$session->get('courseCode');?>)
            {//Java题目使用轮询方式
            	var key = 0;
            	GetScoreJava(ids,key,ids.length);
        	}else{
        		for( var key in ids)
                {
                    GetScore(ids[key]);
                }
        	}

          $('#sum').text(ids.length);
          $('#hint').modal('show');
        }
        else{
            alert('请选择你要批阅的试卷');
        };

    }

    function GetScoreJava(ids,key,length){
            $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("mark/mark")?>',
            dataType:'text',
            data:{"ids":ids[key]},
            cache: false,
            success: function (value) {

                $('#deal_stage_'+ids[key]).children('.label').text('已批阅');
                $('#deal_stage_'+ids[key]).children('.label').attr('class','label label-primary');
                $('#'+ids[key]+'-Score').html("<p style='color:red;'>"+value+"</p>");
                global_num ++;
                $('#count').text(global_num);
                if(key<(length-1)){//使用递归的方式将异步按照顺序执行
                    key++;
                    GetScoreJava(ids,key,length);
                }
            },
            error: function() {
                console.log(ids);
            }
        });
    }

    function GetScore(ids){
            $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("mark/mark")?>',
            dataType:'text',
            data:{"ids":ids},
            cache: false,
            success: function (value) {

                $('#deal_stage_'+ids).children('.label').text('已批阅');
                $('#deal_stage_'+ids).children('.label').attr('class','label label-primary');
                $('#'+ids+'-Score').html("<p style='color:red;'>"+value+"</p>");
                global_num ++;
                $('#count').text(global_num);
            }
        });
    }

    function searchAction(){
        var key = $('#search').val();
        var examId = $('#teach-choice').val();
        var classId = $('#class-choice').val();
        $.post(
            "<?=Url::toRoute('mark/search')?>",
            {
                examId : examId,
                classId : classId,
                key : key,
            },
            function(res)
            {

            },
            'json'
        )
    }
    function viewAction(id){
        window.location.href = '<?=Url::toRoute("paper/view")?>'+'&id='+id;
    }



    function editAction(id){
//        initModel(id, 'edit');
        window.location.href = '<?=Url::toRoute("mark/manual-mark")?>'+'&id='+id;
    }

    function exceptAction(id){
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('mark/exception')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了1，" + textStatus);
            },
            success: function(data){
                $('#except_dialog').modal('show');
                $("#StuName").val(data.paper.StuName);
                $("#StudentID").val(data.paper.StudentID);
                $("#Memo").val(data.paper.Memo);
                var html = "";
                for(var key in data.ips)
                {
                    html += "<tr>"+
                            "<td>"+data.ips[key]+"</td>"+
                        "</tr>";
                }
                $("#MachineIP").html(html);
                var htmlIp = "";
                for(var key1 in data.students){
                    htmlIp += "<tr>"+
                            "<td>"+data.students[key1].StudentID+"</td>"+
                            "<td>"+data.students[key1].StuName+"</td>"+
                        "</tr>";
                }
                $("#otherStu").html(htmlIp);
            }
        });
    }



    function getSelectedIdValues(formId)
    {
        var value="";
        $( formId + " :checked").each(function(i)
        {
            if(!this.checked)
            {
                return true;
            }
            value += this.value;
            if(i != $("input[name='id']").size()-1)
            {
                value += ",";
            }
        });
        return value;
    }

    $('#edit_dialog_ok').click(function (e) {
        e.preventDefault();
        $('#admin-module-form').submit();
    });


    $('#clean_global').click(function(e){
        global_num = 0;
    });


    $('#view_btn').click(function (e) {
        e.preventDefault();
        markAction('');
        global_num = 0;
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });



    $('#admin-module-form').bind('submit', function(e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: '<?=Url::toRoute('paper/create-paper')?>',
            data:{id:$('#teach-choice').val()},
            success: function(value)
            {
                if(value.error == 0){
                    $('#edit_dialog').modal('hide');
                    admin_tool.alert('msg_info', '添加成功', 'success');
                    window.location.reload();
                }
                else{
                    var json = value.data;
                    for(var key in json){
                        $('#' + key).attr({'data-placement':'bottom', 'data-content':json[key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');

                    }
                }

            }
        });
    });





</script>
<?php $this->endBlock(); ?>
