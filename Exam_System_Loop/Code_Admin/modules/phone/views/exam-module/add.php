<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>


<?php $this->beginBlock('header');  ?>
    <!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">


                <div class="box-header">
                    <h3 class="box-title">考试模板配置->模板添加</h3><br><br>
                    <div style="background-color: #ffa2a8; width: 70%;">
                        <lable>更新后的分题方式：针对每个难度的阶段进行分题。难度和阶段全部变成单选，先选难度后选阶段，比如选择简单 一阶段后则会在下方显示一个简单一阶段的输入框，可以显示多个。</lable>
                    </div>
                </div>
                <h1></h1>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(['id' => 'examModuleAdd', 'class' => 'form-horizontal' ,'action' => '' ,'method' => 'post'])?>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">模块名称</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="moduleName" name="Tresourceexaminfo[PaperName]">
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-1 control-label col-md-offset-1">题目类型</label>
                            <div class="col-xs-1">
                                <select class="form-control" id="question-type-choice" style="width:100px;">
                                    <option value="0">请选择</option>
                                    <?php foreach ($type as $value){?>
                                        <option value="<?=$value['CuitMoon_DictionaryCode']?>"><?=$value['CuitMoon_DictionaryName']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <button class="btn btn-primary" id="question-type-add" style="margin-left:100px;">添加</button>
                        </div>
                    </div>




                    <h1></h1>
                    <div class="row">
                        <div class="col-xs-8 col-xs-offset-2">
                            <ul class="nav nav-tabs nav-justified" role="tablist" id="question-type">

                            </ul>

                        </div>
                    </div>

                    <div id="question-type-text" class="tab-content">
                        <div class="tab-pane fade  row" id="name">
                            <h1></h1>
                            <div class="col-xs-6 col-xs-offset-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>题目数量</td>
                                        <td><input class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>题目难度</td>
                                        <td>
                                            <?php foreach ($diff as $value){?>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="" value=""><?=$value["CuitMoon_DictionaryName"]?>
                                                </label>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>题目数量</td>
                                        <td>
                                            <?php foreach ($stage as $value){?>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" id="" value=""><?=$value["CuitMoon_DictionaryName"]?>
                                                </label>
                                            <?php }?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">总分</label>
                            <div class="col-xs-4" id="div-sum-socre">
                                0
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-10 col-md-offset-11">
                                <button id="question-Submit" type="button" class="btn btn-primary">提交</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </div>
</section>



<?php $this->beginBlock('footer');  ?>
<script>

    //add question type to Navigation bar
    $('#question-type-add').click(function (e) {
        e.preventDefault();
        var Tmp_One;
        var Tmp_Code = $('#question-type-choice').val();
        var Tmp = $('#question-type-choice').find("option:selected").text();
        $('#question-type').children().each(function (i) {
            //Has been added?
            if($(this).children().text() == Tmp){
                alert('你已经加入此题型了');
                Tmp_One = true;
                return false;
            }
        });
        if($('#moduleName').val().length!=0){
        if(Tmp_One != true && Tmp_Code!='0') {
            $('#question-type').append('<li role="presentation"><a href="#'+ Tmp_Code +'" data-toggle="tab">' + Tmp + '</a></li>');
            $('#question-type-text').append('<div class="tab-pane fade  row" id="'+ Tmp_Code +'">' +
                '<h1></h1>' +
                '<div class="col-xs-6 col-xs-offset-3">' +
                '<table class="table table-bordered" id="'+ Tmp_Code +'-type">' +
                '<tr><td>题目数量</td><td>' +
                '<input id="'+ Tmp_Code +'-num" class="form-control" name="'+ Tmp_Code +'-number"></td></tr>' +
                '<tr><td>题目难度</td>' +
                '<td><?php foreach ($diff as $value){?><label class="checkbox-inline" id="'+ Tmp_Code +'-diff"><input type="radio" name="diff" id="'+ Tmp_Code +'-'+ <?=$value["CuitMoon_DictionaryCode"]?> +'-diff" value="<?=$value["CuitMoon_DictionaryCode"]?>"><?=$value["CuitMoon_DictionaryName"]?></label><?php }?></td></tr><tr><td>题目阶段</td><td><?php foreach ($stage as $value){?><label class="checkbox-inline" id="'+ Tmp_Code +'-stage"><input type="radio" name="Stages['+ Tmp_Code +'][]" id="'+ Tmp_Code +'-stage" value="<?=$value["CuitMoon_DictionaryCode"]?>" onclick="Stage('+ Tmp_Code +')"><?=$value["CuitMoon_DictionaryName"]?></label><?php }?></td></tr><tr><td>知识点</td><td><div class="checkbox-inline" id="'+ Tmp_Code +'-konwledge" ></div></td></tr><tr><td>每种难度题目数量</td><td><table class="table" id="'+ Tmp_Code +'-new-table">' +
                '<tr><th>题目难度</th><th>题目知识点</th><th>题目总数</th><th>题目数量</th><th>每题分值</th><th>操作</th></tr></table></td></tr></table></div>')
        }
         }else{
         alert('请输入模版名称');
        }
});


    //Asynchronous get the number of questions
    function getkonwledge(Tmp_Code,Stage){
            var a=''
            $.ajax({
                type:'GET',
                url: '<?=Url::toRoute("exam-module/get-konwledge")?>',
                dataType: 'JSON',
                data: {'Stage':Stage},
                success: function (value) {
                     if(value!=null){
                        for(tmp in value){
                         if(($('#'+ Tmp_Code + '_'+Stage +'-konwledge').length)==0){
                         a=a+'<label id="'+ Tmp_Code + '_'+Stage +'-konwledge"><input type="radio" name="Knowledge['+ Tmp_Code +'][]" id="'+ Tmp_Code+'" value="'+value[tmp]['KnowledgeBh']+'" onclick="Knowledge('+ Tmp_Code+','+Stage+')">'+value[tmp]['KnowledgeName']+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>'
                         }
                        }
                        $('#'+Tmp_Code+'-konwledge').append(a)
                     }
                }
            })
    }

    function Stage(Tmp_Code){
        var Stage = []
        $('label[id='+ Tmp_Code +'-stage]').each(function (i) {
            if($(this).children().is(':checked')){
                Stage.push($(this).children().val());
                getkonwledge(Tmp_Code,Stage);
            }
        });
    }

    function Knowledge(Tmp_Code,Stage) {
        var Diff = []
        var Knowledge = []
        $('label[id='+ Tmp_Code +'_'+Stage+'-konwledge]').each(function (i){
             if($(this).children().is(':checked')){
                 Knowledge.push($(this).children().val());
             }
        });

        $('label[id='+ Tmp_Code +'-diff]').each(function (i) {
            if($(this).children().is(':checked')){
                Diff.push($(this).children().val());
            }
        });

        if(Diff[0] != null){
            if($("#"+Tmp_Code+"-"+Diff[0]+"-"+Knowledge[0]+"-rm").length==0) {
                console.log('s')
                if (Diff.length != 0 && Knowledge.length !=0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?=Url::toRoute("exam-module/get-question-sum")?>',
                        dataType: 'JSON',
                        data: {QuestionType: Tmp_Code, Diff: Diff, Knowledge: Knowledge},
                        success: function (value) {
                            if ($('input[id=' + Tmp_Code + '-' + Diff[0] + '-diff]').is(':checked')) {
                                $('#' + Tmp_Code + '-new-table').append('<tr id="' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '-rm"><td>' + value.diff + '</td>' +
                                    '<td id="' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '-stage">' + value.Knowledge['KnowledgeName'] + '</td>' +
                                    '<td id="' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '-question-sum">0</td>' +
                                    '<td><input data="' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '" id="' + Tmp_Code + '-Num" class="number2" name="Num[' + Tmp_Code + '][' + Diff[0] + '][' + Knowledge[0] + ']" onchange="javascript:checkYesOrNo(' + Tmp_Code + ',' + Diff[0] + ',&quot;'+ Knowledge[0]+'&quot;);"></td>' +
                                    '<td><input dataOne="' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '"  id="' + Tmp_Code + '-Score" name="Score[' + Tmp_Code + '][' + Diff[0] + '][' + Knowledge[0] + ']" onchange="javascript:SumScore(' + Tmp_Code + ',' + Diff[0] + ',&quot;' + Knowledge[0] + '&quot;);"></td>' +
                                    '<td id="' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '-del"><button style="height:25px; width: 50px;" onclick="javascript:delCol(' + Tmp_Code + ',' + Diff[0] + ',&quot;' + Knowledge[0] + '&quot;)">删除</button></td></tr>'
                                )

                            } else {
                                $('#' + Tmp_Code + '-' + diff_code + '-rm').remove();
                            }

                            if (value.sum == 0) {
                            } else {
                                $('td[id=' + Tmp_Code + '-' + Diff[0] + '-' + Knowledge[0] + '-question-sum]').text(value.sum)
                            }
                        }
                    })
                }
            }
        }else{
            alert('请先选择难度。');
            $('label[id='+ Tmp_Code +'-Knowledge]').each(function (i) {
                if($(this).children().is(':checked')){
                    $(this).children().attr("checked",false);
                }
            });

        }
    }

    //删除 行
    function delCol(Tmp_Code, diff_code, stage_code){
        $('#'+ Tmp_Code +'-'+ diff_code +'-'+ stage_code +'-rm').remove();
    }

    //check whether the number of input is correct
    function checkYesOrNo(Tmp_Code,diff_code,stage_code) {
        // var num1 = $('#'+Tmp_Code+'-num').val();
        var Sum = getSum();
        var Tnum = getNum();

        var Tmp = $('input[data='+ Tmp_Code +'-'+ diff_code +'-'+ stage_code +']').val();
        var Nims = $('#'+ Tmp_Code +'-'+ diff_code +'-'+ stage_code +'-question-sum').text();
        /*if(parseInt(num1) != parseInt(Tmp)){
            alert("sure the number！");
        } */
        if(parseInt(Tmp) > parseInt(Nims) || parseInt(Sum)>100){
            alert('题目数量不能大于题库总数！');
            $('input[data='+ Tmp_Code +'-'+ diff_code +'-'+ stage_code +']').val("");
        }else{
            $('#div-sum-socre').text(Sum);
            $('#'+ Tmp_Code+'-num').val(Tnum);
        }
    }

    //check whether the socre of input is correct
    function SumScore(Tmp_Code,diff_code,stage_code) {
        var Sum = getSum();
        var Tmp = $('input[dataOne='+ Tmp_Code +'-'+ diff_code +'-'+ stage_code +']').val();
        if(parseInt(Tmp)<0 || parseInt(Tmp)>100 || parseInt(Sum)>100){
            alert("请输入正确参数");
            $('input[dataOne='+ Tmp_Code +'-'+ diff_code +'-'+ stage_code +']').val("");
        }else{
            $('#div-sum-socre').text(Sum);
        }
    }

    //Calculate the total score
    function getSum() {
        var Tmp_Code = [];
        $('a[data-toggle="tab"]').each(function (i) {
            var Tmp = $(this).attr('href');
            Tmp_Code.push(Tmp.substr(1));
        })
        var Num = []
        var Score = []
        for(var key in Tmp_Code){
            $('input[id='+ Tmp_Code[key] +'-Num]').each(function (i) {
                if($(this).val() == ""){
                    Num.push(0);
                }else{
                    Num.push($(this).val())
                }
            })
            $('input[id='+ Tmp_Code[key] +'-Score]').each(function (i) {
                if($(this).val() == ""){
                    Score.push(0);
                }else{
                    Score.push($(this).val())
                }
            })
        }
        var Sum = 0;
        for(var k in Num){
            Sum += Num[k]*Score[k];
        }
        return Sum;
    }
    //Calculate the total number
    function getNum() {
        var Tmp_Code = [];
        $('a[data-toggle="tab"]').each(function (i) {
            var Tmp = $(this).attr('href');
            Tmp_Code.push(Tmp.substr(1));
        })
        var Num = []
        for(var key in Tmp_Code){
            $('input[id='+ Tmp_Code[key] +'-Num]').each(function (i) {
                if($(this).val() == ""){
                    Num.push(0);
                }else{
                    Num.push($(this).val())
                    console.log($(this).val())
                }
            })
        }
        var Sum = 0;
        for(var k in Num){
            Sum += parseInt(Num[k]);
            console.log(Num[k])
        }
        return Sum;
    }

    //Switch Navigation Bar
    $('#question-type a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });


    //Submit
    $('#question-Submit').click(function (e) {
        e.preventDefault();
        sum=getSum();
        if(sum==100) {
            $('#examModuleAdd').submit();
        }else{
            alert('总分必须为100分');
        }
    });

    $('#examModuleAdd').bind('submit',function (e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type:'POST',
            url:'<?=Url::toRoute("exam-module/create")?>',
            dataType:'JSON',
            success:function (value) {
                if(value.error == 0){
                    window.location.href = '<?=Url::toRoute("exam-module/index")?>'
                }else{
                    alert('添加失败');
                }
            }
        })
    });


</script>

<?php $this->endBlock(); ?>
