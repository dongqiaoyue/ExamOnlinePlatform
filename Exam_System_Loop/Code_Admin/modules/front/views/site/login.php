<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>学员登陆界面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <style media="screen">

      .bg{
        width: 100%;
        background-image: url("<?=Url::base()?>/front/img/bghyh00.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center ;
        position: fixed;
        height: 100%;
        background-attachment: fixed;

        opacity: 0.9;
      }

      .box{

        width: 110%;
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
    /* .btn2{
      border: 0px;
      background-color: #fff;
      color: black
    } */
    @media screen and (min-width:2100px){
          .box{
            width: 80%;

          }


     }
     @media screen and (max-width:1000px){
           .box{
             width: 110%;

           }


      }
      @media screen and (min-width:1000px) and (max-width:1500px){

        .box{
          width: 120%;

        }


        }
       @media screen and (min-width:1500px) and (max-width:2000px){

         .box{
           width: 110%;

         }


         }



    </style>
  </head>
  <body>
      <div class="container-fulid ">
          <div class="row">
            <div class="bg">
                <div class="col-md-3  col-xs-10 col-lg-3 col-center-block">
                  <div class="container-small clearfix">
                    <div class="box">
                        <h1>学员登录</h1>
                        <div class="form-group">
                          <label>学号</label>
                          <input type="text" class="form-control" name="StuNumber" id="loginname" tabindex="1" placeholder="请输入学号"/>
                        </div>
                        <div class="form-group">
                          <label>密码</label>
                          <input type="password" class="form-control" name="password" id="password" tabindex="2" placeholder="请输入密码"/>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary btn-block " id="imgLogin" name="button" type="submit">登录</button>
                        </div>
                        <div class="form-group">
                          <a href="<?=Url::toRoute('/not/reset')?>">忘记密码？</a>

                        </div>
                        <a href="<?=Url::toRoute('/index/index')?>" class="btn btn-success btn-lg btn-block btn1">网站首页</a>
                        <button type="button" name="button" class="btn btn-success btn-lg btn-block btn2">非涉密课程学习考评系统</button>

                  </div>

                  </div>

            </div>
          </div>
          <div id = "Waitting" class="loginDiv_over">
               <img src="<?=Url::base()?>/front/img/loadinghyh.gif" alt="……" title="Loading..." width="300px"
                   height="300px" />
          </div>
      </div>
          <script type="text/javascript">

          $(document).ready(function () {
            $("#imgLogin").click(function(){
                  var name = $("#loginname").val();
                  var pwd = $("#password").val();
                  if (name != "" && pwd != "") {
                      $.ajax({
                          type: "post",
                          dataType: "JSON",
                          url: '<?=Url::toRoute("site/login")?>',
                          data: { "StuNumber": $('#loginname').val(), "password": $('#password').val() },
                          success: function (data) {
                              if(data.error == 0){
                                $(".loginDiv_over").css("display","block");
                                  window.location.reload();
                              }else{
                                alert("学号或密码输入错误！");
                              }
                          },
                          cache: false,
                      });
                  }
                  else {
                      alert("学号和密码都不能为空！");
                  }
            });
             // 回车按键绑定
              $(document).keydown(function(event){
                  if(event.keyCode==13){
                      $("#imgLogin").click();
                  }
              });
          });

          </script>
  </body>
</html>
