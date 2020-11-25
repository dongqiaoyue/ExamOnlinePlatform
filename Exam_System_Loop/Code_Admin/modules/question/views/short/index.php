
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$m_know = new \app\models\question\Knowledgepoint();
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
                    <h3 class="box-title">简答题管理</h3>
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
                                    echo '<tr id="rowid_' . $model['QuestionBh']. '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['QuestionBh'] . '"></label></td>';
                                        echo '  <td>' . $model['CustomBh'] . '</td>';
                                        echo '  <td>' . $model['name'] . '</td>';
                                        echo '  <td>' . $m_know->idTranName($model['KnowledgeBh']). '</td>';
                                        echo '  <td>' . $com->codeTranName($model['Stage']) . '</td>';
                                        echo '  <td>' . $model->AddTime . '</td>';
                                        echo '  <td>' . $model->UpdateTime . '</td>';
                                        

                                        echo '  <td class="center">';

                                        echo '      <a id="view_btn" onclick="viewAction(\'' . $model->QuestionBh .'\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        if($model['Score']=='0'){
                                            echo '      <a id="release_btn" onclick="IsSee(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>发布</a>';
                                        }
                                        else{
                                            echo '      <a id="release_btn" onclick="IsSee(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>取消发布</a>';
                                        }
                                        if($model['Checked']=='100001'){
                                            echo '      <a id="check_btn" onclick="checked(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>已审核</a>';
                                        }
                                        else{
                                            echo '      <a id="check_btn" onclick="checked(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>审核</a>';
                                        }
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
                <h3>简答题</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("short/view")]); ?>

                <input type="hidden" class="form-control" id="id" name="id" />

                <div id="Name_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">自定义题号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="short_CustomBh" name="Questions[CustomBh]" placeholder="必填">
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;所&nbsp;属&nbsp;阶&nbsp;段&nbsp;</span>
                    <select class="form-control" id="short_StageCode" value="0" name="Questions[Stage]">

                        <?php foreach ($stage as $model){?>
                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="clearfix"></div>

                <br>
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;&nbsp;知&nbsp;&nbsp;&nbsp;识&nbsp;&nbsp;&nbsp;点&nbsp;&nbsp;</span>
                    <select class="form-control" id="short_KnowledgeBhCode" value="0" name="Questions[KnowledgeBh]">

                    </select>
                </div>
                <div class="clearfix"></div>
                <br>

                <div class="input-group  col-sm-2" style="float: left;" ></div>
                <!-- <br> -->
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;是&nbsp;否&nbsp;公&nbsp;开&nbsp;</span>
                    <select class="form-control" id="short_IsSee" value="0" name="Questions[Score]" >
                        <!-- name="IsSee" -->
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>

                <div class="input-group col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;题&nbsp;目&nbsp;难&nbsp;度&nbsp;</span>
                    <select class="form-control" id="short_DifficultyCode" value="0" name="Questions[Difficulty]">
                        <?php foreach ($dif as $model){?>
                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="clearfix"></div>


                <!--<div class="input-group  col-sm-2" style="float: left;" ><br></div>-->
                 <br>
                <div class="input-group col-sm-10" style="float: left;">
                    <span class="input-group-addon">&nbsp;题&nbsp;目&nbsp;名&nbsp;称&nbsp;</span>
                    <textarea class="form-control" id="short_name" name="Questions[name]" placeholder="必填"></textarea>
                </div>
                <div class="clearfix"></div>
                <br>


            <span class="input-group-addon">题目描述（必填）</span>
            <div class="input-group col-sm-12">
                <div class="input-group " >

                    <div type="text/plain" id="short_Description" name="Questions[Description]"  placeholder="必填"></div>
                </div>
            </div>
            <br>

                <span class="input-group-addon">简答题答案（必填）</span>
                <div class="input-group col-sm-12">
                    <div class="input-group " >

                        <div type="text/plain" id="short_Answer" name="Questions[Answer]"  placeholder=""></div>
                    </div>
                </div>
                <br>


            <div class="clearfix"></div>
            <br>
            <div class="input-group col-sm-5" style="float: left;">
                <span class="input-group-addon">&nbsp;备&nbsp;注&nbsp;信&nbsp;息&nbsp;</span>
                <textarea class="form-control" id="short_Memo" name="Questions[Memo]"></textarea>
            </div>
            <div class="clearfix"></div>
            <br>

                <?php ActiveForm::end(); ?>

            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
                <a id="edit_dialog_ok" href="#" class="btn btn-primary" onclick="answerAction()">确定</a>
            </div>
        </div>
    </div>


<?php $this->beginBlock('footer');  ?>
<!-- <body></body>������ -->
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    var global_i = 0;
    var ue = UE.getEditor('short_Description');
    var ue =  UE.getEditor('short_Answer');
    //alert(1);
   // var ue = UE.getEditor('short_Answer');
</script>
<script>

$("#search").on("input propertychange",function(){
    var key = $(this).val();
    $('#data_table_info').parent().parent().empty();
    $.post(
        "<?=Url::toRoute('short/search-program')?>",
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



//获取题目难度
    function diff(diffBh){
        var html = "";
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('short/diff')?>',
            data:{'diffBh':diffBh},
            async:false,
            dataType:'json',

            success:function(value){
                //alert(value['CuitMoon_DictionaryName']);
                    html += '<option value="'+ value['CuitMoon_DictionaryCode'] + '">'+ value['CuitMoon_DictionaryName']+'</option>';
                    have_diff=1;
                    $("#short_DifficultyCode").append(html);
            }
        })
    }
    //获取题目阶段
    function stage(stage){
        var html = "";
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('short/stage')?>',
            data:{'stage':stage},
            async:false,
            dataType:'json',

            success:function(value){
                /*alert(value['CuitMoon_DictionaryName']);*/
                html += '<option value="'+ value['CuitMoon_DictionaryCode'] + '">'+ value['CuitMoon_DictionaryName']+'</option>';
                $("#short_StageCode").append(html);
            }
        })
    }


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
            $("#short_CustomBh").val('');
            $("#short_StageCode").val('');
            $("#short_KnowledgeBhCode").val('');
            $("#short_IsSee").val('');
            $("#short_DifficultyCode").val('');
            $("#short_name").val('');
            $("#short_Description").val('');
            $("#short_Answer").val('');
        }
        else{
            $("#id").val(data['QuestionBh']);
            $("#short_CustomBh").val(data['CustomBh']);
            //$("#short_StageCode").val(data['StageCode']);
            $("#short_KnowledgeBhCode").val(data['KnowledgeBhCode']);
            $("#short_IsSee").val(data['Score']);
            //$("#short_DifficultyCode").val(data['DifficultyCode']);
            $("#short_name").val(data['name']);
           // $("#short_Answer").val(data['Answer']);
            $("#short_Description").val(data['Description']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#short_CustomBh").attr({readonly:true,disabled:true});
            $("#short_StageCod").attr({readonly:true,disabled:true});
            $("#short_KnowledgeBhCode").attr({readonly:true,disabled:true});
            $("#short_IsSee").attr({readonly:true,disabled:true});
            $("#short_DifficultyCode").attr({readonly:true,disabled:true});
            $("#short_name").attr({readonly:true,disabled:true});
            $("#short_Answer").attr({readonly:true,disabled:true});
            $("#short_Description").attr({readonly:true,disabled:true});
        }
        else{
            $("#short_CustomBh").attr({readonly:false,disabled:false});
            $("#short_StageCod").attr({readonly:false,disabled:false});
            $("#short_KnowledgeBhCode").attr({readonly:false,disabled:false});
            $("#short_IsSee").attr({readonly:false,disabled:false});
            $("#short_DifficultyCode").attr({readonly:false,disabled:false});
            $("#short_name").attr({readonly:false,disabled:false});
            $("#short_Answer").attr({readonly:false,disabled:false});
            $("#short_Description").attr({readonly:false,disabled:false});
            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }



    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('short/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了" + textStatus);
            },
            success: function(data){
                console.log(data);
                diff(data['Difficulty']);
                stage(data['Stage']);
                UE.getEditor('short_Description').setContent(data['Description']);
                UE.getEditor('short_Answer').setContent(data['Answer']);
                if(type=="view") {
                    UE.getEditor('short_Description').setDisabled();
                   UE.getEditor('short_Answer').setDisabled();
                }
                initEditSystemModule(data, type);
            }
        });

    }

    $('#stage-choice').change(function () {
        var Tmp = $(this).val();
        var know = $("#knowledgepoint-choice").val();
        var url = '<?=Url::toRoute('short/index')?>';

        if(Tmp != 0)
            url += '&stage='+Tmp;
        if(know != 0)
            url += '&knowledgeBh='+know;
        window.location.href = url;
    })
    $('#knowledgepoint-choice').change(function () {
        var know = $(this).val();
        var Tmp = $('#stage-choice').val();
        var url = '<?=Url::toRoute('short/index')?>';

        if(Tmp != 0)
            url += '&stage='+Tmp;
        if(know != 0)
            url += '&knowledgeBh='+know;
        window.location.href = url;
        // window.location.href = '<?=Url::toRoute('choice/index')?>'+'&stage='+Tmp+'&knowledgeBh='+know;
    })

    function IsSee(id){
        //alert(id);
        $.ajax({
            type: 'GET',
            url: '<?=Url::toRoute('short/see')?>',
            data: {"id": id},
            catch: false,
            async: false,
            dataType: 'json',
            success:function (value) {

                window.location.reload();
            }
        })
    }

    function checked(id){
        //alert(id);
        $.ajax({
            type: 'GET',
            url: '<?=Url::toRoute('short/check')?>',
            data: {"id": id},
            catch: false,
            async: false,
            dataType: 'json',
            success:function (value) {
                //alert();
                window.location.reload();
            }
        })
    }



    function getKnowledge(stageId)
    {
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('knowledge/knowledge-list')?>',
            data:{'stageId':stageId},
            catch:false,
            async : false,
            dataType:'json',
            success:function (value) {
                var html = '';
                for(var Tmp in value){
                    html += '<option value="'+ value[Tmp]['KnowledgeBh'] + '">'+ value[Tmp]['KnowledgeName']+'</option>';
                }
                $('#short_KnowledgeBhCode').html(html);

            }
        });
    }

    $("#short_StageCode").change(function(){
        getKnowledge($("#short_StageCode").val());
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
                    url: "<?=Url::toRoute('short/delete')?>",
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
        var action = id == "" ? "<?=Url::toRoute('short/create')?>" : "<?=Url::toRoute('short/update')?>";
        $(this).ajaxSubmit({
            type: "post",
            dataType: "json",
            url: action,
            // data:{id:id},
            success: function (value) {
                if (value.error == 0) {
                    $('#edit_dialog').modal('hide');
                    alert('添加成功');
                    window.location.reload();
                }
                else {
                    var json = value.data;
                    for (var key in json) {
                        $('#' + key).attr({
                            'data-placement': 'bottom',
                            'data-content': json[key],
                            'data-toggle': 'popover'
                        }).addClass('popover-show').popover('show');

                    }
                }

            }
        });
    });





</script>
<?php $this->endBlock(); ?>
