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



<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">选择题管理->选择题添加</h3>
                </div>
                <h1></h1>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("choice/index")]); ?>

                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">自定义题号</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="moduleName" name="Questions[CustomBh]">
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">所属阶段</label>
                            <div class="col-xs-1">
                                <select name="Questions[Stage]" id="stage">
                                    <?php foreach ($stage as $model){?>
                                        <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <label for="inputEmail3" class="col-xs-1 control-label">知识点</label>
                            <div class="col-xs-1">
                                <select name="Questions[KnowledgeBh]" id="knowledgePoint" >
                                    <?php foreach ($defaultKnow as $model){?>
                                        <option value="<?=$model['KnowledgeBh']?>"><?=$model['KnowledgeName']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">是否公开</label>
                            <div class="col-xs-1">
                                <label class="radio-inline">
                                    <input type="radio" id="inlineRadio1" value="1" name="Questions[Score]"> 是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio"  id="inlineRadio2" value="0" name="Questions[Score]" checked="checked"> 否
                                </label>
                            </div>

                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">题目难度</label>
                            <div class="col-xs-1">
                                <select name="Questions[Difficulty]">
                                    <?php foreach ($diff as $model){?>
                                        <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">题目名称</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="moduleName" name="Questions[name]">
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">题目描述</label>
                            <div class="col-xs-6">
                                <script type="text/plain" id="container" name="Questions[Description]"></script>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">题目答案</label>
                            <div class="col-xs-6">
                                      <label class="radio-inline">
                                           <input type="radio" id="inlineCheckbox1" value="A" name="Questions[Answer]"> A
                                     </label>
                                     <label class="radio-inline">
                                          <input type="radio" id="inlineCheckbox2" value="B" name="Questions[Answer]"> B
                                     </label>
                                     <label class="radio-inline">
                                          <input type="radio" id="inlineCheckbox3" value="C" name="Questions[Answer]"> C
                                    </label>
                                    <label class="radio-inline">
                                            <input type="radio" id="inlineCheckbox4" value="D" name="Questions[Answer]"> D
                                     </label>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1" >备注</label>
                            <div class="col-xs-4">
                                <textarea class="form-control" name="Questions[Memo]"></textarea>
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
    var ue = UE.getEditor('container');




    //Asynchronous request stage knowledge points
    $('#stage').change(function () {
        var stageId = $(this).val();
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('knowledge/knowledge-list')?>',
            data:{stageId:stageId},
            catch:false,
            dataType:'json',
            success:function (value) {
                $('#knowledgePoint').empty();
                for(var Tmp in value){
                    $('#knowledgePoint').append("<option value='"+ value[Tmp]['KnowledgeBh'] +"'>"+ value[Tmp]['KnowledgeName'] +"</option>")
                }
            }
        })
    })

    $('#questionSubmit').click(function (e) {
        e.preventDefault();
        e.preventDefault();
        $('#admin-role-form').submit();
    });

    //ajax Request compilation
    $('#admin-role-form').bind('submit',function (e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type:'POST',
            dataType:'json',
            url:'<?=Url::toRoute("choice/create")?>',
            success:function (value) {
                if(value.error == 0){
                    alert('添加成功');
                    window.location.href = '<?=Url::toRoute("choice/index")?>'
                }else{
                    alert('添加失败');
                }
            }
        })
    })

</script>
<?php $this->endBlock(); ?>
