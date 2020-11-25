<?php
use yii\helpers\Url;

?>

<div class="well well-lg row">
<br><br><br>
	<div class="col-sm-4">
	</div>

	<div class="col-sm-4">
		<div class="panel panel-default">


			<div class="panel-heading form-group">
			<p>题库状态：<span id="status"><?php if($status == '10005001') echo "开放"; else echo "关闭";?></span></p>
			<br>
			<br>
				<select name="user" class="form-control " id="change_user">
					
                       <option value="10005001">开放</option>
                       <option value="10005002">关闭</option>
                </select>
			<br>
			</div>
			<div class="input-group" style="margin: auto;">
				<button type="button" id="login" class="btn btn-primary" data-toggle="button"> 
				确定
				</button>
			</div>

			<br>
			<br>
			
			
		</div>
	</div>
	<div class="col-sm-4">
	</div>
</div>
<script>
	$('#login').click(function(){
		$.post(
			"<?=Url::toRoute('status/change')?>",
			{
				status:$("#change_user").val(),
			},
			function(){
				window.location.reload();
			}
			)
	})


</script>