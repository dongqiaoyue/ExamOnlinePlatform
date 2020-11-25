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
	background-color: #F9F9F9;
}
*{
	font-family: "微软雅黑";
}
.head{
	margin:0px;
	width:100%;
	height: 50px;
	line-height: 50px;
	font-size: 24px;
	font-weight: bold;
	color:white;
	background-color:#56D4BD;
	box-shadow:4px 1px 1px rgba(0,0,0,0.35),0px 0px 40px rgba(0,0,0,0.1) inset;
	text-align: center;
}
.contain{
	display:block;
	width:83%;
	height:auto;
	margin:5px auto;
	padding-top: 20px;
	padding-left: 2%;
	overflow:hidden;
	border:1px solid #EEE;
}
.box1{
	border:1px solid #F4F4F4;
	background-color: white;
	padding:5px 1%;
	float:left;
	width:98%;
	margin-right:1%;
	margin-bottom: 10px;
	height:200px;
}
.box1 h3{
	color:orange;
}
.partner{
	width:80%;
	margin:0 auto;
	height:auto;
	overflow:hidden;
}
.partner h1{
	font-style: italic;
	text-align: center;
	text-shadow:5px 5px 5px #ccc;
}
.person{
	width:90%;
	margin:0 auto;
	margin-bottom: 15px;
	height:340px;
	border:1px solid #58a2ec;
	background-color: white;
	box-shadow: 0px 3px 4px #d4dce4 inset;
}
.tabName{
	text-align: right;
	width:80px;
}
.person img{
	width:25%;
	max-height:248px;
	float:right;
	margin: 1%;
	margin-top: -5px;
}
.person .ifo{
	width:55%;
	float:left;
	padding:1%;
}
.topName{
	width:100%;
	display: block;
	/*border:1px solid #ffe8c0;*/
	/*border-bottom: 1px solid #e1e1e1;
	background-color: #ffe8c0;*/
}
.topName h2{
	color:#466A99;
	margin:12px auto;
	text-align: center;
}
footer{
	width:100%;
	height:50px;
	background-color:#66C5B4;
	box-shadow:4px 1px 1px rgba(0,0,0,0.5),0px 0px 40px rgba(0,0,0,0.1) inset;
}
#copyRight{
	float: left;
	height:50px;
	line-height:50px;
	color:white;
	width:500px;
	margin-left:5%;
}
.friend-a{
	width:500px;
	float:right;
	margin-right: 5%;
	padding-top: 16px;
}
.friend-a ul{
	float:right;
}
.friend-a ul li{
	float:left;
	list-style: none;
	margin-right: 15px;
	font-size: 14px;
}
.friend-a ul li a{
	color:white;
	letter-spacing: 1px;
	text-decoration: none;
}
.friend-a ul li a:hover{
	color:#D45544;
}
table,tr,td{
	color:#6c6c6c;
	font-weight: bold;
	font-size: 14px;
}
table tr{
	height:30px;
}

</style>
</head>
<header class="head">
CUIT&nbsp;&nbsp;LOOP工作室
</header>
<section class="partner">
	<h1>Our Partners</h1>
	<?php
	foreach ($deve as $model){
		?>
	<article class="person">
	<div class="topName"><h2><span id="name"><?=$model['DeveloperName']?></span>的简介</h2></div>
	<hr/>
		<div class="ifo">
			<table>
				<tr><td class="tabName">姓名：</td><td><?=$model['DeveloperName']?></td></tr>
				<tr><td class="tabName">性别：</td><td><?=$model['Sex']?></td></tr>
				<tr><td class="tabName">年级：</td><td><?=$model['Grade']?></td></tr>
				<tr><td class="tabName">QQ：</td><td><?=$model['QQ']?></td></tr>
				<tr><td class="tabName">座右铭：</td><td><?=$model['Motto']?></td></tr>
				<tr><td class="tabName">擅长方面：</td><td><?=$model['BetterAspect']?></td></tr>
				<tr><td class="tabName">所做项目：</td><td><?=$model['DoneProject']?></td></tr>
			</table>
		</div>
		<img src="upload/tmp_file/<?=$model['Src']?>">
		<!-- <div class="pic">
		<img src="img/img02.jpg">
		</div> -->
	</article>
	<?php }?>
	<!-- <article class="person">		
	</article>
	<article class="person">		
	</article>
	<article class="person">
	</article> -->
</section>

<footer>
    <div id="copyRight">
    </div>
    <div class="friend-a">
	    <ul>
			<li style="border-right: 1px solid white; padding-right: 15px;"><a href="<?=Url::toRoute('/front/site/index')?>">学员登录中心</a></li>
			<li><a href="<?=Url::toRoute('/site/index')?>">教学管理中心</a></li>
		</ul>
	</div>
</footer>
