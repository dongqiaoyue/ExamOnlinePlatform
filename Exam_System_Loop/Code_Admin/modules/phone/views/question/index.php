
<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
use common\commonFuc;

$com = new commonFuc();
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
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-sm-12">
                                <label>学期:&nbsp;</label>
                                <select class="form-control" id="term-choice">
                                    <option value="0">全部学期</option>
                                    <?php if(isset($_GET['term'])){?>
                                        <?php foreach ($term as $model){?>
                                            <?php if($model->CuitMoon_DictionaryCode === $_GET['term']){?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" selected="selected"><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($term as $model){?>
                                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                        <?php }}?>
                                </select>

                                <label>资源类型:&nbsp;</label>
                                <select class="form-control" id="type-choice">
                                    <option value="0">全部</option>
                                    <option value="1000801" <?php if(isset($_GET['type'])) if($_GET['type']==='1000801') echo 'selected';?>>文档</option>
                                    <option value="1000802" <?php if(isset($_GET['type'])) if($_GET['type']==='1000802') echo 'selected';?>>ppt</option>
                                    <option value="1000803" <?php if(isset($_GET['type'])) if($_GET['type']==='1000803') echo 'selected';?>>视频</option>
                                </select>

                                <label>阶段:&nbsp;</label>
                                <select class="form-control" id="stage-choice">
                                    <option value="0">全部阶段</option>
                                    <?php if(isset($_GET['stage'])){?>
                                        <?php foreach ($stage as $model){?>
                                            <?php if($model->CuitMoon_DictionaryCode === $_GET['stage']){?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" selected="selected"><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($stage as $model){?>
                                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                        <?php }}?>
                                </select>

                                <label>知识点:&nbsp;</label>
                                <select class="form-control" id="knowledgepoint-choice">
                                    <option value="0">全部知识点</option>
                                    <?php if(isset($_GET['knowledgeBh'])){?>
                                        <?php foreach ($knowledgepoint as $model){?>
                                            <?php if($model->KnowledgeBh === $_GET['knowledgeBh']){?>
                                                <option value="<?=$model->KnowledgeBh?>" selected="selected"><?=$model->KnowledgeName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->KnowledgeBh?>" ><?=$model->KnowledgeName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($knowledgepoint as $model){?>
                                            <option value="<?=$model->KnowledgeBh?>" ><?=$model->KnowledgeName?></option>
                                        <?php }}?>

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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >资源类型</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >资源名称</th>';


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
                                        echo '  <td>' . $com->codeTranName($model['Type']) . '</td>';
                                        echo '  <td>' . $model['Name'] . '</td>';


                                        echo '  <td class="center">';

                                        echo '      <a id="view_btn" onclick="viewAction(\'' . $model['ID'] .'\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';


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



            $('#term-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var type = $("#type-choice").val();
                var url = '<?=Url::toRoute('question/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno
                if (type != 0)
                    url += '&type='+type

                window.location.href = url;
            });
            $('#stage-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var type = $("#type-choice").val();
                var url = '<?=Url::toRoute('question/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno
                if (type != 0)
                    url += '&type='+type

                window.location.href = url;
            });
            $('#knowledgepoint-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var type = $("#type-choice").val();
                var url = '<?=Url::toRoute('question/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno
                if (type != 0)
                    url += '&type='+type

                window.location.href = url;
            });
            $('#type-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var type = $("#type-choice").val();
                var url = '<?=Url::toRoute('question/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno
                if (type != 0)
                    url += '&type='+type

                window.location.href = url;
            });


            function viewAction(id){
                window.location.href = "<?=Url::toRoute('question/view')?>"+"&ID="+id;
            }

        </script>
        <?php $this->endBlock(); ?>
