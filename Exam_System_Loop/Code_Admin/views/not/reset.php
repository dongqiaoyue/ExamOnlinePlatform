<?PHP
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>学员登陆界面</title>
    <style media="screen">

      .bg{
        width: 100%;
        background-image: url("<?=Url::base()?>/front/img/bghyh1.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center ;
        position: fixed;
        height: 100%;
        background-attachment: fixed;

        opacity: 0.9;
      }
      .box{

        width: 100%;
        height: 450px;
        /* margin-top: 200px; */
        float: none;
       display: block;
       margin-left: auto;
       margin-right: auto;

        -webkit-box-shadow: 0 0 1px 1px rgba(0,0,0,.1);
        box-shadow: 0 0 1px 1px rgba(0,0,0,.2);
        padding: 0 30px;
        border-radius: 0px;

        margin-top: 100px;
      }

      .box h1,h4{
        text-align: center;
      }
      .box h4{
        margin-top: 50px;
        margin-bottom: 20px;
      }
      .col-center-block {
        float: none;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    button{
      box-shadow: 0px;
      border-radius: 0px;
    }
    .btn1{
      margin-bottom: 20px;
    }
		.btn2{
			border: 0px;
			background-color: #fff;
		}
		#notice{
			color: red;
		}
    </style>
  </head>
  <body>
      <div class="container-fulid ">
          <div class="row">
            <div class="bg">
                <div class="col-md-3  col-center-block">
                  <div class="container-small clearfix">
                    <div class="box">
                        <h1>初始化密码</h1>
                        <div class="form-group">
                          <label>学号：</label>
                          <input type="text" class="form-control" name="StuNumber" id="StuNum" tabindex="1" placeholder="请输入学号"/>
                        </div>
                        <div class="form-group">
                          <label>身份证号码：</label>
                          <input type="text" class="form-control" name="password" id="IC" tabindex="2" placeholder="请输入身份证号码"/>
                        </div>
												<div class="form-group">
                          <a href="<?=Url::toRoute('/not/reset')?>"><p id="notice">注：重置后密码初始化为学号！</p></a>

                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary btn-block " id="save" name="button" type="submit">重置</button>
                        </div>

                        <a href="<?=Url::toRoute('/index/index')?>" class="btn btn-success btn-lg btn-block btn1">网站首页</a>
                        <button type="button" name="button" class="btn btn-default btn-lg btn-block btn2">过程化考核平台学生考试中心</button>
                  </div>
                  </div>
            </div>
          </div>
          <div id = "Waitting" class="loginDiv_over">
               <img src="<?=Url::base()?>/front/img/loading.gif" alt="……" title="Loading..." max-width="300px"
                   max-height="300px" />
          </div>
      </div>
<script src="<?=Url::base()?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
	$('#save').click(function(){
		var num = $('#IC').val().length;
		var id = $('#StuNum').val();
		if(!id){
			alert("请输入学号！");
		}else if(num!=18){
			alert("请确认身份证号是否填写正确，默认为18位");
		}else{
		$.post(
			"<?=Url::toRoute('not/resetpasswd')?>",
			{
				StuNum:$('#StuNum').val(),
				IC:$('#IC').val()
			},
			function(res){
				alert(res);
			}
			)
	}
	})
</script>
</body>
</html>
