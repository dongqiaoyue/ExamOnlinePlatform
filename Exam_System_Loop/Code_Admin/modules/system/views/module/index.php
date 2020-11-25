
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
                    <h3 class="box-title">一级模块列表<?php if($id != null){ echo '&nbsp|&nbsp二级模块列表'; } ?></h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>
                            |
                            <!-- <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button> -->
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
                                    <label>模块名称:</label>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'模板名称'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'模板Url'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'模板状态'.'</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $row = 0;
                                    foreach ($info as $model) {
                                        echo '<tr id="rowid_' . $model->CuitMoon_ModuleID . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->CuitMoon_ModuleID . '"></label></td>';
                                        echo '  <td>' . $model->CuitMoon_ModuleOrderNum  . '</td>';
                                        echo '  <td>' . $model->CuitMoon_ModuleName . '</td>';
                                        echo '  <td>' . $model->CuitMoon_ModuleURL . '</td>';
                                        echo '  <td>' . $model->CuitMoon_ModuleStatus . '</td>';
                                        echo '  <td class="center">';
                                        if(isset($id)){
                                            echo '      <a id="view_btn" class="btn btn-primary btn-sm" href="'.Url::toRoute(['module/item', 'id'=>$model->CuitMoon_ModuleURL, 'name'=>$model->CuitMoon_ModuleName ]) .'"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>权限管理</a>';
                                        }else{
                                            echo '      <a id="view_btn" class="btn btn-primary btn-sm" href="'.Url::toRoute(['module/index', 'id'=>$model->CuitMoon_ModuleID ]) .'"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>二级菜单</a>';
                                        }

                                        echo '      <a id="view_btn" onclick="viewAction(\'' . $model->CuitMoon_ModuleID . '\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        // echo '      <a id="edit_btn" onclick="editAction(\'' . $model->CuitMoon_ModuleID  . '\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        // echo '      <a id="delete_btn" onclick="deleteAction(\'' . $model->CuitMoon_ModuleID  . '\')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
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


<!-- 查看编程题-->
<div class="modal fade" id="option_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 id="option_title"></h3>
            </div>
            <div class="modal-body ">

                <?php $form = ActiveForm::begin(["id" => "option_form", "class"=>"form-horizontal"]); ?>
                <div class="input-group" >
                    <input type="hidden" class="form-control option_input " id="CuitMoon_ModuleID" name="TbcuitmoonModule[CuitMoon_ModuleID]"/>        
                </div>
                <div class="input-group" >
                <input type="hidden" class="form-control option_input" id="CuitMoon_ParentModuleID" name="TbcuitmoonModule[CuitMoon_ParentModuleID]"/>
                </div>
                <div class="input-group" >
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;&nbsp;U&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" class="form-control option_input" id="CuitMoon_ModuleURL" name="TbcuitmoonModule[CuitMoon_ModuleURL]">
                </div>
                <br>
                <div class="input-group" >
                    <span class="input-group-addon">&nbsp;模&nbsp;块&nbsp;名&nbsp;称&nbsp;</span>
                    <input type="text" class="form-control option_input" id="CuitMoon_ModuleName" name="TbcuitmoonModule[CuitMoon_ModuleName]">
                </div>
                <br>
                <div class="input-group" >
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;描&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;述&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" class="form-control option_input" id="CuitMoon_ModuleDescription" name="TbcuitmoonModule[CuitMoon_ModuleDescription]">
                </div>
                <br>
                <div class="input-group" >
                    <span class="input-group-addon">&nbsp;&nbsp;&nbsp;备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" class="form-control option_input" id="CuitMoon_ModuleRemarks" name="TbcuitmoonModule[CuitMoon_ModuleRemarks]"  >
                </div>
                <br>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="option_save"></button>
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
        $('#option_save').text('保存');
        $('#option_title').text('查看模块信息');
        initModel(id, true, 'fun');
    }

    function initEditSystemModule(data, flag){

        $('#option_modal').modal('show');
        $('#option_save').attr('disabled',flag);
        $('.option_input').each(function(){
            $(this).attr('disabled',flag);
            $(this).val('');

        });
        var st = "<?=$id;?>";
        if(st)
        {
            $('#CuitMoon_ParentModuleID').val(st);
            // alert($('#CuitMoon_ParentModuleID').val());
        }
        if(data)
            for(var key in data)
                $('#'+key).val(data[key]);
        
    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('module/view')?>",
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

    // function editAction(id){
    //     $('#option_form').attr('action',"<?=Url::toRoute('module/update')?>");
    //     $('#option_title').text('修改模块信息');
    //     $('#option_save').text('修改');
    //     initModel(id, false);
    // }

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
                    url: "<?=Url::toRoute('admin-module/delete')?>",
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
        $('#option_form').attr('action',"<?=Url::toRoute('module/create')?>");
        e.preventDefault();
        $('#option_save').text('保存');
        $('#option_title').text('添加模块信息');
        initEditSystemModule({}, false);
    });
    $('#option_save').click(function(){
        $('#option_form').ajaxSubmit(function(res){
            alert(res);
            document.location.reload();
        })
    })
    

    // $('#admin-module-form').bind('submit', function(e) {
    //     e.preventDefault();
    //     var id = $("#id").val();
    //     var action = id == "" ? "<?=Url::toRoute('module/create')?>" : "<?=Url::toRoute('module/update')?>";
    //     $(this).ajaxSubmit({
    //         type: "post",
    //         dataType:"json",
    //         url: action,
    //         data:{"CuitMoon_ModuleID":id,"TbcuitmoonModule[CuitMoon_ParentModuleID]":"<?=$id?>"},
    //         success: function(value)
    //         {
    //             if(value.error == 0){
    //                 $('#edit_dialog').modal('hide');
    //                 admin_tool.alert('msg_info', '添加成功', 'success');
    //                 window.location.reload();
    //             }
    //             else{
    //                 var json = value.data;
    //                 for(var key in json){
    //                     $('#' + key).attr({'data-placement':'bottom', 'data-content':json[key], 'data-toggle':'popover'}).addClass('popover-show').popover('show');

    //                 }
    //             }

    //         }
    //     });
    // });


</script>
<?php $this->endBlock(); ?>