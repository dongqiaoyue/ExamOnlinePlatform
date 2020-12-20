<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$m_know = new \app\models\question\Knowledgepoint();
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
                        <h3 class="box-title">判断题列表</h3>
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
                                    <select class="form-control" id="stage-choice">
                                        <?php if(isset($stageChoice['stage'])){?>
                                            <?php foreach ($stage as $model){?>
                                                <?php if($model->CuitMoon_DictionaryCode == $stageChoice['stage']){?>
                                                    <option value="<?=$model->CuitMoon_DictionaryCode?>" selected="selected"><?=$model->CuitMoon_DictionaryName?></option>
                                                <?php }else{?>
                                                    <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                                <?php }?>
                                            <?php }?>
                                        <?php }else{?>
                                            <option value="0">全部阶段</option>
                                            <?php foreach ($stage as $model){?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }}?>
                                        >
                                    </select>
                                    <select class="form-control" id="knowledgepoint-choice">
                                            <option value="0">全部知识点</option>
                                            <?php foreach ($knowledgepoint as $key => $value){?>
                                                <option value="<?=$value['KnowledgeBh']?>" ><?=$value['KnowledgeName']?></option>
                                            <?php }?>
                                        >
                                    </select>
                                    <div class="input-group">
                                       <span class="input-group-addon">搜索：</span>
                                       <input type="text" id="search" placeholder="支持题编号，名字"/>
                                    </div>
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
                                            echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >自定义题号</th>';
                                            echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目名称</th>';
                                            echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >知识点</th>';
                                            echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >所属阶段</th>';
                                            echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >添加时间</th>';
                                            echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >最后修改时间</th>';


                                            ?>

                                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                        </tr>
                                        </thead>
                                        <tbody id="program_info">
                                        <?php

                                       foreach ($list as $model) {
                                            $id = $model['QuestionBh'];
                                            echo '<tr id="rowid_' . $model->QuestionBh. '">';
                                            echo '  <td><label><input type="checkbox" value="' . $model->QuestionBh . '"></label></td>';
                                            echo '  <td>' . $model->CustomBh . '</td>';
                                            echo '  <td>' . $model->name . '</td>';
                                            echo '  <td>' . $m_know->idTranName($model->KnowledgeBh). '</td>';
                                            echo '  <td>' . $com->codeTranName($model->Stage) . '</td>';
                                            echo '  <td>' . $model->AddTime . '</td>';
                                            echo '  <td>' . $model->UpdateTime . '</td>';

                                            echo '  <td class="center">';

                                            //echo '      <a id="view_btn" onclick="viewAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                            echo '      <a id="edit_btn" onclick="editAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';

                                            echo $model->Score ? '      <a onclick="IsSee(\'' . $model->QuestionBh. '\',this)" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-ok-circle icon-white"></i>已公开</a>' : '      <a onclick="IsSee(\'' . $model->QuestionBh. '\',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>公开</a>';
                                            echo $model->Checked=='100001' ? '      <a onclick="Checked(\'' . $model->QuestionBh. '\',this)" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-ok-circle icon-white"></i>已审核</a>' : '      <a onclick="Checked(\'' . $model->QuestionBh. '\',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>审核</a>';
                                            echo '      <a id="delete_btn" onclick="deleteAction(' . "'$id'" . ',this)" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';

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
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dataTables_info" id="data_table_info" role="status" aria-live="polite">
                                        <div class="infos">
                                            从<?= $pages->getPage() * $pages->getPageSize() + 1 ?>                   到 <?= ($pageCount = ($pages->getPage() + 1) * $pages->getPageSize()) < $pages->totalCount ?  $pageCount : $pages->totalCount?>                   共 <?= $pages->totalCount?> 条记录</div>
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
                    <h3>判断题</h3>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]); ?>

                    <input type="hidden" class="form-control" id="id" name="id" />


                    <div id="name_div" class="form-group">
                        <label for="name" class="col-sm-2 control-label">题目名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="Questions[name]" placeholder="必填" />
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="name_div" class="form-group">
                        <label for="name" class="col-sm-2 control-label">编号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="code" name="Questions[CustomBh]" placeholder="必填" />
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="college_div" class="form-group">
                        <label for="des" class="col-sm-2 control-label">所属阶段</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Questions[Stage]" id="stageChoice">
                                <?php foreach ($stage as $model){?>
                                    <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="des_div" class="form-group">
                        <label for="des" class="col-sm-2 control-label">知识点</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Questions[KnowledgeBh]" id="knowledgeChoice">
                                <?php foreach ($defaultKnow as $model){?>
                                    <option value="<?=$model['KnowledgeBh']?>"><?=$model['KnowledgeName']?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="des_div" class="form-group">
                        <label for="des" class="col-sm-2 control-label">题目难度</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Questions[Difficulty]" id="controller">
                                <?php foreach ($dif as $model){?>
                                    <option value="<?=$model->CuitMoon_DictionaryCode?>"><?=$model->CuitMoon_DictionaryName?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="remarks_div" class="form-group">
                        <label for="des" class="col-sm-2 control-label">题目描述</label>
                        <div class="col-sm-10">
                          <script type="text/plain" id="container" name="Questions[Description]"></script>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div id="des_div" class="form-group">
                        <label for="des" class="col-sm-2 control-label">题目答案</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" id="inlineCheckbox0" value="0" name="Questions[Answer]"> 错
                            </label>
                            <label class="radio-inline">
                                <input type="radio" id="inlineCheckbox1" value="1" name="Questions[Answer]"> 对
                            </label>

                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div id="remarks_div" class="form-group">
                        <label for="des" class="col-sm-2 control-label">备注</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="des" name="Questions[Memo]" collapse="3"></textarea>
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


    <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
    <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
    <script type="text/javascript">
        //ueditor编辑器
        var ue = UE.getEditor('container');
    </script>
    <script>

        $("#search").on("input propertychange",function(){
        var key = $(this).val();
        $('#data_table_info').parent().parent().empty();
        $.post(
            "<?=Url::toRoute('judgement/search-judgement')?>",
            {
                key:key,
            },
            function(res)
            {
                var html = '';
                for(var key in res)
                {
                    html += '<tr id="rowid_'+res[key].QuestionBh+'">'+
                    '<td><label><input type="checkbox" value="'+res[key].QuestionBh+'"></label></td>'+
                    '<td>'+res[key].CustomBh+'</td>'+
                    '<td>'+res[key].name+'</td>'+
                    '<td>'+res[key].KnowledgeBh+'</td>'+
                    '<td>'+res[key].Stage+'</td>'+
                    '<td class="center"><button id="view_btn" onclick="viewAction(\''+res[key].QuestionBh+'\')" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</button>'+
                    '<a id="edit_btn" onclick="editAction(\''+res[key].QuestionBh+'\')" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                    html += res[key].Score=='1' ? '<a onclick="IsSee(\''+res[key].QuestionBh+'\',this)" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-ok-circle icon-white"></i>已公开</a>' : '<a onclick="IsSee(\''+res[key].QuestionBh+'\',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>公开</a>';
                    html += res[key].Checked=='100001' ? '<a onclick="Checked(\''+res[key].QuestionBh+'\',this)" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-ok-circle icon-white"></i>已审核</a>' : '<a onclick="Checked(\''+res[key].QuestionBh+'\',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>审核</a>';
                    html += '<a onclick="deleteAction(\''+res[key].QuestionBh+'\')" class="btn btn-danger btn-sm"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a></td></tr>';
                }
                $('#program_info').html(html);
            },
            'json'
            )
    })
        //阶段选择
        // $('#stage-choice').change(function () {
        //     var Tmp = $(this).val();
        //     window.location.href = '<?=Url::toRoute('judgement/index')?>'+'&stage='+Tmp;
        // })

        $('#stage-choice').change(function () {
            var Tmp = $(this).val();
            var know = $("#knowledgepoint-choice").val();
            var url = '<?=Url::toRoute('judgement/index')?>';

            if(Tmp != 0)
                url += '&stage='+Tmp;
            if(know != 0)
                url += '&knowledgeBh='+know;
            window.location.href = url;
        })
        $('#knowledgepoint-choice').change(function () {
            var know = $(this).val();
            var Tmp = $('#stage-choice').val();
            var url = '<?=Url::toRoute('judgement/index')?>';

            if(Tmp != 0)
                url += '&stage='+Tmp;
            if(know != 0)
                url += '&knowledgeBh='+know;
            window.location.href = url;
            // window.location.href = '<?=Url::toRoute('choice/index')?>'+'&stage='+Tmp+'&knowledgeBh='+know;
        })


        $('#stageChoice').change(function () {
        var stageId = $(this).val();
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('knowledge/knowledge-list')?>',
            data:{stageId:stageId},
            catch:false,
            dataType:'json',
            success:function (value) {
                $('#knowledgeChoice').empty();
                for(var Tmp in value){
                    $('#knowledgeChoice').append("<option value='"+ value[Tmp]['KnowledgeBh'] +"'>"+ value[Tmp]['KnowledgeName'] +"</option>")
                }
            }
        })
    })

        function IsSee(id,me)
        {
            // var me = $(this);
            // alert($(me).html());
            $.post(
                "<?=Url::toRoute('program/change-see')?>",
                {
                    QuestionBh:id,
                },
                function(res){
                    if(res == '1')
                    {
                        $(me).attr('class','btn btn-primary  btn-sm');

                        $(me).html('<i class="glyphicon glyphicon-ok-circle icon-white"></i>已公开');
                    }
                    else
                    {
                        $(me).attr('class','btn btn-danger btn-sm');
                        $(me).html('<i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>公开');
                    }
                },'text')
        }
        function Checked(id,me)
        {
            $.post(
                "<?=Url::toRoute('program/change-checked')?>",
                {
                    QuestionBh:id,
                },
                function(res){
                    if(res == '100001')
                    {
                        $(me).attr('class','btn btn-primary  btn-sm');

                        $(me).html('<i class="glyphicon glyphicon-ok-circle icon-white"></i>已审核');
                    }
                    else
                    {
                        $(me).attr('class','btn btn-danger btn-sm');
                        $(me).html('<i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>审核');
                    }
                },'text')
        }
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
                $("#stageChoice").val('');
                $("#knowledgeChoice").val('');
                $("#controller").val('');
                $("#container").val('');
                $("#des").val('');
                $("#create_user").val('');
                $("#create_date").val('');
                $("#update_user").val('');
                $("#update_date").val('');

            }
            else{
                $("#id").val(data['QuestionBh']);
                $("#code").val(data['CustomBh']);
                $("#name").val(data.name);
                $("#stageChoice").val(data['Stage']);
                $("#knowledgeChoice").val(data['KnowledgeBh']);
                $("#controller").val(data['Difficulty']);
                $("#container").val(data['Description']);
                $("#des").val(data['Memo']);
                // alert('#inlineCheckbox'+data['Answer']);
                $('#inlineCheckbox'+data['Answer'].trim()).attr('checked','checked');
                $("#create_user").val(data.create_user);
                $("#create_date").val(data.create_date);
                $("#update_user").val(data.update_user);
                $("#update_date").val(data.update_date);

            }
            if(type == "view"){
                $("#id").attr({readonly:true,disabled:true});
                $("#code").attr({readonly:true,disabled:true});
                $("#name").attr({readonly:true,disabled:true});
                $("#stageChoice").attr({readonly:true,disabled:true});
                $("#knowledgeChoice").attr({readonly:true,disabled:true});
                $("#controller").attr({readonly:true,disabled:true});
                $("#container").attr({readonly:true,disabled:true});
                $("#des").attr({readonly:true,disabled:true});
                $("#create_user").attr({readonly:true,disabled:true});
                $("#create_user").parent().parent().show();
                $("#create_date").attr({readonly:true,disabled:true});
                $("#create_date").parent().parent().show();
                $("#update_user").attr({readonly:true,disabled:true});
                $("#update_user").parent().parent().show();
                $("#update_date").attr({readonly:true,disabled:true});
                $("#update_date").parent().parent().show();
                $('#edit_dialog_ok').addClass('hidden');
            }
            else{
                $("#id").attr({readonly:false,disabled:false});
                $("#code").attr({readonly:false,disabled:false});
                $("#name").attr({readonly:false,disabled:false});
                $("#stageChoice").attr({readonly:false,disabled:false});
                $("#knowledgeChoice").attr({readonly:false,disabled:false});
                $("#controller").attr({readonly:false,disabled:false});
                $("#container").attr({readonly:false,disabled:false});
                $("#des").attr({readonly:false,disabled:false});
                $("#create_user").attr({readonly:false,disabled:false});
                $("#create_user").parent().parent().hide();
                $("#create_date").attr({readonly:false,disabled:false});
                $("#create_date").parent().parent().hide();
                $("#update_user").attr({readonly:false,disabled:false});
                $("#update_user").parent().parent().hide();
                $("#update_date").attr({readonly:false,disabled:false});
                $("#update_date").parent().parent().hide();
                $('#edit_dialog_ok').removeClass('hidden');
            }
            $('#edit_dialog').modal('show');
        }

        function initModel(id, type, fun){

            $.ajax({
                type: "GET",
                url: "<?=Url::toRoute('judgement/view')?>",
                data: {"id":id},
                cache: false,
                dataType:"json",
                error: function (xmlHttpRequest, textStatus, errorThrown) {
                    alert("出错了，" + textStatus);
                },
                success: function(data){

                    console.log(data);

                     UE.getEditor('container').setContent(data['Description']);
                //UE.getEditor('NewsContent').attr({readonly:true,disabled:true});
                if(type=='view') {
                    UE.getEditor('container').setDisabled();

                }else{
                    UE.getEditor('container').setEnabled();

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
                        url: "<?=Url::toRoute('judgement/delete')?>",
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
            $('#admin-role-form').submit();
        });

        $('#create_btn').click(function (e) {
            e.preventDefault();
            window.location.href = "<?=Url::toRoute('judgement/add')?>"
        });

        $('#delete_btn').click(function (e) {
            e.preventDefault();
            deleteAction('');
        });



        $('#admin-role-form').bind('submit', function(e) {
            e.preventDefault();
            var id = $("#id").val();
            var action = id == "" ? "<?=Url::toRoute('judgement/create')?>" : "<?=Url::toRoute('judgement/update')?>";
            $(this).ajaxSubmit({
                type: "post",
                dataType:"json",
                url: action,
                // data:{id:id},
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
