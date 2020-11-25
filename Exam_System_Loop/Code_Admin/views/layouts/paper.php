<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?=Url::base()?>/bootstrap/css/bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.2.3 -->
    <script src="<?=Url::base()?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <?php if(isset($this->blocks['header']) == true):?>
        <?= $this->blocks['header'] ?>
    <?php endif;?>
</head>

    <?= $content ?>

<script src="<?=Url::base()?>/plugins/form/jquery.form.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="<?=Url::base()?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<!-- Sparkline -->

<!-- jQuery Knob Chart -->

<?php if(isset($this->blocks['footer']) == true):?>
    <?= $this->blocks['footer'] ?>
<?php endif;?>
<html>
