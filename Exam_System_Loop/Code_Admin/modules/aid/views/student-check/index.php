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
<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
				<div class="box-header">
					<h3 class="box-title">学生考勤管理</h3>
				</div>

				<div class="box-body">
				<!-- 学期选择 -->
				<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="term_choice_btn" value="<?=$term_choice?>"><?=$term_choice;?></button>
                    <ul class="dropdown-menu" role="menu">
	                    <?php if(isset($term)):?>
	                        <?php foreach ($term as $model) {?>
	                            <li>
	                   				<a href="#" class="term_choice_a" value="<?=$model['CuitMoon_DictionaryName']?>"><?=$model['CuitMoon_DictionaryName'];?></a>
	                            </li>
	                        <?php }?>
	                    <?php endif;?>
                    </ul>
                </div>
                <!-- 班级选择 -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="class_choice_btn" value="<?=$class_choice;?>"><?=$class_choice?></button>
                    <!-- 班级信息列表 -->
                    <ul class="dropdown-menu" role="menu" id="class_data">
	                            
                    </ul>
                </div>
                <!-- 日期选择 -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="date_choice_btn" value="<?=$term_choice?>"><?=$date_choice?></button>
                    <!-- 日期信息列表 -->
                    <ul class="dropdown-menu" role="menu" id="date_data">
	                            
                    </ul>
                </div>
                <!-- 点到按钮<br><br> -->
                <button id="check_btn" type="button" class="btn btn-danger"><?php echo date('Y年m月d日--');?>点到</button>
                
                <!-- 点到状态 -->
				 <div class="col-sm-12">
	                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
	                <h3 class="text-center" id="check_title">出勤情况</h3>
	                <button id="update_btn" type="button" class="btn btn-primary">刷新表</button>
	                    <thead>
	                    <tr role="row">

	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
	                        
	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >性别</th>
	                        
	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >班级</th>
	                        
	                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >点到状态</th>
	                    </tr>
	                    </thead>
	                    <!-- 点到信息列表 -->
	                    <tbody id="student_info">
	                    
	                    
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
<!-- 新点到-->
<div class="modal fade" id="check_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		        <h3>今日(<?php echo date('Y年m月d日');?>)点到</h3>
		    </div>
			<div class="modal-body ">
				<div class="">
				    <table id="check_table" class="table table-bordered table-striped dataTable " role="grid" aria-describedby="data_table_info">
				   
				        <thead>
				        <tr role="row">

				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>
				            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >点到</th>
				        </tr>
				        </thead>
				        <!-- 新点到学生信息 -->
				        <tbody id="check_info">
				        	
				        
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


<script>
//模态框被隐藏，更新数据
$("#check_modal").on('hidden.bs.modal',function(){
	var TeachingClassID=$("#class_choice_btn").val();
		var date=$("#date_choice_btn").text();
		$.post(
			"<?=Url::toRoute('student-check/getstate');?>",
			{
				TeachClass:TeachingClassID,
				AttendanceDate:date,
			},
			function(res)
			{
				for(var key in res)
				{
					var state=res[key].AttendanceState=='1' ? '<span class="label label-default">已到</span>' : '<span class="label label-danger ">未到</span>';
					$("#"+res[key].StudentNum).html(state);
				}
			},
			 "json"
			);
});
	
//刷新当前表数据
$("#update_btn").click(function(){
	if($("#date_choice_btn").html()=="请选择日期")
	{
		$("#meg_info").html("请先选择日期");
        $("#option_info").modal("show");
	}
	else
	{
		var TeachingClassID=$("#class_choice_btn").val();
		var date=$("#date_choice_btn").text();
		$.post(
			"<?=Url::toRoute('student-check/getstate');?>",
			{
				TeachClass:TeachingClassID,
				AttendanceDate:date,
			},
			function(res)
			{
				for(var key in res)
				{
					var state=res[key].AttendanceState=='1' ? '<span class="label label-default">已到</span>' : '<span class="label label-danger ">未到</span>';
					$("#"+res[key].StudentNum).html(state);
				}
			},
			 "json"
			);
	}
});
//班级选择按钮被点击，将日期按钮复位
$("#class_choice_btn").click(function(){
	var termx=$("#term_choice_btn").html();
	$("#date_choice_btn").html("请选择日期");
	if($("#term_choice_btn").html()=="请选择学期")
	{
		$("#meg_info").html("请先选择学期");
        $("#option_info").modal("show");
	}

});
//学期按钮被点击，把日期和计划班选择按钮复位
$("#term_choice_btn").click(function(){
	$("#date_choice_btn").html("请选择日期");
	$("#class_choice_btn").html("请选择计划班");
});
//日期按钮被点击，更新按钮信息
$("#date_choice_btn").click(function(){
	
	if($("#class_choice_btn").html()=="请选择计划班")
	{
		$("#meg_info").html("请先选择计划班");
        $("#option_info").modal("show");
	}
	$(".atteninfo").each(function(){
		$(this).html("未到");
		$(this).attr("class","atteninfo label label-danger");
	});
});
//学期选择
$(".term_choice_a").click(function(){
	var termx=$(this).text();
	$("#term_choice_btn").val(termx);
	$("#term_choice_btn").html(termx);
	$.post(
		"<?=Url::toRoute('student-check/getclass');?>",
		{term:termx},
		function(res){
			var htmlinfo='';
			for(var p in res)
			{
				htmlinfo+='<li><a href="#"  class="class_choice_a"' +'>'+'<p class="TeachingName">'+res[p].TeachingName+'</p>'+'<p hidden class="TeachingClassID">'+res[p].TeachingClassID+'</p>'+'</a></li>';
			}
			 $("#class_data").html(htmlinfo);
		},
		"json");
	
});
//点到modal弹出
$("#check_btn").click(function(){
	var term=$("#term_choice_btn").html();
	var TeachingClassID=$("#class_choice_btn").val();
	var date='now';
	if($("#class_choice_btn").text()=="请选择计划班")
	{
		$("#meg_info").html("请先选择计划班");
        $("#option_info").modal("show");
	}
	else
	{	
		//获取当天点到信息
		$.post(
			"<?=Url::toRoute('student-check/getstate');?>",
			{
				TeachClass:TeachingClassID,
				AttendanceDate:date,
			},
			function(res)
			{
				for(var key in res)
				{
					if(state=res[key].AttendanceState=='1')
					{
						$("#"+res[key].StudentNum+'info').children('.info').text('已到');
						$("#"+res[key].StudentNum+'info').attr('class','btn btn-primary dropdown-toggle now_check_btn');
						$("#"+res[key].StudentNum+'info').children('.flag').text('1');
					}
					else
					{
						$("#"+res[key].StudentNum+'info').children('.info').text('未到');
						$("#"+res[key].StudentNum+'info').attr('class','btn btn-danger dropdown-toggle now_check_btn');
						$("#"+res[key].StudentNum+'info').children('.flag').text('0');
					}
				}
				$("#check_modal").modal("show");
				$.post(
					"<?=Url::toRoute('student-check/getdate');?>",
					{TeachingClassID:TeachingClassID,term:term},
					function(res){
						var htmlinfo='';
						for(var key in res)
						{
							htmlinfo+='<li><a href="#" class="date_time">'+'<p class="showDate">'+res[key].AttendanceDate+'</p>'+'<p class="recDate" hidden>'+res[key].AttendanceDate+'</p>'+'</a></li>';
						}
						$("#date_data").html(htmlinfo);
					},
					"json"
					);
			},
			 "json"
			);
		$.post(
			"<?=Url::toRoute('student-check/addcheck');?>",
			{StuNumber:'all',TeachingClassID:TeachingClassID,state:'0'},
			function(res){

			});		
	}
})

//新点到（今日点到）
$(document).on('click','.now_check_btn',function(){
	var self=$(this);
	var TeachingClassID=$("#class_choice_btn").val();

	self.children('.flag').text()=='1' ? self.children('.flag').text('0') : self.children('.flag').text('1');
	self.children('.flag').text()=='1' ? self.children('.info').text('已到') : self.children('.info').text('未到');
	self.children('.flag').text()=='1' ? self.attr('class','btn btn-primary dropdown-toggle now_check_btn') : self.attr('class','btn btn-danger dropdown-toggle now_check_btn');
	
	$.post(
		"<?=Url::toRoute('student-check/addcheck');?>",
		{StuNumber:self.val(),TeachingClassID:TeachingClassID,state:self.children('.flag').text()},
		function(res){

		}

		);

});
//根据教学班级id获取日期
$(document).on('click','.class_choice_a',function(){
	var term=$("#term_choice_btn").val();
	var TeachingName=$(this).children('.TeachingName').html();
	var TeachingClassID=$(this).children('.TeachingClassID').html();
	$("#class_choice_btn").html(TeachingName);
	$("#class_choice_btn").val(TeachingClassID);
	//alert(1);
	
	$.post(
		"<?=Url::toRoute('student-check/getstudent')?>",
		{
		TeachingClassID:TeachingClassID,
		},
		function(res){
			var htmlinfo='';
			var modal_info='';
			var i=1;
			for(var key in res)
			{
				// 点到查看表格信息加载
				htmlinfo+='<tr role="row" id="'+res[key].StuNumber+'x">'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuNumber+'</th>'+'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Name+'</th>'+'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Sex+'</th>'+'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ClassName+'</th>'+'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" id="'+res[key].StuNumber+'">'+'<span class="atteninfo label label-danger ">未到</span>'+'</th>'+'</tr>';
				// modal信息加载
				modal_info+='<tr role="row" class="add">'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].StuNumber+'</th>'+'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].Name+'</th>'+
				'<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="state">'+'<button type="button" class="btn btn-danger dropdown-toggle now_check_btn" data-toggle="dropdown" id="'+res[key].StuNumber+'info" value="'+res[key].StuNumber+'">'+'<p class="info">未到</p><p class="flag" hidden>'+0+'</p>'+'<p class="StuName" hidden>'+res[key].Name+'</p>'+'</button></th>'
				'</tr>';
				i++;
			}
			$("#student_info").html(htmlinfo);
			$("#check_info").html(modal_info);
			
		},	
		"json"
		);
	$.post(
	"<?=Url::toRoute('student-check/getdate');?>",
	{TeachingClassID:TeachingClassID,term:term},
	function(res){
		var htmlinfo='';
		for(var key in res)
		{
			htmlinfo+='<li><a href="#" class="date_time">'+'<p class="showDate">'+res[key].AttendanceDate+'</p>'+'<p class="recDate" hidden>'+res[key].AttendanceDate+'</p>'+'</a></li>';
		}
		$("#date_data").html(htmlinfo);
	},
	"json"
	);
});
//获取出勤信息
$(document).on('click','.date_time',function(){
	var term=$("#term_choice_btn").text();
	var class_name=$("#class_choice_btn").text();
	var TeachingClassID=$("#class_choice_btn").val();
	var date=$(this).children('.recDate').text();
	$("#date_choice_btn").text(date);
	$("#check_title").html("出勤情况（"+class_name+'--'+date+"）");
	$.post(
		"<?=Url::toRoute('student-check/getstate');?>",
		{
			TeachClass:TeachingClassID,
			AttendanceDate:date,
		},
		function(res)
		{
			for(var key in res)
			{
				var state=res[key].AttendanceState=='1' ? '<span class="label label-default">已到</span>' : '<span class="label label-danger ">未到</span>';
				$("#"+res[key].StudentNum).html(state);
			}
		},
		 "json"
		);
});

</script>
