
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$m_exam = new \app\models\teachplan\Examplan();
$m_exam_plan = new \app\models\teachplan\Examplan();
$m_class_manage = new \app\models\teachplan\Teachingclassmannage();
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
                    <h3 class="box-title">考卷管理</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">

                            <button id="XXX" type="button" class="btn btn-xs btn-primary" onclick="submit()">全部交卷</button>
                            |
                            <button id="get_excel" type="button" class="btn btn-xs btn-primary">导出Excel</button>
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
                                        <option value="<?=$value['CuitMoon_DictionaryName']?>" <?php if($value['CuitMoon_DictionaryName'] == $now_term){?>selected="selected" <?php }?>><?=$value['CuitMoon_DictionaryName']?></option>
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
                        </div>


                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'学号'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'姓名'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试开始时间'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试结束时间'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试计划'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'班级'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'试卷状态'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'提交状态'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'操作'.'</th>';

                                        ?>

                                        <!--                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if($choice['Term_Choice']) {
                                        $row = 0;
                                        foreach ($list as $model) {
                                            echo '<tr id="rowid_' . $model->PaperID . '">';
                                            echo '  <td><label><input type="checkbox" value="' . $model->PaperID . '"></label></td>';
                                            echo '  <td>' . $model->StudentID . '</td>';
                                            echo '  <td>' . $model->StuName . '</td>';
                                            echo '  <td>' . $model->ExamBeginTime . '</td>';
                                            echo '  <td>' . $model->ExamEndTime . '</td>';
                                            $Tmp = $m_exam_plan->find()->where(['ExamPlanBh'=>$model->ExamPlanBh])->asArray()->One();
                                            echo '  <td>' .$Tmp['ExamPlanName']. '</td>';
                                            $Tmp = $m_class_manage->find()->where(['TeachingClassID' => $model->TeachingClassID])->asArray()->One();
                                            echo '  <td>' . $Tmp['TeachingName'] . '</td>';
                                            switch ($model->DealState) {
                                                case '0': $Tmp = '<span class="label label-danger">未批阅</sapn>';break;
                                                case '1': $Tmp = '<span class="label label-primary">已批阅</span>';break;
                                                case '2': $Tmp = '<span class="label label-success">已上报</span>';break;
                                                case '3': $Tmp = '<span class="label label-warning">错误试卷</span>';break;
                                                default:
                                                    $Tmp = '<span class="label label-danger">未批阅</span>';break;
                                                    break;
                                            }
                                            echo '  <td>' . $Tmp . '</td>';
                                            $Tmp = $model->SubmitStage ? '<span class="label label-primary">已交卷</span>' : '<span class="label label-danger">未交卷</span>';
                                            echo '  <td id="submit_stage_'.$model->PaperID.'">' . $Tmp. '</td>';
                                            echo '  <td class="center">';
                                            echo '      <a id="view_btn" onclick="viewAction(' . "'$model->PaperID'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>考卷详情</a>';
                                            if ($model->SubmitStage) {
                                                echo '      <a id="submit_paper_'.$model->PaperID.'" onclick="submitAlone(' . "'$model->PaperID', '1'" . ')" class="btn btn-primary btn-sm"  href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>恢复考试</a>';
                                                echo '      <a id="view_btn_1" onclick="correct(' . "'$model->PaperID'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>根据日志恢复试卷</a>';
                                            } else {
                                                echo '      <a id="submit_paper_'.$model->PaperID.'" onclick="submitAlone(' . "'$model->PaperID', '0'" . ')" class="btn btn-primary btn-sm"  href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>交卷</a>';
                                                echo '      <a id="view_btn_2" onclick="correct(' . "'$model->PaperID'" . ')" class="btn btn-danger btn-sm"  disabled="disabled" href="#"> <i class="glyphicon btn-danger glyphicon-zoom-in icon-white"></i>根据日志恢复试卷</a>';
                                            }
                                            echo '      <a id="delete_btn" onclick="deleteAction(' . "'$model->PaperID'" . ')"  class="btn btn-warning btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>删除考卷</a>';
                                            echo '  </td>';
                                            echo '<tr/>';
                                        }
                                    }

                                    ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <!-- row end -->
              <!--           <?php if(isset($pages)){?>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="data_table_info" role="status" aria-live="polite">
                                        <div class="infos">
                                            从<?= $pages->getPage() * $pages->getPageSize() + 1 ?>            		到 <?= ($pageCount = ($pages->getPage() + 1) * $pages->getPageSize()) < $pages->totalCount ?  $pageCount : $pages->totalCount?>            		 共 <?= $pages->totalCount?> 条记录</div>
                                    </div>
                                </div>
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
                        <?php }?> -->
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

<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>试卷详情</h3>
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
                    <label for="code" class="col-sm-2 control-label">试卷名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ExamPlanName" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">开始时间</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ExamBeginTime" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">结束时间</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ExamEndTime" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">IP地址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="MachineIP" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">MAC地址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="MACAddress" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">考试次数</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Memo" name="Number" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="edit_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="recovery_test_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>根据日志恢复试卷</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
    	                <table id="detaile_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
    	                <thead>
    	                <tr role="row">
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目信息</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提交记录</th>
    	                 </tr>
    	                </thead>
    	                <tbody id="detaile_practice">

    	                </tbody>
    	            	</table>
    	            </div>
    	            <div class="col-sm-6">
    	            	<div class="panel-group" >
                            <table class="table table-bordered table-striped " role="grid" >
                           <thead>
                           <tr role="row" >
                                <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                                <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提交时间</th>
                                <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提交信息</th>
                                <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                            </tr>
                           </thead>
                           <tbody id="detaile_submit">

                           </tbody>
                           </table>
    	            	</div>
    	            </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
                 <!-- <a id="recovery_test_ok" href="#" class="btn btn-primary">确定</a> -->
            </div>
        </div>
    </div>
</div>




<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>
    function getExcel(){
        window.location.href="<?=Url::toRoute('exam-info/get-excel')?>"+"&term="+$("#term-choice").val()+"&examPlan="+$('#teach-choice').val()+"&classID="+$('#class-choice').val();
    }
    
    function correct(id) {
        $('#recovery_test_modal').modal('show');
        $.ajax({
            type:'post',
            url:'<?=Url::toRoute("exam-info/get-paper-info")?>',
            data:{paperId:id},
            dataType:"JSON",
            success:function (res) {
            theAnswers = res;
          $('#detaile_practice').empty();
				  var i=1;
				for(var key in res)
				{
          var ID = res[key].PaperID;
          var BH = res[key].QuestionBh;
					$('#detaile_practice').append("<tr><th>"+(i++)+"</th><th>"+res[key].name+"</th><th>"+
                     '<button type="button" class="option_detail_btn btn btn-sm btn-primary" onclick="viewInfo(\''+ID+','+BH+','+key+'\')">查看提交记录</button>'+"</th></tr>")

                    // for(var key1 in res[key].log)
                    // {
                    //     $('#detaile_practice').append("<textarea>"+res[key].log[key1]+"</textarea>")
                    // }
                    // $('#detaile_practice').append("</th></tr>");
				}
            }
        })
    }
    function viewInfo(str){
      var obj = str.split(',');
      var questionBh = obj[1];
      var paperID = obj[0];
      var index = obj[2];
      var logs = theAnswers[index].log;
      var i=1;
      var strings = str;
    //  alert(str);
        $('#detaile_submit').empty();
        for(var key in logs)
        {
            $('#detaile_submit').append("<tr><th>"+(i++)+"</th><th>"+logs[key].time+"</th><th>"+logs[key].answer+"</th><th>"+
            '<button type="button" class="option_detail_btn btn btn-sm btn-primary" onclick="submitAnswer(\''+paperID+','+questionBh+','+key+'\')">选择这个记录作为学生答案</button>'+"</th></tr>")
        }
    }

    function submitAnswer(str){
        var obj = str.split(',');
        var PaperID = obj[0];
        var QuestionBh = obj[1];
        var LogID = obj[2];
        $.ajax({
          type:'post',
          url:'<?=Url::toRoute("exam-info/save")?>',
          data:{PaperID:PaperID,QuestionBh:QuestionBh,LogID:LogID},
          dataType:"JSON",
          success:function (value) {
            //   window.location.reload();
          }
        })
    }

    function submit() {
        var Class = $('#class-choice').val();
        if (Class != null ) {
            $.ajax({
                type:'get',
                url:'<?=Url::toRoute("exam-info/submit")?>',
                data:{Class:Class,examPlan:$('#teach-choice').val()},
                dataType:"JSON",
                success:function (value) {
                    window.location.reload();
                }
            })
        } else {
            alert('请选择班级');
        }
    }

    function submitAlone(id, type) {
        var state = $('#submit_paper_'+id+'').attr('disabled');
        if (state != 'disabled') {
            $.ajax({
                type:'get',
                url:'<?=Url::toRoute("exam-info/submit-alone")?>',
                data:{id:id, type:type},
                dataType:"JSON",
                success:function (value) {
                    if (value.error == 0) {
                        alert(value.msg);
                        window.location.reload();
                        // $('#submit_paper_'+id+'').attr('disabled',"disabled");
                        // $('#submit_stage_'+id+'').html('<span class="label label-primary">已交卷</span>');
                    } else {
                        alert(value.msg);
                    }
                }
            })
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

    $('#get_excel').click(function (e) {
        e.preventDefault();
        getExcel();
    });

    function ajaxGetExamPlan(val,examPlan) {
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("//common/get-exam-plan")?>',
            data:{term:val,type:0},
            dataType:"JSON",
            success:function (value) {
                $('#teach-choice').empty();
                $('#teach-choice').append('<option>请选择</option>');
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
                $('#class-choice').append('<option>请选择</option>')
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
        window.location.href = '<?=Url::toRoute("exam-info/index")?>'+'&term='+$("#term-choice").val()+'&examPlan='
            +$("#teach-choice").val()+'&classID='+$(this).val();
    });

    $(document).ready(function () {
        var term = '<?=$choice["Term_Choice"]?>';
        if (term != false) {
            var examChoice = '<?=$choice["ExamPlan_Choice"]?>';
            var classChoice = '<?=$choice["ClassID_Choice"]?>';
            $('#term-choice option[value='+ term +']').attr('selected','selected');
            ajaxGetExamPlan(term,examChoice);
            ajaxGetClass(examChoice,classChoice);
        }
    });

    // function markAction(id) {
    //     $.ajax({
    //         type:'GET',
    //         url:'<?=Url::toRoute("mark/mark")?>',
    //         dataType:'json',
    //         data:{PaperID:id},
    //         success: function (value) {
    //             if (value.error == 0) {
    //                 $('#'+id+'-Score').text(value.msg);
    //             } else {
    //                 alert('批阅失败');
    //             }
    //         }
    //     })
    // }


    function searchAction(){
        $('#admin-module-search-form').submit();
    }
    function viewAction(id){
        initModel(id,'view','fun');
    }

    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#StuName").val('');
            $("#StudentID").val('');
            $("#ExamPlanName").val('');
            $("#ExamBeginTime").val('');
            $("#ExamEndTime").val('');
            $("#MachineIP").val('');
            $("#MACAddress").val('');
            $("#Memo").val('');

        }
        else{
           $("#StuName").val(data['StuName']);
            $("#StudentID").val(data['StudentID']);
            $("#ExamPlanName").val(data['ExamPlanName']);
            $("#ExamBeginTime").val(data['ExamBeginTime']);
            $("#ExamEndTime").val(data['ExamEndTime']);
            $("#MachineIP").val(data['MachineIP']);
            $("#MACAddress").val(data['MACAddress']);
            $("#Memo").val(data['Memo']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#StuName").attr({readonly:true,disabled:true});
            $("#StudentID").attr({readonly:true,disabled:true});
            $("#ExamPlanName").attr({readonly:true,disabled:true});
            $("#ExamBeginTime").attr({readonly:true,disabled:true});
            $("#ExamEndTime").attr({readonly:true,disabled:true});
            $("#MachineIP").attr({readonly:true,disabled:true});
            $("#MACAddress").attr({readonly:true,disabled:true});
            $("#Memo").attr({readonly:true,disabled:true});
        }
        else{
            $("#StuName").attr({readonly:false,disabled:false});
            $("#StudentID").attr({readonly:false,disabled:false});
            $("#ExamPlanName").attr({readonly:false,disabled:false});
            $("#ExamBeginTime").attr({readonly:false,disabled:false});
            $("#ExamEndTime").attr({readonly:false,disabled:false});
            $("#MachineIP").attr({readonly:false,disabled:false});
            $("#MACAddress").attr({readonly:false,disabled:false});
            $("#Memo").attr({readonly:false,disabled:false});
            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('exam-info/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了，" + textStatus);
            },
            success: function(data){
                initEditSystemModule(data, type);
            }
        });
    }

    function editAction(id){
//        initModel(id, 'edit');
        window.location.href = '<?=Url::toRoute("mark/manual-mark")?>'+'&id='+id;
    }

    function deleteAction(id){
        var ids = [];
        if(!!id == true){
            ids[0] = id;
        }
        else{
            var checkboxs = $('#data_table :checked');
            if(checkboxs.size() > 0){
                var c = 0;
                for(i = 0; i < checkboxs.size(); i++){
                    var id = checkboxs.eq(i).val();
                    if(id != ""){
                        ids[c++] = id;
                    }
                }
            }
        }
        if(ids.length > 0){
            admin_tool.confirm('请确认是否删除', function(){
                $.ajax({
                    type: "GET",
                    url: "<?=Url::toRoute('exam-info/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        alert("出错了，" + textStatus);
                    },
                    success: function(data){
                        for(i = 0; i < ids.length; i++){
                            $('#rowid_' + ids[i]).remove();
                        }
                        admin_tool.alert('msg_info', '删除成功', 'success');
                        window.location.reload();
                    }
                });
            });
        }
        else{
            admin_tool.alert('msg_info', '请先选择要删除的数据', 'warning');
        }

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

    $('#create_btn').click(function (e) {
        e.preventDefault();
        var val = $('#teach-choice option:selected').val();
        console.log(val);
        if(val == null){
            alert('请选择考试计划');
        }else{
            initEditSystemModule('create');
        }
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
