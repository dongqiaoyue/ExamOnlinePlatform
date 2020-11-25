
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
                    <h3 class="box-title">用户管理</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>
                            |
                            <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->

                        <!-- row end search -->

                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'用户名'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'姓名'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'课程'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'角色'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'是否启用'.'</th>';

                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $row = 0;
                                    foreach ($list as $model) {
                                        echo '<tr id="rowid_' . $model->CuitMoon_UserID . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->CuitMoon_UserID . '"></label></td>';
                                        echo '  <td>' . $model->CuitMoon_UserName  . '</td>';
                                        echo '  <td>' . $model->CuitMoon_UserRealName . '</td>';
                                        echo '  <td>' . $model->CuitMoon_UserZipCode . '</td>';
                                        echo '  <td>' . "YOU GUESS". '</td>';
                                        echo '  <td>' . $model->CuitMoon_UserWorkingStatus . '</td>';
                                        echo '  <td class="center">';
                                        echo '      <a id="view_btn" class="btn btn-primary btn-sm" onclick="getRole('. "'$model->CuitMoon_UserID'" .')"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>分配角色</a>';
                                        echo '      <a id="view_btn" onclick="viewAction(' . "'$model->CuitMoon_UserID'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(' . "'$model->CuitMoon_UserID'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        echo '      <a id="delete_btn_" onclick="deleteAction(' . "'$model->CuitMoon_UserID'"  . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                        echo '      <a id="delete_btn_" onclick="resetAction(' . "'$model->CuitMoon_UserID'"  . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>重置密码</a>';
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
<!---->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
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
                <h3>添加用户</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-module-form", "class"=>"form-horizontal", "action"=>Url::toRoute("dictionary/create")]); ?>
                <input type="hidden" class="form-control" id="CuitMoon_DictionaryID" name="TbcuitmoonDictionary[CuitMoon_DictionaryID]" />
                <div id="code_div" class="form-group">
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="CuitMoon_UserID" name="TbcuitmoonUser[CuitMoon_UserID]"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="CuitMoon_UserName" name="TbcuitmoonUser[CuitMoon_UserName]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">课程</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="TbcuitmoonUser[CuitMoon_AreaCode]" id="CuitMoon_AreaCode">
                            <option value="">请选择</option>
                            <?php
                            foreach($course as $key=>$data){
                                echo "<option value='" . $data['CuitMoon_DictionaryCode'] . "'>". $data['CuitMoon_DictionaryName']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="CuitMoon_UserRealName" name="TbcuitmoonUser[CuitMoon_UserRealName]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="display_label"  placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="CuitMoon_UserPassWord" name="TbcuitmoonUser[CuitMoon_UserPassWord]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">手机</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="CuitMoon_UserCellphone" name="TbcuitmoonUser[CuitMoon_UserCellphone]"  />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="CuitMoon_UserEmail" name="TbcuitmoonUser[CuitMoon_UserEmail]" />
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div id="display_label_div" class="form-group">
                    <label for="display_label" class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea id="CuitMoon_UserRemarks" class="form-control" rows="3" name="TbcuitmoonUser[CuitMoon_UserRemarks]"></textarea>
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

<div class="modal fade" id="tree_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>角色选择</h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="select_role_id" />
                <?php $form = ActiveForm::begin(["id" => "system-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("system-role/save")]); ?>
                <input type="hidden" class="form-control" id="user-id" name="id" />


                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-4 control-label "><h4>角色选择</h4></label>
                    <div class="col-sm-8" id="exam-modules">
                        <select multiple class="form-control" id="roles" name="role">

                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="role-ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>

    function resetAction(ID)
    {
        $.post(
            "<?=Url::toRoute('user/reset-passwd')?>",
            {
                ID:ID
            },

            function(res){
                alert(res);
            }
            )

    }
    function searchAction(){
        $('#admin-module-search-form').submit();
    }
    function viewAction(id){
        initModel(id, 'view', 'fun');
    }
    
    function getRole(id) {
        $.ajax({
            type:'GET',
            dataType:'JSON',
            url:'<?=Url::toRoute("user/get-role")?>',
            data:{'id':id},
            success:function (value) {
                $('#roles').empty();
                $('#user-id').val(id);
                for(var Tmp in value.All) {
                    $('#roles').append('<option value="' + value.All[Tmp].name + '">' + value.All[Tmp].name + '</option>');
                }
                if(value.Choice.length != 0){
                    for(var Tmp in value.Choice) {
                        $('option[value=' + value.Choice[Tmp].name + ']').attr('selected', true);
                    }
                }
                $('#tree_dialog').modal('show');
            }
        })
    }

    $('#role-ok').click(function (e) {
        e.preventDefault();
        $('#system-role-form').submit();
    })

    $('#system-role-form').bind('submit',function (e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type:'POST',
            dataType:'JSON',
            url:'<?=Url::toRoute("user/create-role")?>',
            success:function (value) {
                if(value.error == 0){
                    alert('修改成功');
                    window.location.reload();
                }
            }
        })
    })

    function initEditSystemModule(data, type){
        if(type == 'create'){
            $('#admin-module-form').find('.form-control').each(function(){
                $(this).val('');
            })
  

        }
        else{
            for(var key in data)
                $('#'+key).val(data[key]);
            $('#CuitMoon_UserPassWord').val('1111111');
            $('#display_label').val('1111111');
            

        }
        if(type == "view"){
            $('#admin-module-form').find('.form-control').each(function(){
                $(this).attr('disabled',true);
            })
 
        }
        else{
            $('#admin-module-form').find('.form-control').each(function(){
                $(this).attr('disabled',false);
            })
            if(type != 'create')
            {
                $('#CuitMoon_UserPassWord').attr('disabled',true);
                $('#display_label').attr('disabled',true);
            }
      
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('user/view')?>",
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
        $('#admin-module-form').attr('action','<?=Url::toRoute('user/update')?>');
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
                    url: "<?=Url::toRoute('user/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (res) {
                        
                        window.location.reload();
                    },
                    success: function(res){
                        
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
        $('#admin-module-form').ajaxSubmit(function(res){
            alert(res);
            window.location.reload();
        });
    });

    $('#create_btn').click(function (e) {
        e.preventDefault();
        $('#admin-module-form').attr('action','<?=Url::toRoute('user/create')?>');
        initEditSystemModule({}, 'create');
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-module-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            data:{'id':id},
            success: function(value)
            {
                if(value.error == 0){
                    $('#edit_dialog').modal('hide');
                    admin_tool.alert('msg_info', '添加成功', 'success');
                    
                }
                else{
                    for(var key in value['msg']){
                        $('#' + key).attr({'data-placement':'bottom', 'data-content':value['msg'][key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');

                    }
                }

            }
        });
    });


</script>
<?php $this->endBlock(); ?>