<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>

<head>
    <title>非涉密课程学习考评系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <!-- CSS Libs -->
    <link rel="stylesheet" href="<?=Url::base()?>/front/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/animate.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/bootstrap-switch.min.css"> -->
     <!-- <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/checkbox3.min.css"> -->

     <!-- <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/jquery.dataTables.min.css"> -->
     <!-- <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/dataTables.bootstrap.css"> -->
     <!-- <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/lib/css/select2.min.css"> -->



    <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/css/themes/flat-blue.css">
    <link rel="stylesheet" type="text/css" href="<?=Url::base()?>/front1/css/themes/flat-green.css">

    <!-- Javascript Libs -->
    <!-- <script src="https://cdn.bootcss.com/jquery/3.0.0/jquery.js"></script> -->
    <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/bootstrap.min.js"></script>

    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/Chart.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/bootstrap-switch.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/jquery.matchHeight-min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/jquery.dataTables.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/dataTables.bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/select2.full.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/ace/ace.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/ace/mode-html.js"></script> -->
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/lib/js/ace/theme-github.js"></script> -->
    <script type="text/javascript" src="<?=Url::base()?>/front1/js/app.js"></script>
    <!-- <script type="text/javascript" src="<?=Url::base()?>/front1/js/index.js"></script> -->
    <!-- Javascript -->
</head>

<body class="flat-blue">
    <div class="app-container">
        <div class="row content-container">
            <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-expand-toggle">
                            <i class="fa fa-bars icon"></i>
                        </button>
                        <ol class="breadcrumb navbar-breadcrumb">
                            <li class="active">非涉密课程学习考评系统</li>
                        </ol>
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>

                        <li class="dropdown danger">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-star-half-o"></i> 0</a>
                            <ul class="dropdown-menu danger  animated fadeInDown">
                                <li class="title">
                                    消息 <span class="badge pull-right">0</span>
                                </li>
                                <li>
                                    <ul class="list-group notifications">
                                        <a href="<?=Url::toRoute('exam/index')?>">
                                            <li class="list-group-item">
                                                <span class="badge">0</span> <i class="fa fa-exclamation-circle icon"></i> 考试
                                            </li>
                                        </a>
                                        <a href="<?=Url::toRoute('grade/index')?>">
                                            <li class="list-group-item">
                                                <span class="badge success">0</span> <i class="fa fa-check icon"></i> 成绩
                                            </li>
                                        </a>
                                        <a href="<?=Url::toRoute('up/index')?>">
                                            <li class="list-group-item">
                                                <span class="badge danger">0</span> <i class="fa fa-comments icon"></i> 作业
                                            </li>
                                        </a>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=\app\models\systembase\Studentinfo::find()->where(['StuNumber' => Yii::$app->session->get('StudentNum')])->asArray()->one()['Name'];?> <span class="caret"></span></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                <li class="profile-img">
                                    <img src="<?=Url::base()?>/front1/img/profile/picjumbo.com_HNCK4153_resize.jpg" class="profile-img">
                                </li>
                                <li>
                                    <div class="profile-info">
                                        <h4 class="username"><?=\app\models\systembase\Studentinfo::find()->where(['StuNumber' => Yii::$app->session->get('StudentNum')])->asArray()->one()['Name'];?></h4>
                                        <p><?=\app\models\systembase\Studentinfo::find()->where(['StuNumber' => Yii::$app->session->get('StudentNum')])->asArray()->one()['StuNumber'];?></p>
                                        <div class="btn-group margin-bottom-2x" role="group">
                                            <a href="<?=Url::toRoute('site/person-info')?>" class="btn btn-default"><i class="fa fa-user"></i>个人信息</a>
                                            <a href="<?=Url::toRoute('site/change-password')?>" class="btn btn-default"><i class="fa fa-flash">修改密码</i></a>
                                            <a href="<?=Url::toRoute('site/logout')?>" class="btn btn-default"><i class="fa fa-sign-out"></i>退出</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="side-menu sidebar-inverse">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="side-menu-container">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#">
                                <div class="icon fa fa-paper-plane"></div>
                                <div class="title">非涉密课程学习考评系统</div>
                            </a>
                            <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                                <i class="fa fa-times icon"></i>
                            </button>
                        </div>
                        <ul class="nav navbar-nav">
                            <li class="" >
                                <a href="<?=Url::toRoute('site/index')?>">
                                    <span class="icon fa fa-tachometer"></span><span class="title">首页</span>
                                </a>
                            </li>
                            <li class="panel panel-default dropdown " >
                                <a  href="<?=Url::toRoute('exam/index')?>"  >
                                    <span class="icon fa fa-desktop"></span><span class="title">进入考试</span>
                                </a>
                            </li>
                            <li class="panel panel-default dropdown" >
                                <a href="<?=Url::toRoute('test/index')?>">
                                    <span class="icon fa fa-table"></span><span class="title">进入练习</span>
                                </a>
                                <!-- Dropdown level 1 -->

                            </li>
                            <li class="panel panel-default dropdown hidden">
                                <a data-toggle="collapse" href="#dropdown-table">
                                    <span class="icon fa fa-table"></span><span class="title">zhe</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-table" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="<?=Url::toRoute('site/theming')?>">Table</a>
                                            </li>
                                            <li><a href="../table/datatable.html">Datatable</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="panel panel-default dropdown " >
                                <a href="<?=Url::toRoute('grade/index')?>">
                                    <span class="icon fa fa-file-text-o"></span><span class="title">成绩查询</span>
                                </a>
                                <!-- Dropdown level 1 -->

                            </li>

                            <!-- Dropdown-->
                            <li class="panel panel-default dropdown" >
                              <a href="<?=Url::toRoute('up/index')?>">
                                    <span class="icon fa fa-cubes"></span><span class="title">作业管理</span>
                                </a>
                                <!-- Dropdown level 1 -->

                            </li>
                            <!-- Dropdown-->
                            <li class="panel panel-default dropdown" >
                                <a data-toggle="collapse" href="#dropdown-example">
                                    <span class="icon fa fa-slack"></span><span class="title">工程实践</span>
                                </a>
                                <!-- Dropdown level 1 -->

                            </li>
                            <!-- Dropdown-->
                            <li class="panel panel-default dropdown" >
                                <a href="<?=Url::toRoute('test/code')?>">
                                    <span class="icon fa fa-archive"></span><span class="title">在线编译</span>
                                </a>
                                <!-- Dropdown level 1 -->

                            </li>
                            <li class="panel panel-default dropdown" >
                                <a href="#">
                                    <span class="icon fa fa-thumbs-o-up"></span><span class="title">关于</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </div>

            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">

                                <?= $content ?>


                </div>
            </div>
        </div>
        <footer class="app-footer">
            <div class="wrapper">
                <span class="pull-right">2.1 <a href="#"><i class="fa fa-long-arrow-up"></i></a></span> © 2018 Copyright. cuit@Loop
        </footer>



</body>


</html>
