<?PHP
use yii\helpers\Url;
?>

<div class="well well-lg row">
<br><br><br>
	<div class="col-sm-4">
	</div>

	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title text-center">
					请完善自己的信息
				</h3>
			</div>
			<br>
			<br>
			<div class="panel-body">
					<div class="input-group">
						<span class="input-group-addon">身份证号：</span>
						<input type="text" class="form-control" placeholder="用于重置密码" id="IC">
					</div>
					<br><br><br>

					<div class="input-group" style="margin: auto;">
						<button type="button" id="save" class="btn btn-primary" data-toggle="button"> 
						保存
						</button>
					</div>
					<br>

			</div>
		</div>
	</div>
	<div class="col-sm-4">
	</div>
</div>
 <script src="<?=Url::base()?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
	$('#save').click(function(){
		$.post(
			"<?=Url::toRoute('not/saveic')?>",
			{
				IC:$('#IC').val()
			},
			function(res){
				window.location.reload();
			}
			)
	})
</script>
