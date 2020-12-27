
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use app\models\phone\Tresourceexaminfo;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$m_know = new \app\models\question\Knowledgepoint;
$m_model = new \app\models\phone\Tresourceexaminfo;
?>


<?php $this->beginBlock('header');  ?>
<!-- <head></head>�д���� -->
<?php $this->endBlock(); ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title"><a style="cursor:pointer;" href="<?=Url::toRoute("learnall/index")?>">资源学习情况-></a><?= $tresources['Name']?></h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
<!--                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>-->
<!--                            |-->
<!--                            <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>-->
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <!-- row start search-->
                        <!-- row end search -->

                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学号</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >添加时间</th>';

                                        ?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="program_info">
                                    <?php
                                    foreach ($list as $model) {
                                        $id = $model['PaperBH'];
                                        echo '<tr id="rowid_' . $model['PaperBH']. '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['PaperBH'] . '"></label></td>';
                                        echo '  <td>' . $model['StuID'] . '</td>';
                                        echo '  <td>' . $model['StuName'] . '</td>';
                                        echo '  <td>' . $model['score'] . '</td>';
                                        echo '  <td>' . $model['EndTime'] . '</td>';

                                        echo '  <td class="center">';

                                        echo '      <a id="view_btn" onclick="viewScore(\''.$model['ResourcesID'].'\',\''.$model['StuID'].'\')" data-toggle="modal" data-target="#view" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看详情</a>';
//                                        echo '      <a id="delete_btn" onclick="deleteAction(' . "'$id'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';

                                        echo '  </td>';
                                        echo '</tr>';
                                    }
                                    ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</section>
<!-- /.content -->
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
</div>


    <?php $this->beginBlock('footer');  ?>
    <!-- <body></body>������ -->
    <script>
        function viewScore(id1,id2) {
            var html = '';
            $.ajax({
                type:'GET',
                url:'<?=Url::toRoute('learnall/score')?>',
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
    <?php $this->endBlock(); ?>
