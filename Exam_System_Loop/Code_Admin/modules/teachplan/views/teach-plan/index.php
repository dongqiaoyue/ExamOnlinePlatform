
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
                    <h3 class="box-title">计划班列表</h3>
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
                        <div class="row">
                            <div class="col-sm-9">
                                <select class="form-control" id="term-choice">
                                    <option value="0">全部</option>
                                    <?php foreach ($term as $model) {?>
                                        <option value="<?=$model['CuitMoon_DictionaryName']?>" <?php if($model['CuitMoon_DictionaryName'] == $now_term && Yii::$app->request->get('term') == ""){?>selected="selected" <?php }?>><?=$model['CuitMoon_DictionaryName']?></option>
                                    <?php }?>
                                </select>

                                <select class="form-control" id="type-choice">
                                    <option value="all">全部</option>
                                    <option value="1">教学班级</option>
                                    <option value="0">期末考试班级</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <?php ActiveForm::begin(['id' => 'teach-plan-search-form', 'method'=>'get', 'options' => ['class' => 'form-inline'], 'action'=>Url::toRoute('teach-plan/index')]); ?>

                                <div class="form-group" style="margin: 5px;">
                                    <label>教学班名称:</label>
                                    <input type="text" class="form-control" id="search-value" name="search" >
                                </div>
                                <div class="form-group">
                                    <a onclick="searchAction()" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>搜索</a>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                        <!-- row start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                    <thead>
                                    <tr role="row">

                                        <?php
                                        echo '<th><input id="data_table_check" type="checkbox"></th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >教学班名称</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >院系名称</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >教师姓名</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >课程名</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >学期</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($list as $model) {
                                        $id = $model->TeachingClassID;
                                        echo '<tr id="rowid_' . $model->TeachingClassID . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model->TeachingClassID . '"></label></td>';
                                        echo '  <td>' . $model->TeachingName . '</td>';
                                        echo '  <td>' . $model->Department . '</td>';
                                        echo '  <td>' . $model->TeacherName. '</td>';
                                        echo '  <td>' . $CourseName . '</td>';
                                        echo '  <td>' . $model->Term . '</td>';
                                        echo '  <td class="center">';
                                        echo '      <a id="view_btn" class="btn btn-primary btn-sm" href="'.Url::toRoute(['teach-plan/student', 'classId'=>$model->TeachingClassID]).'"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>学生列表</a>';
                                        echo '      <a id="view_btn" onclick="viewAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        echo '      <a id="edit_btn" onclick="changeTeacher(' . "'$id'"  . ')" class="btn btn-warning btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>赠送班级</a>';
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
                <h3>计划班</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]); ?>

                <input type="hidden" class="form-control" id="id" name="id" />


                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">教学班</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="TeachingName" name="Teachingclassmannage[TeachingName]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="term_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">选择学院</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="Teachingclassmannage[Department]" id="Department">
                            <?php
                            foreach($college as $key=>$data){
                                echo "<option value='" . $data['CuitMoon_DictionaryName'] . "'>". $data['CuitMoon_DictionaryName']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div id="term_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">学期</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="Teachingclassmannage[Term]" id="Term">
                            <?php
                            foreach($term as $key=>$data){
                                echo "<option value='" . $data['CuitMoon_DictionaryName'] . "'>". $data['CuitMoon_DictionaryName']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="remarks_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="Memo" name="Teachingclassmannage[Memo]" collapse="3"></textarea>
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

<div class="modal fade" id="change_teacher_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>选择要赠送的老师</h3>
            </div>
            <div class="modal-body">
                <select name="user" class="form-control " id="change_user">
					<?php foreach ($teacher as $value){?>
                        <option value="<?=$value['CuitMoon_UserName']?>"><?=$value['CuitMoon_UserRealName']?></option>
                    <?php }?>
				</select>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="change_teacher_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>
    var global_class;
    function changeTeacher(id){
        $('#change_teacher_modal').modal('show');
        global_class = id;
    }
    $('#change_teacher_ok').click(function(){
        $.ajax({
            type: "POST",
            url: "<?=Url::toRoute('teach-plan/change-class-teacher')?>",
            data: {"id":global_class,"teacher":$('#change_user').val()},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                window.location.reload();
            },
            success: function(res){
                window.location.reload();
            }
        });
    })
    function searchAction(){
       $('#teach-plan-search-form').submit();
    }
    function viewAction(id){
        initModel(id, 'view', 'fun');
    }

    $(function (){
        if('<?=\Yii::$app->request->get('term');?>' == ""){
            var Tmp = $('#term-choice').val();
            window.location.href = '<?=Url::toRoute('teach-plan/index')?>'+'&term='+Tmp;
        }
    });
    $('#term-choice').change(function () {
        var Tmp = $(this).val();
        window.location.href = '<?=Url::toRoute('teach-plan/index')?>'+'&term='+Tmp;
    });

    $('#type-choice').change(function () {
        var Tmp = $(this).val();
        window.location.href = '<?=Url::toRoute('teach-plan/index')?>'+'&term='+$('#term-choice').val()+'&type='+Tmp;
    });

    $(document).ready(function () {
        var term = '<?=$term_choice?>';
        var type = '<?=$type_choice?>';
        $('#term-choice option[value="<?=$term_choice?>"]').attr("selected","selected");
        $('#type-choice option[value="<?=$type_choice?>"]').attr("selected","selected");
    });

    function initEditSystemModule(data, type){
        $('#edit_dialog').modal('show');
        if(type == 'create'){
            $("#TeachingName").val('');
            $("#Term").val('');
            $("#CourseID").val('');
            $("#TeacherName").val('');
            $("#Department").val('');
            $("#Memo").val('');
        }
        else{
            $("#TeachingName").val(data['TeachingName']);
            $("#Term").val(data['Term']);
            $("#CourseID").val(data['CourseID']);
            $("#TeacherName").val(data['TeacherName']);
            $("#Department").val(data['Department']);
            $("#Memo").val(data['Memo']);
            $("#id").val(data['TeachingClassID']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#TeachingName").attr({readonly:true,disabled:true});
            $("#Term").attr({readonly:true,disabled:true});
            $("#CourseID").attr({readonly:true,disabled:true});
            $("#TeacherName").attr({readonly:true,disabled:true});
            $("#Department").attr({readonly:true,disabled:true});
            $("#Memo").attr({readonly:true,disabled:true});
        }
        else{
            $("#TeachingName").attr({readonly:false,disabled:false});
            $("#Term").attr({readonly:false,disabled:false});
            $("#CourseID").attr({readonly:false,disabled:false});
            $("#TeacherName").attr({readonly:false,disabled:false});
            $("#Department").attr({readonly:false,disabled:false});
            $("#Memo").attr({readonly:false,disabled:false});
            $('#edit_dialog_ok').removeClass('hidden');
        }

    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('teach-plan/view')?>",
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
                    url: "<?=Url::toRoute('teach-plan/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        alert("出错了，" + textStatus);
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



    $('#edit_dialog_ok').click(function (e) {
        e.preventDefault();
        $('#admin-role-form').submit();
    });

    $('#create_btn').click(function (e) {
        e.preventDefault();
        initEditSystemModule({}, 'create');
    });

    // $('#delete_btn').click(function (e) {
    //     e.preventDefault();
    //     deleteAction('');
    // });

    $('#admin-role-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        var action = id == "" ? "<?=Url::toRoute('teach-plan/create')?>" : "<?=Url::toRoute('teach-plan/update')?>";
        console.log(action);
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: action,
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


</script>
<?php $this->endBlock(); ?>
