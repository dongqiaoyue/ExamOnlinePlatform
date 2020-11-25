<?php
/**
 * Created by PhpStorm.
 * User: ProPHPer
 * Date: 2016/11/17
 * Time: 下午8:09
 */
use yii\helpers\Url;

?>
<div class="row">
<br><br>
<div class="col-lg-4">

</div>
<div class="col-lg-2">
   <input type="text" class="form-control" id="search" placeholder="搜索：route，ip，用户账号"/>
</div>

<div class="col-lg-2">
<input type="text" class="form-control" id="time" readonly="readonly" placeholder="日期选择" name="time" />
</div>
<div class="col-lg-4">

</div>
</div>
<div class="row">
<div class="col-sm-12">
    <table id="log_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
    <h3 class="text-center" id="log_title"></h3>
        <thead>
        <tr role="row">

            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >用户帐号</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >用户姓名</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >route</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >IP</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >user_agent</th>

            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >日期</th>
            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >详情</th>
        </tr>
        </thead>
        <!-- 点到信息列表 -->
        <tbody id="log_info">


        </tbody>
    </table>

    <div class="modal-footer">
		<ul class="pagination" id="page">
		</ul>

	</div>
</div>
</div>

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

	                <h3>GET请求参数表</h3>
	                <tr role="row">
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
	                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >参数</th>
	                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >值</th>
	                 </tr>
	                </thead>
	                <tbody id="detaile_get">

	                </tbody>
	            	</table>
	            </div>
	            <div class="col-sm-6">
	            	<table id="detaile_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
	                <thead>
	                <h3>POST请求参数表</h3>
	                <tr role="row">
                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
	                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >参数</th>
	                	<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >值</th>

	                 </tr>
	                </thead>
	                <tbody id="detaile_post">

	                </tbody>
	            	</table>
	            </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script>

	$("#search").on("input propertychange",function(){
		var key = $(this).val();
		$.post(
			"<?=Url::toRoute('log/search-log')?>",
			{
				key:key,

				PageNum:0,
			},
			function(res){
				$('#log_info').empty();
				var i=1;
				for(var key in res)
				{
					$('#log_info').append(
						'<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].userName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].routeName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].route+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ip+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user_agent+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].created_at+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary option_btn" value="'+res[key].id+'">详情</button></th></tr>'
						);

				}
				var count = res[0]['count'];
				var html_li = '';
				for(var i=0; i<count; i++)
				{
					if(res[0]['i']/20 == i)
						html_li += '<li class="active"><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';
					else if(res[0]['i']/20 - i < 5 && res[0]['i']/20 - i > -5)
						html_li += '<li><a href="#" class="seacher_page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';

				}
				$('#page').html(html_li);
			},
			"json"
			)
	})
	$(document).ready(function(){
		$( "#time" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
	})
	$('#time').change(function(){
		var time = $('#time').val();
		$.post(
			"<?=Url::toRoute('log/get-log')?>",
			{
				time:time,
				PageNum:0,
			},
			function(res){
				$('#log_info').empty();
				var i=1;
				for(var key in res)
				{
					$('#log_info').append(
						'<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].userName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].routeName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].route+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ip+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user_agent+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].created_at+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary option_btn" value="'+res[key].id+'">详情</button></th></tr>'
						);
				}
				var count = res[0]['count'];
				var html_li = '';
				for(var i=0; i<count; i++)
				{
					if(res[0]['i']/20 == i)
						html_li += '<li class="active"><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';
					else if(res[0]['i']/20 - i < 5 && res[0]['i']/20 - i > -5)
						html_li += '<li><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';

				}
				$('#page').html(html_li);
			},
			"json"
			)

	})

	$(document).on('click','.page_choice',function(){
		var time = $('#time').val();
		var PageNum = $(this).children('.PageNum').text();
		$.post(
			"<?=Url::toRoute('log/get-log')?>",
			{
				time:time,
				PageNum:PageNum,
			},
			function(res){
				$('#log_info').empty();
				var i=res[0]['i']+1;
				for(var key in res)
				{
					$('#log_info').append(
						'<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].userName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].routeName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].route+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ip+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user_agent+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].created_at+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary option_btn" value="'+res[key].id+'">详情</button></th></tr>'
						);

				}
				var count = res[0]['count'];
				var html_li = '';
				for(var i=0; i<count; i++)
				{
					if(res[0]['i']/20 == i)
						html_li += '<li class="active"><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';
					else if(res[0]['i']/20 - i < 5 && res[0]['i']/20 - i > -5 )
						html_li += '<li><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';

				}
				$('#page').html(html_li);
			},
			"json"
			)

	})
	$(document).on('click','.seacher_page_choice',function(){
		var key = $('#search').val();
		var PageNum = $(this).children('.PageNum').text();
		$.post(
			"<?=Url::toRoute('log/search-log')?>",
			{
				key:key,
				PageNum:PageNum,
			},
			function(res){
				$('#log_info').empty();
				var i=res[0]['i']+1;
				for(var key in res)
				{
					$('#log_info').append(
						'<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user+'</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].userName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].routeName+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].route+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ip+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].user_agent+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].created_at+'</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-sm btn-primary option_btn" value="'+res[key].id+'">详情</button></th></tr>'
						);

				}
				var count = res[0]['count'];
				var html_li = '';
				for(var i=0; i<count; i++)
				{
					if(res[0]['i']/20 == i)
						html_li += '<li class="active"><a href="#" class="page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';
					else if(res[0]['i']/20 - i < 5 && res[0]['i']/20 - i > -5 )
						html_li += '<li><a href="#" class="seacher_page_choice">'+(i+1)+'<p class="PageNum" hidden>'+i+'</p></a></li>';

				}
				$('#page').html(html_li);
			},
			"json"
			)

	})
	$(document).on('click','.option_btn',function(){
		var id = $(this).val();
		$('#detaile_modal').modal('show');
		$.post(
			"<?=Url::toRoute('log/get-details')?>",
			{
				id:id,
			},
			function(res){
				$('#detaile_get').empty();
				$('#detaile_post').empty();
				var i=1;

				for(var key in res.gets)
					$('#detaile_get').append(
						'<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+
                        '</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+key+
                        '</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><textarea>'+
                        res.gets[key]+'</textarea></tr>');

				i=1;


				for(var key in res.posts)
					$('#detaile_post').append(
						'<tr role="row"><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i++)+
                        '</th><th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+key+
                        '</th><th tabindex="0" class="name" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><textarea>'+
                        res.posts[key]+'</textarea></tr>'
						);

			},
			'json'
			)

	})

</script>
