
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\system\TbcuitmoonDictionary;
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
                    <h3 class="box-title">试卷详情</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <?php
                            echo '<button  onclick = "addquestion('."'$ids'".')" type="button" class="btn btn-xs btn-primary">添加题目</button>';
                                ?>
                            <button id="delete_btn" type="button" class="btn btn-xs btn-danger">批量删除</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
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
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题号</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目名字</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目描述</th>';
                                                ?>
                                                <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($question as $model) {
                                                $id = $model['QuestionBh'];
                                                echo '<tr style="height:100px !important; overflow:hidden !important;" id="rowid_' . $model['QuestionBh'] . '">';
                                                echo '  <td><label><input type="checkbox" value="' . $model['QuestionBh'] . '"></label></td>';
                                                echo '  <td>' . $model['CustomBh'] . '</td>';
                                                echo '  <td>' . $model['name'] . '</td>';
                                                echo '  <td style="display:block; height:70px !important; overflow:hidden; text-overflow:ellipsis;">' . $model['Description']. '</td>';
                                                echo '  <td class="center">';
                                                echo '      <a id="view_btn" onclick="viewAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
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
                                    <div class="col-sm-7">
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
                <h3>试卷题目详情</h3>
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("paper/index")]); ?>

                <input type="hidden" class="form-control" id="id" name="id" />

                <div id="ID_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">题号</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="CustomBh" name="Questions[CustomBh]" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">题目名字</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="name" name="Questions[name]" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Stage_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">题目阶段</label>
                    <div class="col-sm-10">
                        <select  class="form-control" id="Stage" name="Questions[Stage]">

                            <option value="all">请选择</option>
                            <?php
                            foreach($typeS as $key=>$data){
                                echo "<option value='" . $data->CuitMoon_DictionaryName . "'>". $data->CuitMoon_DictionaryName."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Descript_div" class="form-group">
                    <label for="des" id="timu" class="col-sm-2 control-label">题目详情</label>
                    <div class="col-sm-10">
                        <script type="text/plain" id="Description" name="Questions[Description]"></script>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="type_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">题目类型</label>
                    <div class="col-sm-10">
                        <select  class="form-control" id="QuestionType" name="Questions[QuestionType]">
                        <option value="all">请选择</option>
                        <?php
                        foreach($typeQ as $key=>$data){
                            echo "<option value='" . $data->CuitMoon_DictionaryName . "'>". $data->CuitMoon_DictionaryName."</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
                <a id="edit_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    var ue = UE.getEditor('Description');
</script>
<script>

    function searchAction(){
        $('#admin-role-search-form').submit();
    }
    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#CustomBh").val('');
            $("#name").val('');
            $("#Stage").val('');
            $("#Description").hide();
            $("#timu").hide();
            $("#QuestionType").val('');
        }
        else{
            $("#CustomBh").val(data['CustomBh']);
            $("#name").val(data['name']);
            $("#Stage").val(data['Stage']);
            $("#Description").val(data['Description']);
            $("#QuestionType").val(data['QuestionType']);
            alert(data['QuestionType']);
            $("#id").val(data['QuestionBh']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#CustomBh").attr({readonly:true,disabled:true});
            $("#name").attr({readonly:true,disabled:true});
            $("#Stage").attr({readonly:true,disabled:true});
            $("#Description").attr({readonly:true,disabled:true});
            $("#QuestionType").attr({readonly:true,disabled:true});

        }
        else{
            $("#CustomBh").attr({readonly:false,disabled:false});
            $("#name").attr({readonly:false,disabled:false});
            $("#Stage").attr({readonly:false,disabled:false});
            $("#Description").attr({readonly:false,disabled:false});
            $("#QuestionType").attr({readonly:false,disabled:false});

            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('paper/viewq')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了，" + textStatus);
            },
            success: function(data){
                console.log(data);
                UE.getEditor('Description').setContent(data['Description']);
                if(type=='view') {
                    UE.getEditor('Description').setDisabled();
                }
                initEditSystemModule(data, type);
            }
        });
    }


    function viewAction(id){
        initModel(id, 'view', 'fun');
    }
    function editAction(id){
        initModel(id, 'edit');
    }

    function addquestion(id){
        window.location.href = '<?=Url::toRoute("paper/addquestion")?>'+'&id='+id;
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
                    url: "<?=Url::toRoute('paper/deleteq')?>",
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



    $('#edit_dialog_ok').click(function (e) {
        e.preventDefault();
        $('#admin-role-form').submit();
    });

    $('#create_btn').click(function (e) {
        e.preventDefault();

    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-role-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        console.log(action);
        $(this).ajaxSubmit({
            type: "post",
            dataType:"json",
            url: "<?=Url::toRoute('paper/createq')?>",
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


</script>
<?php $this->endBlock(); ?>