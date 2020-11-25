<?php
use yii\helpers\Url;
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">试卷归档</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="row">
                            <div class="col-sm-3">
                                <label>学期:&nbsp;</label>
                                <select class="form-control" id="term_choice">
                                	
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>考试计划:&nbsp;</label>
                                <select class="form-control" id="exam_choice">
                                	
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>班级:&nbsp;</label>
                                <select class="form-control" id="class_choice">

                                </select>
                            </div>

                            <div class="col-sm-3">
                                <button type="button" class="btn btn-sm btn-primary" id="tar">试卷归档</button>
                            </div>
                          
                        </div>
                    </div>
                    
                    
                    <div class="col-sm-12">
                    <table id="no_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                    <h3 class="text-center" id="no_title"></h3>
                        <thead>
                        <tr role="row">

                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数</th>
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

<script>

$('#exam_choice').change(function (e) {

        e.preventDefault();
        ajaxGetClass($(this).val(),0)
    });
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
                        $('#class_choice').append('<option value="'+ value.msg[Tmp].ID +'">'+ value.msg[Tmp].ClassName +'</option>');
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
                $('#exam_choice').empty();
                $('#exam_choice').append('<option>请选择</option>');
                for(var Tmp in value){
                    
                        $('#exam_choice').append('<option value="'+ value[Tmp]['ExamPlanBh'] +'">'+ value[Tmp]['ExamPlanName'] +'</option>');
                }
            }
        })
    }

    function getPaper()
    {
    	$.post(
    		"<?=Url::toRoute('tar-paper/get-paper')?>",
    		{
    			examPlan:$('#exam_choice').val(),
    			classID:$('#class_choice').val()
    		},
    		function(res){
                $('#no_info').empty();
                var i = 1;
                for(var key in res)
                {
                    $('#no_info').append('<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StudentID+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >' +res[key].Score+ '</th></tr>');
                }

    		},
            'json'
    		)
    }

    $('#term_choice').change(function(){
        getClass($('#term_choice').val());
    })
    $('#class_choice').change(function(){
        getPaper();
        
    })

    $('#tar').click(function(){
        var examPlan = $('#exam_choice').val();
        var classID = $('#class_choice').val();
        
        if(examPlan == '请选择')
            alert('请选择考试计划');
        else if(classID == '请选择')
            alert('请选择班级');
        else
        {
            // window.location.href = '<?=Url::toRoute("tar-paper/get-tar")?>'+'&examPlan='+$("#exam_choice").val()+'&classID='+$("#class_choice").val();
            $.post(
                "<?=Url::toRoute('tar-paper/get-tar')?>",
                {
                    examPlan:examPlan,
                    classID:classID
                },
                function(res){
                    // \Yii::$app->basePath.'/upload/'.$user.'/homework';
                    window.location.href = "/tar_file/"+res+'.zip';
                }
                )
        }
    })
    getTerm();
    $(function (){
        getClass('<?=$now_term;?>');
    });
    getClass($('#term_choice').val());
</script>