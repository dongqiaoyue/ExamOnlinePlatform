
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
                    <h3 class="box-title">考试模块配置</h3>
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
                            <select class="form-control" id="resources-choice">
                                <option value="0">全部资源</option>
                                <option value="1000801">学习文档</option>
                                <option value="1000802">ppt资源</option>
                                <option value="1000803">视频资源</option>
                            </select>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'模版名称'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'配置人'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'配置时间'.'</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $row = 0;
                                    foreach ($info as $model) {
                                        echo '<tr id="rowid_' . $model->BH . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->BH . '"></label></td>';
                                        echo '  <td>' . $model->PaperName. '</td>';
                                        echo '  <td>' . $model->AddBy . '</td>';
                                        echo '  <td>' . $model->AddAt . '</td>';
                                        echo '  <td class="center">';
                                        echo '      <a id="view_btn" onclick="viewAction(' . "'$model->BH'". ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editNameAction(' . "'$model->BH'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改模块名称</a>';
                                        echo '      <a id="delete_btn" onclick="deleteAction(' . "'$model->BH'"  . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
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

<div class="modal fade bs-example-modal-lg" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>模块详情</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered">
                            <tr>
                                <td>模板名称:</td>
                                <td id="view-name"></td>
                                <td>配置人:</td>
                                <td id="view-teacher"></td>
                            </tr>
                            <tr>
                                <td>资源名:</td>
                                <td id="view-item"></td>
                                <td>时间:</td>
                                <td id="view-time"></td>
                            </tr>
                            <tr>
                                <td>试卷总分:</td>
                                <td id="view-totalScore"></td>
                                <td>试卷题数:</td>
                                <td id="view-number"></td>
                            </tr>
                            <tr id="view-detail">
                                <th>题型</th>
                                <th>题目数量</th>
                                <th>所占分值</th>
                                <th>题目难度</th>
                                <th>知识点</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="editName_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
        <?php $form = ActiveForm::begin(["id" => "admin-moduleName-form", "class"=>"form-horizontal"]);  ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>请输入新名称</h3>
            </div>
            <div class="modal-body">
                <input type="text" name="newModleName" id="newModleName" class="form-control">
            </div>
            <input type="text" name="editName_ExamConfigRecordID" id="editName_ExamConfigRecordID" value="" style="display:none">
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
                <a  id="editName_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
            <?php ActiveForm::end(); ?>
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

    function initModel(id, type, fun){
        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('exam-module/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了，" + textStatus);
            },
            success: function(data){
                console.log(data)
                $('#view-name').text(data['tmp']['PaperName']);
                $('#view-teacher').text(data['tmp']['AddBy']);
                $('#view-totalScore').text(data['totalScore']);
                $('#view-item').text(data['tmp']['ResourcesID']);
                $('#view-time').text(data['tmp']['AddAt']);
                $('#view-number').text(data['totalNumber']);
                $('tr[name="class"]').each(function (e) {
                    $(this).remove();
                })
                for(var tmp in data['data']){
                    $('#view-detail').after('<tr name="class"><td>'+ data['data'][tmp]['QuestionType'] +'</td>' +
                        '<td>'+ data['data'][tmp]['QuestionTypeNumber'] +'</td>' +
                        '<td>'+ data['data'][tmp]['EveryQuestionScore'] +'</td>' +
                        '<td>'+ data['data'][tmp]['difficulty'] +'</td>' +
                        '<td>'+ data['data'][tmp]['KnowledgeName'] +'</td></tr>');
                }
                $('#edit_dialog').modal('show');
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
                    url: "<?=Url::toRoute('exam-module/delete')?>",
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
            alert('请先选择要删除的数据');
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

    function editNameAction(id){
        $("#editName_ExamConfigRecordID").val(id);
        $('#editName_dialog').modal('show');
    }

    $('#editName_dialog_ok').click(function (e) {
        e.preventDefault();
        $('#admin-moduleName-form').submit();
    });


    $('#create_btn').click(function (e) {
//        e.preventDefault();
//        initEditSystemModule({}, 'create');
        window.location.href = "<?=Url::toRoute('exam-module/add-view')?>";
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#resources-choice').change(function () {
        var Type = $('#resources-choice').val();
        window.location.href =  "<?=Url::toRoute('exam-module/index')?>&Type=" + Type;
    });

    $('#admin-module-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        var action = id == "" ? "<?=Url::toRoute('module/create')?>" : "<?=Url::toRoute('module/update')?>";
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
            data:{"CuitMoon_ModuleID":id},
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

    $('#admin-moduleName-form').bind('submit', function(e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: "<?= Url::toRoute('exam-module/update')?>",
            success: function(value)
            {
                $('#editName_dialog').modal('hide');
                admin_tool.alert('msg_info', '修改成功', 'success');
                alert(value);
                window.location.reload();
            },
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert( xmlHttpRequest.readyState+ textStatus);
                window.location.reload();
            }
        });
    });
</script>
<?php $this->endBlock(); ?>