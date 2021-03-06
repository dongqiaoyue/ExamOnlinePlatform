
<?php
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use app\models\phone\Tresourceexaminfo;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$m_know = new \app\models\question\Knowledgepoint;
$m_model = new \app\models\phone\Tresourceexaminfo;

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
                    <h3 class="box-title">学习视频资源管理</h3>
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
                                <label>学期:&nbsp;</label>
                                <select class="form-control" id="term-choice">
                                    <option value="0">全部学期</option>
                                    <?php if(isset($_GET['term'])){?>
                                        <?php foreach ($term as $model){?>
                                            <?php if($model->CuitMoon_DictionaryCode === $_GET['term']){?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" selected="selected"><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($term as $model){?>
                                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                        <?php }}?>
                                </select>

                                <label>阶段:&nbsp;</label>
                                <select class="form-control" id="stage-choice">
                                    <option value="0">全部阶段</option>
                                    <?php if(isset($_GET['stage'])){?>
                                        <?php foreach ($stage as $model){?>
                                            <?php if($model->CuitMoon_DictionaryCode === $_GET['stage']){?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" selected="selected"><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($stage as $model){?>
                                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                        <?php }}?>
                                </select>

                                <label>知识点:&nbsp;</label>
                                <select class="form-control" id="knowledgepoint-choice">
                                    <option value="0">全部知识点</option>
                                    <?php if(isset($_GET['knowledgeBh'])){?>
                                        <?php foreach ($knowledgepoint as $model){?>
                                            <?php if($model->KnowledgeBh === $_GET['knowledgeBh']){?>
                                                <option value="<?=$model->KnowledgeBh?>" selected="selected"><?=$model->KnowledgeName?></option>
                                            <?php }else{?>
                                                <option value="<?=$model->KnowledgeBh?>" ><?=$model->KnowledgeName?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        <?php foreach ($knowledgepoint as $model){?>
                                            <option value="<?=$model->KnowledgeBh?>" ><?=$model->KnowledgeName?></option>
                                        <?php }}?>

                                </select>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >自定义编号</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >视频名称</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >添加时间</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >添加人</th>';


                                        ?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="program_info">
                                    <?php
                                    foreach ($list as $model) {
                                        $id = $model['ID'];
                                        echo '<tr id="rowid_' . $model['ID']. '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['ID'] . '"></label></td>';
                                        echo '  <td>' . $model['CustomBh'] . '</td>';
                                        echo '  <td>' . $model['Name'] . '</td>';
                                        echo '  <td>' . $model->AddAt . '</td>';
                                        echo '  <td>' . $model->AddBy . '</td>';
                                        if($model['IsExam']==1){
                                            if($m=$m_model->isModel($id)){
                                                echo '      <td>'.$m['PaperName'].'</td>';
                                            }else{
                                                echo '      <td><font color="red">未配置测试模板</font></td>';
                                            }
                                        }else{
                                            echo '<td>不需要考核</td>';
                                        }

                                        echo '  <td class="center">';

                                        echo '      <a id="view_btn" onclick="viewAction(\'' . $model->ID .'\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                        echo '      <a id="edit_btn" onclick="editAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                                        if($model['IsPublish']=='1'){
                                            echo '      <a id="check_btn" onclick="IsPublish(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>已公开</a>';
                                        }
                                        else{
                                            echo '      <a id="check_btn" onclick="IsPublish(' . "'$id'"  . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>公开</a>';
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
                <h3>学习视频</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("video/view")]); ?>

                <input type="hidden" class="form-control" id="id" Name="id" />

                <div id="Name_div" class="form-group">
                    <label for="Name" class="col-sm-2 control-label">自定义编号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="video_CustomBh" name="Tresources[CustomBh]" placeholder="必填">
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div id="Name_div" class="form-group">
                    <label for="Name" class="col-sm-2 control-label">
                        <a id="video_url">预览视频</a>
                    </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="video_ResourcesURL" name="Tresources[ResourcesURL]" >
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <!--上传视频-->
                        <div id="mydialog" class="col-sm-4" >
                            <button id="upid">
                                更新视频
                            </button>
                        </div>
                        <!-- 进度条 -->
                        <div class="col-xs-4">
                            <div id="allProgress" class="progress progress-small">
                                <div class="progress-bar bg-yellow" id="myProgress" style="width: 0%;"></div>
                            </div>
                        </div>
                        <!--//-->
                    </div>
                </div>


                <br>
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;学&nbsp;期</span>
                    <select class="form-control" id="video_Term" value="0" name="Tresources[Term]">
                        <?php foreach ($term as $model){?>
                            <option id="<?=$model->CuitMoon_DictionaryCode?>" value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;所&nbsp;属&nbsp;阶&nbsp;段&nbsp;</span>
                    <select class="form-control" id="video_StageCode" value="0">
                        <?php foreach ($stage as $model){?>
                            <option id="<?=$model->CuitMoon_DictionaryCode?>" value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon" id="model1">&nbsp;模&nbsp;板&nbsp;配&nbsp;置&nbsp;</span>
                    <select size=1 name="BH" id="model">
                        <option value="0" selected>无</option>
                        <?php foreach ($mod as $value){ ?>
                        <option id="<?=$value->BH?>" value="<?=$value->BH?>"><?=$value->PaperName?></option><?php }?>
                    </select>
                    </span>
                </div>
                <div class="clearfix"></div>
                <br>
                <div  style="float: left;"  >
                    <span class="input-group-addon">&nbsp;&nbsp;知&nbsp;&nbsp;&nbsp;识&nbsp;&nbsp;&nbsp;点&nbsp;&nbsp;</span>
                    <span  id="video_KnowledgeBhCode" value="0" name="Tresources[KnowledgeBh]" >

                    </span>
                </div>
                <div class="clearfix"></div>
                <br>

                <!-- <br> -->
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;是&nbsp;否&nbsp;考&nbsp;核&nbsp;</span>
                    <select class="form-control" id="video_IsExam" value="0" name="Tresources[IsExam]" >
                        <!-- Name="IsExam" -->
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>

                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;前&nbsp;置&nbsp;资&nbsp;源&nbsp;</span>
                    <select class="form-control" id="video_BeforeID" value="0" name="Tresources[BeforeID]">
                        <option value="0" selected>无</option>
                        <?php foreach ($pr as $model){?>
                            <option id="<?=$model->ID?>" value="<?=$model->ID?>" ><?=$model->Name?></option>
                        <?php }?>
                    </select>
                </div>


                <div class="clearfix"></div>


                <!--<div class="input-group  col-sm-2" style="float: left;" ><br></div>-->
                <br>
                <div class="input-group col-sm-10" style="float: left;">
                    <span class="input-group-addon">&nbsp;视&nbsp;频&nbsp;标&nbsp;题&nbsp;</span>
                    <textarea class="form-control" id="video_Name" name="Tresources[Name]" placeholder="必填"></textarea>
                </div>
                <div class="clearfix"></div>
                <br>


                <span class="input-group-addon">视频描述</span>
                <div class="input-group col-sm-12">
                    <div class="input-group " >

                        <div type="text/plain" id="video_Description" name="Tresources[Description]"  placeholder="必填"></div>
                    </div>
                </div>
                <br>



                <div class="clearfix"></div>
                <br>

                <?php ActiveForm::end(); ?>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
                    <a id="edit_dialog_ok" href="#" class="btn btn-primary" onclick="ContentAction()">确定</a>
                </div>
            </div>
        </div>


        <?php $this->beginBlock('footer');  ?>
        <!-- <body></body>������ -->
        <script src="<?=Url::base()?>/fcup/fcup/js/jquery.fcup.js"></script>
        <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
        <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
        <script type="text/javascript">
            //ueditor编辑器
            var global_i = 0;
            var ue = UE.getEditor('video_Description');
            //alert(1);
            // var ue = UE.getEditor('video_ResourcesContent');
        </script>
        <script>

            $("#search").on("input propertychange",function(){
                var key = $(this).val();
                $('#data_table_info').parent().parent().empty();
                $.post(
                    "<?=Url::toRoute('video/search-program')?>",
                    {
                        key:key,
                    },
                    function(res)
                    {
                        var html = '';
                        for(var key in res)
                        {
                            html += '<tr id="rowid_'+res[key].ID+'">'+
                                '<td><label><input type="checkbox" value="'+res[key].ID+'"></label></td>'+
                                '<td>'+res[key].CustomBh+'</td>'+
                                '<td>'+res[key].Name+'</td>'+
                                '<td>'+res[key].AddAt+'</td>'+
                                '<td>'+res[key].AddBy+'</td>'+
                                '<td class="center"><button id="view_btn" onclick="viewAction(\''+res[key].ID+'\')" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</button>'+
                                '<a id="edit_btn" onclick="editAction(\''+res[key].ID+'\')" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';
                            html += res[key].IsPublish=='1' ? '<a onclick="IsPublish(\''+res[key].ID+'\',this)" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-ok-circle icon-white"></i>已公开</a>' : '<a onclick="IsPublish(\''+res[key].ID+'\',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>公开</a>';
                            if (res[key].IsExam=='1')
                                html +=  checkcheck(res[key].ID) == '1' ? '<a onclick="jump(\''+res[key].ID+'\',this)" class="btn btn-danger btn-sm" > <i class="glyphicon glyphicon-ok-circle icon-white"></i>添加测试模板</a>' : '<a onclick="alert(`已经有一个测试模板了，还要我怎样`)" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-ok-circle icon-white"></i>已有测试模板</a>';
                            html += '<a onclick="deleteAction(\''+res[key].ID+'\')" class="btn btn-danger btn-sm"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a></td></tr>';
                        }
                        $('#program_info').html(html);
                    },
                    'json'
                )
            })


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

                $("#video_StageCode").val('');
                $('#video_KnowledgeBhCode').empty();
                $("#video_StageCode").children().show();

                if(type == 'create'){
                    $("#video_CustomBh").val('');
                    $("#video_IsExam").val('0');
                    $("#video_BeforeID").val('');
                    $("#video_Name").val('');
                    $("#video_Description").val('');
                    $("#video_ResourcesContent").val('');
                    $("#video_ResourcesURL").val();
                    $("#video_Term").val('');
                    $("#model").val('');
                    UE.getEditor('video_ResourcesContent').setContent('');
                    UE.getEditor('video_ResourcesContent').setEnabled();
                }
                else{
                    $("#id").val(data['ID']);
                    $("#video_CustomBh").val(data['CustomBh']);
                    stage(data['KnowledgeBh']);
                    knowledge(data['KnowledgeBh']);
                    //$("#video_KnowledgeBhCode").val(data['KnowledgeBh']);
                    $("#video_IsExam").val(data['IsExam']);
                    $("#video_BeforeID").val(data['BeforeID']);
                    $("#video_ResourcesURL").val(data['ResourcesURL']);
                    $("#video_url").attr({href:'<?=Yii::$app->request->hostInfo;?>/'+data['ResourcesURL'],target:"_blank"});
                    //$("#video_DifficultyCode").val(data['DifficultyCode']);
                    $("#video_Name").val(data['Name']);
                    $("#video_ResourcesContent").val(data['ResourcesContent']);
                    $("#video_Description").val(data['Description']);
                    $("#"+data['Term']).attr("selected",true);
                    $("#"+data['BH']).attr("selected",true);
                    $('#model').addClass('hidden');
                    $('#model1').addClass('hidden');
                    $('#edit_dialog_ok').addClass('hidden');

                }
                if(type == "view"){
                    $("#video_CustomBh").attr({readonly:true,disabled:true});
                    $("#video_StageCode").attr({readonly:true,disabled:true});
                    $("#video_KnowledgeBhCode").attr({readonly:true,disabled:true});
                    $("#video_IsExam").attr({readonly:true,disabled:true});
                    $("#video_BeforeID").attr({readonly:true,disabled:true});
                    $("#video_Name").attr({readonly:true,disabled:true});
                    $("#video_ResourcesURL").attr({readonly:true,disabled:true});
                    $("#video_Term").attr({readonly:true,disabled:true});
                    $("#video_ResourcesContent").attr({readonly:true,disabled:true});
                    $("#video_Description").attr({readonly:true,disabled:true});

                }
                else{
                    $("#video_CustomBh").attr({readonly:false,disabled:false})
                    $("#video_StageCode").attr({readonly:false,disabled:false});
                    //$("#video_KnowledgeBhCode").attr({readonly:false,disabled:false});
                    $("#video_IsExam").attr({readonly:false,disabled:false});
                    $("#video_BeforeID").attr({readonly:false,disabled:false});
                    $("#video_Name").attr({readonly:false,disabled:false});
                    $("#video_ResourcesContent").attr({readonly:false,disabled:false});
                    $("#video_Description").attr({readonly:false,disabled:false});
                    $("#video_ResourcesURL").attr({readonly:false,disabled:false});
                    $("#video_Term").attr({readonly:false,disabled:false});
                    $('#model').removeClass('hidden');
                    $('#model1').removeClass('hidden');
                    $('#edit_dialog_ok').removeClass('hidden');
                }
                $('#edit_dialog').modal('show');
            }

            //获取题目阶段
            function stage(knowledge){
                $.ajax({
                    type:'GET',
                    url:'<?=Url::toRoute('video/stage')?>',
                    data:{'knowledge':knowledge},
                    async:false,
                    dataType:'json',

                    success:function(value){
                        var html ='';
                        for(var Tmp in value){
                            getKnowledge(Tmp,value[Tmp]);
                        }
                    }
                })
            }
            //获取知识点对应阶段
            function knowledge(knowledge){
                $.ajax({
                    type:'GET',
                    url:'<?=Url::toRoute('video/knowledge')?>',
                    data:{'knowledge':knowledge},
                    async:false,
                    dataType:'json',

                    success:function(value){
                        for(var Tmp in value){
                            $("#"+value[Tmp]).children('input').attr('checked',true);
                        }
                    }
                })
            }

            function initModel(id, type, fun){

                $.ajax({
                    type: "GET",
                    url: "<?=Url::toRoute('video/view')?>",
                    data: {"id":id},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        alert("出错了" + textStatus);
                    },
                    success: function(data){
                        console.log(data);
                        UE.getEditor('video_Description').setContent(data['Description']);
                        if(type=="view") {
                            UE.getEditor('video_Description').setDisabled();
                        }else{
                            UE.getEditor('video_Description').setEnabled();
                        }
                        initEditSystemModule(data, type);
                    }
                });

            }

            $('#term-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var url = '<?=Url::toRoute('video/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno

                window.location.href = url;
            });
            $('#stage-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var url = '<?=Url::toRoute('video/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno

                window.location.href = url;
            });
            $('#knowledgepoint-choice').change(function (e) {
                e.preventDefault();
                var kno = $("#knowledgepoint-choice").val();
                var stage = $("#stage-choice").val();
                var term = $("#term-choice").val();
                var url = '<?=Url::toRoute('video/index')?>';
                if (term != 0)
                    url += '&term='+term;
                if (stage != 0)
                    url += '&stage='+stage;
                if (kno != 0)
                    url += '&knowledgeBh='+kno

                window.location.href = url;
            });

            function checkcheck(id) {
                var aa;
                $.ajax({
                    type: 'GET',
                    url: '<?=Url::toRoute('video/model')?>',
                    data: {"id": id},
                    catch: false,
                    async: false,
                    dataType: 'json',
                    success:function (value) {
                        //alert(value);
                        aa = value;
                    }
                });
                return aa;
            }

            function jump(id) {
                window.location.href = "<?=Url::toRoute('exam-module/add-view')?>&id="+id;
            }

            function IsPublish(id){
                //alert(id);
                $.ajax({
                    type: 'GET',
                    url: '<?=Url::toRoute('video/publish')?>',
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



            //添加框获取知识点
            function getKnowledge(stageId,stageName)
            {
                //alert();
                $.ajax({
                    type:'GET',
                    url:'<?=Url::toRoute('video/knowledge-list')?>',
                    data:{'stageId':stageId},
                    catch:false,
                    async : false,
                    dataType:'json',
                    success:function (value) {
                        var html='';
                        //alert(stageName);
                        html += stageName+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        for(var Tmp in value){
                            html += '<span id="'+value[Tmp]['KnowledgeBh']+'" ><input  id= "'+value[Tmp]['KnowledgeName']+'" type="checkbox" name="KnowledgeBhCode[]" value="'+value[Tmp]['KnowledgeBh']+'">';
                            html += '<label for="'+value[Tmp]['KnowledgeName']+'" style="font-size:15px;" >'+value[Tmp]['KnowledgeName']+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
                            $('#video_StageCode').children('#'+stageId).hide();
                        }
                        html += '<br>';
                        $('#video_KnowledgeBhCode').append(html);

                    }
                });
            }

            $("#video_StageCode").change(function(){
                //alert();
                getKnowledge($("#video_StageCode").val(),$("#video_StageCode option:selected").text());
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
                            url: "<?=Url::toRoute('video/delete')?>",
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


            $('#video_BeforeID').mouseover(function () {
                $('#video_BeforeID').children().removeAttr('hidden');
                var id = $('#id').val();
                $('#'+id).attr('hidden','true');
            })

            $('#edit_dialog_ok').click(function (e) {
                e.preventDefault();
                $('#admin-role-form').submit();

            });

            $('#create_btn').click(function (e) {
                e.preventDefault();
                window.location.href = '<?=Url::toRoute('video/add')?>';
            });

            $('#delete_btn').click(function (e) {
                e.preventDefault();
                deleteAction('');
            });

            $('#admin-role-form').bind('submit', function(e) {
                e.preventDefault();
                var id = $("#id").val();
                var action = id == "" ? "<?=Url::toRoute('video/create')?>" : "<?=Url::toRoute('video/update')?>";
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
            // 进度条
            function Progress(value) {
                $('#myProgress').css('width', value + '%');
                // if(value == 100){
                //     window.location.reload();
                // }
            }

            function CloseDialog() {
                $('#mydialog').hide();
            }


            $.fcup({

                upId: 'upid', //上传dom的id

                upShardSize: '', //切片大小,(单次上传最大值)单位M，默认2M

                upMaxSize: '', //上传文件大小,单位M，不设置不限制

                upUrl: '<?=Url::base()?>/fcup/php/file.php', //文件上传接口

                upType: 'FLV,mp4,AVI,MPG,flv,MP4,avi,mpg', //上传类型检测,用,号分割

                //接口返回结果回调，根据结果返回的数据来进行判断，可以返回字符串或者json来进行判断处理
                upCallBack: function (res) {

                    // 状态
                    var status = res.status;
                    // 信息
                    var msg = res.message;
                    // url
                    var url = res.url;

                    // 已经完成了
                    if (status == 2) {
                        alert(msg);
                        $("#video_url").attr({href:'<?=Yii::$app->request->hostInfo;?>/'+url,target:"_blank"});
                        $("#video_ResourcesURL").val(url);


                    }

                    // 还在上传中
                    if (status == 1) {
                        console.log(msg);
                    }

                    // 接口返回错误
                    if (status == 0) {
                        // 停止上传并且提示信息
                        $.upStop(msg);
                    }
                },

                // 上传过程监听，可以根据当前执行的进度值来改变进度条
                upEvent: function (num) {
                    // num的值是上传的进度，从1到100
                    Progress(num);
                },

                // 发生错误后的处理
                upStop: function (errmsg) {
                    // 这里只是简单的alert一下结果，可以使用其它的弹窗提醒插件
                    alert(errmsg);
                },

                // 开始上传前的处理和回调,比如进度条初始化等
                upStart: function () {
                    Progress(0);
                    // $('#mydialog').hide();
                    //$('#allProgress').show();
                    alert('开始上传');
                }

            });





        </script>
        <?php $this->endBlock(); ?>
