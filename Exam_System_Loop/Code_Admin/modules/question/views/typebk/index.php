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
    <script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<?php $this->endBlock(); ?>


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-header">
                        <h3 class="box-title">填空题题列表</h3>
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

                                            echo '      <button id="view_btn" onclick="viewAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" > <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</button>';
                                            echo '      <a id="edit_btn" onclick="editAction(' . "'$id'"  . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>修改</a>';


                                            echo $model->Score ? '      <a onclick="IsSee(\'' . $model->QuestionBh. '\',this)" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-ok-circle icon-white"></i>已公开</a>' : '      <a onclick="IsSee(\'' . $model->QuestionBh. '\',this)" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>公开</a>';
                                            echo $model->Checked=='100001' ? '      <a onclick="Checked(\'' . $model->QuestionBh. '\',this)" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-ok-circle icon-white"></i>已审核</a>' : '      <a onclick="Checked(\'' . $model->QuestionBh. '\',this)" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon glyphicon-ban-circle icon-white"></i>审核</a>';
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
<!-- 查看修改添加modal -->
<div class="modal fade" id="typebk_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-title" id="typebk_title"></h3>
            </div>
            <div class="modal-body ">
                <!-- <?=Url::toRoute('correct/add')?> -->
                <form id="typebk_form" method="post">
                <div class="input-group " >
                    <input type="hidden" class="form-control" id="typebk_QuestionBh" name="Questions[QuestionBh]"/>
                </div>
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">自定义题号</span>
                        <input type="text" class="form-control" id="typebk_CustomBh" name="Questions[CustomBh]" placeholder="必填">
                </div>
                <div class="input-group  col-sm-2" style="float: left;" ><br></div>
                <!-- <br> -->
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;所&nbsp;属&nbsp;阶&nbsp;段&nbsp;</span>
                    <select class="form-control" id="typebk_Stage" value="0" name="Questions[Stage]">

                        <?php foreach ($stage as $model){?>
                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;&nbsp;知&nbsp;&nbsp;&nbsp;识&nbsp;&nbsp;&nbsp;点&nbsp;&nbsp;</span>
                    <select class="form-control" id="typebk_KnowledgeBh" value="0" name="Questions[KnowledgeBh]">

                    </select>
                </div>
                <div class="input-group  col-sm-2" style="float: left;" ><br></div>
                <!-- <br> -->
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;是&nbsp;否&nbsp;公&nbsp;开&nbsp;</span>
                    <select class="form-control" id="typebk_Score" value="0" name="Questions[Score]" >
                    <!-- name="Questions[IsSee" -->
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;题&nbsp;目&nbsp;难&nbsp;度&nbsp;</span>
                    <select class="form-control" id="typebk_Difficulty" value="0" name="Questions[Difficulty]">
                    </select>
                </div>

                <div class="input-group  col-sm-2" style="float: left;" ><br></div>
                <!-- <br> -->
                <div class="input-group col-sm-5" style="float: left;">
                    <span class="input-group-addon">&nbsp;题&nbsp;目&nbsp;名&nbsp;称&nbsp;</span>
                    <textarea class="form-control" id="typebk_name" name="Questions[name]" placeholder="必填"></textarea>
                </div>
                <div class="clearfix"></div>
                <br>
                <div id="add_option">

                </div>
                <span class="input-group-addon">题目描述（必填）</span>

				</div>
                <div class="input-group col-sm-12">
                    <script type="text/plain" id="typebk_Description" name="Questions[Description]" style="width:100%" placeholder="必填"></script>
                </div>
                <br>

                <span style="color:red;" class="input-group-addon">&nbsp;改&nbsp;错&nbsp;答&nbsp;案&nbsp;(若要修改以前的答案，请先点击上面的<b>重置答案</b>按钮)</span>
                <div class="input-group col-sm-12" style="float: left;">

                    <table id="add_test_case_tb" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">

                        <thead>
                        <tr role="row">

                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >填空序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >答案</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数百分比</th>
                        </tr>
                        </thead>
                        <!-- 点到信息列表 -->
                        <tbody id="add_answer_info">


                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group col-sm-5" style="float: left;">
                    <span class="input-group-addon">&nbsp;备&nbsp;注&nbsp;信&nbsp;息&nbsp;</span>

                    <textarea class="form-control" id="typebk_Memo" name="Questions[Memo]"></textarea>
                </div>
                <div class="clearfix"></div>
                <br>

                </form>
            </div>
            <div class="modal-footer" id="option_type">

            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('footer');  ?>
    <!-- <body></body>后代码块 -->



    <script type="text/javascript">
        //ueditor编辑器
        UE.getEditor('typebk_Description');

    </script>
    <script>
    $("#search").on("input propertychange",function(){
        var key = $(this).val();
        $('#data_table_info').parent().parent().empty();
        $.post(
            "<?=Url::toRoute('typebk/search-typebk')?>",
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

        //修改可见
         function IsSee(id,me)
        {
            $.post(
                "<?=Url::toRoute('typebk/change-see')?>",
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
        //修改审核
        function Checked(id,me)
        {
            $.post(
                "<?=Url::toRoute('typebk/change-checked')?>",
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
        //获取困难
        function getDiff()
        {

            $.post(
                "<?=Url::toRoute('program/get-diff')?>",
                {},
                function(res){
                    var html = '';
                    for(var key in res)
                        html += '<option value="'+ res[key].CuitMoon_DictionaryCode + '">'+ res[key].CuitMoon_DictionaryName+'</option>';
                    // $('#update_DifficultyCode').html(html);
                    have_diff = 1;
                    $('#typebk_Difficulty').html(html);
                },
                "json"
                );
        }
        //获取答案给view
        function getAnswerView(id)
        {
            $.post(
                "<?=Url::toRoute('typebk/get-answer')?>",
                {
                    QuestionBh:id,
                },
                function(res){
                    var html = '';
                    for(var key in res)
                    {
                        html += '<tr role="row" class="parent_answer">'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ApfillPosition+'</th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                            '<div class="col-sm-6">'+
                                '<input type="text" class="form-control" disabled value="'+res[key].Answer+'" name="old['+res[key].ApfillPosition+'][Answer]" placeholder="必填"/>'+
                            '</div></th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                            '<div class="col-sm-6">'+
                                '<input type="text" class="form-control" disabled value="'+res[key].Proportion+'" name="old['+res[key].Proportion+'][Proportion]" placeholder="必填"/>'+
                            '</div></th>'+
                            '</tr>'
                            ;
                    }
                    $('#add_answer_info').html(html);
                },
                'json'

                )
        }
        //获取答案给编辑
        function getAnswerUpdate(id)
        {
            $.post(
                "<?=Url::toRoute('typebk/get-answer')?>",
                {
                    QuestionBh:id,
                },
                function(res){
                    var html = '';
                    for(var key in res)
                    {
                        html += '<tr role="row" class="parent_answer">'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+res[key].ApfillPosition+'</th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                            '<div class="col-sm-6">'+
                                '<input type="text" class="form-control" value="'+res[key].Answer+'" name="old['+res[key].ApfillPosition+'][Answer]" placeholder="必填"/>'+
                            '</div></th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                            '<div class="col-sm-6">'+
                                '<input type="text" class="form-control" value="'+res[key].Proportion+'" name="old['+res[key].ApfillPosition+'][Proportion]" placeholder="必填"/>'+
                            '</div></th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ></th>'
                            ;
                    }
                    $('#add_answer_info').html(html);
                },
                'json'

                )
        }
        function init(flag)
        {
            $('#add_option').empty();
            // $('#typebk_add_answer').attr('disabled',flag);
            // $('#typebk_save_update').attr('disabled',flag);
            if(flag)
                UE.getEditor('typebk_Description').setDisabled();
            else
                UE.getEditor('typebk_Description').setEnabled();
            $('#typebk_form').children('.input-group').each(function(){
                // alert(this);
                $(this).children('.form-control').val('');
                $(this).children('.form-control').attr('disabled',flag);
            });
            UE.getEditor('typebk_Description').setContent('');
            $('#option_type').empty();
            $('#add_answer_info').empty();
        }
        getDiff();
        getKnowledge();
         //获取知识点
        function getKnowledge(id)
        {
            $.ajax({
                type:'GET',
                url:'<?=Url::toRoute('knowledge/knowledge-list')?>',
                data:{stageId:id},
                catch:false,
                async : false,
                dataType:'json',
                success:function (value) {
                    var html = '';
                    for(var Tmp in value){
                        html += '<option value="'+ value[Tmp]['KnowledgeBh'] + '">'+ value[Tmp]['KnowledgeName']+'</option>';
                    }

                    $('#typebk_KnowledgeBh').html(html);

                }
            });
        }
        //阶段选择

        $('#stage-choice').change(function () {
            var Tmp = $(this).val();
            var know = $("#knowledgepoint-choice").val();
            var url = '<?=Url::toRoute('typebk/index')?>';

            if(Tmp != 0)
                url += '&stage='+Tmp;
            if(know != 0)
                url += '&knowledgeBh='+know;
            window.location.href = url;
        })
        $('#knowledgepoint-choice').change(function () {
            var know = $(this).val();
            var Tmp = $('#stage-choice').val();
            var url = '<?=Url::toRoute('typebk/index')?>';

            if(Tmp != 0)
                url += '&stage='+Tmp;
            if(know != 0)
                url += '&knowledgeBh='+know;
            window.location.href = url;
            // window.location.href = '<?=Url::toRoute('choice/index')?>'+'&stage='+Tmp+'&knowledgeBh='+know;
        })

        $(document).on('click','#add_bk_btn',function(){
            UE.getEditor('typebk_Description').execCommand('insertHtml', '<input maxlength="50" type="text"/>',true);
        })
        function getTypebk(id)
        {
            $.post(
                "<?=Url::toRoute('typebk/get-typebk')?>",
                {
                    QuestionBh:id,
                },
                function(res){
                    getKnowledge(res.Stage);
                    for(var key in res)
                        $('#typebk_'+key).val(res[key]);

                    UE.getEditor('typebk_Description').setContent(res.Description);
                },
                'json'
                )
        }

        //异步请求阶段知识点
        $('#typebk_Stage').change(function () {
            var stageId = $(this).val();
            getKnowledge(stageId);
        })





        function viewAction(id){
            UE.getEditor('typebk_Description').removeListener("selectionchange",addAnswer);
            $('#typebk_modal').modal('show');
            init(true);
            getTypebk(id);
            getAnswerView(id);
            // alert($('#typebk_Stage').val());
        }

        function editAction(id){
            console.log(id)
            UE.getEditor('typebk_Description').removeListener("selectionchange",addAnswer);
            $('#typebk_modal').modal('show');
            init(false);
            getTypebk(id);
            getAnswerUpdate(id);
            $('#option_type').html('<button id="update_save" type="button" class="btn btn-sm btn-danger">修改</button>');
            $('#add_option').html('<button id="update_reset_btn" type="button" class="btn btn-sm btn-danger">重置答案</button>');
        }
        $(document).on('click','#update_save',function(){
            //$('#typebk_form').attr('action','<?//=Url::toRoute("typebk/update")?>//');
            //$('#typebk_form').ajaxSubmit(function(res){
            //    alert(res);
            //    document.location.reload();
            //})
            var formBasic = {};
            //获取富文本框值
            formBasic['Questions[Description]'] = UE.getEditor('typebk_Description').getContent();
            var form = $('#typebk_form').serializeArray();
            $.each(form, function() {
                formBasic[this.name] = this.value;
            });
            //获取答案表格

            var rows = document.getElementById("add_answer_info").rows.length;
            var Apfill_ans = {};
            var Apfill_pro = {};
            for(var i=0; i<rows; i++){
                if(document.getElementsByName("Apfill["+i+"][Apfill][Answer]").item(0)){
                    Apfill_ans[i] = document.getElementsByName("Apfill["+i+"][Apfill][Answer]").item(0).value;
                    Apfill_pro[i] = document.getElementsByName("Apfill["+i+"][Apfill][Proportion]").item(0).value;
                }
            }

            // console.log(Apfill);
            // console.log(formBasic);
            $(this).ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: '<?=Url::toRoute("typebk/update")?>', // 需要提交的 url
                data: {
                    'formBasic': formBasic,
                    'Apfill_ans': Apfill_ans,
                    'Apfill_pro': Apfill_pro
                },
                success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                    // 此处可对 data 作相关处理
                    alert('提交成功！');
                    document.location.reload();
                }
            });
        })
        $(document).on('click','#update_reset_btn',function(){
            $('#add_option').html('<button id="add_bk_btn" type="button" class="btn btn-sm btn-primary">当前位置插入空格</button>');
            UE.getEditor('typebk_Description').addListener( 'selectionchange', addAnswer);
            UE.getEditor('typebk_Description').execCommand('insertHtml', ' ',true);
        })

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
                        url: "<?=Url::toRoute('typebk/delete')?>",
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


        $(document).on('click','#add_save',function(){
            //$('#typebk_form').attr('action','<?//=Url::toRoute("typebk/add")?>//');
            //$('#typebk_form').ajaxSubmit(function(res){
            //
            //    alert(res);
            //    document.location.reload();
            //})
            var formBasic = {};
            //获取富文本框值
            formBasic['Questions[Description]'] = UE.getEditor('typebk_Description').getContent();
            var form = $('#typebk_form').serializeArray();
            $.each(form, function() {
                formBasic[this.name] = this.value;
            });
            //获取答案表格

            var rows = document.getElementById("add_answer_info").rows.length;
            var Apfill_ans = {};
            var Apfill_pro = {};
            for(var i=0; i<rows; i++){
                if(document.getElementsByName("Apfill["+i+"][Apfill][Answer]").item(0)){
                    Apfill_ans[i] = document.getElementsByName("Apfill["+i+"][Apfill][Answer]").item(0).value;
                    Apfill_pro[i] = document.getElementsByName("Apfill["+i+"][Apfill][Proportion]").item(0).value;
                }
            }

            // console.log(Apfill);
            // console.log(formBasic);
            $(this).ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: '<?=Url::toRoute("typebk/add")?>', // 需要提交的 url
                data: {
                    'formBasic': formBasic,
                    'Apfill_ans': Apfill_ans,
                    'Apfill_pro': Apfill_pro
                },
                success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                    // 此处可对 data 作相关处理
                    alert('提交成功！');
                    document.location.reload();
                }
            });

        })
        function addAnswer(editor)
        {
            var string = UE.getEditor('typebk_Description').getContent();
            var sum = string.split("type").length-1;
            var html = '';
            for(var i=0; i<sum; i++)
            {
                html += '<tr role="row" class="parent_answer">'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+(i+1)+'</th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                            '<div class="col-sm-6">'+
                                '<input type="text" class="form-control"  value="" name="Apfill'+'['+i+'][Apfill][Answer]" placeholder="必填">'+
                            '</div></th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                            '<div class="col-sm-6">'+

                                '<input type="text" class="form-control"  value="" name="Apfill'+'['+i+'][Apfill][Proportion]" placeholder="必填">'+
                            '</div></th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ></th>'
                            ;
            }
            $('#add_answer_info').html(html);
        }

        $('#create_btn').click(function(){
            UE.getEditor('typebk_Description').addListener( 'selectionchange', addAnswer);
            $('#typebk_modal').modal('show');

            init(false);
            $('#option_type').html('<button id="add_save" type="button" class="btn btn-sm btn-danger">保存</button>');
            $('#add_option').html('<button id="add_bk_btn" type="button" class="btn btn-sm btn-primary">当前位置插入空格</button>');
        })
        $('#edit_dialog_ok').click(function (e) {

        });


        $('#delete_btn').click(function (e) {
            e.preventDefault();
            deleteAction('');
        });




    </script>
<?php $this->endBlock(); ?>
