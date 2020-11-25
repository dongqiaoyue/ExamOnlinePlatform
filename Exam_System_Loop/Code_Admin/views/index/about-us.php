<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Jophy" />
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style media="screen">

    .navbar-brand {
      width: 60px;
      background-image: url("<?=Url::base()?>/front/img/logo6.png");
      background-repeat: no-repeat;
      background-size: 80%;
      background-position: center center;
    }
  .myheading{
    background-color: #333;

  }
  .navbar{
    border-radius: 0px;
    background-color: #fff;
    box-sizing: border-box;
    box-shadow: 0 3px 5px rgba(0,0,0,.3);
    transition:0.3s;
  }
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
	color: black;
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

.top3{ width:158px; height:174px; display:block; background:#666; color:#fff;
   text-align:center; font-size:12px;
   color: black;
   background-image: url("<?=Url::base()?>/front/img/qrcode.jpg");
   background-repeat: no-repeat;
   background-size: 90%;
   background-position: center center;
   display:none;



   line-height:40px; text-decoration:none; position:fixed;
   right:90px; bottom:35px; }
   .top p{
     margin-top: 2px;
   }
.top{ width:40px; height:40px; display:block; background:#666; color:#fff;
   text-align:center; font-size:30px;
   background-image: url("<?=Url::base()?>/front/img/top1.png");
   background-repeat: no-repeat;
   background-size: 40%;
   background-position: center center;



   line-height:40px; text-decoration:none; position:fixed;
   right:50px; bottom:50px; display:none;}
.top1{ width:40px; height:40px; display:block; background:#666; color:#fff;

  background-image: url("<?=Url::base()?>/front/img/wx.png");
  background-repeat: no-repeat;
  background-size: 40%;
  background-position: center center;

  text-align:center; font-size:30px; line-height:40px; text-decoration:none; position:fixed; right:50px; bottom:90px; }
.top:hover{ background:#666}
.about-us{
  margin-left: 30px;
}
#toggle-checkbox:checked ~ div {
  display: block !important;
}

#toggle-label {
  display: inline-block;
  position: absolute;
  right: 15px;
  top: 13px;
  font-size: 16px;
  font-weight: normal;
  color: #666;
  display: none;
}

#toggle-label:hover {
  color: #333;
}
    </style>
    <script type="text/javascript">
    $(function(){
          $(".top1").hover(function(){
        $(".top3").css("display","block");
    },function(){
        $(".top3").css("display","none");
    });


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
        <nav class="navbar navbar-default ">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">
              </a>
            </div>
            <label id="toggle-label" class="visible-xs-inline-block" for="toggle-checkbox">MENU</label>
      <input class="hidden" id="toggle-checkbox" type="checkbox">
            <div class="collspse navbar-collapse hidden-xs">
              <ul class="nav navbar-nav">
								<li class=""><a href="<?=Url::toRoute('/index/index')?>">首页</a></li>
								<li class="active"><a href="<?=Url::toRoute('/index/about-us')?>">关于我们</a></li>
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
              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/site/index')?>" role="button">老师登陆</a>
              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/front/site/index')?>" role="button">学生登陆</a>
            </div>
          </div>
        </nav>
      </div>
		<div class="container clearfix">
        <div class="row">
            <div class="col-md-12">
              <div class="nav-smart">
                <ol class="breadcrumb">
                    <li><a href="<?=Url::toRoute('/index/index')?>">首页</a></li>
                    <li class="active">关于我们</li>
                </ol>
              </div>
            </div>
						<div class="col-md-10 about-us">
						<h2>关于我们</h2><br>

						<p>我们是一个划时代的优秀团队，我们每个人都是团队的不可或缺的一部分，我们专注于<strong>Web网站</strong>开发， 从事<strong>ASP.NET、PHP、HTML5/CSS、Java</strong>等混合开发。我们的很多非常优秀的作品，它们都是属于我们团队中的每一个人。 </p>

						<h3>1. 涉及的技术</h3><br>

						<p>21世纪的是一个智能的时代，在这个时代里，每天都有新技术的兴起，也意味有其它落后的技术被淘汰。因此，我们涉及到以下技术：</p>
						<br>
						<blockquote><p>HTML5,ASP.NET、JAVASCRIPT,OJ,C#,CSS,Java</p></blockquote>

						<p>...在这里我们并不属于一个工匠师，或许我们更应该是一个画家。</p>
						<br>
						<h3>2. 人才需求</h3><br>

						<p>我们作为一支优秀的团队，<strong>有丰富的创造力，想象力</strong>；同时也是一支积极上进的队伍。如果你还在为大学而感到迷惘，徘徊时，请加入我们的队伍，在这里你可以充分发挥的你智慧，去创造属于你的辉煌，为你的人生画上完美的一笔。</p>
						<br>
						<h3>3. 我们的产品</h3><br>

						<p>成功优秀的作品：<strong>成都信息工程学院过程化考核平台、CUIT教师听课APP、CUIT教学质量监测APP、CUIT项目评审APP、移动学习系统APP(基于过程化考核平台)、毕业设计管理系统、大学生创新创业管理系统，智能家居,农产品追溯系统</strong>。</p>
						<br>
						<h3>4. 我们的目标</h3><br>

						<p>目标总是能够激励人们不断的奋斗，去完善我们的不足。所以我们的目标能够不断的完善我们现有系统的可靠性，开发一套独立，便捷人们的系统，<strong>同时希望的我们的团队能够不断的继承和传播，让这种学习奋斗的精神可以永远的延续下去</strong>。</p>
						<br><br><br>
						</div>
        </div>
      </div>
    <div class="myfooter">
     <div class="container">
             <div class="row">
               <div class="col-xs-12">
                 <div class="footer-link">
                    <a href="<?=Url::toRoute('/front/site/index')?>" title="学生登陆">学生登陆</a>
                    <a href="<?=Url::toRoute('/site/index')?>" title="老师登陆">老师登陆</a>
                 </div>
               </div>
             </div>
     </div>
    </div>
    <div class="top-wg">
      <div class="top1">
        <a href="javascript:;" class=""></a>
      </div>
      <div class="top">
          <a href="javascript:;" class=""></a>
      </div>
      <div class="top3">
          

      </div>


    </div>

  </body>
  </html>
