
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$m_exam = new \app\models\teachplan\Examplan();
?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">学生练习情况</h3>
                    <!-- <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">生成考卷</button>
                            |
                            <button id="delete_btn" type="button"  class="btn btn-xs btn-danger">批量删除</button>
                        </div>
                    </div> -->
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
                                <label>班级:&nbsp;</label>
                                <select class="form-control" id="teach_choice">
                                	
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                <thead>
                                <tr role="row">
                                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >练习次数</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >练习题目总数</th>
                                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>

                                 </tr>
                                </thead>
                                <tbody id="stu_info">

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
         	</div>
        </div>
    </div>
</section>


<div class="modal fade" id="detaile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-title" id="detaile_title"></h3>
            </div>
            <div class="modal-body" id="detaile_info">
            <div class="row">
                <div class="col-sm-6">
	                <table id="detaile_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
	                <thead>
	                <tr role="row">
	                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
	                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >日期</th>
	                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >ip</th>
	                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目数</th>
	                    <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>

	                 </tr>
	                </thead>
	                <tbody id="detaile_practice">

	                </tbody>
	            	</table>
	            </div>
	            <div class="col-sm-6">
	            	<div class="panel-group" id="accordion">

	            	</div>
	            </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
	function getClass(term)
	{
		$.post(
			"<?=Url::toRoute('practice/get-class')?>",
			{
				Term:term,
			},
			function(res){
				$('#stu_info').empty();
				$('#teach_choice').empty();
				$('#teach_choice').append('<option value="0">请选择班级</option>');
				for(var key in res)
					$('#teach_choice').append('<option value="'+res[key].TeachingClassID+'">'+res[key].TeachingName+'</option>')
			},
			'json'
			)
	}
	function getStudent(teach)
	{
		$.post(
			"<?=Url::toRoute('practice/get-student')?>",
			{
				TeachingClassID:teach,
			},
			function(res){
				var i=1;
				$('#stu_info').empty();
				for(var key in res)
				{
					$('#stu_info').append('<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuNumber+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Name+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].sum+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].questionSum+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary option_btn" value="'+res[key].StuNumber+'">详情</button></th></tr>');
				}
			},
			"json"
			)
	}
	$('#term_choice').change(function(){
		getClass($('#term_choice').val());
	})
	$('#teach_choice').change(function(){
		getStudent($('#teach_choice').val());
	})
	$(document).on('click','.option_btn',function(){
		$('#accordion').empty();
		var me = $(this);
		$.post(
			"<?=Url::toRoute('practice/get-detaile')?>",
			{
				TeachingClassID:$('#teach_choice').val(),
				StuNumber:$(this).val()
			},
			function(res){
				$('#detaile_modal').modal('show');
				$('#detaile_practice').empty();
				$('#detaile_title').text(me.parent().parent().children('.name').html()+'练习情况');
				var i=1;
				for(var key in res)
				{
					$('#detaile_practice').append('<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].InTestTime+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].IPAddress+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].sum+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="option_detail_btn btn btn-sm btn-primary" value="'+res[key].DetailsID+'">查看练习题目</button></th></tr>');
				}
			},
			'json'
			)
	})
	$(document).on('click','.option_detail_btn',function(){
		var DetailsID = $(this).val();
		$.post(
			"<?=Url::toRoute('practice/get-practice-qus')?>",
			{
				DetailsID:DetailsID,
			},
			function(res){
				$('#accordion').empty();
				var i=0;
				for(var key in res)
				{
					var new_item = $('<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"  href="#collapse'+i+'"><p>'+res[key].CustomBh+'：<p style="font-size:1.3rem;">'+res[key].name+'</p>'+'<p style="font-size:1.3rem;">最后提交时间：<span class="label label-primary" style="font-size:1.2rem;">'+res[key].SubmitTime+'</span><span class="label label-primary" style="float:right;font-size:1.4rem;">'+res[key].Difficulty+'</span><span class="label label-primary" style="float:right;font-size:1.4rem;">'+res[key].QuestionType+'</span><span class="label label-danger" style="float:right;font-size:1.4rem;">得分：'+res[key].Score+'</span></p></a></h4></div> <div id="collapse'+i+'" class="panel-collapse collapse "><div class="panel-body">'+'学生答案：<br><textarea  rows="20" cols="90">'+res[key].StuAnswer+'</textarea>'+'</div></div></div>').hide();
					// parent.append(new_item);
					
					$('#accordion').append(new_item);
					i++;
					new_item.show(600,"swing");
				}
			},
			'json'
			)
	})
	getTerm();
	$(function (){
		getClass('<?=$now_term;?>');
	});
	getClass($('#term_choice').val());



</script>