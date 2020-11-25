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
  color: #ffffff;
}
.myfooter p:hover{
  color: #ffffff;
}
.footer-link {
    padding: 25px 0;
    margin: 0 auto;
    text-align: center;
    border-bottom: 1px solid #d0d6d9;
}

.footer-link a {
    margin: 0 10px;
    color: #99a1a6;
}

.friendly-link {
    height: 50px;
    line-height: 50px;
    border-bottom: 1px solid #99a1a6;
    color: #99a1a6;
    text-align: center;
	  overflow:hidden;
}

.friendly-link span {
    font-weight: bold;
    margin-right: 10px;

}

.friendly-link a {
    color: #99a1a6;
    margin: 0 10px;
}

.footer-copyright {
    padding: 20px 0 25px;
    text-align: center;
    color: #b4bbbf;
}
.top{ width:50px; height:50px; display:block; background:#888; color:#fff; text-align:center; font-size:30px; line-height:50px; text-decoration:none; position:fixed; right:50px; bottom:50px; display:none;}
.top:hover{ background:#093}
.news-title {
  line-height: 1.3;
}

.news-status {
  color: #999;
}

.news-status .label {
  opacity: .8;
}

.news-content {
  margin-top: 20px;
  font-size: 15px;
  line-height: 1.5;
	-webkit-box-shadow: 0 0 0px 1px rgba(0,0,0,.1);
  box-shadow: 0 0 0px 1px rgba(0,0,0,.1);
	border-radius: 2px;
	margin-bottom: 20px;
	padding: 30px 60px;


}

.news-content img {
  margin-top: 10px;
  margin-bottom: 10px;
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
              <from class="navbar-form navbar-right hidden-xs" role="search">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="请输入内容">
                  </div>
                  <button type="submit" class="btn btn-default">搜索</button>
              </from>
            </div>
          </div>
        </nav>
      </div>
		<div class="container clearfix">
        <div class="row">
            <div class="col-xs-12">
              <div class="nav-smart">
                <ol class="breadcrumb">
                    <li><a href="<?=Url::toRoute('/index/index')?>">首页</a></li>
                    <li ><a href="<?=Url::toRoute('/index/news-list')?>">新闻列表</a></li>
										<?php foreach($m_news as $model) {?>
										<li class="active"><?=$model['newstitle']?></li>
										<?php }?>
                </ol>
              </div>
            </div>
						<div class="col-md-10	">
      				<div class="container">
      		    <div class="col-xs-9  col-xs-offset-1">

      					<?php foreach($m_news as $model) {?>
      						<h1 class="news-title"><?=$model['newstitle']?></h1>

      						<div class="news-status">
      								发布者：<?=$model['releaseUser']?> &nbsp;发布时间：<?=$model['releasetime']?>
      						</div>
      			    <?php }?>


      		      </div>
      		      <div class="news-content col-xs-12 col-xs-offset-0">
      						<?php foreach($m_news as $model) {?>
      						<p><?=$model['newscontent']?></p>
      						<?php }?>
      		      </div>
      		    </div>
        </div>
				</div>
      </div>
    <div class="myfooter">
     <div class="container">
             <div class="row">
                  <div class="col-xs-12">
                    <div class="footer-link">
                       <a href="<?=Url::toRoute('/front/site/index')?>" title="学生登陆">学员登陆</a>
                       <a href="<?=Url::toRoute('/site/index')?>" title="老师登陆">教员登陆</a>
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
          <p>QQ反馈群</p>

      </div>


    </div>
  </body>
  </html>
