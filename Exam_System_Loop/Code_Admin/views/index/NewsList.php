<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
//  foreach ($type as $model) {
//     $kename = $model['CuitMoon_DictionaryName'];
//     var_dump($kename);
//     echo '<li> <a id="NewsType" onclick="newsAction(' . "'$kename'" . ')" href="#">'.$kename.'</a></li>';
// }
// var_dump($m_news);

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
      background-image: url("<?=Url::base()?>/front/img/logo5.png");
      background-repeat: no-repeat;
      background-size: 80%;
      background-position: center center;
    }
  .myheading{
    background-color: #333;
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
.navbar{
  border-radius: 0px;
  background-color: #fff;
  box-sizing: border-box;
  box-shadow: 0 3px 5px rgba(0,0,0,.3);
  transition:0.3s;
}
.myfooter {
	background-color: #fff;
	border-bottom: 2px solid rgba(185, 205, 222, 0.2);
	padding-top: 20px;
	color: #9d9d9d;
  text-align: center;
  width:100%;
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
    border-bottom: 2px solid rgba(185, 205, 222, 0.2);
}

.footer-link a {
    margin: 0 10px;
    color: #99a1a6;
}

.friendly-link {
    height: 50px;
    line-height: 50px;
    border-bottom: 2px solid rgba(185, 205, 222, 0.2);
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
.news-list-item {
    padding-top: 10px;
    padding-bottom: 10px;

    border-bottom: 2px solid rgba(185, 205, 222, 0.2);
}

.news-list-item:first-child {
    padding-top: 0;
}

.news-list-item .title {
    display: block;
    color: #444;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
    line-height: 1.5;
}

.news-list-item .title:hover {
    color: #337ab7;
}

.news-list-item .info {
    color: #888;
}

.avatar {
    display: inline-block;
}

.avatar img {
    display: inline-block;
    width: 16px;
    height: 16px;
    margin-right: 5px;
}
.news-title {
  line-height: 1.3;
}

.news-status {
  color: #999;
}

.news-status .label {
  opacity: .8;
}

.news-list{
  margin-bottom: 80px;
}
.news-list-item img{

    max-width: 80%;
    display: block;
    border-radius: 3px;
}
.news-list-item:first-child {
    padding-top: 0;
}
.news-title {
  line-height: 1.3;
}

.news-status {
  color: #999;
}

.news-status .label {
  opacity: .8;
}


.list-group-item {
    border: 0;
    margin-bottom: 5px;
}
.info{
  margin-top: 20px;
}
#touxiang{
  max-width: 100%;
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
        <nav class="navbar navbar-default  ">
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
                <li class=""><a href="<?=Url::toRoute('/index/about-us')?>">关于我们</a></li>
                <li class="active"><a href="<?=Url::toRoute('/index/news-list')?>">新闻列表</a></li>
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
              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/site/index')?>" role="button">教员登陆</a>
              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/front/site/index')?>" role="button">学员登陆</a>
            </div>
          </div>
        </nav>
    </div>

    <div class="mybody">
      <div class="container">
          <div class="row">
              <div class="col-md-12 clearfix">
                <div class="nav-smart">
                  <ol class="breadcrumb">
                      <li><a href="<?=Url::toRoute('/index/index')?>">首页</a></li>
                      <li class="active">新闻列表</li>
                  </ol>
                </div>
              </div>
              <div class="leftmenu col-md-3 hidden-xs">
                <div class="list-group">
                   <a href="<?=Url::toRoute('/index/news-list')?>" class="list-group-item active main-news">全部</a>
                  <?php foreach ($type as $model) {
                      $id = $model['CuitMoon_DictionaryName'];
                      echo ' <a id='.$id.' class="list-group-item" onclick="newsAction(' . "'$id'" . ')" href="#">'.$model['CuitMoon_DictionaryName'].'</a>';
                  }?>
              </div>
            </div>
        <div class="col-md-7">
            <div class="news-list">
              <?php foreach($m_news as $model) { if ($model['State']==0){continue;}?>
                <div class="news-list-item clearfix">
                  <div class="col-xs-4">
                    <img  id="touxiang" src="<?=Url::base()?>/front/img/logo5.png">
                  </div>
                  <div class="col-xs-8">
                    <a href="<?=Url::toRoute('index/news')?>&&id=<?=$model['newsBh']?>" class="title"><?=$model['newstitle']?></a>
                    <div class="info">
                      <span><span class="avatar"><img src="<?=Url::base()?>/front/img/logo5.png" ></span><?=$model['releaseUser']?></span> ⋅
                      <span>9999k评论</span> ⋅
                      <span><?=$model['releasetime']?></span>
                    </div>
                  </div>
                </div>

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
    <script>


        function newsAction($id){
            // console.log($id);
            $(".list-group-item").removeClass('active');
            $("#"+$id).addClass('active');


            $.ajax({
                type: "GET",
                url: "<?=Url::toRoute('index/news-type')?>",
                data: {"id":$id},
                cache: false,
                dataType:"json",
                error: function (xmlHttpRequest, textStatus, errorThrown) {
                    alert( xmlHttpRequest.readyState+ textStatus);
                    window.location.reload();
                },
                success: function(data){
                      // console.log(data);
                        var html = '<div class="news-list">';
                        for(key in data)
                        {
                            if(data[key].State==0){continue;}
                            else{

                              html += '<div class="news-list-item clearfix">'+
                                            '<div class="col-md-4">'+
                                              '<img src="<?=Url::base()?>/front/img/timg.jpg">'+
                                            '</div>'+
                                              '<div class="col-md-8">'+
                                                '<a href="<?=Url::toRoute('index/news')?>&&id='+data[key].newsBh+'" class="title">'+data[key].newstitle+'</a>'+
                                                  '<div class="info">'+
                                                  '<span><span class="avatar"><img src="<?=Url::base()?>/front/img/default.gif" ></span>admin</span>⋅nbsp'+
                                                  '<span>9999k评论</span> ⋅'+
                                                  '<span>'+data[key].releasetime+'</span>'+
                                                  '</div>'+
                                              '</div>'+
                                          '<div>'+
                                          '</div>'+
                                          '<div>'+
                                          '</div>'+
                                          '</div>';
                            }

                        }
                          html+='</div>';

                         // document.write(html);
                        $('.news-list ').html('');

                        $('.news-list').append(html);
                }
            });
        }
    </script>
  </body>
  </html>
