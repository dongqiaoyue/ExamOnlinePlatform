
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<style type="text/css">
    input[type=radio]{
        margin-left:20px;
    }

</style>
<?php $this->endBlock(); ?>

<section class="content">
    <h1 class="text-center">过程化考核平台</h1>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <?php foreach ($info as $key=>$data){?>
                                <li><a href="#"><?=$com->codeTranName($key)?></a></li>
                            <?php }?>
                        </ul>

                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
    <h1></h1>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="row">
                <div class="col-xs-5">
                    <?php foreach($type as $model){?>
                   <h2> <?=$model?></h2>
                    <?php }?>
                </div>
            </div>


            <?php foreach ($info as $k=>$value) {?>
                <div class="">
                    <div class="row">
                        <div class="col-xs-1">
                            <button type="button" class="btn btn-lg btn-primary" onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                        </div>
                    </div>
                    <h1></h1>
                    <div style="display: none" id="<?=$k;?>">
                        <?php foreach ($value as $key=>$item) {?>
                            <div class="row" id="<?=$k;?>" >
                                <button type="button" class="btn btn-default col-xs-10 col-xs-offset-1" onclick="toggle(<?=$i?>)">(<?=$item['Score'];?> 分) <?=$i.'.'.$item['CustomBh'];?>   <?=$item['name']?></button>
                                <div class="col-xs-10 col-xs-offset-1" style="display: none" id="<?=$i;?>">
                                    <?=$item['Description'];?>
                                    <?=switchType($k, $item['QuestionBh']);?>
                                </div>
                            </div>
                            <h6></h6>
                            <?php $i++; }?>
                    </div>
                </div>
            <?php }?>


        </div>
    </div>
</section>

<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>

    function toggle(id) {
        var display =$('#'+id).css('display');
        if (display == 'none') {
            $('#'+id).slideDown(500);
        } else {
            $('#'+id).slideUp(500);
        }
    }

    function compile(id) {
        var code = $('textarea[name="'+ id +'"]').val();
        if (code == ""){
            alert("请输入代码");
        }else {
            $('#compile'+ id +'').text('正在编译');
            $('#compile'+ id +'').attr("disabled","disabled");
            $.ajax({
                type: 'POST',
                url: '<?=Url::toRoute("/common/compile")?>',
                dataType: "JSON",
                data: {"id": id, "code": code},
                success: function (value) {
                    $('#compile'+ id +'').text('编译');
                    $('#compile'+ id +'').removeAttr('disabled');
                    $('#score' + id + '').text(value);
                }
            })
        }
    }
</script>
<?php $this->endBlock(); ?>

<?php
function switchType($type, $questionBh){
    switch ($type){
        case '100020101':
            echo '<input type="radio" value="A" name="'.$questionBh.'"/>A
            <input type="radio" value="B" name="'.$questionBh.'"/>B
            <input type="radio" value="C" name="'.$questionBh.'"/>C
            <input type="radio" value="D" name="'.$questionBh.'"/>D';
            break;
        case '100020102':
            echo '<input type="checkbox" value="A" name="'.$questionBh.'"/>A
            <input type="checkbox" value="B" name="'.$questionBh.'"/>B
            <input type="checkbox" value="C" name="'.$questionBh.'/>C
            <input type="checkbox" value="D" name="'.$questionBh.'"/>D';
            break;
        case '1000203':
            echo '<input type="radio" value="A" name="'.$questionBh.'"/>对
            <input type="radio" value="B" name="'.$questionBh.'"/>错';
            break;
        case '1000204':

            break;
        case '1000205':

            break;
        case '1000206':
            echo '<h1></h1><textarea class="col-xs-8" rows="20" name="'.$questionBh.'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$questionBh.'" class="btn btn-default" onclick="compile('."'$questionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$questionBh.'"></strong>';
            break;
        case '1000207':

            break;
        case '1000208':

            break;
    }
}
?>

