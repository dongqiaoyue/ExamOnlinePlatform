<?php
/**
 * Created by PhpStorm.
 * User: ProPHPer
 * Date: 2017/1/11
 * Time: 上午11:44
 */
use yii\helpers\Url;
use yii\helpers\Html;
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
				<div class="box-header">
					<h3 class="box-title">成绩综合</h3>
				</div>

				<div class="box-body">
				<!-- 学期选择 -->
				<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="term_choice_btn" value="0">学期选择</button>
                    <ul class="dropdown-menu" role="menu" id="term_choice_data">
	                    
                    </ul>
                </div>
                <!-- 班级选择 -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="class_choice_btn" value="0">班级选择</button>
                    <!-- 班级信息列表 -->
                    <ul class="dropdown-menu" role="menu" id="class_choice_data">
	                            
                    </ul>
                </div>
                <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="excel_btn" value="0">导出EXCEL</button>
                </div>
                <!-- 新增作业<br><br> -->
                <!-- <button id="add_homework_question_btn" type="button" class="btn btn-danger">添加</button> -->
                
                <!-- 点到状态 -->
				 <div class="col-sm-12">
	                <table id="homework_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
	                <h3 class="text-center" id="homework_title">综合成绩</h3>
	                    <thead>
	                    <tr role="row">

	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >教学班</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >性别</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >考勤</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >平时作业</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提问</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >其他</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >总分</th>
	                    </tr>
	                    </thead>
	                    <!-- 点到信息列表 -->
	                    <tbody id="homework_info">
	                    
	                    
	                    </tbody>
	                </table>
                </div>

				 </div>
				 <div class="box-footer">
				 <!-- footer -->
				 </div>
			</div>
		</div>
	</div>
</section>
<!-- 操作提示 -->
<div class="modal fade" id="option_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="meg_info"></h4>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function optionRes(res)
	{
		$("#meg_info").text(res);
		$('#option_info').modal('show');
	}
	function getTerm(){
		$.post(
			"<?=Url::toRoute('class-question/get-term')?>",
			{

			},
			function(res){
				var html = '';
				for(key in res)
				{
					html += '<li><a href="#" class="term_choice">'+res[key].CuitMoon_DictionaryName+'<p hidden class="term_id">'+res[key].CuitMoon_DictionaryCode+'</p><p hidden class="term_name">'+res[key].CuitMoon_DictionaryName+'</p></a></li>';
				}
				$("#term_choice_data").html(html);
			},
			"json"
			)
	}
	getTerm();
	function getClass(){
		var Term = $('#term_choice_btn').val();
		$.post(
			"<?=Url::toRoute('class-question/get-class')?>",
			{
				Term : Term,
			},
			function(res){
				var html = '';
				for(key in res)
				{
					html += '<li><a href="#" class="class_choice">'+res[key].TeachingName+'<p hidden class="class_id">'+res[key].TeachingClassID+'</p><p hidden class="class_name">'+res[key].TeachingName+'</p></a></li>';
				}
				$('#class_choice_data').html(html);
			},
			"json"
			) 
	}
	function getGradeSum()
	{
		var className = $("#class_choice_btn").text();
		var TeachingClassID = $("#class_choice_btn").val();
		$.post(
			"<?=Url::toRoute('sum-grade/get-grade-sum-all')?>",
			{
				TeachingClassID:TeachingClassID,
			},
			function(res){
				var html = '';
				for(key in res)
				{
					html += '<tr role="row">'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+className+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuNumber+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Name+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Sex+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].attentionRecord+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].homeworkScoreGrade+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].questionScoreGrade+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+''+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].sum+'</th>'+
					'</tr>';
				}
				$('#homework_info').html(html);
			},
			"json"
			)
	}
	$(document).on('click','.term_choice',function(){
		var child_name = $(this).children('.term_name').text();
		$('#term_choice_btn').val(child_name);
		$('#term_choice_btn').text(child_name);
		getClass();
		$('#class_choice_btn').val('0');
		$('#class_choice_btn').text('班级选择');
	})
	$(document).on('click','.class_choice',function(){
		var TeachingName = $(this).children('.class_name').text();
		var TeachingClassID = $(this).children('.class_id').text();
		$('#class_choice_btn').val(TeachingClassID);
		$('#class_choice_btn').text(TeachingName);
		getGradeSum();
	})
	$("#excel_btn").click(function(){
		var TeachingClassID = $('#class_choice_btn').val();
		if(TeachingClassID != '0')
			window.location.href="<?=Url::toRoute('sum-grade/get-grade-excel')?>"+"&TeachingClassID="+TeachingClassID;
		else
			optionRes('请先选择班级');
		
	})

</script>