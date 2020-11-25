
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
                    <h3 class="box-title">新闻数据管理</h3>
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
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <!-- row start search-->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>新闻类型:</label>
                                        <select class="form-control" id="type-choice">
                                            <option value="all">全部</option>
                                            <?php foreach ($type as $model) {?>
                                                <option value="<?=$model['CuitMoon_DictionaryName']?>"><?=$model['CuitMoon_DictionaryName']?></option>
                                            <?php }?>
                                        </select>
                                        </div>
                                    <div class="col-sm-3">
                                        <?php ActiveForm::begin(['id' => 'admin-role-search-form', 'method'=>'get', 'options' => ['class' => 'form-inline'], 'action'=>Url::toRoute('news/index')]); ?>

                                        <div class="form-group" style="margin: 5px;">
                                            <label>新闻标题:</label>
                                            <input type="text" class="form-control" id="search-value" name="search">
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >新闻类型</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >新闻标题</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >新闻内容</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >新闻发布者</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >新闻发布时间</th>';
                                        ?>
                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($news as $model) {
                                        $id = $model['newsBh'];
                                        echo '<tr style="height:100px !important; overflow:hidden !important;" id="rowid_' . $model['newsBh'] . '">';
                                        echo '  <td><label><input type="checkbox" value="' . $model['newsBh'] . '"></label></td>';
                                        echo '  <td>' . $model['newstype'] . '</td>';
                                        echo '  <td>' . $model['newstitle'] . '</td>';
                                        echo '  <td style="display:block; height:80px !important; overflow:hidden; text-overflow:ellipsis;">' . $model['newscontent']. '</td>';
                                        echo '  <td>' . $model['releaseUser']. '</td>';
                                        echo '  <td>' . $model['releasetime']. '</td>';
                                        echo '  <td class="center">';
                                        if($model['State']=='0'){
                                            echo '      <a id="release_btn" onclick="releaseAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>发布</a>';
                                        }
                                        else{
                                            echo '      <a id="release_btn" onclick="releaseAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>取消发布</a>';
                                        }

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
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h3>新闻数据</h3>
                <?php $form = ActiveForm::begin(["id" => "admin-role-form","method"=>"get", "class"=>"form-horizontal", "action"=>Url::toRoute("news/view")]); ?>

                <input type="hidden" class="form-control" id="id" name="id" />

                <div id="Title_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">新闻标题</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="NewsTitle" name="Newsinfo[newstitle]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Type_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">新闻类型</label>
                    <div class="col-sm-10">
                        <select class="form-group" name="Newsinfo[newstype]" id="NewsType">
                            <option value="all">请选择</option>
                            <?php
                            foreach($type as $key=>$data){
                                echo "<option value='" . $data->CuitMoon_DictionaryName . "'>". $data->CuitMoon_DictionaryName."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="remarks_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">新闻内容</label>
                    <div class="col-sm-10">
                        <script type="text/plain" id="NewsContent" name="Newsinfo[newscontent]"></script>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="User_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">新闻发布者</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Newsinfo[releaseUser]" id="ReleaseUser" placeholder="必填" />
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
    var ue = UE.getEditor('NewsContent');
</script>
<script>


    function searchAction(){
        $('#admin-role-search-form').submit();
    }


    $('#type-choice').change(function () {
        var Typ = $(this).val();
        window.location.href = '<?=Url::toRoute('news/index')?>'+'&type='+Typ;
    });

    $(document).ready(function () {
        var type = '<?=$type_choice?>';
        if (type != 0) {
            $('#type-choice option[value="<?=$type_choice?>"]').attr("selected","selected");
        }
    });


    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#NewsTitle").val('');
            $("#NewsType").val('');
            $("#NewsContent").val('');
            $("#ReleaseUser").val('');
        }
        else{
            $("#NewsTitle").val(data['newstitle']);
            $("#NewsType").val(data['newstype']);
            $("#NewsContent").val(data['newscontent']);
            $("#ReleaseUser").val(data['releaseUser']);

            $("#id").val(data['newsBh']);
            $('#edit_dialog_ok').addClass('hidden');
        }
        if(type == "view"){
            $("#NewsTitle").attr({readonly:true,disabled:true});
            $("#NewsType").attr({readonly:true,disabled:true});
            $("#NewsContent").attr({readonly:true,disabled:true});
            $("#ReleaseUser").attr({readonly:true,disabled:true});

        }
        else{
            $("#NewsTitle").attr({readonly:false,disabled:false});
            $("#NewsType").attr({readonly:false,disabled:false});
            $("#NewsContent").attr({readonly:false,disabled:false});
            $("#ReleaseUser").attr({readonly:false,disabled:false});

            $('#edit_dialog_ok').removeClass('hidden');
        }
        $('#edit_dialog').modal('show');
    }

    function initModel(id, type, fun){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('news/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了，" + textStatus);
            },
            success: function(data){
                console.log(data);
                UE.getEditor('NewsContent').setContent(data.newscontent);
                //UE.getEditor('NewsContent').attr({readonly:true,disabled:true});
                if(type=='view') {
                    UE.getEditor('NewsContent').setDisabled();
                }
                initEditSystemModule(data, type);
            }
        });
    }

    function initModelT(id){

        $.ajax({
            type: "GET",
            url: "<?=Url::toRoute('news/release')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert( xmlHttpRequest.readyState+ textStatus);
                window.location.reload();
            },
            success: function(data){
                console.log(data)
                window.location.reload();
            }
        });
    }


    function viewAction(id){
        initModel(id, 'view', 'fun');
    }
    function editAction(id){
        initModel(id, 'edit');
    }

    function releaseAction(id){
        initModelT(id);
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
                    url: "<?=Url::toRoute('news/delete')?>",
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
        window.location.href = "<?=Url::toRoute('news/add')?>";
    });


    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#admin-role-form').bind('submit', function(e) {
        e.preventDefault();
        var id = $("#id").val();
        var action = id == "" ?"<?=Url::toRoute('news/create')?>" : "<?=Url::toRoute('news/update')?>";
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


</script>
<?php $this->endBlock(); ?>