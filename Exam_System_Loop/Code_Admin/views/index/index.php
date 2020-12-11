<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
use app\models\system\TbcuitmoonDictionary;
$m_Dic = new TbcuitmoonDictionary();
$com = new commonFuc();
$i = 1;
// var_dump($deve);
?>
<head>
  <meta charset="UTF-8">
  <!-- <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no"/> -->
  <!-- <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" /> -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Jophy" />
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?=Url::base()?>/front/img/inco.ico"/>

    <style media="screen">
      body{
        font-family: "proxima-nova", sans-serif;
        background: linear-gradient(270deg, #8c76ed, #fca4c5);
        font-family: Roboto, sans-serif;
      }
      .cont {
          width: 100vw;
          height: 100vh;
          margin: 0 auto;
          position: absolute;
          z-index: -1;
      }

      .navbar {
          background-color: transparent !important;
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
  .navbar-btn {
      position: absolute;
      right: 40px;
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
  margin: 10px 50px;
  margin-left: 25px;
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

.top3{ width:300px; height:400px; display:block; background:#666; color:#fff;
   text-align:center; font-size:12px;
   color: black;
    opacity: 0;
    transition: 1s;
   background-image: ;
   background-repeat: no-repeat;
   background-size: 100%;
   background-position: center center;
   display:none;



   line-height:40px; text-decoration:none; position:fixed;
   right:10%; bottom:30%; }
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
.top1{ width:80px; height:80px; display:block;

  background-image: url("<?=Url::base()?>/front/img/caidan.png");
  background-repeat: no-repeat;
  background-size: 100%;
  background-position: center center;

  text-align:center; font-size:30px; line-height:40px; text-decoration:none; position:fixed; right:7%; bottom:15%; }
.top:hover{ background:#666}
.about-us{
  margin-left: 30px;
}
@media only screen and (max-width: 479px){

 .myheading{
      background-color: #eee;

 }
 .navbar{
   background-color: #eee;
 }
 .ggg{
   position: absolute;
   top:350px;
   right: 220px;  line-height:25px;

   text-align: center;
 }
 .ggg .col-xs-6{
    text-align: center;

 }

}
</style>

    <script src="<?=Url::base()?>/front/orbit/three.js"></script>
    <script src="<?=Url::base()?>/front/orbit/OrbitControls.js"></script>
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
        $(".top1").hover(function(){
            clearTimeout(window.timer)
            $(".top3").css("display","block");
            setTimeout(() => {
                $(".top3").css("opacity","1");
            }, 0)



            console.log('sss');
        },function(){

            $(".top3").css("opacity","0");

            window.timer = setTimeout(() => {
                $(".top3").css("display","none");
            },1000)




            console.log('sssssss');
        });



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
  <body >
  <div class="cont"></div>
    <div class="myheading ">
        <nav class="navbar navbar-default navbar-fixed-top nav-touming">
          <div class="container">
            <div class="navbar-header">
              <a class="navbar-brand" href="#">
              </a>
            </div>
            <label id="toggle-label" class="visible-xs-inline-block" for="toggle-checkbox">MENU</label>
            <input class="hidden" id="toggle-checkbox" type="checkbox">
            <div class="collspse navbar-collapse hidden-xs">
              <ul class="nav navbar-nav" >
                  <li class="" style="color: #000000 !important;"><a href="<?=Url::toRoute('/index/index')?>">首页</a></li>
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

              <a class="btn btn-default navbar-btn navbar-right" href="<?=Url::toRoute('/site/index')?>" role="button"><?php echo $m_Dic->getDictionaryListByType([2020402])['name'][0];?>登陆</a>


            </div>
          </div>
        </nav>
      </div>
  <br>
  <br>
  <br>
        <div class="contaier-fulid clearfix">
          <div class="row  hidden-xs">
              <div class="col-md-12">
                <div class="bg">
                      <div class="col-md-4 col-md-offset-4 " style="text-align: center">
                        <div class="content">
                          <h1 class="">Hi</h1>
                          <!-- <p>过程化考核平台</p> -->
                        </div>
                        <div class="bt">
                            <a class="btn btn-success btn-lg btn-block" style="font-size: 4vh; font-weight: lighter" href="<?=Url::toRoute('/front/site/index')?>" role="button">进入考试</a>
                        </div>
                      </div>
                </div>

              </div>

          </div>
          <div class="container visible-xs">
          <div class="row ">
            <div class="container">
              <div class="row">
                <div class="bg1">
                  <div class="col-xs-6 col-xs-offset-3">
                    <h1 >欢迎你</h1>

                  </div>
                  <div class="col-xs-8 col-xs-offset-2">
                      <div class="container">
                          <h3 ><?php echo $m_Dic->getDictionaryListByType(['2020301'])['name']['0']?>系统</h3>
                      </div>

                  </div>




                  </div>
                </div>
              </div>

            </div>

            </div>
          </div>

    <div class="container" >
          <div class="row" style="margin-top: 30vh">
            <div class="col-sm-12 ">
                <div class="col-md-9  col-xs-12 de-title ">
                        <h1>  <a href="http://47.106.121.212/" class="btn btn-info btn-lg"></a></h1>

                </div>

                <div class="col-sm-12 ">
                        <div class="member">
                          <?php foreach($deve as $model){?>
                            <!-- var_dump($model); -->

                              <div class="col-md-4 col-xs-12 col-md-offset-0">
                                    <div class="col-md-4 hidden-xs">

                                    </div>
                                    <div class="col-md-6 col-xs-12 member-info">
                                       <h3><?=$model['DeveloperName']?></h3>

                                       <p class="text-muted"><?=$model['Motto']?></p>
                                       <p class="text-muted"><?=$model['Grade']?></p>
                                       <p class="text-muted"><?=$model['QQ']?></p>
                                    </div>
                              </div>
                              <?php }?>



                        </div>
                </div>
            </div>
          </div>
        </div>


      </div>

    <div class="myfooter clearfix">
     <div class="container">
             <div class="row">
                <div class="col-xs-12">
                  <div class="footer-link">
                     <a href="<?=Url::toRoute('/front/site/index')?>" title="<?php echo $m_Dic->getDictionaryListByType(['2020401'])['name']['0']?>登陆"><?php echo $m_Dic->getDictionaryListByType(['2020401'])['name']['0']?>登陆</a>
                     <a href="<?=Url::toRoute('/site/index')?>" title="<?php echo $m_Dic->getDictionaryListByType(['2020402'])['name']['0']?>登陆"><?php echo $m_Dic->getDictionaryListByType(['2020402'])['name']['0']?>登陆</a>
                  </div>
                </div>
             </div>
     </div>
    </div>


      </div>


    </div>

  </body>
<script> var container = document.querySelector('.cont')
    console.log(container)
    width = container.clientWidth;
    height = container.clientHeight;

    var SEPARATION = 100,
        AMOUNTX = 50,
        AMOUNTY = 50;

    function init() {

        // heeere we go !

        var blue = new THREE.Color(0x7658ef);
        var pink = new THREE.Color(0xfca4c5);

        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(75, width / height , 0.1, 2500);


        var renderer = new THREE.WebGLRenderer({
            alpha: true,
            antialias: true
        });

        renderer.setSize(container.clientWidth, container.clientHeight);
        container.appendChild(renderer.domElement);

        function onResize() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        }
        window.addEventListener('resize', onResize, false);

        //THREEx.WindowResize(renderer, camera);
        var shape = [];
        geometry = new THREE.IcosahedronGeometry(100, 0);
        material = new THREE.MeshNormalMaterial({
            color: 0x0000ff
        });

        shape[0] = new THREE.Mesh(geometry, material);
        shape[1] = new THREE.Mesh(geometry, material);
        // shape[2] = new THREE.Mesh(geometry, material);
        shape[0].position.set(0, 500, 0);
        shape[1].position.set(0, 500, 0);
        // shape[2].position.set(0, 500, 0);
        scene.add(...shape);

        // var GridHelper = new THREE.GridHelper(1000, 50);
        // scene.add(GridHelper);


        //波纹图
        var particles, particle, count = 0;
        var i = 0;
        particles = new Array();
        var PI2 = Math.PI * 2;

        var spriteMaterial = new THREE.SpriteMaterial({
            color: 0xffffff
        });

        for (var ix = 0; ix < AMOUNTX; ix++) {

            for (var iy = 0; iy < AMOUNTY; iy++) {

                particle = particles[i++] = new THREE.Sprite(spriteMaterial);
                particle.position.x = ix * SEPARATION - ((AMOUNTX * SEPARATION) / 2);
                particle.position.z = iy * SEPARATION - ((AMOUNTY * SEPARATION) / 2);
                scene.add(particle);

            }

        }

        var light = new THREE.PointLight(0xfca4c5);
        light.position.set(0, 100, 0);
        scene.add(light);

        camera.position.set(500, 700, 1000); // x y z

        // let helper = new THREE.GridHelper(50000, 500);
        // scene.add(helper)

        controls = new THREE.OrbitControls(camera);
        controls.enableZoom = false;
        //controls.update() must be called after any manual changes to the camera's transform
        controls.update();

        function render() {
            requestAnimationFrame(render);
            controls.update();

            var i = 0;

            for (var ix = 0; ix < AMOUNTX; ix++) {

                for (var iy = 0; iy < AMOUNTY; iy++) {

                    particle = particles[i++];
                    particle.position.y = (Math.sin((ix + count) * 0.3) * 50) + (Math.sin((iy + count) * 0.5) * 50);
                    particle.scale.x = particle.scale.y = (Math.sin((ix + count) * 0.3) + 1) * 2 + (Math.sin((iy + count) *
                        0.5) + 1) * 2;

                }

            }

            renderer.render(scene, camera);

            count += 0.1;

            shape[0].rotation.x += 0.035;
            shape[0].rotation.y -= 0.005;
            shape[1].rotation.y += 0.015;
            shape[1].rotation.z -= 0.005;
            // shape[2].rotation.z -= 0.025;
            // shape[2].rotation.x += 0.005;
            renderer.render(scene, camera);
        }
        render();

    }

    init();</script>
  </html>
