<?php
/**
 * Created by PhpStorm.
 * User: ProPHPer
 * Date: 2017/1/11
 * Time: 上午11:44
 */
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
				<div class="box-header">
					<h3 class="box-title">课堂提问管理</h3>
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
                <!-- 点到按钮<br><br> -->
                <button id="add_class_question_btn" type="button" class="btn btn-danger">提问</button>
                
                <!-- 点到状态 -->
				 <div class="col-sm-12">
	                <table id="class_question_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
	                <h3 class="text-center" id="class_question_title">提问情况</h3>
	                    <thead>
	                    <tr role="row">

	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >性别</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >班级</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提问次数</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >查看记录</th>
	                    </tr>
	                    </thead>
	                    <!-- 点到信息列表 -->
	                    <tbody id="class_question_info">
	                    
	                    
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



<!-- 详细信息-->
<div class="modal fade" id="details_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		        <h3>详情</h3>
		    </div>
			<div class="modal-body ">
				<div class="">
				    <table id="details_table" class="table table-bordered table-striped dataTable " role="grid" aria-describedby="data_table_info">
				   
				        <thead>
				        <tr role="row">

				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >班级</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提问时间</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >等级</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >得分</th>

				        </tr>
				        </thead>
				        <!-- 新点到学生信息 -->
				        <tbody id="details_info">
				        	
				        
				        </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- 新提问-->
<div class="modal fade" id="add_class_question_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		       	<h3>今日(<?php echo date('Y年m月d日');?>)提问</h3>
		    </div>
			<div class="modal-body ">
				<div class="">
				    <table id="add_question_table" class="table table-bordered table-striped dataTable " role="grid" aria-describedby="data_table_info">
				   
				        <thead>
				        <tr role="row">

				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >总提问次数</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >今天提问次数</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >得分等级</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
				        </tr>
				        </thead>
				        <!-- 新点到学生信息 -->
				        <tbody id="add_question_info">
				        	
				        
				        </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 提示信息 -->
<div class="modal fade" id="option_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="meg_info"></h4>
            </div>
        </div>
    </div>
</div>


<script type="">
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
				//alert(res);
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
	function getClassQuestion()
	{
		var TeachingClassID = $('#class_choice_btn').val();
		$.post(
			"<?=Url::toRoute('class-question/get-student')?>",
			{
				TeachingClassID:TeachingClassID,
			},
			function(res){
				var html = '';
				var html1 = '';
				var i=1;
				for(key in res)
				{
					html += '<tr role="row" id="'+res[key].StuNumber+'">'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuNumber+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Name+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Sex+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ClassName+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" id="'+res[key].StuNumber+'_time">0次'+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-primary dropdown-toggle class_question_details" data-toggle="dropdown" value="'+res[key].StuNumber+'">详情</button></th>'+
				'</tr>';
					html1 += '<tr role="row" id=add_"'+res[key].StuNumber+'">'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuNumber+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Name+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" id="'+res[key].StuNumber+'_times">0次'+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" id="'+res[key].StuNumber+'_today_times">0次'+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><select class="form-control" id="'+res[key].StuNumber+'_score"><option value="0">请打分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option></select></th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-danger dropdown-toggle add_question_save_btn" data-toggle="dropdown" value="0"><p hidden class="add_studentNum">'+res[key].StuNumber+'</p>保存</button></th>'+
				'</tr>';
					i++;
				}
				$('#class_question_info').html(html);
				$('#add_question_info').html(html1);
				getTime();
				getTodayTime();
			},
			"json"
			)
	}
	function getTime()
	{
		var TeachingClassID = $('#class_choice_btn').val();
		$.post(
			"<?=Url::toRoute('class-question/get-class-question-time')?>",
			{
				TeachingClassID:TeachingClassID,
			},
			function(res){
				for(key in res)
				{
					$('#'+res[key].studentNum+'_time').text(res[key].time+'次');
					$('#'+res[key].studentNum+'_times').text(res[key].time+'次');
				}
			},
			"json"
			)
	}
	function getTodayTime()
	{
		var TeachingClassID = $('#class_choice_btn').val();

		$.post(
			"<?=Url::toRoute('class-question/get-today-time')?>",
			{
				TeachingClassID:TeachingClassID,
			},
			function(res){
				for(key in res)
				{
					$('#'+res[key].studentNum+'_today_times').text(res[key].time+'次');
				}
			},
			"json"
			)
	}
	$(document).on('click','.term_choice',function(){
		//var child_id = $(this).children('.child_id').text();
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
		getClassQuestion();
	})
	$(document).ready(getTerm());
	$(document).on('click','.class_question_details',function(){
		var StuNumber = $(this).val();
		var className = $('#class_choice_btn').text();
		var TeachingClassID = $('#class_choice_btn').val();
		//alert(StuNumber);
		$.post(
			"<?=Url::toRoute('class-question/get-details')?>",
			{
				StuNumber:StuNumber,
				TeachingClassID:TeachingClassID,
			},
			function(res){
				var html = '';
				var i=1;
				for(key in res)
				{
					html += '<tr role="row" id="'+res[key].StudentNum+'x">'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StudentNum+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StudentName+'</th>'+
				
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+className+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].QuestionDate+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ScoreGrade+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Score+'</th>'+
				'</tr>';
					i++;
				}
				$('#details_info').html(html);
				$('#details_modal').modal('show');
			},
			"json"
			)
	})
	$('#add_class_question_btn').click(function(){
		var TeachingClassID = $("#class_choice_btn").val();
		if(TeachingClassID==0)
			optionRes('请先选择班级');
		else
			$("#add_class_question_modal").modal('show');
		
	})
	$('#class_choice_btn').click(function(){
		var term = $('#term_choice_btn').val();
		if(term == 0)
			optionRes('请先选择学期');

	})
	$(document).on('click','.add_question_save_btn',function(){
		
		var StuNumber = $(this).children('.add_studentNum').text();
		var TeachingClassID = $("#class_choice_btn").val();
		var score = $('#'+StuNumber+'_score').val();
		$.post(
			"<?=Url::toRoute('class-question/add-question')?>",
			{
				TeachingClassID:TeachingClassID,
				StuNumber:StuNumber,
				score:score,
			},
			function(res)
			{
				getTime();
				getTodayTime();
				// optionRes(res);
				
			}

			)

	})
</script>
