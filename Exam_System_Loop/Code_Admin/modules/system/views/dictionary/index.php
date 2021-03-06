
<?php
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
                    <h3 class="box-title">字典列表<?php if($id != null){
                        $m_dic = new \app\models\system\TbcuitmoonDictionary();
                        echo '&nbsp|&nbsp'.$m_dic->findOne(['CuitMoon_DictionaryID' => $id])-> CuitMoon_DictionaryName;
                        } ?></h3>
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
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-sm-12">
                                <?php ActiveForm::begin(['id' => 'admin-module-search-form', 'method'=>'get', 'options' => ['class' => 'form-inline'], 'action'=>Url::toRoute('admin-module/index')]); ?>

                                <div class="form-group" style="margin: 5px;">
                                    <label>字典名称:</label>
                                    <input type="text" class="form-control" id="query[id]" name="query[id]"  value="<?=isset($query["id"]) ? $query["id"] : "" ?>">
                                </div>

                                <div class="form-group">
                                    <a onclick="searchAction()" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>搜索</a>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                        <!-- row end search -->

                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'编号'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'字典名称'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'字典Code'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'这行仅仅为了格式'.'</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $row = 0;
                                    foreach ($info as $model) {
                                        echo '<tr id="rowid_' . $model->CuitMoon_DictionaryID . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->CuitMoon_DictionaryID . '"></label></td>';
                                        echo '  <td>' . $model->CuitMoon_DictionaryOrderNum  . '</td>';
                                        echo '  <td>' . $model->CuitMoon_DictionaryName . '</td>';
                                        echo '  <td>' . $model->CuitMoon_DictionaryCode . '</td>';
                                        echo '  <td>' . "YOU GUESS" . '</td>';
                                        echo '  <td class="center">';
                                        if ($model->CuitMoon_ParentDictionaryID == '0') {
                                            echo '      <a id="view_btn" class="btn btn-primary btn-sm" href="'.Url::toRoute(['dictionary/index', 'id'=>$model->CuitMoon_DictionaryID ]) .'"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>二级菜单</a>';
                                        }
                                        echo '      <a id="view_btn" onclick="viewAction(' . "'$model->CuitMoon_DictionaryID'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(' . "'$model->CuitMoon_DictionaryID'"   . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        echo '      <a id="delete_btn" onclick="deleteAction(' . "'$model->CuitMoon_DictionaryID'"   . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                        echo '  </td>';
                                        echo '<tr/>';
                                    }

                                    ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>

                        <!-- row start 分页-->
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
                <h3>主菜单管理</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-module-form", "class"=>"form-horizontal", "action"=>Url::toRoute("dictionary/create")]); ?>
                <input type="hidden" class="form-control" id="id" name="TbcuitmoonDictionary[CuitMoon_DictionaryID]" />

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="CuitMoon_DictionaryCode" name="TbcuitmoonDictionary[CuitMoon_DictionaryCode]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">字典名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="CuitMoon_DictionaryName" name="TbcuitmoonDictionary[CuitMoon_DictionaryName]" placeholder="必填" />
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
<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>
    function searchAction(){
        $('#admin-module-search-form').submit();
    }
    function viewAction(id){
        initModel(id, 'view', 'fun');
    }

    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#id").val('');
            $("#CuitMoon_DictionaryCode").val('');
            $("#CuitMoon_DictionaryName").val('');

        }
        else{
            $("#id").val(data.CuitMoon_DictionaryID);
            $("#CuitMoon_DictionaryCode").val(data.CuitMoon_DictionaryCode);
            $("#CuitMoon_DictionaryName").val(data.CuitMoon_DictionaryName);
        }
        if(type == "view"){
            $("#CuitMoon_DictionaryCode").attr({readonly:true,disabled:true});
            $("#CuitMoon_DictionaryName").attr({readonly:true,disabled:true});
            $('#edit_dialog_ok').addClass('hidden');
        }
        else{
            $("#CuitMoon_DictionaryCode").attr({readonly:false,disabled:false});
            $("#CuitMoon_DictionaryName").attr({readonly:false,disabled:false});
            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('dictionary/view')?>",
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
                    url: "<?=Url::toRoute('dictionary/delete')?>",
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
        var action = id == "" ? "<?=Url::toRoute('dictionary/create')?>" : "<?=Url::toRoute('dictionary/update')?>";
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
            data:{"CuitMoon_DictionaryID":id,"TbcuitmoonDictionary[CuitMoon_ParentDictionaryID]":"<?=$id?>"},
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