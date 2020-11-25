<?php
use yii\helpers\Url;
?>

<div class="well row">
	<div class="col-sm-4">
	</div>


	<form class="form-horizontal col-sm-4" id="chan_form" method="post" action="<?=Url::toRoute('site/save-myinfo')?>">
	  <div class="form-group">
	    <label for="firstname" class="col-sm-2 control-label">用户名</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="firstname" disabled="true" name="CuitMoon_UserID" value="<?=$myinfo['CuitMoon_UserName']?>">
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <label for="lastname" class="col-sm-2 control-label">姓名</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="CuitMoon_UserRealName" name="TbcuitmoonUser[CuitMoon_UserRealName]" value="<?=$myinfo['CuitMoon_UserRealName']?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="lastname" class="col-sm-2 control-label">手机</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="CuitMoon_UserCellphone" name="TbcuitmoonUser[CuitMoon_UserCellphone]" value="<?=$myinfo['CuitMoon_UserCellphone']?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="lastname" class="col-sm-2 control-label">Email</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="CuitMoon_UserEmail" name="TbcuitmoonUser[CuitMoon_UserEmail]" value="<?=$myinfo['CuitMoon_UserEmail']?>">
	    </div>
	  </div>
	  
	  <div class="">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="" class="btn btn-default">修改</button>
	    </div>
	  </div>
	</form>
	<div class="col-sm-4">
	</div>



</div>
