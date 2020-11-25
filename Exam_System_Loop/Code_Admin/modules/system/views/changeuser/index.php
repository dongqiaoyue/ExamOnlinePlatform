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
			<br>
			<br>
				<select name="user" class="form-control " id="change_user">
					<?php foreach ($user as $value){?>
                        <option value="<?=$value['CuitMoon_UserName']?>"><?=$value['CuitMoon_UserRealName']?></option>
                    <?php }?>
				</select>
			<br>
			</div>
			<div class="input-group" style="margin: auto;">
				<button type="button" id="login" class="btn btn-primary" data-toggle="button"> 
				登陆
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
			"<?=Url::toRoute('changeuser/login')?>",
			{
				user:$("#change_user").val(),
			},
			function(){
				window.location.reload();
			}
			)
	})


</script>