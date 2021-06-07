
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\phone\Tresourceslearn;

?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<!--用了很蠢的方法查询,反应过来的时候已经做得差不多了，反正也跑得动，就不改了-->
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">学生练习情况</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="output_excel" type="button" class="btn btn-xs btn-primary">导出Excel</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="row">
                            <div class="col-sm-12">
<!--                                <label>专业:&nbsp;</label>-->
<!--                                <select class="form-control" id="major-choice">-->
<!--                                    <option>请选择</option>-->
<!--                                    --><?php //foreach ($class_list as $model) {?>
<!--                                        <option value="--><?//=$model['MajorName']?><!--">--><?//=$model['MajorName']?><!--</option>-->
<!--                                    --><?php //}?>
<!--                                </select>-->
<!--                                <label>班级:&nbsp;</label>-->
<!--                                <select class="form-control" id="class-choice">-->
<!---->
<!--                                </select>-->
                                <label>学期</label>
                                <select class="form-control" id="term-choice">
<!--                                    <option value="0">全部学期</option>-->
                                    <?php if(isset($_GET['term'])){?>
                                        <?php foreach ($term as $model){?>
                                            <?php if($model->CuitMoon_DictionaryName === $_GET['term']){?>
                                                <option value="<?=$model->CuitMoon_DictionaryName?>" selected="selected"><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->CuitMoon_DictionaryName?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($term as $model){?>
                                            <option value="<?=$model->CuitMoon_DictionaryName?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                        <?php }}?>
                                </select>
                                <label>我的教学班:&nbsp;</label>
                                <select class="form-control" id="myClass-choice">
                                    <option value="0">全部班级</option>
                                    <?php foreach ($myClass as $model) {?>
                                        <?php if ($model['TeachingClassID'] == $w){?>
                                        <option selected="selected" value="<?=$model['TeachingClassID']?>"><?=$model['TeachingName']?></option>
                                        <?php }else{?>
                                        <option value="<?=$model['TeachingClassID']?>"><?=$model['TeachingName']?></option>
                                        <?php }}?>
                                </select>
                            </div>
                        </div>

                <!-- row start -->
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                <thead>
                                <tr role="row">
                                    <th rowspan="2">学号</th>
                                    <th>资源名称</th>
                                    <?php foreach ($doc as $key => $value){};
                                    if ($key>2)$key=2;?>
                                    <th colspan="<?= $key+1?>" style="text-align: center">学习文档</th>

                                    <?php foreach ($ppt as $key => $value){};
                                    if ($key>2)$key=2;?>
                                    <th colspan="<?= $key+1?>" style="text-align: center">ppt资源</th>

                                    <?php foreach ($vid as $key => $value){};
                                    if ($key>2)$key=2;?>
                                    <th colspan="<?= $key+1?>" style="text-align: center">视频资源</th>

                                </tr>
                                <tr>
                                    <th>名字</th>
                                    <?php
                                    foreach ($doc as $key => $value){
                                        echo '<th>'.$value['Name'].'</th>';
                                    }
                                    foreach ($ppt as $key => $value){
                                        echo '<th>'.$value['Name'].'</th>';
                                    }
                                    foreach ($vid as $key => $value){
                                        echo '<th>'.$value['Name'].'</th>';
                                    }
                                    ?>
                                </tr>
                                <?php
                                foreach ($list as $key => $value){
                                    echo '<tr>';
                                    echo '<th>'.$value['StuNumber'].'</th>';
                                    echo '<th><a style="cursor:pointer;"  onclick="jump('.$value['StuNumber'].')">'.$value['Name'].'></a></th>';
                                    $aa = (new Tresourceslearn())->findScore($value['StuNumber'],$doc);
                                    $i = 0;
                                    foreach ($aa as $v){
                                        if ($v['ResourcesStatus'] == null)
                                            echo '<th><font style="color: red">未学习</font></th>';
                                        else {
                                            if ($v['ResourcesStatus'] == 1000808)
                                                echo '<th><font style="color: #4682B4	">' . $v['Score'] . '</font></th>';
                                            else
                                                echo '<th><font style="color: red"> 已通过 </font></th>';
                                        }
                                            $i++;
                                            if ($i == 3)break;
                                    }
                                    $aa = (new Tresourceslearn())->findScore($value['StuNumber'],$ppt);
                                    $i = 0;
                                    foreach ($aa as $v){
                                        if ($v == null)
                                            echo '<th><font style="color: red">未学习</font></th>';
                                        else {
                                            if ($v == '100')
                                                echo '<th><font style="color: #4682B4	">' . $v . '</font></th>';
                                            else
                                                echo '<th><font style="color: red">' . $v . '</font></th>';
                                        }
                                        $i++;
                                        if ($i == 3)break;
                                    }
                                    $aa = (new Tresourceslearn())->findScore($value['StuNumber'],$vid);
                                    $i = 0;
                                    foreach ($aa as $v){
                                        if ($v == null)
                                            echo '<th><font style="color: red">未学习</font></th>';
                                        else {
                                            if ($v == '100')
                                                echo '<th><font style="color: #4682B4	">' . $v . '</font></th>';
                                            else
                                                echo '<th><font style="color: red">' . $v . '</font></th>';
                                        }
                                        $i++;
                                        if ($i == 3)break;
                                    }
                                    echo '</tr>';
                                }
                                ?>



                                </thead>
                                <tbody id="stu_info">

                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="data_table_info" role="status" aria-live="polite">
                                    <div class="infos">
                                        从<?= $pages->getPage() * $pages->getPageSize() + 1 ?>            		到 <?= ($pageCount = ($pages->getPage() + 1) * $pages->getPageSize()) < $pages->totalCount ?  $pageCount : $pages->totalCount?>            		 共 <?= $pages->totalCount?> 条记录</div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="data_table_paginate">
                                    <?= LinkPager::widget([
                                        'pagination' => $pages,
                                        'nextPageLabel' => '»',
                                        'prevPageLabel' => '«',
                                        'firstPageLabel' => '首页',
                                        'lastPageLabel' => '尾页',
                                    ]); ?>

                                </div>
                            </div>
                        </div>

            </div>
        </div>
    </div>
</section>
<script>

    $('#major-choice').change(function (e) {
        e.preventDefault();
        ajaxGetClass($(this).val(),false);
    });

    function ajaxGetClass(val,classId) {
        $.ajax({
            type:'get',
            url:'<?=Url::toRoute("learn/get-major-class")?>',
            data:{major:val},
            dataType:"JSON",
            success:function (value) {
                $('#class-choice').empty();
                $('#class-choice').append('<option value="没有任何作用的选项">请选择</option>')
                for(var Tmp in value){
                    if (value[Tmp]['ClassName'] == classId) {
                        $('#class-choice').append('<option selected="selected" value="'+ value[Tmp]['ClassName'] +'">'+ value[Tmp]['ClassName'] +'</option>');
                    } else {
                        $('#class-choice').append('<option value="'+ value[Tmp]['ClassName'] +'">'+ value[Tmp]['ClassName'] +'</option>');
                    }
                }
            }
        })
    }

    $('#output_excel').click(function (e) {
        e.preventDefault();
        var TeachingClassID = $('#myClass-choice').val();
        if (TeachingClassID == "0") {
            alert('请选择我的教学班');
        } else {
            window.location.href = '<?=Url::toRoute("learn/output-excel")?>'
                + '&TeachingClassID='+TeachingClassID;
        }
    });

    //$('#class-choice').change(function (e) {
    //    e.preventDefault();
    //    window.location.href = '<?//=Url::toRoute("learn/index")?>//'+'&major='+$("#major-choice").val()+'&class='+$(this).val();
    //});
    //
    $('#myClass-choice').change(function (e) {
        e.preventDefault();
        var url = '<?=Url::toRoute("learn/index")?>' ;
        if ($('#myClass-choice').val() != 0)
            url += '&TeachingClassID='+$('#myClass-choice').val();
        if ($('#term-choice').val() != 0)
            url += '&term='+$('#term-choice').val();
        window.location.href = url;
    });
    $('#term-choice').change(function (e) {
        e.preventDefault();
        var url = '<?=Url::toRoute("learn/index")?>' ;
        if ($('#myClass-choice').val() != 0)
            url += '&TeachingClassID='+$('#myClass-choice').val();
        if ($('#term-choice').val() != 0)
            url += '&term='+$('#term-choice').val();
        window.location.href = url;
    });
    //
    //$(document).ready(function () {
    //    var major = '<?//=$choice["major"]?>//';
    //    if (major != '') {
    //        $('#major-choice option[value='+ major +']').attr('selected','selected');
    //        ajaxGetClass('<?//=$choice["major"]?>//','<?//=$choice["class"]?>//');
    //    }
    //});
    function jump(id) {
        window.location.href = '<?=Url::toRoute("learn/view")?>&id='+id+'&term='+$('#term-choice').val();
    }

</script>

