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
use app\models\UploadForm;
$m_upload = new UploadForm();
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
				<div class="box-header">
					<h3 class="box-title">平时作业</h3>
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
                <!-- 新增作业<br><br> -->
                <button id="add_homework_question_btn" type="button" class="btn btn-danger">添加</button>
                <!-- <br><br>
                <div class="input-group">
			       <span class="input-group-addon">搜索：</span>
			       <input type="text" id="search" placeholder="学号,姓名,性别,手机号"/>
			    </div> -->
                <!-- 点到状态 -->
				 <div class="col-sm-12">
	                <table id="homework_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
	                <h3 class="text-center" id="homework_title">已经布置作业</h3>
	                    <thead>
	                    <tr role="row">

	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >作业名称</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >截至时间</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >是否截至</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学生是否可见</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >作业修改</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学生完成详细</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >删除</th>
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


<!-- 新作业-->
<div class="modal fade" id="add_homework_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 50%;">
		<div class="modal-content">
			<div class="modal-header">
		        <h3 class="box-title" id="modal_title"></h3>
		    </div>
			<div class="modal-body ">

        		<form id="add_homework_form" action="<?=Url::toRoute('homework/save-homework')?>" method="post">
        		<div class="input-group" >
        			<input type="hidden" class="form-control" id="HomeworkID" name="HomeworkID"/>
        		</div>
        		<div class="input-group" >
		            <span class="input-group-addon">教师名字</span>
		            <input type="text" class="form-control" placeholder="名字" disabled id="TeacherName">
	        	</div>
		        <br>
		        <div class="input-group " >
					<span class="input-group-addon">选择班级</span>
	                <select class="form-control" id="TeachClass" value="0" name="TeachClass">
	                	
	                </select>
	            </div>
	            <br>
		        <div class="input-group" >
		            <span class="input-group-addon">作业名称</span>
		            <input type="text" class="form-control" id="HomeworkName" name="HomeworkName" placeholder="必填" >
		        </div>
		        <br>
		        <div class="input-group " >
		        <span class="input-group-addon">是否可见</span>
		            <select class="form-control" id="IsStuSee" value="0" name="IsStuSee">
	                	<option value="1">可见</option>
	                	<option value="0">不可见</option>
	                </select>
		        </div>
		        <br>
        		<div class="input-group ">
		            <span class="input-group-addon">截止日期</span>
		            <input type="text" class="form-control" id="DeadTime" readonly="readonly" placeholder="必填" name="DeadTime" style="position: relative; z-index: 9999 ;"/>
		        </div>
		        <br>
    			
			    <span class="input-group-addon">内容</span>
    			<div class="input-group " >
		            
		            <script type="text/plain" id="WorkDesc" name="WorkDesc"></script>
		        </div>
		        <br>
			    <div class="input-group " >
		            <span class="input-group-addon">备注信息</span>
		            <textarea class="form-control" id="Memo" name="Memo"></textarea>
		        </div>
		        <br>   
	            <div class="input-group " >
		            <span class="input-group-addon">上传图片</span>
		              <input type="file" id="WorkURL" name="WorkURL" accept = "image/*">
		        </div>
		        <br>
    			

    			</form>
    			<div class="input-group " id="image_see">
		            
		              
		        </div>
		        <br>

			</div>
			<div class="modal-footer" >
				<div class="input-group " id="btn_type">
    				
    			</div>
			</div>
		</div>
	</div>
</div>
<!-- 批改作业 -->
<div class="modal fade" id="mark_homework_modal" style="height:auto; overflow-y: auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%; border:1px solid green; position: relative;">
		<div class="modal-content">
			<div class="modal-header">
		        <h3 class="box-title" id="mark_title"></h3>
		    </div>
			<div class="modal-body" >  <!-- style="position: relative;" -->

        		<form id="mark_homework_form" action="<?=Url::toRoute('homework/mark-homework')?>" method="post">
        		<div class="input-group" >
        			<input type="hidden" class="form-control" id="mark_StudentWorkID" name="HomeworkID"/>
        		</div>
        		<div class="input-group" >
		            <span class="input-group-addon">学生姓名</span>
		            <input type="text" class="form-control" placeholder="名字" disabled id="mark_StudentName" disabled>
	        	</div>
		        <br>
		        <div class="input-group" >
		            <span class="input-group-addon">学生学号</span>
		            <input type="text" class="form-control" placeholder="名字" disabled id="mark_StudentNum" disabled>
	        	</div>
		        
	            <br>
		        <span class="input-group-addon">学生作业答案</span>
		        	<script type="text/plain" id="mark_WorkContent" name="mark_WorkContent"></script>
	        	<br>
	       <div id="toFloat" style="position: fixed; top:30px; z-index: 10000; width:410px; right:50px;"> 	
		        <div class="input-group" style="width:160px; float:left; margin-right: 10px;">
					<span class="input-group-addon">所获等级</span>
	                <select class="form-control" id="mark_ScoreGrade" value="0" name="ScoreGrade">
	                	<option value="A">A</option>
	                	<option value="B">B</option>
	                	<option value="C">C</option>
	                	<option value="D">D</option>
	                	<option value="E">E</option>
	                </select>
	            </div>
	            <br>
		        <div class="input-group" style="width:200px; float:right; top:-20px;">
		            <span class="input-group-addon">附件下载</span>
		            <button type="button" class="btn btn-primary" id="file_download">下载</button>
	        	</div>
	        </div>
	        	</form>
	        </div>
    			
			<div class="modal-footer" id="dafen" style="position: fixed; top:30px; z-index: 10000; right: 0; padding: 0;">
    			<button type="button" class="btn btn-primary" id="mark_save_btn">打分</button>
			</div>
		</div>
	</div>
</div>

<!-- 上传作业查看 -->
<div class="modal fade" id="upload_homework_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;">
		<div class="modal-content">
			<div class="modal-header">
		        <h3>提交情况</h3>
		    </div>
			<div class="modal-body ">
				<div class="">
				    <table id="upload_homework_table" class="table table-bordered table-striped dataTable " role="grid" aria-describedby="data_table_info">
				   
				        <thead>
				        <tr role="row">

				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >得分等级</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提交时间</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >批阅时间</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >是否批阅</th>
				            <!-- <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th> -->
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >作业批改</th>
				        </tr>
				        </thead>
				        <!-- 新点到学生信息 -->
				        <tbody id="upload_homework_info">
				        	
				        
				        </tbody>
				    </table>
				</div>
			</div>
			<div class="modal-footer">
				<ul class="pagination" id="page">
				</ul>

			</div>
		</div>
	</div>
</div>
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

<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    var ue = UE.getEditor('WorkDesc');
    var ue1 = UE.getEditor('mark_WorkContent');
</script>

<script type="text/javascript">
$(document).ready(function(){
	var element = document.getElementById('mark_homework_modal');
	setInterval(function(){
	//获取滚动条到顶部的垂直高度 (即网页被卷上去的高度) 
	 var _top = element.scrollTop+30;
     $("#toFloat").css('top',_top);
     $("#dafen").css('top',_top);
	},2);
})

var global_HomeworkID;
var global_PageNum;
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
	getClassAll();
	$(document).ready(function(){
		$( "#DeadTime" ).datetimepicker({
                timeFormat: "HH:mm:ss",
                dateFormat: "yy-mm-dd"
            });
	});
	function initModal()
	{
		$('#image_see').html('');
		$('#modal_title').val('');
		$("#DeadTime").val('');
 		// $('#TeachClass').val('0');
 		$("#HomeworkName").val('');
 		$('#IsStuSee').val('');
 		$('#Memo').val('');
 		$("#WorkURL").val('');
 		UE.getEditor('WorkDesc').setContent('');
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
	function getClassAll()
	{
		$.post(
			"<?=Url::toRoute('homework/get-class-all')?>",
			{

			},
			function(res)
			{
				
				var html = '';
				for(key in res)
				{
					html += '<option value="'+res[key].TeachingClassID+'">'+res[key].TeachingName+'</option>';
					$('#TeacherName').val(res[key].TeacherName);
				}
				$('#TeachClass').html(html);

			},
			"json"
			)
	}
	function getAllHomework()
	{
		var TeachClass = $("#class_choice_btn").val();
		$.post(
			"<?=Url::toRoute('homework/get-all-homework')?>",
			{
				TeachClass:TeachClass,
			},
			function(res)
			{
				var html = '';
				var i=1;
				var isDead;
				var isSee;
				$('#homework_info').html('');
				for(key in res)
				{
					isSee = res[key].IsStuSee==1 ? '<button type="button"class="btn btn-primary dropdown-toggle change_issee_btn"  value="'+res[key].HomeworkID+'">可&nbsp;&nbsp;&nbsp;&nbsp;见</button>' : '<button type="button"class="btn btn-danger dropdown-toggle change_issee_btn"  value="'+res[key].HomeworkID+'">不可见</button>';
					isDead = new Date(res[0]['now'].replace("-", "/").replace("-", "/")) > new Date(res[key].DeadTime.replace("-", "/").replace("-", "/")) ? '<span class="label label-danger">已截止</span>' : '<span class="label label-primary">未截止</span>';
					html += '<tr role="row" id="'+res[key].HomeworkID+'">'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].HomeworkName+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].DeadTime+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+isDead+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+isSee+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+'<button type="button" class="btn btn-primary update_homework_btn" value="'+res[key].HomeworkID+'">编辑</button>'+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+'<button type="button"class="btn btn-primary dropdown-toggle student_dtails_btn" data-toggle="dropdown" '+'value="'+res[key].HomeworkID+'">查看</button>'+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+'<button type="button" class="btn btn-danger dropdown-toggle delete_homework_btn" data-toggle="dropdown"'+' value="'+res[key].HomeworkID+'">删除</button>'+'</th>'+
					'</tr>';
					i++;
				}
				$('#homework_info').html(html);

			},
			"json"
			)
	}
	function getUploadAll(HomeworkID,PageNum)
	{
		global_HomeworkID = HomeworkID;
		global_PageNum = PageNum;
		$.post(
			"<?=Url::toRoute('homework/get-upload-homework-all')?>",
			{
				HomeworkID:HomeworkID,
				PageNum:PageNum,
			},
			function(res)
			{
				var html = '';
				var i=res[0]['i']+1;
				var isSee;
				for(key in res)
				{
					isSee = res[key].MarkDate ? '<span class="label label-primary">已批改</span>' : '<span class="label label-danger">未批改</span>';
					if(res[key].StudentWorkID)
					html += '<tr role="row">'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StudentNum+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StudentName+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ScoreGrade+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].uploadTime+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].MarkDate+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+isSee+'</th>'+
					// '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StudentNum+'</th>'+
					'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+'<button type="button" class="btn btn-primary dropdown-toggle mark_homework_btn" data-toggle="dropdown" '+'value="'+res[key].StudentWorkID+'">批改</button>'+'</th>'+
					'</tr>';


					i++;
				}
				$('#upload_homework_info').html(html);
				$('#upload_homework_modal').modal('show');
				var count = res[0]['count'];
				var html_li = '';
				for(var i=0; i<count; i++)
				{
					if(res[0]['i']/10 == i)
						html_li += '<li class="active"><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p><p class="HomeworkID" hidden>'+HomeworkID+'</p></a></li>';
					else
						html_li += '<li><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p><p class="HomeworkID" hidden>'+HomeworkID+'</p></a></li>';

				}
				$('#page').html(html_li);
			},
			"json"
			)
	}
	$(document).on('click','#save_homework_btn',function(){
		var DeadTime = $("#DeadTime").val();
 		var TeachClass = $('#TeachClass').val();
 		var HomeworkName = $("#HomeworkName").val();

 		if(HomeworkName==0 || DeadTime==0 || TeachClass==0 )
 			alert('必填内容不能为空');
 		else
 		{
 			$('#add_homework_form').ajaxSubmit({
 				type:'post',
 				dateType:'json',
 				url:'<?=Url::toRoute('homework/save-homework')?>',
 				success:function(res){
 					$('#add_homework_modal').modal('hide');
 					getAllHomework();
 					optionRes(res);
 				}
 			})
 		}
	})
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
		getAllHomework();
	})
	$(document).on('click','.change_issee_btn',function(){
		var HomeworkID = $(this).val();
		$.post(
			"<?=Url::toRoute('homework/change-is-see')?>",
			{
				HomeworkID:HomeworkID,
			},
			function(res){
				getAllHomework();
			})
	})
	$(document).on('click','.delete_homework_btn',function(){
		var me = $(this);
		admin_tool.confirm('请确认是否删除', function(){
			var HomeworkID = $(me).val();
			$.post(
			"<?=Url::toRoute('homework/delete-homework')?>",
			{
				HomeworkID:HomeworkID,
			},
			function(res)
			{
				getAllHomework();
				optionRes(res);
			}
			);
		});
		
	})
	$("#add_homework_question_btn").click(function(){

		initModal();
		var TeachClass = $('#class_choice_btn').val();
		if(TeachClass != '0')
			$('#TeachClass').val(TeachClass);
		$('#IsStuSee').val('1');
		$('#modal_title').text('添加平时作业');
		$("#add_homework_modal").modal('show');
		$("#btn_type").html('<button id="save_homework_btn" type="button" class="btn btn-danger">保存</button><br><br><br><br><br><br>');

	})
	$(document).on('click','.update_homework_btn',function(){
		initModal();
		var TeachClass = $('#class_choice_btn').val();
		if(TeachClass != '0')
			$('#TeachClass').val(TeachClass);
		$("#btn_type").html('<button id="update_save_btn" type="button" class="btn btn-danger">修改</button><br><br><br><br><br><br>');
		var HomeworkID = $(this).val();

		$.post(
			"<?=Url::toRoute('homework/get-one-homework')?>",
			{
				HomeworkID:HomeworkID,
			},
			function(res){
				
				if(res.WorkURL)
					$('#image_see').html('<span class="input-group-addon">已传图片</span><img src="'+res.WorkURL+'" name="WorkURL" id="WorkURL_img" style="width: 100px; height: 100px;" />');
				$('#HomeworkID').val(res.HomeworkID);
				$('#modal_title').text('修改作业');
				$("#DeadTime").val(res.DeadTime);
		 		$('#TeachClass').val(res.TeachClass);	
		 		$("#HomeworkName").val(res.HomeworkName);
		 		$('#IsStuSee').val(res.IsStuSee);
		 		$('#Memo').val(res.Memo);
		 		UE.getEditor('WorkDesc').setContent(res.WorkDesc);
				$('#add_homework_modal').modal('show');
			},
			"json"
			)
	})
	$(document).on('mouseover','#WorkURL_img',function(){
		$(this).attr('style','width:500px');
	})
	$(document).on('mouseout','#WorkURL_img',function(){
		$(this).attr('style','width:100px;height:100px;');
	})
	$(document).on('click','#update_save_btn',function(){
		var DeadTime = $("#DeadTime").val();
 		var TeachClass = $('#TeachClass').val();
 		var HomeworkName = $("#HomeworkName").val();

 		if(HomeworkName==0 || DeadTime==0 || TeachClass==0 )
 			alert('必填内容不能为空');
 		else
 		{
 			$('#add_homework_form').ajaxSubmit({
 				type:'post',
 				dateType:'json',
 				url:'<?=Url::toRoute('homework/update-homework')?>',
 				success:function(res){
 					getAllHomework();
 					$('#add_homework_modal').modal('hide');
 					optionRes(res);
 				}
 			})
 		}
	})
	$(document).on('click','.student_dtails_btn',function(){
		var HomeworkID = $(this).val();
		getUploadAll(HomeworkID,0);
	})
	$(document).on('click','.mark_homework_btn',function(){
		var StudentWorkID = $(this).val();
		$("#upload_homework_modal").modal('hide');
		$.post(
			"<?=Url::toRoute('homework/get-upload-homework-one')?>",
			{
				StudentWorkID:StudentWorkID,
			},
			function(res){
				for(key in res){
					if(typeof res[key] !== 'undefined')
						$('#mark_'+key).val(res[key]);
				}
				UE.getEditor('mark_WorkContent').setDisabled();
				if(res.WorkContent)
					UE.getEditor('mark_WorkContent').setContent(res.WorkContent);
				else
					UE.getEditor('mark_WorkContent').setContent('');
				$('#mark_homework_modal').modal('show');
			},
			"json"
			)	
	})
	$('#mark_homework_modal').on('hide.bs.modal', function () {
  		$('#upload_homework_modal').modal('show');
	})

 	$(document).on('click','.page_choice',function(){
 		var PageNum = $(this).children('.PageNum').text();
 		var HomeworkID = $(this).children('.HomeworkID').text();
 		getUploadAll(HomeworkID,PageNum);
 	})
 	$('#mark_save_btn').click(function(){
 		var StudentWorkID = $('#mark_StudentWorkID').val();
 		var ScoreGrade = $('#mark_ScoreGrade').val();
 		$.post(
 			"<?=Url::toRoute('homework/mark-homework')?>",
 			{
 				StudentWorkID:StudentWorkID,
 				ScoreGrade:ScoreGrade,
 			},
 			function(res){
 				alert(res);
 				$("#mark_homework_modal").modal('hide');
 				getUploadAll(global_HomeworkID,global_PageNum);
 			}
 			)
 	})

</script>