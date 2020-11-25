
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$m_exam = new \app\models\teachplan\Examplan();
?>

<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>
<style>
.form-control{
    min-width: 150px;
    margin-right: 20px;
}
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">考卷生成</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">生成考卷</button>
                            |
                            <button id="delete_btn" type="button"  class="btn btn-xs btn-danger">批量删除</button></br>
                            </br>
                            <button id="copy_btn" type="button"  class="btn btn-xs btn-primary">复制试卷</button>
                            |
                            <button id="add_question" type="button"  class="btn btn-xs btn-primary">指定生成</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="row">
                            <div class="col-sm-2">
                                <label>学期:&nbsp;</label>
                                <select class="form-control" id="term-choice">
                                    <?php foreach ($term as $value){?>
                                        <option value="<?=$value['CuitMoon_DictionaryName']?>" <?php if($value['CuitMoon_DictionaryName'] === $now_term){?>selected="selected" <?php }?>><?=$value['CuitMoon_DictionaryName']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>考试计划:&nbsp;</label>
                                <select class="form-control" id="teach-choice">

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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考卷名称'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'考试计划'.'</th>';
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'命题时间'.'</th>';
                                        ?>

                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if(isset($list)) {
                                        $row = 0;
                                        foreach ($list as $model) {
                                            echo '<tr id="rowid_' . $model->PaperBh . '">';
                                            echo '  <td><label><input type="checkbox" value="' . $model->PaperBh . '"></label></td>';
                                            echo '  <td>' . $model->PaperName . '</td>';
                                            if ($Tmp = $m_exam->findOne(['ExamPlanBh' => $model->ExamPlanBh])) {
                                                echo '  <td>'  . $Tmp->ExamPlanName . '</td>';
                                            }
                                            echo '  <td>' . $model->CreateTime . '</td>';
                                            echo '  <td class="center">';
                                            echo '      <a id="view_btn" onclick="viewAction(' . "'$model->PaperBh'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                            echo '      <a id="delete_btn_" onclick="deleteAction(' . "'$model->PaperBh'" . ')" class="btn btn-danger btn-sm" href="#"> <i class="glyphicon glyphicon-trash icon-white"></i>删除</a>';
                                            // echo '      <a id="update_btn_" onclick="updateAction(' . "'$model->PaperBh'" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-edit icon-white"></i>详情</a>';

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


<div class="modal fade" id="add_question_modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>指定题目生成试卷</h3>
            </div>
            <div class="modal-body">
                <div class="panel-group" id="accordion">

                </div>
            </div>
            <div style="margin-left:20px;"><lable>请输入生成试卷数量：</lable><input id="paperNum" type="text"></input></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a> <a
                    id="add_question_ok" href="#" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_dialog" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>试卷生成</h3>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-module-form", "class"=>"form-horizontal", "action"=>Url::toRoute("module/create")]); ?>

                <div id="code_div" class="form-group">
                    <label for="code" class="col-sm-2 control-label">份数</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="code" name="Number" placeholder="必填" />
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
<script>

    $("#add_question").click(function(){
        // alert(1);

        var id = $('#teach-choice').val();
        // alert(id);
        if(id == '请选择' || id==null){
            alert('请先选择考试计划');
        }else {

            $.ajax({
                type:'POST',
                url:'<?=Url::toRoute("paper/get-can-choice-question")?>',
                data:{id:id},
                dataType:"JSON",
                success:function (res) {
                    if(res.code == 200)
                    {
                        $('#add_question_modal').modal('show');
                        res = res.data;
                        var i = 0;
                        $('#accordion').empty();
                        for(var key in res)
                        {
                            var new_item = '<div class="panel panel-default checkNumdiv"><div class="panel-heading">'+
                            '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion"  href="#collapse'+i+
                            '"><p><span class="typeName">'+res[key].QuestionTypeName+res[key].difficultyName+'</span>&nbsp;&nbsp;&nbsp;（<span class="checkNum" id="'+res[key].PaperConfigureID+'">'+res[key].QuestionTypeNumber+'</span>道）</p></a></h4></div> <div id="collapse'+i+'" class="panel-collapse collapse "><div class="panel-body">';
                            var j = i;
                            for(var key1 in res[key].choice){
                                new_item += "<p style=\"color:red;\">"+key1+"</p>";
                                for(var key2 in res[key].choice[key1])
                                {
                                    new_item += '<label><input class="newInput" name="'+res[key].PaperConfigureID+'" value="'+res[key].choice[key1][key2].QuestionBh+'" type="checkbox">'+"("+res[key].EveryQuestionSocre+"分)知识点："+
                                    res[key].choice[key1][key2].KnowledgeName+
                                    '题号：'+res[key].choice[key1][key2].CustomBh+'--'+res[key].choice[key1][key2].name+'</label><br>'
                                }
                            }
                            new_item += '</div></div></div>';
        					// parent.append(new_item);

        					$('#accordion').append(new_item);
        					i++;
        					// new_item.show(600,"swing");
                        }
                    }else {
                        alert(res.msg)
                    }

                }
            })
            // GetCanChoiceQuestion
            // alert(id);
        }
    })
    $(function (){
        var val = $('#term-choice').val();
        ajaxGetExamPlan(val,0);
    });
    
    $('#term-choice').change(function (e) {
        var val = $(this).val();
        e.preventDefault();
        ajaxGetExamPlan(val,0);
    });

    $(document).on('click','.newInput',function(){
           var typeID = $(this).attr('name');
           var num = parseInt($('#'+typeID).text());
           var checkedLength = parseInt($('input[name="'+typeID+'"]:checked').length);
           //alert(checkedLength+":"+num);
           var hh = num-checkedLength;
           if(hh<0){
              alert('你已超过最多可选的数量！');
                $(this).removeAttr('checked');
           }
    });

    // function submitCheck(){
    //   // submitFlag = 1;
    //    var subData = new Array();
    //     $('.checkNum').each(function(){
    //         num1 = parseInt($(this).text());  //模板数量
    //         var childArray = new Array();
    //         var configerId = $(this).attr('id');
    //         var configerID = new Array();
    //         $(this).find('.newInput:checked').each(function(){
    //         var val = $(this).val();
    //         configerID.push(val);
    //     });
    //         subData.push(configerID);
    //         //alert(configerID);
    //        /* checkedLength1 = $(this).parents('.checkNumdiv').find('input:checked').length;
    //         name = $(this).parents('.checkNumdiv').find('.typeName').text();
    //         if(num1!=checkedLength1){
    //             //alert('类型的题目数量与模板不相符！');
    //             alert('"'+name+'"  类型的题目数量应为'+num1+'道，已选'+checkedLength1+'道');
    //             submitFlag = 0;
    //         }*/
    //     });
    // };

    $('#add_question_ok').click(function(){
        var planVal = $('#teach-choice option:selected').val();
        var paperNum = $('#paperNum').val();
       /* submitCheck();
        var childValue = new Array();
        $('.newInput:checked').each(function(){
            var val = $(this).val();
            childValue.push(val);
        });*/
        var subData = new Array();
        var i = 0;
        $('.checkNumdiv').each(function(){
            //num1 = parseInt($(this).text());  //模板数量
            var configer = $(this).find('.checkNum').attr('id');
            var configerID = new Array();
            // subData[i]['id'] = configer;
            // subData.push({id:configer});
            $(this).find('.newInput:checked').each(function(){
                var val = $(this).val();
                configerID.push(val);
            });
            // alert(configer);
            var tmp = {"id":configer,"question":configerID};
            subData.push(tmp);
            // console.log(configer);  //有值
            // subData[i]['question'] = configerID;
            // subData.push({question:configerID});
            // subData[configer] = configerID;
            console.log(subData);
            i++;
        });
          $.ajax({
            type:'POST',
            url:'<?=Url::toRoute("paper/save-question")?>',
            data:{"examPlan":planVal,"id":subData,"paperNum":paperNum},
            datatype:'JSON',
            success:function(obj){
                var hh = JSON.parse(obj);
                if(parseInt(hh.status)==200){
                    alert("指定生成试卷成功");
                   window.location.reload();
                }else{
                    //alert(hh.msg);
                    alert('提交失败！');
                }
            },
            error:function(){
                alert('请求发送失败！');
            }
          })

    });

    function ajaxGetExamPlan(val,ExamPlan) {
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("//common/get-exam-plan")?>',
            data:{term:val,type:0},
            dataType:"JSON",
            success:function (value) {
                $('#teach-choice').empty();
                $('#teach-choice').append('<option>请选择</option>');
                for(var Tmp in value){
                    if (ExamPlan == value[Tmp]['ExamPlanBh']){
                        $('#teach-choice').append('<option selected="selected" value="'+ value[Tmp]['ExamPlanBh'] +'">'+ value[Tmp]['ExamPlanName'] +'</option>');
                    } else {
                        $('#teach-choice').append('<option value="'+ value[Tmp]['ExamPlanBh'] +'">'+ value[Tmp]['ExamPlanName'] +'</option>');
                    }
                }
            }
        })
    }

    $('#teach-choice').change(function (e) {
        e.preventDefault();
        window.location.href = '<?=Url::toRoute("paper/index")?>'+'&term='+$("#term-choice").val()+'&examPlan='+$(this).val();
    });

    $(document).ready(function () {
        var term = '<?=$TermChoice?>';
        if (term != 0) {
            var ExamPlan = '<?=$ExamPlan?>';
            $('#term-choice option[value='+ term +']').attr('selected','selected');
            ajaxGetExamPlan(term,ExamPlan);
            $('#teach-choice option[value='+ ExamPlan +']').attr('selected','selected');
        }
    });


    function searchAction(){
        $('#admin-module-search-form').submit();
    }
    function viewAction(id){
        window.location.href = '<?=Url::toRoute("paper/view")?>'+'&id='+id;
    }

    function initEditSystemModule(data, type){
        if(type == 'create'){
            $("#id").val('');
            $("#code").val('');
            $("#display_label").val('');
            $("#has_lef").val('');
            $("#des").val('');
            $("#entry_url").val('');
            $("#display_order").val('');
            $("#create_user").val('');
            $("#create_date").val('');
            $("#update_user").val('');
            $("#update_date").val('');

        }
        else{
            $("#id").val(data.id);
            $("#code").val(data.code);
            $("#display_label").val(data.display_label);
            $("#has_lef").val(data.has_lef);
            $("#des").val(data.des);
            $("#entry_url").val(data.entry_url);
            $("#display_order").val(data.display_order);
            $("#create_user").val(data.create_user);
            $("#create_date").val(data.create_date);
            $("#update_user").val(data.update_user);
            $("#update_date").val(data.update_date);
        }
        if(type == "view"){
            $("#id").attr({readonly:true,disabled:true});
            $("#code").attr({readonly:true,disabled:true});
            $("#display_label").attr({readonly:true,disabled:true});
            $("#has_lef").attr({readonly:true,disabled:true});
            $("#des").attr({readonly:true,disabled:true});
            $("#entry_url").attr({readonly:true,disabled:true});
            $("#display_order").attr({readonly:true,disabled:true});
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
            $("#display_label").attr({readonly:false,disabled:false});
            $("#has_lef").attr({readonly:false,disabled:false});
            $("#des").attr({readonly:false,disabled:false});
            $("#entry_url").attr({readonly:false,disabled:false});
            $("#display_order").attr({readonly:false,disabled:false});
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
            url: "<?=Url::toRoute('admin-module/view')?>",
            data: {"id":id},
            cache: false,
            dataType:"json",
            error: function (xmlHttpRequest, textStatus, errorThrown) {
                alert("出错了1，" + textStatus);
            },
            success: function(data){
                initEditSystemModule(data, type);
            }
        });
    }
//复制试卷
    function copyAction(){
        var ids = [];

            var checkboxs = $('#data_table :checked');
            if(checkboxs.size() > 0){
                var c = 0;
                for(var i = 0; i < checkboxs.size(); i++){
                    var id = checkboxs.eq(i).val();
                    if(id != ""){
                        ids[c++] = id;
                    }
                }
            }else{
                //   alert(3);
            }
        //alert(ids);
        if(ids.length !=0){
            //alert("123");
            $.ajax({
                type:"GET",
                data:{"ids":ids},
                url:"<?=Url::toRoute('paper/copy')?>",
                datatype:"json",
                catch:"false",
                error: function (xmlHttpRequest, textStatus, errorThrown) {
                 alert("出错了a，" + xmlHttpRequest.readState);
                 },
                success: function(data){
                   alert("复制试卷成功");
                    window.location.reload();
                    }
            });
        }
        else{
            alert("请选择你需要复制的试卷");
        }
    }
//输出试卷
    // function updateAction(id){
    //     window.location.href = '<?=Url::toRoute("paper/output")?>'+'&id='+id;
    // }
//删除试卷
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
            }else{
             //   alert(3);
            }
        }
       // alert(ids.length>0);
        if(ids.length !=0){
            admin_tool.confirm('请确认是否删除', function(){
                $.ajax({
                    type: "GET",
                    url: "<?=Url::toRoute('paper/delete')?>",
                    data: {"ids":ids},
                    cache: false,
                    dataType:"json",
                    error: function (xmlHttpRequest, textStatus, errorThrown) {
                        alert("出错了a，" + xmlHttpRequest.readState);
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
      /*  // submitCheck();

        if(submitFlag){
            $('#admin-module-form').submit();
        }else{
            alert(2);
        }*/

    });

    $('#create_btn').click(function (e) {
        e.preventDefault();
        var val = $('#teach-choice option:selected').val();
        console.log(val);
        if(val == null){
            alert('请选择考试计划');
        }else{
            initEditSystemModule('create');
        }
    });

    $('#delete_btn').click(function (e) {
        e.preventDefault();
        deleteAction('');
    });

    $('#copy_btn').click(function (e) {
        e.preventDefault();
        copyAction();
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
