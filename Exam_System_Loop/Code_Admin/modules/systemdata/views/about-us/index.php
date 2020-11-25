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
                    <h3 class="box-title">关于我们信息管理</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">添&nbsp;&emsp;加</button>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >标题</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >内容</th>';
                                        ?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($ab as $model) {
                                        $id = $model['aboutUsID'];
                                        echo '<tr id="rowid_' . $model['aboutUsID'] . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['aboutUsID'] . '"></label></td>';
                                        echo '  <td>' . $model['title'] . '</td>';
                                        echo '  <td>' . $model['info'] . '</td>';
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
                <h3>关于我们信息</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("about-us/index")]); ?>

<!--                <input type="hidden" class="form-control" id="id" name="id" />-->

                <div id="title_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="Title" name="aboutUs[title]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="info_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">信息内容</label>
                    <div class="col-sm-10">
                    <!-- <script type="text/plain" id="test_test" name="test_test" style="width:100%"></script> -->
                        <input type="text" class="form-control" id="test_test" name="test_test" placeholder="必填" />
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

<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    alert(1);
    var ue = UE.getEditor('test_test');
    $('#test_test').val('111');
    UE.getEditor('test_test').setContent('1111');
    alert(UE.getEditor('test_test').getContent());
</script>

<!--    <script type="text/javascript" src="--><?//=Url::base()?><!--/component/editor/ueditor.config.js"></script>-->
<!--<script type="text/javascript" src="--><?//=Url::base()?><!--/component/editor/ueditor.all.min.js"></script>-->
<!--<script>-->
<!--    //ueditor编辑器-->
<!--    var ue = UE.getEditor('test_test');-->
<!--</script>-->
<script>
    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#Title").val('');
            $("#Info").val('');
        }
        else{
            $("#Title").val(data['title']);
            $("#Info").val(data['info']);

            $("#id").val(data['aboutUsID']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#Title").attr({readonly:true,disabled:true});
            $("#Info").attr({readonly:true,disabled:true});

        }
        else{
            $("#Title").attr({readonly:false,disabled:false});
            $("#Info").attr({readonly:false,disabled:false});

            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }
function viewAction(id){
    initModel(id, type, fun);
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


    function initModel(id,type,fun){
    $.ajax({
        type:"GET",
        url:"<?=Url::toRoute("about-us/view")?>",
        data:{"id":id},
        dataType:"json",
        cache:false,
        error: function (xmlHttpRequest, textStatus, errorThrown) {
            alert("出错了，" + textStatus);
        },
        success:function (data) {

        }
    })
}

$('#admin-role-form').bind('submit', function(e) {
    e.preventDefault();
    var id = $("#id").val();
    var action = id == "" ?"<?=Url::toRoute('about-us/create')?>" : "<?=Url::toRoute('about-us/update')?>";
    console.log(action);
    $(this).ajaxSubmit({
        type: "post",
        dataType:"json",
        url: action,
        async: false,
        error: function (xmlHttpRequest, textStatus, errorThrown) {
            alert("出错了，" + textStatus);
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

    function deleteAction(id){
        var ids = [];
        if(!!id == true){
            ids[0] = id;
        }
        else{
            var checkboxs = $('#data_table :checked');
            if(checkboxs.size() > 0){
                var c = 0;
                for(var i = 0; i < checkboxs.size(); i++){
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
                    url: "<?=Url::toRoute('about-us/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        // alert("出错了，" + textStatus);
                        window.location.reload();
                    },
                    success: function(data){
                        for(var i = 0; i < ids.length; i++){
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

    </script>