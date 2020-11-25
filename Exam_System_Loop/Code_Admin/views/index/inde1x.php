<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
// var_dump($deve);
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=100%, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes"/>
  <!-- <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no"/> -->
  <!-- <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" /> -->
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  /> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Jophy" />
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



    <link rel="shortcut icon" href="<?=Url::base()?>/front/img/inco.ico"/>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style media="screen">
    body{
        font-family: "proxima-nova", sans-serif;

      }

            *
      {
        cursor: url(http://cur.cursors-4u.net/symbols/sym-1/sym46.cur), default!important;
      }
    .navbar-brand {
      width: 60px;
      background-image: url("<?=Url::base()?>/front/img/logo4.png");
      background-repeat: no-repeat;
      background-size: 80%;
      background-position: center center;
    }
  .myheading{
    background-color: #ffffff00;
    height: 0px;
  }
  .navbar{
    border-radius: 0px;
    background-color: #fff;
    box-sizing: border-box;

    transition:0.3s;
    border: 0px;

    position: fixed!important;
    top:-50px;left:0;

  }


  .navbar.on{ top:0}
  .navbar-brand{
    width:50px;
  }
  ul,ul li{
    list-style: none;
  }

a{
  text-decoration: none!important ;
}
.myfooter {
	background-color: #fff;
	border-top: 1px solid #ddd;
	padding-top: 20px;
	color: #9d9d9d;
  text-align: center;
}
.myfooter a:hover{
  color: #000;
}
.myfooter p:hover{
  color: #000;
}
.footer-link {
    padding: 25px 0;
    margin: 0 auto;
    text-align: center;
    border-bottom: 1px solid #d0d6d9;
}

.footer-link a {
    margin: 0 10px;
    color: #000;
}

.friendly-link {
    height: 50px;
    line-height: 50px;
    border-bottom: 1px solid #99a1a6;
    color: #000;
    text-align: center;
	  overflow:hidden;
}

.friendly-link span {
    font-weight: bold;
    margin-right: 10px;

}

.friendly-link a {
    color: #000;
    margin: 0 10px;
}

.footer-copyright {
    padding: 20px 0 25px;
    text-align: center;
    color: #000;
}
.top{ width:50px; height:50px; display:block; background:#888; color:#fff; text-align:center; font-size:30px; line-height:50px; text-decoration:none; position:fixed; right:50px; bottom:50px; display:none;}
.top:hover{ background:#093}
#dep{
  background-color: #eee;
  height: 1000px;
}
.bg{
  background-image: url("<?=Url::base()?>/front/img/bghyh.png");
  background-repeat: no-repeat;
  background-size: 120%;
  background-position: center center;
  height: 850px;
  background-color: #eee;
  opacity:0.9;
  background-clip:content-box;

  /* text-indent: -9999px; */
  width: 100%;
}
.bg .col-md-4 .content{
  text-align: center;
}
.content{
  margin: 0px auto;
  vertical-align:middle;
  margin-top: 220px;
  margin-bottom: 30px;
}
.bt{
  height: 80px;
  width: 240px;
  margin: 0 auto;
}
.bt .btn {
    padding: 1rem 4rem;
    border-radius: 0;
    border: none;
    font-weight: 700;
    font-size: 1.5rem;
    line-height: 1.25;
    background-color: #ea5959;
}
.bg-de{
  width:100%;
  height:auto;
  background-color: #fcfcfc;
  margin-bottom: 40px;
}
.de-title{
  border-bottom: 2px solid rgba(185, 205, 222, 0.2);

  margin: 30px 60px;
  margin-top: 80px;
  overflow: hidden;
  width: 90%;

}
.de-title a{
  border-radius: 0px;
  border:0px;
  float: right !important;
  display: inline-block;
  vertical-align: baseline;

}
.member img{

  background-repeat: no-repeat;
  background-size: 100%;
  background-position: center center;
  background-color: #eee;
  opacity:0.8;
  margin-top: 15px;
}
.de-content{
  margin: 20px 15px;
}
.member .col-md-4{

  height: 150px;
  margin-bottom: 40px;

}
.member-info{
  margin-left: 20px;
  vertical-align: center;
}
*:not([class*="icon"]):not(i) {
    font-family: "微软雅黑" !important;
}

</style>
    <script type="text/javascript">


    $(function(){
    	var top1=$(window).scrollTop()
    	$(".navbar").addClass("on")

    	$(window).scroll(function(){

    		var top2=$(window).scrollTop();

    		if(top2>top1){
    			$(".navbar").removeClass("on")
    		}else{
    			$(".navbar").addClass("on")
    		}
    		top1=top2;
    	})
    })




    $(function(){


      $(window).scroll(function(){
      	var t=$(this).scrollTop()
        // console.log(t);
      	if(t<100){
          // console.log(t);
          $(".navbar").css("background-color","#ffffff00");
          $(".navbar").css("box-shadow","rgba(0, 0, 0, 0.0) 0px 0px 0px");

          $(".shouye").removeClass('active');


      	}else{
      		$(".navbar").css("background-color","#fff");
          $(".navbar").css("box-shadow","rgba(0, 0, 0, 0.14) 0px 2px 4px");
            $(".shouye").addClass('active');
      	}

      })


    $(window).scroll(function(){
    	var t=$(this).scrollTop()
    	if(t>200){
    		$(".top").stop().fadeIn();
    	}else{
    		$(".top").stop().fadeOut();
    	}

    })



    $(".top").click(function(){

    	$("body,html").stop().animate({scrollTop:0},300)
    })



    })
      </script>

  </head>
  <body>


    <div class="myheading">
        <nav class="navbar navbar-default navbar-fixed-top nav-touming">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">
              </a>
            </div>
            <div class="collspse navbar-collapse">
              <ul class="nav navbar-nav">
                  <li class="active shouye"><a href="<?=Url::toRoute('/index/index')?>">首页</a></li>
                  <li class=""><a href="<?=Url::toRoute('/index/about-us')?>">关于我们</a></li>
                  <li class=""><a href="<?=Url::toRoute('/index/news-list')?>">新闻列表</a></li>
                  <li class="dropdown hidden">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expended="false">系统维护<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">回复系统</a></li>
                      <li><a href="#">回复系统</a></li>
                      <li><a href="#">回复系统</a></li>
                      <li><a href="#">回复系统</a></li>

                    </ul>
                  </li>
              </ul>
              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/front/site/index')?>" role="button">学员登陆</a>
              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/site/index')?>" role="button">教员登陆</a>
              <from class="navbar-form navbar-right" role="search">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入内容">
                  </div>
                  <button type="submit" class="btn btn-default">搜索</button>
              </from>
            </div>
          </div>
        </nav>
      </div>
        <div class="contaier-fulid">
          <div class="row">
              <div class="col-md-12">
                <div class="bg">
                      <div class="col-md-4 col-md-offset-4">
                        <div class="content">
                          <h1 class="">欢迎你</h1>
                          <h3>非涉密课程学习考评系统</h3><br>
                          <!-- <p>过程化考核平台</p> -->

                        </div>
                        <div class="bt">
                            <a class="btn btn-success btn-lg btn-block" href="<?=Url::toRoute('/front/site/index')?>" role="button">开始</a>
                        </div>
                      </div>
                </div>

              </div>

          </div>
        <div class="container">
          <div class="row">
            <div class="col-md-12 bg-de">
                <div class="col-md-12 de-title">
                        <h1>Members  <a href="#" class="btn btn-info btn-lg">Join In</a></h1>

                </div>

                <div class="col-md-12 de-content">
                        <div class="member">
                          <?php foreach($deve as $model){?>
                            <!-- var_dump($model); -->
                              <div class="col-md-4">
                                    <div class="col-md-4">
                                      <img class="img-circle" style="width:100px;" src="upload/tmp_file/<?=$model['Src']?>" alt="">
                                    </div>
                                    <div class="col-md-6 member-info">
                                       <h3><?=$model['DeveloperName']?></h3>
                                       <p class="text-muted"><?=$model['Motto']?></p>
                                       <p class="text-muted">QQ:<?=$model['QQ']?></p>
                                    </div>
                              </div>
                              <?php }?>



                        </div>
                </div>
            </div>
          </div>
        </div>


      </div>

    <div class="myfooter">
     <div class="container">

             <div class="footer-link">
                <a href="<?=Url::toRoute('/front/site/index')?>" title="学生登陆">学生登陆</a>
                <a href="<?=Url::toRoute('/site/index')?>" title="老师登陆">老师登陆</a>
             </div>

     </div>
    </div>
    <a href="javascript:;" class="top">∧</a>
  </body>
  </html>
