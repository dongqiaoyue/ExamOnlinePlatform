
<?php
use yii\widgets\LinkPager;
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
                    <h3 class="box-title">角色列表</h3>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >角色名称</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >角色描述</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >创建时间</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

<!--                                    --><?php
                                    foreach ($list as $model) {
                                        echo '<tr id="rowid_' . $model->name . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->name . '"></label></td>';
                                        echo '  <td>' . $model->name . '</td>';
                                        echo '  <td>' . $model->description . '</td>';
                                        echo '  <td>' . date("Y-m-d H:i:s",$model->created_at) . '</td>';
                                        echo '  <td class="center">';
                                        echo '      <a id="view_btn" onclick="rightAction('."'$model->name'".')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>分配权限</a>';
                                        // echo '      <a id="view_btn" onclick="viewAction(' . "'$model->name'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        // echo '      <a id="edit_btn" onclick="editAction(' . "'$model->name'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        echo '      <a id="delete_btn_" onclick="deleteAction(' . "'$model->name'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                        echo '  </td>';
                                        echo '</tr>';
                                    }
                                   ?>



                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>

                        <!-- row start -->

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
                <h3>角色</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]); ?>

                <input type="hidden" class="form-control" id="id" name="AdminRole[id]" />


                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">角色名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="des_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">角色描述</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="des" name="des" placeholder="" />
                    </div>
                    <div class="clearfix"></div>
                </div>



                <div id="update_user_div" class="form-group">
                    <label for="update_user" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="update_user" name="AdminRole[update_user]" placeholder="" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="update_date_div" class="form-group">
                    <label for="update_date" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="update_date" name="AdminRole[update_date]" placeholder="" />
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

<!-- 分配权限 -->
<div class="modal fade" id="tree_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>权限分配</h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="select_role_id" />
                <?php $form = ActiveForm::begin(["id" => "system-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("system-role/save")]); ?>
                <div id="treeview"></div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="right_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>
<!-- 分配权限结束 -->

<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>
    // 分配权限
    $(function(){
        // 树节点 http://www.htmleaf.com/jQuery/Menu-Navigation/201502141379.html
        $('#user_btn').click(function(){
            $('#tree_dialog').modal('show');
        });

        $('#right_btn').click(function(){

        });
    });
    function changeCheckState(node, checked){
        if(!!node.nodes == true){
            var nodes = node.nodes;
            for(var i = 0; i < nodes.length; i++){
                var node1 = nodes[i];
                if(checked == true){
                    $('#treeview').treeview('checkNode', [ node1.nodeId, { silent: true } ]);
                }
                else{
                    $('#treeview').treeview('uncheckNode', [ node1.nodeId, { silent: true } ]);
                }
                changeCheckState(node1, checked);
            }
        }
    }

    function rightAction(roleId){
        $('#select_role_id').val(roleId);
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('role/get-permission')?>",
            data: {'roleId':roleId},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了，" + textStatus);
            },
            success: function(data){
                $('#treeview').treeview({
                    data:data,
                    showIcon: false,
                    showCheckbox: true,
                    onNodeChecked: function(event, node) {
                        //console.log('======',node);
                        changeCheckState(node, true);
                    },
                    onNodeUnchecked: function (event, node) {
                        changeCheckState(node, false);
                    }
                });
            }
        });
        $('#tree_dialog').modal('show');
    }

    $('#right_dialog_ok').click(function(){
        var role_id = $('#select_role_id').val();
        var checkNodes = $('#treeview').treeview('getChecked');
        if(checkNodes.length > 0){
            var rids = [];
            for(i = 0; i < checkNodes.length; i++){
                var node = checkNodes[i];
                if(node.type == 'r'){
                    rids.push(node.rid);
                }
            }
            $('#tree_dialog').modal('hide');
            $.ajax({
                type: "POST",
                url: "<?=Url::toRoute('role/permission')?>",
                data: {"rids":rids, 'roleId':role_id},
                cache: false,
                dataType:"json",
                error: function (xmlHttpRequest, textStatus, errorThrown) {
                    alert("出错了，" + textStatus);
                },
                success: function(data){
                    if(data.error == 0){
                        admin_tool.alert('msg_info', '保存成功', 'success');
                    }
                    else{
                        admin_tool.alert('msg_info', '保存失败', 'error');
                    }
                    
//	 			   console.log(msg);
                    //initEditSystemModule(data, type);
                }
            });
// 		console.log('====',rids);
        }
    });
    //分配权限

    function searchAction(){
        $('#admin-role-search-form').submit();
    }
    function viewAction(id){
        initModel(id, 'view', 'fun');
    }

    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#id").val('');
            $("#code").val('');
            $("#name").val('');
        }
        else{
            $("#id").val(data.id);
            $("#code").val(data.code);
            $("#name").val(data.name);
        }
        if(type == "view"){
            $("#id").attr({readonly:true,disabled:true});
            $("#code").attr({readonly:true,disabled:true});
            $("#name").attr({readonly:true,disabled:true});
            $('#edit_dialog_ok').addClass('hidden');
        }
        else{
            $("#id").attr({readonly:false,disabled:false});
            $("#code").attr({readonly:false,disabled:false});
            $("#name").attr({readonly:false,disabled:false});
            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('role/view')?>",
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
                    url: "<?=Url::toRoute('role/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        // alert("出错了，" + textStatus);
                        window.location.reload();
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
        $('#admin-role-form').submit();
    });

    $('#create_btn').click(function (e) {
        e.preventDefault();
        initEditSystemModule({}, 'create');
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-role-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        var action = id == "" ? "<?=Url::toRoute('role/create')?>" : "<?=Url::toRoute('admin-role/update')?>";
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
            data:{id:id},
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