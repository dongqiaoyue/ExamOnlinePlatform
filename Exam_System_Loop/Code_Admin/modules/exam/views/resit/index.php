<?php
use yii\helpers\Url;
?>
<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>

<link rel="stylesheet" type="text/css" href="<?=Url::base()?>/component/time/jquery.datetimepicker.css"/>
<style>
.form-control{
    min-width: 150px;
    margin-right: 20px;
}
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">补考管理</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="row">
                            <div class="col-sm-2">
                                <label>学期:&nbsp;</label>
                                <select class="form-control" id="term_choice">
                                	
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>考试计划:&nbsp;</label>
                                <select class="form-control" id="teach_choice">
                                	
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>班级:&nbsp;</label>
                                <select class="form-control" id="class_choice">

                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>考试日期:&nbsp;</label>
                                <select class="form-control" id="date_choice">

                                </select>
                            </div>
                            <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-primary" id="view_bt">查看当天补考信息</button>
                            </div>
                            <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-primary" id="add_bt">新增补考</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                    <table id="not_pass_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                    <h3 class="text-center" id="not_pass_title">本次未达考试线</h3>
                        <thead>
                        <tr role="row">

                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >考试总次数</th>
                        </tr>
                        </thead>
                        <!-- 点到信息列表 -->
                        <tbody id="not_pass_info">
                        
                        
                        </tbody>
                    </table>
                    </div>
                    <div class="col-sm-6">
                    <table id="no_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                    <h3 class="text-center" id="no_title">本次达到考试线</h3>
                        <thead>
                        <tr role="row">

                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >考试总次数</th>
                        </tr>
                        </thead>
                        <!-- 点到信息列表 -->
                        <tbody id="no_info">
                        
                        
                        </tbody>
                    </table>
                    </div>


                </div>
         	</div>
        </div>
    </div>
</section>
<div class="modal fade" id="resit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-title" id="resit_title"></h3>
            </div>
            <div class="modal-body" id="resit_info">
            <div class="row">
               <!--  <div class="col-sm-6">
                    <table id="can_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                    <thead>

                    <h3>可选补考学生</h3>
                    <tr role="row">
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                     </tr>
                    </thead>
                    <tbody id="can_resit">

                    </tbody>
                    </table>
                </div> -->
                <div class="col-sm-12">
                    <table id="has_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                    <thead>
                    <h3>已选补考学生</h3>
                    <tr role="row">
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                        <!-- <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th> -->

                     </tr>
                    </thead>
                    <tbody id="has_resit">

                    </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_resit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-title" id="add_resit_title"></h3>
            </div>
            <div class="modal-body" id="add_resit_info">
            <div class="row">
                <div class="col-sm-12">
                    <form id="option_form" method="post" action="<?=url::toRoute('resit/save-resit')?>">
                        <div class="input-group " >
                            <input type="hidden" class="form-control" id="option_ExamPlanBh" name="ExamPlanBh"/>
                        </div>
                        <input type="hidden" class="form-control" id="option_Tea" name="TeachingClass"/>
                        <div class="input-group " ><br><br><br></div>
                        <!-- <br> -->
                        <div class="input-group  " >
                            <span class="input-group-addon">开始时间</span>
                            <input type="text" class="form-control" id="option_StarTime" name="StarTime" placeholder="必填">
                        </div>

                        <table id="can_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                        <thead>

                        <h3>可选补考学生</h3>
                        <tr role="row">
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><input id="data_table_check" type="checkbox">&nbsp;&nbsp;选择</th>
                         </tr>
                        </thead>
                        <tbody id="can_add_resit">

                        </tbody>
                        </table>
                    </form>
                    <button type="button" class="btn btn-sm btn-primary" id="save_resit">保存</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php $this->beginBlock('footer');  ?>
<script src="<?=Url::base()?>/component/time/jquery.datetimepicker.full.min.js"></script>
<script>
    $('#save_resit').click(function(){
        $('#option_ExamPlanBh').val($('#teach_choice').val());
        $('#option_Tea').val($('#class_choice').val());
        $('#option_form').ajaxSubmit(function(res){
            alert(res);
        });
    })
    $(document).ready(function(){
        $('#option_StarTime').datetimepicker();
    })
    $('#data_table_check').click(function(){
        // var val = $('#data_table_check').attr('checked');
        $('.select').each(function(){
            // alert($('#data_table_check').val());
            $(this).prop('checked',$('#data_table_check').prop('checked'));
        })
    })
    $('#view_bt').click(function(){
        $('#resit_modal').modal('show');
        // getCanStu();
        getResitStu();
    })
    $('#add_bt').click(function(){

        
        $('#add_resit_modal').modal('show');
        getCanStu();
    })
    $('#teach_choice').change(function (e) {

        e.preventDefault();
        ajaxGetClass($(this).val(),0)
    });
    function getCanStu()
    {
        $.post(
            "<?=Url::toRoute('resit/get-can-stu')?>",
            {
                ExamPlanBh:$('#teach_choice').val(),
                TeachClass:$('#class_choice').val(),
                //Time:$('#date_choice').val()
            },
            function(res){
                // $('#can_resit').empty();
                $('#can_add_resit').empty();
                var i = 1;
                for(var key in res.NotPass)
                {
                    // $('#can_resit').append(
                    //     '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StudentID+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StuName+'</th></tr>');

                    // <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary add_resit_btn_this" value="'+res.NotPass[key].StudentID+'">添加到本次的补考</button></th>
                    $('#can_add_resit').append(
                        '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StudentID+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StuName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >' +res.NotPass[key].Score+ '</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><input type="checkbox" class="select" name="stu[stu'+i+']" value="' +res.NotPass[key].StudentID+ '"></th></tr>');
                }
                for(var key in res.No)
                {

                    // $('#can_resit').append(
                    //     '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.No[key].StuNumber+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.No[key].Name+'</th></tr>'
                    //     );
                    // <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary add_resit_btn_this" value="'+res.No[key].StuNumber+'">添加到本次的补考</button></th>
                    $('#can_add_resit').append(
                        '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.No[key].StuNumber+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.No[key].Name+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >缺考</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><input type="checkbox" class="select" name="stu[stu'+i+']" value="' +res.No[key].StuNumber+ '"></th></tr>');
                }
            },
            'json'
            );
    }
    function getResitStu()
    {
         $.post(
            "<?=Url::toRoute('resit/get-resit-stu')?>",
            {
                ExamPlanBh:$('#teach_choice').val(),
                TeachClass:$('#class_choice').val(),
                Time:$('#date_choice').val()
            },
            function(res){
                $('#has_resit').empty();
                var i = 1;
                for(var key in res.NotPass)
                {
                    $('#has_resit').append(
                        '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StudentID+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StuName+'</th></tr>');
                    // <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-danger cancel_resit_btn" value="'+res.NotPass[key].StuNumber+'">取消本次的补考</button></th>
                }
            },
            'json'
            );
    }
    function ajaxGetClass(val,classId) {
        $.ajax({
            type:'get',
            url:'<?=Url::toRoute("//common/get-class")?>',
            data:{teach:val},
            dataType:"JSON",
            success:function (value) {
                $('#class_choice').empty();
                $('#class_choice').append('<option>请选择</option>');
                for(var Tmp in value.msg){
                    if (value.msg[Tmp].ID == classId) {
                        $('#class_choice').append('<option selected="selected" value="'+ value.msg[Tmp].ID +'">'+ value.msg[Tmp].ClassName +'</option>');
                    } else {
                        $('#class_choice').append('<option value="'+ value.msg[Tmp].ID +'">'+ value.msg[Tmp].ClassName +'</option>');
                    }
                }
            }
        })
    }
    function getTerm()
    {
        $.post(
            "<?=Url::toRoute('practice/get-term')?>",
            {},
            function(res){
                $('#stu_info').empty();
                $('#term_choice').empty();
                for(var key in res){
                    var Termname = res[key].CuitMoon_DictionaryName;
                    if('<?=$now_term;?>' ==Termname){
                        $('#term_choice').append('<option value="'+Termname+'" selected="selected">'+Termname+'</option>')
                    }else{
                        $('#term_choice').append('<option value="'+Termname+'">'+Termname+'</option>')
                    }
                }
            },
            'json'
            )
    }
    function getClass(val) {
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("//common/get-exam-plan")?>',
            data:{term:val,type:0},
            dataType:"JSON",
            success:function (value) {
                $('#teach_choice').empty();
                $('#teach_choice').append('<option>请选择</option>');
                for(var Tmp in value){
                    
                        $('#teach_choice').append('<option value="'+ value[Tmp]['ExamPlanBh'] +'">'+ value[Tmp]['ExamPlanName'] +'</option>');
                }
            }
        })
    }
    function getExamInfo()
    {
        $.post(
            "<?=Url::toRoute('resit/get-exam')?>",
            {
                ExamPlanBh:$('#teach_choice').val(),
                TeachClass:$('#class_choice').val(),
                Time:$('#date_choice').val()
            },
            function(res){
                $('#no_info').empty();
                $('#not_pass_title').text("本次未达考试线（"+res.PassScore+"）");
                
                var i = 1;
                $('#not_pass_info').empty();
                for(var key in res.NotPass)
                {

                    $('#not_pass_info').append(
                        '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StudentID+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].StuName+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].Score+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.NotPass[key].num+'</th></tr>'
                        );
                }
                for(var key in res.No)
                {

                    $('#not_pass_info').append(
                        '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.No[key].StuNumber+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.No[key].Name+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >缺考</th></tr>'
                        );
                }
                i = 1;
                $('#no_info').empty();
                for(var key in res.IsPass)
                {

                    $('#no_info').append(
                        '<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.IsPass[key].StudentID+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.IsPass[key].StuName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.IsPass[key].Score+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res.IsPass[key].num+'</th></tr>'
                        );
                }
            },
            'json'
            )
    }
    function getExamDate()
    {
        $.post(
            "<?=Url::toRoute('resit/get-exam-date')?>",
            {
                ExamPlanBh:$('#teach_choice').val(),
                TeachClass:$('#class_choice').val()
            },
            function(res){

                $('#date_choice').empty();
                $('#date_choice').append('<option>请选择</option>');
                for(var key in res)
                {
                    $('#date_choice').append('<option value="'+ res[key].time +'">'+ res[key].time +'</option>');
                }
            },
            'json'
            )
    }
    $('#term_choice').change(function(){
        getClass($('#term_choice').val());
    })
    $('#class_choice').change(function(){
        getExamDate();
        
    })
    $('#date_choice').change(function(){

        $('#no_info').empty();
        $('#not_pass_info').empty();
        getExamInfo();
        
    })

    getTerm();
    $(function (){
        getClass('<?=$now_term;?>');
    });
    getClass($('#term_choice').val());

</script>
<?php $this->endBlock(); ?>
