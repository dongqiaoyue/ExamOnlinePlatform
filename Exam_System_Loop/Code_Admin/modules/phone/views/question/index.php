
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$m_know = new \app\models\question\Knowledgepoint();

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
                    <h3 class="box-title">学生问答管理</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-sm-12">
                                <label>我的教学班:&nbsp;</label>
                                <select class="form-control" id="myClass-choice">
                                    <option>请选择</option>
                                    <?php foreach ($myClass as $model) {?>
                                        <option value="<?=$model['TeachingClassID']?>"><?=$model['TeachingName']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >所属资源名</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >帖子状态</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >添加时间</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >提问人</th>';


                                        ?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="program_info">
                                    <?php
                                    foreach ($list as $model) {
                                        $id = $model['ID'];
                                        echo '<tr id="rowid_' . $model['ID']. '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['ID'] . '"></label></td>';
                                        echo '  <td>' . (new \app\models\phone\Tresources())->Resources($model['ResourcesID']). '</td><td>';
                                        if($model['Status']=='1000805'){
                                            echo '      待确认';
                                        }
                                        else if ($model['Status']=='1000806'){
                                            echo '      已完结';
                                        }
                                        else{
                                            echo '      <font color="red">待回复</font>';
                                        }
                                        echo '  </td><td>' . $model->AddAt . '</td>';
                                        echo '  <td>' . $model->AddBy . '</td>';


                                        echo '  <td class="center">';

                                        echo '      <a id="view_btn" onclick="viewAction(\'' . $model->ID .'\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        if($model['IsPublish']=='1'){
                                            echo '      <a id="check_btn" onclick="IsPublish(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>已公开</a>';
                                        }
                                        else{
                                            echo '      <a id="check_btn" onclick="IsPublish(' . "'$id'"  . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>公开</a>';
                                        }
                                        if($model['IsTOP']=='1'){
                                            echo '      <a id="top_btn" onclick="IsTOP(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>已置顶</a>';
                                        }
                                        else{
                                            echo '      <a id="top_btn" onclick="IsTOP(' . "'$id'"  . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>置顶</a>';
                                        }
                                        echo '      <a id="delete_btn" onclick="deleteAction(' . "'$id'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';

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

        <?php $this->beginBlock('footer');  ?>
        <!-- <body></body>������ -->

        <script>



            $('#myClass-choice').change(function (e) {
                e.preventDefault();
                window.location.href = '<?=Url::toRoute("question/index")?>'+'&TeachingClassID='+$(this).val();
            });


            function viewAction(id){
                window.location.href = "<?=Url::toRoute('question/view')?>"+"&id="+id;
            }

            function IsPublish(id){
                //alert(id);
                $.ajax({
                    type: 'GET',
                    url: '<?=Url::toRoute('question/publish')?>',
                    data: {"id": id},
                    catch: false,
                    async: false,
                    dataType: 'json',
                    success:function (value) {
                        //alert();
                        window.location.reload();
                    }
                })
            }

            function IsTOP(id){
                //alert(id);
                $.ajax({
                    type: 'GET',
                    url: '<?=Url::toRoute('question/top')?>',
                    data: {"id": id},
                    catch: false,
                    async: false,
                    dataType: 'json',
                    success:function (value) {
                        //alert();
                        window.location.reload();
                    }
                })
            }



            function deleteAction(id){
                var ids = [];
                if(!!id == true){
                    ids[0] = id;
                }
                else{
                    var checkboxs = $('#data_table :checked');
                    if(checkboxs.size() > 0){
                        var c = 0;
                        for(i = 0; i < checkboxs.size(); i++){
                            var id = checkboxs.eq(i).val();
                            if(id != ""){
                                ids[c++] = id;
                            }
                        }
                    }
                }
                if(ids.length > 0){
                    admin_tool.confirm('请确认是否删除', function(){
                        $.ajax({
                            type: "GET",
                            url: "<?=Url::toRoute('question/delete')?>",
                            data: {"ids":ids},
                            cache: false,
                            dataType:"json",
                            error: function (xmlHttpRequest, textStatus, errorThrown) {
                                alert("出错了" + textStatus);
                                // window.location.reload();
                            },
                            success: function(data){
                                for(var i = 0; i < ids.length; i++){
                                    $('#rowid_' + ids[i]).remove();
                                }
                                admin_tool.alert('msg_info', '删除成功', 'success');
                                //window.location.reload();
                            }
                        });
                    });
                }
                else{
                    admin_tool.alert('msg_info', '请选择要删除的数据', 'warning');
                }

            }
            

            $('#delete_btn').click(function (e) {
                e.preventDefault();
                deleteAction('');
            });

        </script>
        <?php $this->endBlock(); ?>
