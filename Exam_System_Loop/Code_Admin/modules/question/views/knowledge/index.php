<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
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
                    <h3 class="box-title">知识点列表</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>
                            |
                            <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'名称'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'描述'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'所属章节'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'所属阶段'.'</th>';
                                        // echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >添加时间</th>';

                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    foreach ($list as $model) {
                                        $id = $model['KnowledgeBh'];
                                        echo '<tr id="rowid_' . $model->KnowledgeBh . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $id . '"></label></td>';
                                        echo '  <td>' . $model->KnowledgeName  . '</td>';
                                        echo '  <td>' . $model->Description . '</td>';
                                        echo '  <td>' . $com->codeTranName($model->Chapter). '</td>';
                                        echo '  <td>' . $com->codeTranName($model->Stage) . '</td>';
                                        // echo '  <td>' . $model->AddTime . '</td>';

                                        echo '  <td class="center">';
                                        echo '      <a id="delete_btn" onclick="deleteAction(' . "'$id'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                        echo '      <a onclick="updateAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" href="#">
                                                <i class="glyphicon glyphicon-trash icon-white"></i>修改</a>';

                                        echo '  </td>';
                                        echo '<tr/>';
                                    }

                                    ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <!-- row end -->
                        <!-- row start -->
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
                        <!-- row end -->

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

<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>知识点添加</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-module-form", "class"=>"form-horizontal", "action"=>Url::toRoute("module/create")]); ?>
                <input type="hidden" class="form-control" id="id" name="Knowledgepoint[KnowledgeBh]" />

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="code" name="Knowledgepoint[KnowledgeName]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="Knowledgepoint[Description]"></textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="des_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">所属章节</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="Knowledgepoint[Chapter]">
                            <?php foreach ($chapter as $model){?>
                                <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_order_div" class="form-group">
                    <label for="display_order" class="col-sm-2 control-label">所属阶段</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="Knowledgepoint[Stage]">
                            <?php foreach ($stage as $model){?>
                                <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="edit_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="update_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>知识点修改</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "update_knowledge", "class"=>"form-horizontal", "action"=>Url::toRoute("knowledge/update-knowledge")]); ?>
                <input type="hidden" class="form-control" id="KnowledgeBh" name="Knowledgepoint[KnowledgeBh]" />

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="KnowledgeName" name="Knowledgepoint[KnowledgeName]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="Description" name="Knowledgepoint[Description]"></textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="des_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">所属章节</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="Chapter" name="Knowledgepoint[Chapter]">
                            <?php foreach ($chapter as $model){?>
                                <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_order_div" class="form-group">
                    <label for="display_order" class="col-sm-2 control-label">所属阶段</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="Stage" name="Knowledgepoint[Stage]">
                            <?php foreach ($stage as $model){?>
                                <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="update_ok" href="#" class="btn btn-primary">修改</a>
            </div>
        </div>
    </div>
</div>
<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>
    function searchAction(){
        $('#admin-module-search-form').submit();
    }
    function viewAction(id){
        initModel(id, 'view', 'fun');
    }


    function updateAction(id){
        $.post(
            "<?=Url::toRoute('knowledge/get-knowledge-by-id')?>",
            {
                id:id,
            },
            function(res){
                // alert(res);
                $('#update_dialog').modal('show');
                // alert(res.KnowledgeBh);
            for(var key in res)
                $('#'+key).val(res[key]);
            },
            'json'
        )
    }
    $('#update_ok').click(function(){
        $('#update_knowledge').submit();
        //window.location.reload();
    })
    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#id").val('');
            $("#code").val('');
            $("#display_label").val('');
            $("#has_lef").val('');
            $("#des").val('');
            $("#entry_url").val('');
            $("#display_order").val('');
            $("#create_user").val('');
            $("#create_date").val('');
            $("#update_user").val('');
            $("#update_date").val('');

        }
        else{
            $("#id").val(data.id);
            $("#code").val(data.code);
            $("#display_label").val(data.display_label);
            $("#has_lef").val(data.has_lef);
            $("#des").val(data.des);
            $("#entry_url").val(data.entry_url);
            $("#display_order").val(data.display_order);
            $("#create_user").val(data.create_user);
            $("#create_date").val(data.create_date);
            $("#update_user").val(data.update_user);
            $("#update_date").val(data.update_date);
        }
        if(type == "view"){
            $("#id").attr({readonly:true,disabled:true});
            $("#code").attr({readonly:true,disabled:true});
            $("#display_label").attr({readonly:true,disabled:true});
            $("#has_lef").attr({readonly:true,disabled:true});
            $("#des").attr({readonly:true,disabled:true});
            $("#entry_url").attr({readonly:true,disabled:true});
            $("#display_order").attr({readonly:true,disabled:true});
            $("#create_user").attr({readonly:true,disabled:true});
            $("#create_user").parent().parent().show();
            $("#create_date").attr({readonly:true,disabled:true});
            $("#create_date").parent().parent().show();
            $("#update_user").attr({readonly:true,disabled:true});
            $("#update_user").parent().parent().show();
            $("#update_date").attr({readonly:true,disabled:true});
            $("#update_date").parent().parent().show();
            $('#edit_dialog_ok').addClass('hidden');
        }
        else{
            $("#id").attr({readonly:false,disabled:false});
            $("#code").attr({readonly:false,disabled:false});
            $("#display_label").attr({readonly:false,disabled:false});
            $("#has_lef").attr({readonly:false,disabled:false});
            $("#des").attr({readonly:false,disabled:false});
            $("#entry_url").attr({readonly:false,disabled:false});
            $("#display_order").attr({readonly:false,disabled:false});
            $("#create_user").attr({readonly:false,disabled:false});
            $("#create_user").parent().parent().hide();
            $("#create_date").attr({readonly:false,disabled:false});
            $("#create_date").parent().parent().hide();
            $("#update_user").attr({readonly:false,disabled:false});
            $("#update_user").parent().parent().hide();
            $("#update_date").attr({readonly:false,disabled:false});
            $("#update_date").parent().parent().hide();
            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('admin-module/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了，" + textStatus);
            },
            success: function(data){
                initEditSystemModule(data, type);
            }
        });
    }

    function editAction(id){
        initModel(id, 'edit');
    }

    function deleteAction(id){
        //alert(id);
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
                    url: "<?=Url::toRoute('knowledge/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        alert("出错了，" + textStatus);
                    },
                    success: function(data){
                        for(i = 0; i < ids.length; i++){
                            $('#rowid_' + ids[i]).remove();
                        }
                        admin_tool.alert('msg_info', '删除成功', 'success');
                        window.location.reload();
                    }
                });
            });
        }
        else{
            admin_tool.alert('msg_info', '请先选择要删除的数据', 'warning');
        }

    }

    function getSelectedIdValues(formId)
    {
        var value="";
        $( formId + " :checked").each(function(i)
        {
            if(!this.checked)
            {
                return true;
            }
            value += this.value;
            if(i != $("input[name='id']").size()-1)
            {
                value += ",";
            }
        });
        return value;
    }

    $('#edit_dialog_ok').click(function (e) {
        e.preventDefault();
        $('#admin-module-form').submit();
    });

    $('#create_btn').click(function (e) {
        e.preventDefault();
        initEditSystemModule({}, 'create');
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-module-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        var action = id == "" ? "<?=Url::toRoute('knowledge/create')?>" : "<?=Url::toRoute('module/update')?>";
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
            data:{"CuitMoon_ModuleID":id,},
            success: function(value)
            {
                if(value.error == 0){
                    $('#edit_dialog').modal('hide');
                    admin_tool.alert('msg_info', '添加成功', 'success');
                    window.location.reload();
                }
                else{
                    var json = value.data;
                    for(var key in json){
                        $('#' + key).attr({'data-placement':'bottom', 'data-content':json[key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');

                    }
                }

            }
        });
    });


</script>
<?php $this->endBlock(); ?>
