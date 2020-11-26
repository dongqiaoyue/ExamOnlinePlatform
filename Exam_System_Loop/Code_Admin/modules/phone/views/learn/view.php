
<?php

use app\models\phone\Tresources;
use app\models\phone\Tresourceslearn;
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title"><a style="cursor:pointer;" href="<?=Url::toRoute("learn/index")?>">学生练习情况-></a><?= $name?>的练习情况</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <tr role="row">
                                        <th>分类</th>
                                        <th>名称</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>测试次数</th>
                                        <th>最近分数</th>
                                        <th>操作</th>
                                    </tr>
                                    <tr><th rowspan="<?= $i+1?>" style="vertical-align: middle">文章资源</th></tr>


                                    <?php
                                        foreach ($doc as $value)
                                        {
                                            $data = (new Tresourceslearn())->findByID($value,$id);
                                            echo '<tr><th>'.(new Tresources())->Resources($value);
                                            if (isset($data['StTime']))
                                            {echo '</th><th>'.$data['StTime'].'</th><th>'.$data['EdTime'].'</th><th>'.$data['ScoreCount'].'</th><th>';
                                                if ($data['Score'] == 100) echo '<font style="color: #4682B4	">'.$data['Score'].'</font>';
                                                else echo '<font style="color: red">'.$data['Score'].'</font>';
                                                echo '</th><th>'.'<a id="view_btn" onclick="viewScore(\''.$data['ResourcesID'].'\',\''.$data['StuID'].'\')" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>'.'</th></tr>';
                                            }else
                                                echo '</th><th>无</th><th>无</th><th>无</th><th><font style="color: red">未学习</font></th><th><a id="view_btn" onclick="" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a></th></tr>';
                                        }
                                        ?>
                                    <tr><th rowspan="<?= $j+1?>" style="vertical-align: middle">ppt资源</th></tr>
                                        <?php
                                        foreach ($ppt as $value)
                                        {
                                            $data = (new Tresourceslearn())->findByID($value,$id);
                                            echo '<tr><th>'.(new Tresources())->Resources($value);
                                            if (isset($data['StTime']))
                                                {echo '</th><th>'.$data['StTime'].'</th><th>'.$data['EdTime'].'</th><th>'.$data['ScoreCount'].'</th><th>';
                                                if ($data['Score'] == 100) echo '<font style="color: #4682B4	">'.$data['Score'].'</font>';
                                                else echo '<font style="color: red">'.$data['Score'].'</font>';
                                                echo '</th><th>'.'<a id="view_btn" onclick="viewScore(\''.$data['ResourcesID'].'\',\''.$data['StuID'].'\')" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>'.'</th></tr>';
                                            }else
                                                echo '</th><th>无</th><th>无</th><th>无</th><th><font style="color: red">未学习</font></th><th><a id="view_btn" onclick="" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a></th></tr>';
                                        }
                                        ?>
                                    <tr><th rowspan="<?= $z+1?>" style="vertical-align: middle">视频资源</th></tr>
                                        <?php
                                        foreach ($vid as $value)
                                        {
                                            $data = (new \app\models\phone\Tresourceslearn())->findByID($value,$id);
                                            echo '<tr><th>'.(new Tresources())->Resources($value);
                                            if (isset($data['StTime']))
                                            {echo '</th><th>'.$data['StTime'].'</th><th>'.$data['EdTime'].'</th><th>'.$data['ScoreCount'].'</th><th>';
                                                if ($data['Score'] == 100) echo '<font style="color: #4682B4	">'.$data['Score'].'</font>';
                                                else echo '<font style="color: red">'.$data['Score'].'</font>';
                                                echo '</th><th>'.'<a id="view_btn" onclick="viewScore(\''.$data['ResourcesID'].'\',\''.$data['StuID'].'\')" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>'.'</th></tr>';
                                            }else
                                                echo '</th><th>无</th><th>无</th><th>无</th><th><font style="color: red">未学习</font></th><th><a id="view_btn" onclick="" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a></th></tr>';
                                        }
                                        ?>
                                    <tbody id="stu_info">

                                    <!--查看分数-->
                                    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="title">详情</h4>
                                                </div>
                                                <div>
                                                    <div style="margin-left:25%; float: left; width: 20%; border: 1px solid #4c4c4c; text-align: center">成绩</div>
                                                    <div style="margin-right:25%; float: right; width: 30%; border: 1px solid #4c4c4c; text-align: center"">时间</div>
                                                </div>
                                                <div id="content">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal -->
                                    </div>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
</section>
<script>
    function viewScore(id1,id2) {
        var html = '';
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('learn/score')?>',
            data:'id1='+id1+'&id2='+id2,
            async:false,
            dataType:'json',

            success:function(value){
                var html = '';
                $('#content').empty();
                for(var Tmp in value){
                    //alert(value[Tmp].EndTime);
                    html += '<div style="margin-left:25%; float: left; width: 20%; border: 1px solid #4c4c4c; text-align: center">'+value[Tmp].score+'</div><div id="content" style="margin-right:25%; float: right; width: 30%; border: 1px solid #4c4c4c; text-align: center"">'+value[Tmp].EndTime+'</div>';
                }
                $('#content').append(html);
            }
        });

    }


</script>

