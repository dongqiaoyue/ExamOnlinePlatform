
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
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
                    <h3 class="box-title">开发者信息管理</h3>
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
                                <?php ActiveForm::begin(['id' => 'admin-role-search-form', 'method'=>'get', 'options' => ['class' => 'form-inline'], 'action'=>Url::toRoute('developer/index')]); ?>

                                <div class="form-group" style="margin: 5px;">
                                    <label>姓名:</label>
                                    <input type="text" class="form-control" id="name-value" name="name">
                                </div>

                                <div class="form-group">
                                    <a onclick="searchAction()" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>搜索</a>
                                </div>
                                <?php ActiveForm::end(); ?>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >姓名</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >性别</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >年级</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >座右铭</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >QQ</th>';
                                        ?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($developer as $model) {
                                        $id = $model['DeveloperID'];
                                        echo '<tr id="rowid_' . $model['DeveloperID'] . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['DeveloperID'] . '"></label></td>';
                                        echo '  <td>' . $model['DeveloperName'] . '</td>';
                                        echo '  <td>' . $model['Sex'] . '</td>';
                                        echo '  <td>' . $model['Grade'] . '</td>';
                                        echo '  <td>' . $model['QQ']. '</td>';
                                        echo '  <td>' . $model['Motto']. '</td>';
                                        echo '  <td class="center">';
                                        echo '      <a id="view_btn" onclick="viewAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
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

<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h3>开发者信息</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("developer/index")]); ?>

                <input type="hidden" class="form-control" id="id" name="id" />

                <div id="Name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">姓名</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="Name" name="Developerinfo[DeveloperName]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Sex_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="Sex" name="Developerinfo[Sex]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Grade_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">年级</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Developerinfo[Grade]" id="Grade" placeholder="只能是数字" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="QQ_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">QQ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Developerinfo[QQ]" id="QQ" placeholder="" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Motto_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">座右铭</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Developerinfo[Motto]" id="Motto" placeholder="" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row">
                    <div class="form-group" id="Better_div">
                        <label for="des" class="col-sm-2 control-labe">擅长方面</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="Better" name="Developerinfo[BetterAspect]"></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group" id="Project_div">
                        <label for="des" class="col-sm-2 control-labe">所做项目</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="Project" name="Developerinfo[DoneProject]"></textarea>
                        </div>
                    </div>
                </div>

                <?php $form=ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'id'=>'admin-upload-form']);?>
                <label for="file">个人照片:</label>
                <div>注：文件名不能为中文</div>
                <input type="file" name="file" id="file" />
                <?php ActiveForm::end();?>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="edit_dialog_ok" href="#" class="btn btn-primary" onclick="uploadAction()">确定</a>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('footer');  ?>
<!-- <body></body>������ -->

<script>



    function searchAction(){
        $('#admin-role-search-form').submit();
    }
    function editAction(id){
        initModel(id, 'edit');
    }

    function viewAction(id){
        initModel(id, 'view', 'fun');
    }

    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#Name").val('');
            $("#Sex").val('');
            $("#Grade").val('');
            $("#Motto").val('');
            $("#Better").val('');
            $("#Project").val('');
            $("#QQ").val('');
        }
        else{
            $("#Name").val(data['DeveloperName']);
            $("#Sex").val(data['Sex']);
            $("#Grade").val(data['Grade']);
            $("#Motto").val(data['Motto']);
            $("#Better").val(data['BetterAspect']);
            $("#Project").val(data['DoneProject']);
            $("#QQ").val(data['QQ']);
            $("#id").val(data['DeveloperID']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#Name").attr({readonly:true,disabled:true});
            $("#Sex").attr({readonly:true,disabled:true});
            $("#Grade").attr({readonly:true,disabled:true});
            $("#Motto").attr({readonly:true,disabled:true});
            $("#Better").attr({readonly:true,disabled:true});
            $("#Project").attr({readonly:true,disabled:true});
            $("#QQ").attr({readonly:true,disabled:true});
        }
        else{
            $("#Name").attr({readonly:false,disabled:false});
            $("#Sex").attr({readonly:false,disabled:false});
            $("#Grade").attr({readonly:false,disabled:false});
            $("#Motto").attr({readonly:false,disabled:false});
            $("#Better").attr({readonly:false,disabled:false});
            $("#Project").attr({readonly:false,disabled:false});
            $("#QQ").attr({readonly:false,disabled:false});
            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('developer/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了" + textStatus);
            },
            success: function(data){
                console.log(data);
                initEditSystemModule(data, type);
            }
        });
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
                    url: "<?=Url::toRoute('developer/delete')?>",
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



    $('#edit_dialog_ok').click(function (e) {
        e.preventDefault();
        $('#admin-role-form').submit();

    });

    $('#create_btn').click(function (e) {
        e.preventDefault();
        initEditSystemModule({},'create');
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-role-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        var action = id == "" ?"<?=Url::toRoute('developer/create')?>" : "<?=Url::toRoute('developer/update')?>";
        console.log(action);
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
            async: false,
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                window.location.reload();
            },
            success: function(value)
            {
                if(value.error == 0){
                    $('#edit_dialog').modal('hide');
                    admin_tool.alert('msg_info', '添加成功', 'success');
                    window.location.reload();
                }
                else{
                    for(var key in value['msg']){
                        $('#' + key).attr({'data-placement':'bottom', 'data-content':value['msg'][key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');

                    }
                }

            }
        });
    });
    function uploadAction(){
        var serializeData = $("#admin-upload-form").serialize();
        var id = $("#id").val();
        var action = id == "" ?"<?=Url::toRoute('developer/create')?>" : "<?=Url::toRoute('developer/update')?>";
        $("#admin-upload-form").ajaxSubmit({

            type: "POST",
            dataType: "json",
            url: action,
            async: false,
            data:serializeData,
            success: function (data) {
                alert(data);
                if (data.status == "warning") {
                    alert(data.msg);
                } else if (data.status == "success") {

                }else{
                    alert("添加成功");
                }
            },
            error: function (data) {alert(data.msg); },

        });
    }


</script>
<?php $this->endBlock(); ?>