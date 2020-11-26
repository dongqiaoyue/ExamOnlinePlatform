<?php
/**
 * Created by PhpStorm.
 * User: wangxixi
 * Date: 2017/2/21
 * Time: 15:07
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>


<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>
<style>
    body{margin:8px;font-family:sans-serif;font-size:16px;}
    p{margin:5px 0;}
    #aaa{padding:0;word-wrap:break-word;cursor:text;height:90%;}
    div {border-radius:5px;}
</style>


<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a style="cursor:pointer;" href="<?=Url::toRoute("question/index")?>">学生问答-></a>查看情况</h3>
                </div>
                <h1></h1>
                <br>
                <div class="row">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">
                           <font size="2px">
                               <?= $list['AddBy']?><br>
                               <?= $class?>
                           </font>
                        </label>
                        <div class="col-xs-6" style="border:1px solid #000">
                            <?= $list['content']?>
                        </div>
                    </div>
                </div>
                <hr id="cut">
                <!--回复内容-->

                <?php
                if($reply)
                {
                    foreach ($reply as $key => $value)
                    {
                        echo '<div class="row">';
                        echo    '<div class="form-group">';
                        echo        '<label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1"><font size="2px">'.$value['AddBy'];
                        echo        '</font></label>';
                        echo        '<div id="aaa" class="col-xs-6" style="border: 1px solid #4c4c4c;padding: 2px">';
                        echo            $value['content'];
                        echo        '</div>';
                        echo    '</div>';
                        echo '</div><br>';
                    }
                }
                ?>

                <hr>
                <?php



                ?>


                <div class="box-body">
                    <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("question/index")]); ?>
                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">回复</label>
                            <div class="col-xs-6">
                                <script type="text/plain" id="reply" name="Tresourcesreplyqa[content]" ></script>
                            </div>
                        </div>
                    </div>
                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-10 col-md-offset-11">
                                <button id="questionSubmit" type="button" class="btn btn-primary">提交</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->beginBlock('footer');  ?>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    //var global_i = 0;
    var ue = UE.getEditor('reply', {
        autoFloatEnabled: false//是否保持toolbar的位置不动，默认true
    });

    $('#questionSubmit').click(function (e) {
        e.preventDefault();
        e.preventDefault();
        $('#admin-role-form').submit();
    });

    //ajax Request compilation
    $('#admin-role-form').bind('submit',function (e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            data:{'id':'<?= $list['ID']?>'},
            type:'POST',
            dataType:'json',
            url:'<?=Url::toRoute("question/create")?>',
            success:function (value) {
                if(value.error == 0){
                    alert('添加成功');
                    $.ajax({
                        type: 'POST',
                        url: '<?=Url::toRoute('question/change')?>',
                        data: {"id": '<?= $list['ID']?>'}
                    });
                    window.location.reload();
                }else{
                    alert('添加失败');
                }
            }
        })
    })

</script>
<?php $this->endBlock(); ?>
