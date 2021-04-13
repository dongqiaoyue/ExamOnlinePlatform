
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\exam\Paperconfigure;
$m_paper = new Paperconfigure();
?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<link rel="stylesheet" type="text/css" href="<?=Url::base()?>/component/time/jquery.datetimepicker.css"/>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">考试计划列表</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>
                            |
                            <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control" id="term-choice">
                                    <option value="0">全部</option>
                                    <?php foreach ($Terms as $model) {?>
                                        <option value="<?=$model['CuitMoon_DictionaryName']?>" <?php if($model['CuitMoon_DictionaryName'] == $now_term && Yii::$app->request->get('term') == ""){?>selected="selected" <?php }?>><?=$model['CuitMoon_DictionaryName']?></option>
                                    <?php }?>
                                </select>
                                <select class="form-control" id="type-choice">
                                    <option value="all">全部</option>
                                    <option value="1">期末考试</option>
                                    <option value="2">过程化考核</option>
                                    <option value="3">其他</option>
                                </select>
                            </div>
                        </div>
                        <!-- row end search -->

                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >考试名称</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >课程名称</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >开始时间</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >结束时间</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >发布状态</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >试卷模块</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($list as $model) {
                                        echo '<tr id="rowid_' . $model->ExamPlanBh . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->ExamPlanBh . '"></label></td>';
                                        echo '  <td>' . $model->ExamPlanName . '</td>';
                                        echo '  <td>' . $CourseName . '</td>';
                                        if(date('Y-m-d',strtotime($model->StarTime))==date('Y-m-d'))
                                        {
                                            echo ' <td> <span class="label label-danger">' . $model->StarTime. '（今天）</span></td>';
                                            echo '  <td> <span class="label label-danger">' . $model->EndTime . '</span></td>';
                                        }
                                        else
                                        {
                                            echo ' <td> ' . $model->StarTime. '</td>';
                                            echo '  <td> ' . $model->EndTime . '</td>';
                                        }

                                        $Tmp = $model->IsFixedPlace ?  '<span class="label label-primary">已发布</span>' :  '<span class="label label-danger">未发布</span>';
                                        echo '  <td class="IsFixedPlace">'. $Tmp .'</td>';
                                        if($Tmp = $m_paper->isExamModule($model->ExamPlanBh)){
                                            echo '  <td><span class="label label-primary">'. $Tmp['ExamPaperName'] .'</span></td>';
                                        }else{
                                            echo ' <td><span class="label label-danger">未配置模块</span> </td>';
                                        }
                                        echo '  <td class="center">';
                                        echo '      <a id="paper-config" class="btn btn-primary btn-sm paper-config" href="'.$model->ExamPlanBh.'" <i class="glyphicon glyphicon-zoom-in icon-white"></i>试卷模块</a>';
                                        if ($model->IsFixedPlace) {
                                            echo '      <button id="edit_btn" class="btn btn-primary btn-sm" value="1" onclick="publishAction(' . "'$model->ExamPlanBh'" . ',this)" > <i class="glyphicon glyphicon-edit icon-white"></i>取消发布</button>';
                                        } else {
                                            echo '      <button id="edit_btn" value="0" onclick="publishAction(' . "'$model->ExamPlanBh'" . ',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon-edit icon-white"></i>发布</button>';
                                        }
                                        echo '      <a id="view_btn" onclick="viewAction(\'' . $model->ExamPlanBh . '\')" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(\'' . $model->ExamPlanBh . '\')" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        echo '      <a id="delete_btn" onclick="deleteAction(' . "'$model->ExamPlanBh'". ')" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                        echo '  </td>';
                                        echo '</tr>';
                                    }
//                                    ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>
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

<div class="modal fade" id="option_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-title" id="option_title"></h3>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-xs-6">
                    <!-- <?=Url::toRoute('correct/add')?> -->
                        <form id="option_form" action="" method="post">
                        <div class="input-group " >
                            <input type="hidden" class="form-control" id="option_ExamPlanBh" name="Examplan[ExamPlanBh]"/>
                        </div>
                        <div class="input-group  " >
                            <span class="input-group-addon">考试名字</span>
                            <input type="text" class="form-control" id="option_ExamPlanName" name="Examplan[ExamPlanName]" placeholder="必填">
                        </div>
                        <div class="input-group " ><br></div>
                        <!-- <br> -->
                        <div class="input-group  " >
                            <span class="input-group-addon">开始时间</span>
                            <input type="text" class="form-control" id="option_StarTime" name="Examplan[StarTime]" placeholder="必填">
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="input-group "  >
                            <span class="input-group-addon">结束时间</span>
                            <input type="text" class="form-control" id="option_EndTime" name="Examplan[EndTime]" placeholder="必填">
                        </div>
                        <div class="input-group " ><br></div>
                        <!-- <br> -->
                        <div class="input-group "  >
                            <span class="input-group-addon">发布状态</span>
                            <select class="form-control" id="option_IsFixedPlace" value="0" name="Examplan[IsFixedPlace]">
                                <option value="1">已发布</option>
                                <option value="0">未发布</option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <div class="input-group " >
                            <span class="input-group-addon">考试时间</span>
                            <input type="text" class="form-control" id="option_ExamTime" name="Examplan[ExamTime]" placeholder="必填">
                        </div>
                        <br>
                        <div class="input-group " >
                            <span class="input-group-addon">通过分数</span>
                            <input type="text" class="form-control" id="option_PassScore" name="Examplan[PassScore]" placeholder="必填">
                        </div>
                        <div class="input-group " ><br></div>
                        <!-- <br> -->
                        <div class="input-group " >
                            <span class="input-group-addon">考试权重</span>
                            <input type="text" class="form-control" id="option_Weights" name="Examplan[Weights]" placeholder="必填">
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        </form>
                        <div class="modal-footer" id="option_type">

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div>
                            <table id="not_pass_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                            <!-- <h3 class="text-center" id="exam_stu_title">参考学生</h3> -->
                                <thead>
                                <tr role="row">

                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                                </tr>
                                </thead>
                                <!-- 点到信息列表 -->
                                <tbody id="exam_stu">


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clo-xs-6">
                    <a id="student_add" onclick="addstu()" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-zoom-in icon-white"></i>添加学生</a>
                    </div>
                </div>


        </div>
        </div>
    </div>
</div>


<div class="modal fade" id="stu_add" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>添加学生</h3>
            </div>
            <div class="modal-body">
            <form id="student_form" action=<?=Url::toRoute('exam-plan/add-student')?> method="post">    
            <div class="input-group " >
            <input type="hidden" class="form-control" id="option_ExamPlanBh1" name="Examplan"/>
            </div>  
            <span class="input-group-addon">选择教学班</span>
            <div class="input-group" id="selectclass">
    
            </div>
            <div class="input-group " >
            <span class="input-group-addon">学生学号</span>
            <input class="form-control" id="studentcode" name="studentcode"/>
            </div>
            </form>
            </div>
            <div class="modal-footer">
                <a  class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="edit_student_ok"  class="btn btn-primary">确定</a>
            </div>
        </div>
      </div>
</div>



<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>试卷模块选择</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]); ?>

                <input type="hidden" class="form-control" id="ExamPlanBh" name="ExamPlanBh" />


                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-4 control-label "><h4>考试模块</h4></label>
                    <div class="col-sm-8" id="exam-modules">

                    </div>
                    <div class="clearfix"></div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a  class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="edit_dialog_ok"  class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('footer');  ?>
<script src="<?=Url::base()?>/component/time/jquery.datetimepicker.full.min.js"></script>
<!-- <body></body>后代码块 -->
<script>


    //显示考试模板
    $('.paper-config').click(function (e) {
        e.preventDefault();
        var id = $(this).attr("href");
        $('#ExamPlanBh').val(id);
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("exam-plan/get-module")?>',
            data:{id:id},
            dataType:"json",
            success:function (value) {
                $('#exam-modules').empty();
                for (var Tmp in value.data){
                    if(value.data[Tmp]['ExamConfigRecordID'] == value.ExamConfigRecordID) {
                        $('#exam-modules').append('<div class="radio"> <label> <input type="radio" name="ExamConfigRecordID" id="optionsRadios1" value="'+ value.data[Tmp]['ExamConfigRecordID'] +'" checked="checked">'+ value.data[Tmp]['ExamPaperName'] +'</label> </div>');
                    }else{
                        $('#exam-modules').append('<div class="radio"> <label> <input type="radio" name="ExamConfigRecordID" id="optionsRadios1" value="'+ value.data[Tmp]['ExamConfigRecordID'] +'" >'+ value.data[Tmp]['ExamPaperName'] +'</label> </div>');
                    }
                }
            }
        })
        // initEditSystemModule('','create');
        $('#edit_dialog').modal('show');
    });


    $(function (){
        if('<?=Yii::$app->request->get('term');?>' == ""){
            var Tmp = $('#term-choice').val();
            window.location.href = '<?=Url::toRoute('exam-plan/index')?>'+'&term='+Tmp;
        }
    });
    $('#term-choice').change(function () {
        var Tmp = $(this).val();
        window.location.href = '<?=Url::toRoute('exam-plan/index')?>'+'&term='+Tmp;
    });

    $('#type-choice').change(function () {
        var Tmp = $(this).val();
        window.location.href = '<?=Url::toRoute('exam-plan/index')?>'+'&term='+$('#term-choice').val()+'&type='+Tmp;
    });

    $(document).ready(function () {
        $('#term-choice option[value="<?=$TermChoice?>"]').attr("selected","selected");
        $('#type-choice option[value="<?=$TypeChoice?>"]').attr("selected","selected");
    });


    //分配权限

    function searchAction(){
        $('#admin-role-search-form').submit();
    }
    function viewAction(id){

        initModel(id, 'view', 'fun');
    }

    function addstu(){
     Bh = $('#option_ExamPlanBh').val();
     $.ajax({
       type: "GET",
       url: "<?=URL::toRoute('exam-plan/get-techclass')?>",
       data: {"Bh":Bh},
       dataType:"json",
       success: function(data){
          $('#stu_add').modal('show');
          $('#option_ExamPlanBh1').val($('#option_ExamPlanBh').val());
          for(var value in data) {
            $('#selectclass').append('<label> <input type="radio" name="Teachingclass" id="TeachingClassID" value="'+ data[value]['TeachingClassID'] +'" checked="checked">'+ data[value]['TeachingName'] +'</label>');
          }
     }
     });
     
    }
    function publishAction(id,me) {
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('exam-plan/publish')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            success: function(data){
                if (data.error == 0) {

                    if($(me).val()==1)
                    {
                        $(me).parent().parent().children('.IsFixedPlace').html('<span class="label label-danger">未发布</span>');

                        $(me).attr('class','btn btn-danger btn-sm');
                        $(me).val('0');
                        $(me).html('<i class="glyphicon glyphicon-edit icon-white"></i>发布');

                    }
                    else
                    {
                        $(me).parent().parent().children('.IsFixedPlace').html('<span class="label label-primary">已发布</span>');
                        $(me).attr('class','btn btn-primary btn-sm');
                        $(me).val('1');
                        $(me).html('<i class="glyphicon glyphicon-edit icon-white"></i>取消发布');
                    }
                } else {
                    alert('发布失败');
                }
            }
        });
    }

    function initEditSystemModule(data, type){
        $('#option_modal').modal('show');
        if(type == 'create'){

            $('#option_form').children('.input-group').each(function(){

                $(this).children('.form-control').val('');

            });
        }
        else{
            for(var key in data)
                $('#option_'+key).val(data[key]);
            $("#exam_stu").empty();
            for(var key in data.class)
            {
                $('#exam_stu').append('<tr><th>'+key+'</th><th></th><th></th><th></th></tr>');
                var i = 1;
                for(var key1 in data.class[key])
                {
                    // alert(i%2 == 1);
                    if(i%2 == 1)
                        $('#exam_stu').append('<tr>');
                    else
                        $('#exam_stu').append('</tr>');

                    $('#exam_stu').append('<th>'+data.class[key][key1].StuNumber+'</th><th>'+data.class[key][key1].Name+'</th>');
                    // if(i%2 == 0)

                    // else
                    // $('#exam_stu').append('<td>'+data.class[key][key1].StuNumber+'</td><td>'+data.class[key][key1].Name+'</td>');
                    i = i+1;
                    //
                }
            }
        }
        if(type == "view"){
            $('#option_type').empty();
            $('#option_form').attr('action','');
            $('#option_form').children('.input-group').each(function(){
            $('#option_title').text('查看考试计划');
            $(this).children('.form-control').attr('disabled',true);
            $('#student_add').addClass('hidden');
            });

        }
        else{
            $('#option_form').children('.input-group').each(function(){
                $('#option_title').text('修改考试计划');
                $(this).children('.form-control').attr('disabled',false);

            });
            $('#option_type').html('<button id="update_save" type="button" class="btn btn-lg btn-danger">修改</button>');
            $('#option_form').attr('action',"<?=Url::toRoute('exam-plan/update')?>");
            //$('#option_EndTime').attr('disabled',true);
            $('#option_StarTime').datetimepicker();
            $('#option_EndTime').datetimepicker();
           

        }

    }
    Date.prototype.pattern=function(fmt) {
        var o = {
        "M+" : this.getMonth()+1, //月份
        "d+" : this.getDate(), //日
        "h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时
        "H+" : this.getHours(), //小时
        "m+" : this.getMinutes(), //分
        "s+" : this.getSeconds(), //秒
        "q+" : Math.floor((this.getMonth()+3)/3), //季度
        "S" : this.getMilliseconds() //毫秒
        };
        var week = {
        "0" : "/u65e5",
        "1" : "/u4e00",
        "2" : "/u4e8c",
        "3" : "/u4e09",
        "4" : "/u56db",
        "5" : "/u4e94",
        "6" : "/u516d"
        };
        if(/(y+)/.test(fmt)){
            fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
        }
        if(/(E+)/.test(fmt)){
            fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "/u661f/u671f" : "/u5468") : "")+week[this.getDay()+""]);
        }
        for(var k in o){
            if(new RegExp("("+ k +")").test(fmt)){
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
            }
        }
        return fmt;
    }
    $('#option_StarTime').blur(function(){
        var start = $('#option_StarTime').val();
        var min = $('#option_ExamTime').val();
        var event_EndTime = new Date(start);
        event_EndTime.setTime(event_EndTime.getTime()+Number(min)*60000);
        $('#option_EndTime').val(event_EndTime.pattern("yyyy/MM/dd HH:mm:ss"));
    })
    $("#option_ExamTime").on('input propertychange',function(){
        var start = $('#option_StarTime').val();
        var min = $('#option_ExamTime').val();
        var event_EndTime = new Date(start);
        event_EndTime.setTime(event_EndTime.getTime()+Number(min)*60000);
        $('#option_EndTime').val(event_EndTime.pattern("yyyy/MM/dd HH:mm:ss"));
    });
    $(document).on('click','#update_save',function(){
        $('#option_form').ajaxSubmit(function(res){
            alert(res);
            window.location.reload();
        })
    })
    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('exam-plan/view')?>",
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
        initModel(id, 'edit');
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
                    url: "<?=Url::toRoute('exam-plan/delete')?>",
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
        $('#admin-role-form').submit();
    });

     //提交增加学生表单
    $(document).on('click','#edit_student_ok',function(){
        $('#student_form').ajaxSubmit(function(res){
            alert(res);
            window.location.reload();
        })
    });

    $('#create_btn').click(function (e) {
        window.location.href = "<?=Url::toRoute('exam-plan/add')?>";
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });


    $('#admin-role-form').bind('submit', function(e) {
        e.preventDefault();
        var action = "<?=Url::toRoute('exam-plan/set-module')?>" ;
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
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
