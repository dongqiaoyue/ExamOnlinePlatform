
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

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">成绩管理</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <button id="create_btn" type="button" class="btn btn-xs btn-primary">上&nbsp;&emsp;报</button>
                            |
                            <button id="get_excel" type="button" class="btn btn-xs btn-primary">导出Excel</button>
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
                                        <option value="<?=$value['CuitMoon_DictionaryName']?>" <?php if($value['CuitMoon_DictionaryName'] == $now_term){?>selected="selected" <?php }?>><?=$value['CuitMoon_DictionaryName']?></option>
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
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'总成绩'.'</th>';

                                        if (isset($examPlan)) {
                                            foreach ($examPlan as $item) {
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.$item->ExamPlanName.'</th>';
                                            }
                                        }
                                        echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >'.'操作'.'</th>';

                                        ?>

                                        <!--                                        <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if($choice['Term_Choice']) {
                                        $row = 0;
                                        foreach ($list as $model) {
                                            echo '<tr id="rowid_' . $model['info']->StuNumber . '">';
                                            echo '  <td><label><input type="checkbox" value="' . $model['info']->StuNumber . '"></label></td>';
                                            echo '  <td>' . $model['info']->StuNumber . '</td>';
                                            echo '  <td>' . $model['info']->Name . '</td>';
                                            echo '  <td>' . $model['info']->Sex  . '</td>';
                                            echo '  <td>' . 0 . '</td>';
                                            for ($i=1; $i<=$count; $i++) {
                                                echo '  <td>' . $model[$i]. '</td>';
                                            }
                                            echo '  <td class="center">';
                                            echo '      <a id="view_btn" onclick="viewAction(' . "' '" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>查看</a>';
                                            echo '      <a id="view_btn" onclick="viewAction(' . "' '" . ')" class="btn btn-primary btn-sm" href="#"> <i class="glyphicon glyphicon-zoom-in icon-white"></i>上报</a>';
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
              <!--           <?php if(isset($pages)){?>
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
                        <?php }?> -->
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

<?php $this->beginBlock('footer');  ?>
<!-- <body></body>后代码块 -->
<script>

    $(function (){
        var val = $('#term-choice').val();
        ajaxGetClass(val,0);
    });
    $('#term-choice').change(function (e) {
        var val = $(this).val();
        e.preventDefault();
        ajaxGetClass(val,0);
    });


    function ajaxGetClass(val,classId) {
        $.ajax({
            type:'get',
            url:'<?=Url::toRoute("grade-sum/get-class")?>',
            data:{term:val},
            dataType:"JSON",
            success:function (value) {
                $('#class-choice').empty();
                $('#class-choice').append('<option>请选择</option>')
                for(var Tmp in value){
                    if (value[Tmp]['TeachingClassID'] == classId) {
                        $('#class-choice').append('<option selected="selected" value="'+ value[Tmp]['TeachingClassID'] +'">'+ value[Tmp]['TeachingName'] +'</option>');
                    } else {
                        $('#class-choice').append('<option value="'+ value[Tmp]['TeachingClassID'] +'">'+ value[Tmp]['TeachingName'] +'</option>');
                    }
                }
            }
        })
    }

    $('#class-choice').change(function (e) {
        e.preventDefault();
        window.location.href = '<?=Url::toRoute("grade-sum/index")?>'+'&term='+$("#term-choice").val()+'&classID='+$(this).val();
    });

    $(document).ready(function () {
        var term = '<?=$choice["Term_Choice"]?>';
        if (term != false) {
            var classChoice = '<?=$choice["ClassID_Choice"]?>';
            $('#term-choice option[value='+ term +']').attr('selected','selected');
            ajaxGetClass(term,classChoice);
        }
    });

    function markAction(id) {
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute("mark/mark")?>',
            dataType:'json',
            data:{PaperID:id},
            success: function (value) {
                if (value.error == 0) {
                    $('#'+id+'-Score').text(value.msg);
                } else {
                    alert('批阅失败');
                }
            }
        })
    }


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
                alert("出错了，" + textStatus);
            },
            success: function(data){
                initEditSystemModule(data, type);
            }
        });
    }

    function editAction(id){
//        initModel(id, 'edit');
        window.location.href = '<?=Url::toRoute("mark/manual-mark")?>'+'&id='+id;
    }

    function getExcel(){
        window.location.href="<?=Url::toRoute('grade-sum/get-excel')?>"+"&classID="+$('#class-choice').val();
        // $.post(
        //         "<?=Url::toRoute('grade-sum/get-excel')?>",
        //         {
        //             classID:$('#class-choice').val(),
        //         },
        //         function(res){

        //         }
        //     )

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

    $('#get_excel').click(function (e) {
        e.preventDefault();
        getExcel();
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