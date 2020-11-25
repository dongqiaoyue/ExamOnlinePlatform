<?php
/**
 * Created by PhpStorm.
 * User: ProPHPer
 * Date: 2017/1/11
 * Time: 上午11:44
 */
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">模块比例设置</h3>
                    
                </div>
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        
                            <!-- 下拉选择学期 -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="choice1" value="<?=$choice1?>">
                                    
                                    <?=$choice1?>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                <?php if(isset($term)):?>
                                    <?php foreach ($term as $model) {?>
                                        <li>
                                        <a href="<?=Url::toRoute(['module-proportion/index','term'=>$model['CuitMoon_DictionaryName']]);?>"><?=$model['CuitMoon_DictionaryName'];?></a>
                                        </li>
                                    <?php }?>
                                <?php endif;?>
                                </ul>
                            </div>
                            <!-- 下拉选择计划班 -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle " data-toggle="dropdown" id="choice2" value="<?=$choice2?>">
                                    <?=$choice2?>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                <?php if(isset($classInfo) && $classInfo!=NULL):?>
                                    <?php foreach ($classInfo as $model1) {?>
                                        <li>
                                        <a href="<?=Url::toRoute(['module-proportion/index','term'=>$choice1,'classInfo'=>$model1['TeachingClassID']]);?>"><?=$model1['TeachingName'];?></a>
                                        </li>
                                    <?php }?>
                                <?php endif;?>
                                </ul>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-9">
                                <table id="grade_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                <h3 class="text-center">等级--分值</h3>
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >等级：</th>
                                        <?php foreach($AllGradeS as $GradeS){?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="grade" ><?=$GradeS['GradeName']?></th>
                                        <?php }?>
                                        
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数：</th>
                                        <?php foreach($AllGradeS as $GradeS){?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="grade" ><?=$GradeS['Score']?></th>
                                        <?php }?>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                    
                                    <button id="update_grade_btn" type="button" class="btn btn-sm btn-primary ">编辑</button>
                                    
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-9">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                <h3 class="text-center">模块</h3>
                                    <thead>
                                    <tr role="row">

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >模块名字</th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >模块比例(%)</th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >教学班级</th>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >考勤</th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >
                                        <?php if(isset($AllModule['AttendancePercent'])):?>
                                        <?=$AllModule['AttendancePercent']?>
                                        <?php endif;?>
                                        </th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><?=$choice2.'（'.$choice1.'）'?></th>
                                    </tr>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >作业</th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >
                                        <?php if(isset($AllModule['HomeworkPercent'])):?>
                                        <?=$AllModule['HomeworkPercent']?>
                                        <?php endif;?>
                                        </th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><?=$choice2.'（'.$choice1.'）'?></th>
                                    </tr>
                                     <tr role="row">
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提问</th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >
                                        <?php if(isset($AllModule['QuestionPercent'])):?>
                                        <?=$AllModule['QuestionPercent']?>
                                        <?php endif;?>
                                        </th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><?=$choice2.'（'.$choice1.'）'?></th>
                                    </tr>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >其他</th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >
                                        <?php if(isset($AllModule['OtherPercent'])):?>
                                        <?=$AllModule['OtherPercent']?>
                                        <?php endif;?>
                                        </th>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><?=$choice2.'（'.$choice1.'）'?></th>
                                    </tr>
                                    <?php if (count($otherModules)!=0):?>
                                        <?php foreach($otherModules as $otherModule){?>
                                            <tr role="row">
                                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><?=$otherModule['ModuleName']?></th>
                                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><?=$otherModule['ModulePercent']?>
                                            </th>
                                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >
                                                <?=$choice2.'（'.$choice1.'）'?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-sm btn-danger delete_btn" id="<?=$otherModule['ModuleID'];?>" value="<?=$otherModule['ModulePercent'];?>">删除</button>
                                            </th>
                                        </tr>
                                        <?php }?>
                                    <?php endif;?>
                                    </tbody>

                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                            <button id="update_btn" type="button" class="btn btn-sm btn-primary ">修改比例</button>
                            <button id="add_btn" type="button" class="btn btn-sm btn-primary ">添加模块</button>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
</section>
<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>模块比例分配</h3>
                </div>
                
                <div class="modal-body">
                    <?php $form=ActiveForm::begin([
                        'id'=>'update_module',
                        'action'=>Url::toRoute(['module-proportion/updatemodule','term'=>$choice1,'classInfo'=>$AllModule['TeachingClassID']]),
                        'method'=>'post',

                    ])?>
                    <div class="row">
                    <input type="hidden" class="form-control" name="Staticmodulepercent[StaticID]" value="<?=$AllModule['StaticID']?>"/>
                    <input type="hidden" class="form-control" name="Staticmodulepercent[TeachingClassID]" value="<?=$AllModule['TeachingClassID']?>"/>

                    <div id="name_div" class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12 control-label text-center" >考勤</label>
                            <input type="text" class="form-control jq text-center" id="P1" name="Staticmodulepercent[AttendancePercent]" value="<?php echo isset($AllModule['AttendancePercent']) ? $AllModule['AttendancePercent'] : 0;?>" />
                        
                        </div>
                    </div>
                    <div id="name_div" class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12 control-label text-center">作业</label>
                            <input type="text" class="form-control jq text-center" id="P2" name="Staticmodulepercent[HomeworkPercent]" value="<?php echo isset($AllModule['HomeworkPercent']) ? $AllModule['HomeworkPercent'] : 0;?>"/>
                        
                        </div>
                    </div>

                    <div id="name_div" class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12 control-label text-center">提问</label>
                            <input type="text" class="form-control jq text-center" id="P3" name="Staticmodulepercent[QuestionPercent]" value="<?php echo isset($AllModule['QuestionPercent']) ? $AllModule['QuestionPercent'] : 0;?>"/>
                        
                        </div>
                    </div>
                    <div id="name_div" class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12 control-label text-center">其他</label>
                            <input type="text" class="form-control jq text-center" id="P4"  name="Staticmodulepercent[OtherPercent]" value="<?php echo isset($AllModule['OtherPercent']) ? $AllModule['OtherPercent'] : 0;?>"/>
                        
                        </div>
                    </div>

                    
                    <?php if (count($otherModules)!=0):?>
                        <?php $i=5;?>
                        <?php foreach($otherModules as $otherModule){?>
                        <div id="name_div" class="form-group">
                        <div class="col-sm-12">

                            <input type="hidden" class="form-control" name="<?=$i?>[ModuleID]" value="<?=$otherModule['ModuleID']?>"/>
                            <label for="name" class="col-sm-12 control-label text-center"><?=$otherModule['ModuleName']?></label>
                            <input type="text" class="form-control jq text-center"  name="<?=$i?>[ModulePercent]" value="<?php echo isset($otherModule['ModulePercent']) ? $otherModule['ModulePercent'] : 0;?>" id="P<?=$i++;?>"/>
                        </div>
                        </div>
                        <?php }?>
                    <?php endif;?>
                    
                    <?php ActiveForm::end(); ?>
                </div>

                <div class="modal-footer">
                    <p class="text-center"><?= Html::Button('保存', ['class' => 'btn btn-primary','id'=>'save','type'=>'button']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete_form" action="<?=Url::toRoute('module-proportion/deletemodule');?>" method="get">
    <input type="hidden" id="delete_module_id" name="ModuleID" value=""/>
    <input type="hidden" id="delete_module_val" name="ModulePercent" value=""/>
</form>
<!-- //添加模块 -->
<div class="modal fade" id="add_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>模块添加</h3>
                </div>
                
                <div class="modal-body">
                    <?php $form=ActiveForm::begin([
                        'id'=>'add_module',
                        'action'=>Url::toRoute(['module-proportion/addmodule','term'=>$choice1,'classInfo'=>$AllModule['TeachingClassID']]),
                        'method'=>'post',


                    ])?>
                    <div class="row">
                    <?php if(isset($Module['ModuleID'])):?>
                        <input type="hidden" class="form-control" name="Module[ModuleID]" value="<?=$Module['ModuleID']?>"/>
                    <?php endif;?>
                    <?php if(isset($AllModule['TeachingClassID'])):?>
                        <input type="hidden" class="form-control" name="Module[TeachingClassID]" value="<?=$AllModule['TeachingClassID']?>"/>
                    <?php endif;?>
                    <div id="name_div" class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12 control-label text-center">模块名字</label>
                             <input type="text" class="form-control text-center" id="new_name" name="Module[ModuleName]" />
                        </div>
                    </div>
                    
                    <?php ActiveForm::end() ?>
                    
                </div>
                <div class="modal-footer">
                    <p class="text-center"><?= Html::Button('添加', ['class' => 'btn btn-primary','id'=>'add','type'=>'button']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 更新固定的配置ABCD -->
<div class="modal fade" id="update_grade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>配置等级--分数</h3>
                </div>
                
                <div class="modal-body">
                    <?php $form=ActiveForm::begin([
                        'id'=>'update_grade_form',
                        'action'=>Url::toRoute(['module-proportion/updategrade']),
                        'method'=>'post',
                    ])?>
                    <div class="row">
                    <?php $i=0;?>
                    <?php foreach($AllGradeS as $Grades){?>
                    <input type="hidden" class="form-control" name="<?=$i?>Gradescoreset[GradeName]" value="<?=$Grades['GradeName'];?>"/>
                    <input type="hidden" class="form-control" name="<?=$i?>Gradescoreset[SetID]" value="<?=$Grades['SetID'];?>"/>
                    <input type="hidden" class="form-control" name="<?=$i?>Gradescoreset[TeachingClassID]" value="<?=$Grades['TeachingClassID'];?>"/>
                    <div id="name_div" class="form-group">
                        <div class="col-sm-12">
                            <label for="name" class="col-sm-12 control-label text-center"><?=$Grades['GradeName']?></label>
                             <input type="text" class="form-control text-center" id="new_name" name="<?=$i?>Gradescoreset[Score]" value="<?=$Grades['Score'] ? $Grades['Score'] : 0;?>"/>
                        </div>
                    </div>
                    <?php $i++;?>
                    <?php }?>
                    <?php ActiveForm::end() ?>
                    
                </div>
                <div class="modal-footer">
                    <p class="text-center"><?= Html::Button('保存', ['class' => 'btn btn-primary','id'=>'update_grade_sb','type'=>'button']) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="option_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="meg_info"></h4>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    //修改比例
    $("#update_btn").click(function(){

        if($("#choice1").val()=="请选择学期" || $("#choice2").val()=="请选择计划班")
            {
                $("#meg_info").html("请先选择学期和计划班级");
                $("#option_info").modal("show");
            }
        else
            $('#edit_dialog').modal('show');
    });
    //添加模块
    $("#add_btn").click(function(){
        if($("#choice1").val()=="请选择学期" || $("#choice2").val()=="请选择计划班")
            {
                $("#meg_info").html("请先选择学期和计划班级");
                $("#option_info").modal("show");

            }
        else
            $('#add_form').modal('show');
        
    });
    //修改ABCD
    $("#update_grade_btn").click(function(){
        if($("#choice1").val()=="请选择学期" || $("#choice2").val()=="请选择计划班")
            {
                $("#meg_info").html("请先选择学期和计划班级");
                $("#option_info").modal("show");

            }
        else
            $('#update_grade').modal('show');
    });
    //保存修改ABCD-->提交数据
    $("#update_grade_sb").click(function(){
        $("#update_grade_form").ajaxSubmit(
            function(response){
                //document.write(response);
            window.location.reload();
        });
    });
    //保存修改-->提交数据
    $("#save").click(function(){
        var sum=0;
        $(".jq").each(function(){
            sum+=$(this).val()*1;
        });
        if(sum!=100)
        {
            $("#meg_info").html("模块百分比之和必须等于100");
            $("#option_info").modal("show");
        }
        else
        {
            $("#update_module").ajaxSubmit(
                function(response){
                    window.location.reload();
                    //document.write(response);
                });
        }
    });
    //添加-->提交数据
    $("#add").click(function(){
        if(!$("#new_name").val())
        {
            $("#meg_info").html("模块名字不能为空");
            $("#option_info").modal("show");
        }
        else
        {
            $("#add_module").ajaxSubmit(
                function(response){
                window.location.reload();
            });
        }
    });
    //删除-->提交数据
    $(".delete_btn").click(function(){
        var id=$(this).attr("id");
        var value=$(this).val();
        
        if(value!=0)
        {
            $("#meg_info").html("当前模块已配置比例，不可删除。若要删除，请将此比例修改为0");
            $("#option_info").modal("show");
            //window.location.reload();
        }
        else
        {
            $("#delete_module_id").val(id);
            $("#delete_module_val").val(value);
            $("#delete_form").ajaxSubmit(
            function(response){
                //alert(response);
                $("#meg_info").html("该模块已删除");
                $("#option_info").modal("show");
                //document.write(response);
                window.location.reload();
            });
        }
            
    });

    
</script>



