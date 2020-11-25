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
                        <h3 class="box-title">改错题列表</h3>
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

                                            echo '      <a id="view_btn" onclick="viewAction(\'' . $model->QuestionBh .'\')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
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
<div class="modal fade" id="correct_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-title" id="correct_title"></h3>
            </div>
            <div class="modal-body ">
                <!-- <?=Url::toRoute('correct/add')?> -->
                <form id="correct_form" action="" method="post">
                <div class="input-group " >
                    <input type="hidden" class="form-control" id="correct_QuestionBh" name="QuestionBh"/>
                </div>
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">自定义题号</span>
                        <input type="text" class="form-control" id="correct_CustomBh" name="CustomBh" placeholder="必填">
                </div>
                <div class="input-group  col-sm-2" style="float: left;" ><br></div>
                <!-- <br> -->
                <div class="input-group  col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;所&nbsp;属&nbsp;阶&nbsp;段&nbsp;</span>
                    <select class="form-control" id="correct_Stage" value="0" name="Stage">

                        <?php foreach ($stage as $model){?>
                            <option value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;&nbsp;知&nbsp;&nbsp;&nbsp;识&nbsp;&nbsp;&nbsp;点&nbsp;&nbsp;</span>
                    <select class="form-control" id="correct_KnowledgeBh" value="0" name="KnowledgeBh">

                    </select>
                </div>
                <div class="input-group  col-sm-2" style="float: left;" ><br></div>
                <!-- <br> -->
                <div class="input-group col-sm-5" style="float: left;"  >
                    <span class="input-group-addon">&nbsp;是&nbsp;否&nbsp;公&nbsp;开&nbsp;</span>
                    <select class="form-control" id="correct_IsSee" value="0" name="Score" >
                    <!-- name="IsSee" -->
                        <option value="1">是</option>
                        <option value="0">否</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group col-sm-5" style="float: left;" >
                    <span class="input-group-addon">&nbsp;题&nbsp;目&nbsp;难&nbsp;度&nbsp;</span>
                    <select class="form-control" id="correct_Difficulty" value="0" name="Difficulty">
                    </select>
                </div>

                <div class="input-group  col-sm-2" style="float: left;" ><br></div>
                <!-- <br> -->
                <div class="input-group col-sm-5" style="float: left;">
                    <span class="input-group-addon">&nbsp;题&nbsp;目&nbsp;名&nbsp;称&nbsp;</span>
                    <textarea class="form-control" id="correct_name" name="name" placeholder="必填"></textarea>
                </div>
                <div class="clearfix"></div>
                <br>


                <span class="input-group-addon">题目描述（必填）</span>
                <div class="input-group col-sm-12">
                    <div class="input-group " >

                        <script type="text/plain" id="correct_Description" name="Description" style="width:100%" placeholder="必填"></script>
                    </div>
                </div>
                <br>
                <div class="input-group col-sm-5" style="float: left;">
                    <span class="input-group-addon">&nbsp;开&nbsp;始&nbsp;标&nbsp;记&nbsp;</span>
                    <input type="text" class="form-control" id="correct_startTag" name="StartTag" value="/*********Found************/" placeholder="必填">
                </div>
                <div class="input-group  col-sm-2" style="float: left;" ><br></div>

                <div class="input-group col-sm-5" style="float: left;">

                </div>
                <div class="clearfix"></div>
                <br>
                <div class="input-group col-sm-12">
                    <span class="input-group-addon">&nbsp;改&nbsp;错&nbsp;内&nbsp;容&nbsp;</span>
                    <textarea class="form-control" id="correct_AnswerDescript" name="AnswerDescript" rows="13" placeholder="必填"></textarea>
                </div>
                <br>
                <button type="button" class="btn btn-primary" id="correct_add_answer">添加答案</button>
                <span class="input-group-addon">&nbsp;改&nbsp;错&nbsp;答&nbsp;案&nbsp;</span>
                <div class="input-group col-sm-12" style="float: left;">

                    <table id="add_test_case_tb" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">

                        <thead>
                        <tr role="row">

                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >序号</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >答案</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >分数百分比</th>
                            <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
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
                    <textarea class="form-control" id="correct_Memo" name="Memo"></textarea>
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



<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    var have_diff = 0;
    var global_i = 0;
    var global_j = 0;
    var ue = UE.getEditor('correct_Description');
</script>


      <script>
       $("#search").on("input propertychange",function(){
        var key = $(this).val();
        $('#data_table_info').parent().parent().empty();
        $.post(
            "<?=Url::toRoute('correct/search-correct')?>",
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

        //添加一个答案
      $('#correct_add_answer').click(function(){
        global_i++;
        var i = $('.parent_answer').size()+1;
        var html =  '<tr role="row" class="parent_answer">'+
                '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
                '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">'+
                '<div class="col-sm-1">'+
                '<button type="button" class="btn btn-primary add_child_answer" value="answer[answer'+i+']">增加</button>'+
                '</div><div class="clearfix"></div><br>'+
                '</th>'+

                '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending"><input type="text" class="form-control add_score" name="answer[answer'+i+'][Score]" value="" placeholder="必填（限数字）"/></th>'+

                '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-danger delete_one_answer">删除</button></th>'+
                '</tr>';
        $("#add_answer_info").append(html);

      })
      //删除一个答案
      $(document).on('click','.delete_one_answer',function(){
        $(this).parent().parent().remove();
        var i = 1;
        $('.parent_answer').each(function(index){
            $(this).children(":first").text(i);
            i++;
        })
      })
      //检验是否可以提交
      function CanAdd()
      {
        var arr=new Array()
        arr.push($('#correct_CustomBh').val());

        arr.push($('#correct_name').val());
        arr.push($('#correct_startTag').val());
        arr.push($('#correct_AnswerDescript').val());
        arr.push($('#correct_KnowledgeBh').val());
        arr.push($('#correct_Stage').val());
        arr.push(UE.getEditor('correct_Description').getContent());
        // alert(arr);
        for(var i=0; i<arr.length; i++)
            if(arr[i] == '')
                return false;
        var sum = 0;
        var flag = true;
        $('.add_score').each(function(){
            var score = $(this).val();

            if(score*1 != score ||  score <= 0)
            {
                flag = false;
            }
            else
                sum += score*1;

        })

        if(flag && sum <= 100 )
            return true;
        else
            return false;
      }
      //新增保存
      $(document).on('click','#correct_save_update',function(){
        if(CanAdd())
        {
            $('#correct_form').attr('action','<?=Url::toRoute("correct/add")?>');
            $('#correct_form').ajaxSubmit(function(res){
                alert(res);

            })
        }
        else
            alert('请正确填写数据');
      })
      //添加新答案信息
      $(document).on('click','.add_child_answer',function(){
        global_j++;
        var name = $(this).val();
        var html = '<div class="col-sm-6">'+
                '<input type="text" class="form-control" name="'+name+'[Answer'+global_j+']" value="" placeholder="必填"/><a class="label label-danger delete_answer_info">删除</a>'+
                '</div>';
        $(this).parent().parent().append(html);
      })
      //删除答案信息
      $(document).on('click','.delete_answer_info',function(){
        $(this).parent().remove();
      })
      //获取知识点
      function getKnowledge(stageId)
        {
            $.ajax({
                type:'GET',
                url:'<?=Url::toRoute('knowledge/knowledge-list')?>',
                data:{stageId:stageId},
                catch:false,
                async : false,
                dataType:'json',
                success:function (value) {
                    var html = '';
                    for(var Tmp in value){
                        html += '<option value="'+ value[Tmp]['KnowledgeBh'] + '">'+ value[Tmp]['KnowledgeName']+'</option>';
                    }
                    $('#correct_KnowledgeBh').html(html);

                }
            });
        }
        //获取困难等级
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
                    $('#correct_Difficulty').html(html);
                },
                "json"
                );
        }
        $('#correct_Stage').change(function(){
            getKnowledge($('#correct_Stage').val());
        })

        //阶段选择
        $('#stage-choice').change(function () {
            var Tmp = $(this).val();
            var know = $("#knowledgepoint-choice").val();
            var url = '<?=Url::toRoute('correct/index')?>';

            if(Tmp != 0)
                url += '&stage='+Tmp;
            if(know != 0)
                url += '&knowledgeBh='+know;
            window.location.href = url;
        })
        $('#knowledgepoint-choice').change(function () {
            var know = $(this).val();
            var Tmp = $('#stage-choice').val();
            var url = '<?=Url::toRoute('correct/index')?>';

            if(Tmp != 0)
                url += '&stage='+Tmp;
            if(know != 0)
                url += '&knowledgeBh='+know;
            window.location.href = url;
            // window.location.href = '<?=Url::toRoute('choice/index')?>'+'&stage='+Tmp+'&knowledgeBh='+know;
        })


        //异步请求阶段知识点
        $('#stageJudgement').change(function () {
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
                        $('#knowledgeJudgement').append("<option value='"+ value[Tmp]['KnowledgeBh'] +"'>"+ value[Tmp]['KnowledgeName'] +"</option>")
                    }
                }
            })
        })



        //修改可见
         function IsSee(id,me)
        {
            $.post(
                "<?=Url::toRoute('correct/change-see')?>",
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
                "<?=Url::toRoute('correct/change-checked')?>",
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
        //初始化modal
        function init(flag)
        {
            $('#correct_add_answer').attr('disabled',flag);
            $('#correct_save_update').attr('disabled',flag);
            if(flag)
                UE.getEditor('correct_Description').setDisabled();
            else
                UE.getEditor('correct_Description').setEnabled();
            $('#correct_form').children('.input-group').each(function(){

                $(this).children('.form-control').val('');
                $(this).children('.form-control').attr('disabled',flag);
            });
            UE.getEditor('correct_Description').setContent('');
            $('#add_answer_info').empty();
            $('#correct_startTag').val('/*********Found************/');
        }
        //查看按钮触发的获取答案
        function getAnswerView(id)
        {
            $.post(
            "<?=Url::toRoute('correct/get-answer')?>",
            {
                QuestionBh:id,
            },
            function(res){
                var html = '';
                var i = 1;
                for(var key in res)
                {
                    html += '<tr role="row" class="parent_answer">'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">';
                    for(var key1 in res[key].Answer.key)
                    {
                        html += '<div class="col-sm-6">'+
                                '<input type="text" class="form-control" placeholder="必填" disabled value="'+res[key].Answer.key[key1].Answer+'"/>'+
                                '</div>';
                    }
                    html += '</th>'+

                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending"><input type="text" class="form-control add_score" value="'+res[key].Proportion+'" placeholder="必填（限数字）" disabled/></th>'+

                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ><button type="button" class="btn btn-danger delete_update_answer" disabled>删除</button></th>'+
                            '</tr>';
                    i++;
                }

                $('#add_answer_info').html(html);

            },
            'json'
            )
         }

         //编辑按钮触发的获取答案
        function getAnswerUpdate(id)
        {
            $.post(
            "<?=Url::toRoute('correct/get-answer')?>",
            {
                QuestionBh:id,
            },
            function(res){
                var html = '';
                var i = 1;
                for(var key in res)
                {



                    html += '<tr role="row" class="parent_answer">'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'+i+'</th>'+
                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" class="child_parent">';

                    for(var key1 in res[key].Answer.key)
                    {

                        html += '<div class="col-sm-6">'+
                                '<input type="text" class="form-control"  value="'+res[key].Answer.key[key1].Answer.replace(/\"/g, "&quot;")+'" name="old['+res[key].ErrorCount+']['+key1+']" placeholder="必填"/>'+
                                '</div>';
                    }
                    html += '</th>'+

                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending"><input type="text" name="old['+res[key].ErrorCount+'][Score] class="form-control add_score" value="'+res[key].Proportion+'" placeholder="必填（限数字）"/></th>'+

                            '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" ></th>'+
                            '</tr>';
                            // <button type="button" class="btn btn-danger delete_update_answer" value="'+id+';'+res[key].ErrorCount+'"></button>
                    i++;
                }

                $('#add_answer_info').html(html);

            },
            'json'
            )
         }



        //获取一个改错退
        function getCorrect(id)
        {
            $.post(
                "<?=Url::toRoute('correct/get-correct')?>",
                {
                    QuestionBh:id,
                },
                function(res){

                    getKnowledge(res.Stage);
                    for(var key in res)
                        $('#correct_'+key).val(res[key]);

                    $('#correct_IsSee').val(res.Score);

                    UE.getEditor('correct_Description').setContent(res.Description);
                },
                'json'
                )
        }
        //查看一个题
        function viewAction(id){
            $('#correct_modal').modal('show');
            $('#option_type').html('');
            if(!have_diff)
                getDiff();
            init(true);
            getCorrect(id);
            getAnswerView(id);

        }
        //修改一个题
        function editAction(id){
            $('#option_type').html('<button type="button" class="btn btn-info" id="correct_save">修改</button>');
            $('#correct_modal').modal('show');
            if(!have_diff)
                getDiff();
            init(false);
            getCorrect(id);
            getAnswerUpdate(id);
            // initModel(id, 'edit');
        }
        //删除操作
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
                        url: "<?=Url::toRoute('correct/delete')?>",
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
        $(document).on('click','#correct_save',function(){
            // alert(1);
            if(CanAdd())
            {
                $('#correct_form').attr('action','<?=Url::toRoute("correct/update")?>');
                $('#correct_form').ajaxSubmit(function(res){
                    alert(res);
                })
            }
            else
                alert('请正确填写数据');



        })
        //新增题目
        $('#create_btn').click(function (e) {

            $('#correct_modal').modal('show');
            $('#option_type').html('<button type="button" class="btn btn-info" id="correct_save_update">添加</button>');
            if(!have_diff)
                getDiff();
            getKnowledge($('#correct_Stage').val());
            init(false);

        });
        //删除操作
        $('#delete_btn').click(function (e) {
            e.preventDefault();
            deleteAction('');
        });


      </script>
<?php $this->endBlock(); ?>
