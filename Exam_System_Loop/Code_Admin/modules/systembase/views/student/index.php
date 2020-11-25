
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
                    <h3 class="box-title">学员信息管理</h3>
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

                        <div class="row">
                            <div class="col-sm-2">
                                <label>专业:&nbsp;</label>
                                <select class="form-control" id="major-choice">
                                    <option>请选择</option>
                                    <?php foreach ($class_list as $model) {?>
                                        <option value="<?=$model['MajorName']?>"><?=$model['MajorName']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>班级:&nbsp;</label>
                                <select class="form-control" id="class-choice">

                                </select>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'学号'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'姓名'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'性别'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'班级'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'图片是否上传'.'</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if(isset($list)) {
                                            $row = 0;
                                            foreach ($list as $model) {
                                                echo '<tr id="rowid_' . $model->StuNumber . '">';
                                                echo '  <td><label><input type="checkbox" value="' . $model->StuNumber . '"></label></td>';
                                                echo '  <td>' . $model->StuNumber . '</td>';
                                                echo '  <td>' . $model->Name . '</td>';
                                                echo '  <td>' . $model->Sex . '</td>';
                                                echo '  <td>' . $model->ClassName . '</td>';
                                                echo '  <td>' . $model->StudentPhoto . '</td>';
                                                echo '  <td class="center">';
                                                echo '      <a id="view_btn" onclick="viewAction(' . "'$model->StuNumber'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                                echo '      <a id="edit_btn" onclick="editAction(' . "'$model->StuNumber'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                                echo '      <a id="delete_btn_" onclick="deleteAction(' . "'$model->StuNumber'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                                echo '      <a id="delete_btn_" onclick="ResetPasswd(' . "'$model->StuNumber'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>重置密码</a>';
                                                echo '  </td>';
                                                echo '<tr/>';
                                            }
                                        }

                                        ?>


                                    </tbody>
                                    <!-- <tfoot></tfoot> -->
                                </table>
                            </div>
                        </div>
                        <!-- row end -->
                                                <?php if(isset($pages)){?>
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
                                                <?php }?>
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

<div class="modal fade" id="edit_student" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>学员基本信息查看</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "student-info", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]); ?>

                <input type="hidden" class="form-control" id="StudentNumber" name="StudentNumber" />

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">学号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="StuNumber" name="Studentinfo[StuNumber]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Name" name="Studentinfo[Name]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">证件号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ICNumber" name="Studentinfo[ICNumber]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-10">
                        &nbsp;&nbsp;<input type="radio"  id="Sex" name="Studentinfo[Sex]" value="男"/>男&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio"  id="Sex" name="Studentinfo[Sex]" value="女"/>女
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Password" name="Password" placeholder="默认为学号" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">班级</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ClassName" name="Studentinfo[ClassName]" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">学院</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="DepartmentName" name="Studentinfo[DepartmentName]" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">专业</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="MajorName" name="Studentinfo[MajorName]" />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="edit_student_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>

    $('#major-choice').change(function (e) {
        e.preventDefault();
        ajaxGetClass($(this).val(),false);
    });

    function ajaxGetClass(val,classId) {
        $.ajax({
            type:'get',
            url:'<?=Url::toRoute("student/get-major-class")?>',
            data:{major:val},
            dataType:"JSON",
            success:function (value) {
                $('#class-choice').empty();
                $('#class-choice').append('<option>请选择</option>')
                for(var Tmp in value){
                    if (value[Tmp]['ClassName'] == classId) {
                        $('#class-choice').append('<option selected="selected" value="'+ value[Tmp]['ClassName'] +'">'+ value[Tmp]['ClassName'] +'</option>');
                    } else {
                        $('#class-choice').append('<option value="'+ value[Tmp]['ClassName'] +'">'+ value[Tmp]['ClassName'] +'</option>');
                    }
                }
            }
        })
    }
    $('#class-choice').change(function (e) {
        e.preventDefault();
        window.location.href = '<?=Url::toRoute("student/index")?>'+'&major='+$("#major-choice").val()+'&class='+$(this).val();
    });
    $('#edit_student_ok').click(function(){
        
        $('#student-info').ajaxSubmit(function(res){
            alert(res);
            window.location.reload();
        })
    })
    $(document).ready(function () {
        var major = '<?=$choice["major"]?>';
        if (major != '') {
            $('#major-choice option[value='+ major +']').attr('selected','selected');
            ajaxGetClass('<?=$choice["major"]?>','<?=$choice["class"]?>');
        }
    });


    function searchAction(){
        $('#admin-module-search-form').submit();
    }
    function viewAction(id){
        initModel(id,'view','fun');
    }

    function ResetPasswd(id)
    {
        $.post(
            "<?=Url::toRoute('student/reset-passwd')?>",
            {
                StuNumber:id
            },
            function(res){
                alert(res);
            },
            'json'
            )
    }
    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#StuNumber").attr({readonly:false,disabled:false});

//            $('#id').val('');
            $("#StudentNumber").val('');
            $("#StuNumber").val('');
            $("#Name").val('');
            $("#ICNumber").val('');
            $("#DepartmentName").val('');
            $("#ClassName").val('');
            $("#MajorName").val('');
            $("#Password").val('');
        }
        else{
            $("#StuNumber").attr({readonly:true,disabled:false});
//            $('#id').val(data.StuNumber);
            $("#StudentNumber").val(data.StuNumber);
            $("#StuNumber").val(data.StuNumber);
            $("#Name").val(data.Name);
            $("#ICNumber").val(data.ICNumber);
            $("#DepartmentName").val(data.DepartmentName);
            $("#ClassName").val(data.ClassName);
            $("#MajorName").val(data.MajorName);
            $("input[value="+ data.Sex +"]").attr('checked','true');
            $("#Password").val('你并不能查看');
        }
        if(type == "view"){
            $("#StuNumber").attr({readonly:true,disabled:true});
            $("#Name").attr({readonly:true,disabled:true});
            $("#ICNumber").attr({readonly:true,disabled:true});
            $("#DepartmentName").attr({readonly:true,disabled:true});
            $("#ClassName").attr({readonly:true,disabled:true});
            $("#MajorName").attr({readonly:true,disabled:true});
            $("#Password").attr({readonly:true,disabled:true});
            $('#edit_student_ok').addClass('hidden');
        }
        else{
//            $("#StuNumber").attr({readonly:false,disabled:false});
            $("#Name").attr({readonly:false,disabled:false});
            $("#ICNumber").attr({readonly:false,disabled:false});
            $("#DepartmentName").attr({readonly:false,disabled:false});
            $("#ClassName").attr({readonly:false,disabled:false});
            $("#MajorName").attr({readonly:false,disabled:false});
            $("#Password").attr({readonly:false,disabled:false});
            $('#edit_student_ok').removeClass('hidden');
        }
        $('#edit_student').modal('show');
    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('//teachplan/teach-plan/view-student')?>",
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
        $('#student-info').attr('action',"<?=Url::toRoute('student/update')?>");
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
                    url: "<?=Url::toRoute('student/delete')?>",
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

    

    $('#create_btn').click(function (e) {
        $('.box-title').text('添加学生');
        $('#student-info').attr('action',"<?=Url::toRoute('student/add')?>");
        initEditSystemModule('','create');
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-module-form').bind('submit', function(e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: '<?=Url::toRoute('paper/create-paper')?>',
            data:{id:$('#teach-choice').val()},
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