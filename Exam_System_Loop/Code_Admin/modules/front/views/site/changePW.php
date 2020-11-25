<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>
<style type="text/css">
body{
	background:#ECF0F5;
	margin-top: 0px;
}
.wrap{
	max-width:86%;
	height:500px;
	margin:0 auto;

	background-color: white;
}
.content{
	max-width:35%;
	height:390px;
	margin:0 auto;
	margin-top:50px;
	padding-top: 10px;
	background-color: #f9f9f9;

	background-repeat: no-repeat;
	background-size:cover;
	background-position:center;
	border-radius: 8px;
	text-align: center;
}
.content .IfoName{
	max-width: 80%;

	letter-spacing: 2px;
	margin:0 auto;
	margin-top: 20px;
	text-align: center;
	height: 35px;
	font-weight: 30px;
	line-height: 30px;
	font-size: 20px;
	margin-bottom: -15px;

}
.content .password{
	max-width:60%;
	margin:0 auto;
	margin-top: 30px;
	height:250px;
	border:0px solid gray;
}
#pass{
	max-width:80%;
	margin: 0 auto;
	line-height: 50px;
	margin-top: 20px;
	font-size: 15px;
}
input{
	height:26px;
	border-radius: 3px;

}
#sub{


	border-radius: 0px;
	width:50%;
	margin:0 auto;
	margin-top: 15px;

	text-align: center;


	letter-spacing: 8px;
	color: white;
	cursor: pointer;
}
.left{
	max-width:110px;
	text-align: right;
	margin-right: 8px;
}
.right{
	max-width: 240px;
	text-align: left;
}
label{
	font-weight: normal;
}
.password{
	min-width: 406px;
	min-height: 300px;
}

</style>
</head>

 <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function() {
            	$("#sub").click(function(){
            		var oldWord = $("#OldPW").val();
            		var newWord1 = $("#NewPw1").val();
            		var newWord2 = $("#NewPw2").val();
            		if(!oldWord){
            			alert("请输入原始密码！");
            		}else if(!newWord1){
            			alert("请输入新密码！");
            		}else if(newWord1!=newWord2){
            			alert("请重新确认新密码!");
            		}else{
            			$.ajax({
            				type:"post",
            				dataType:'json',
            				url:'<?=Url::toRoute("site/change")?>',
            				data:{ "StuNumber":$('#user').html(),"oldpassword":$('#OldPW').val(),"newpassword":$('#NewPw1').val() },
            				success:function(data){
            					if(data.error == 0){
            						alert('修改成功');
									window.location.reload();
            					}else{
            						alert("原始密码输入错误！");
            					}
            				},
            				cache:false,
            			});
            		}
            	});
            });
</script>

<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">
<div class="wrap">
	<div class="content">
		<div class="IfoName"><span>修改个人密码</span>
		</div>
		<div class="password">
			<table id="pass">
				<tr><td class="left" >用户名&nbsp;&nbsp;&nbsp;：</td><td class="right" id="user" name="StuNumber"><?=Yii::$app->session->get('StudentNum')?></td></tr>
				<tr><td class="left"><label>原密码&nbsp;&nbsp;&nbsp;：</label></td><td class="right"><input id="OldPW" class="form-control" type="password" name="oldpassword" maxlength="20"></td></tr>
				<tr><td class="left"><label>新密码&nbsp;&nbsp;&nbsp;：</label></td><td class="right"><input id="NewPw1"  class="form-control" type="password" name="newpassword" maxlength="20"></td></tr>
				<tr><td class="left"><label>确认密码：</label></td><td class="right"><input id="NewPw2" class="form-control" type="password" maxlength="20"></td></tr>
			</table>
			<button  id="sub" type="submint" value="提交" class="btn btn-primary  ">提交</button>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
