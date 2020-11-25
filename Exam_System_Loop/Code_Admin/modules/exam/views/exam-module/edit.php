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
                    <h3 class="box-title">考试模板配置->模板更新</h3><br><br>
                    <div style="background-color: #ffa2a8; width: 70%;">
                        <lable>更新后的分题方式：针对每个难度的阶段进行分题。难度和阶段全部变成单选，先选难度后选阶段，比如选择简单 一阶段后则会在下方显示一个简单一阶段的输入框，可以显示多个。</lable>
                    </div>
                </div>
                <h1></h1>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(['id' => 'examModuleAdd', 'class' => 'form-horizontal' ,'action' => '' ,'method' => 'post'])?>
                    <input type="hidden" class="form-control" name="configId" value="<?=$id?>">
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">模块名称</label>
                            <div class="col-xs-4">
                                <input value="<?=$config['info']['ExamPaperName']?>" type="text" class="form-control" id="moduleName" name="Examconfigrecord[ExamPaperName]">
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-1 control-label col-md-offset-1">模块备注</label>
                            <div class="col-xs-4">
                                <textarea value="<?=$config['info']['ConfigMemo']?>" class="form-control" rows="3" id="moduleRemarks" name="Examconfigrecord[ConfigMemo]"></textarea>
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
                                <?php $i=0;if(isset($config['type']['name'])){foreach($config['type']['name'] as $key) {?>
                                    <li role="presentation"><a href="#<?=$config['type']['code'][$i]?>" data-toggle="tab"> <?=$key?> </a></li>
                                <?php $i++;}}?>
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
                        <?php foreach($config['papers'] as $key=>$val){?>
                        <div class="tab-pane fade  row" id="<?=$key?>">
                            <h1></h1>
                            <div class="col-xs-6 col-xs-offset-3">
                                <table class="table table-bordered" id="<?=$key?>-type">
                                    <tr>
                                        <td>题目数量</td>
                                        <td>
                                            <input id="<?=$key?>-num" class="form-control" name="<?=$key?>-number">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>题目难度</td>
                                        <td>
                                            <?php foreach ($diff as $value){?>
                                                <label class="checkbox-inline" id="<?=$key?>-diff"><input type="radio" name="diff" id="<?=$key?>-<?=$value["CuitMoon_DictionaryCode"]?>-diff" value="<?=$value["CuitMoon_DictionaryCode"]?>"><?=$value["CuitMoon_DictionaryName"]?></label>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>题目阶段</td>
                                        <td>
                                            <?php foreach ($stage as $value){?>
                                                <label class="checkbox-inline" id="<?=$key?>-stage"><input type="radio" name="Stages[<?=$key?>][]" id="<?=$key?>-stage" value="<?=$value["CuitMoon_DictionaryCode"]?>" onclick="Stage('<?=$key?>')"><?=$value["CuitMoon_DictionaryName"]?></label>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>每种难度题目数量</td>
                                        <td>
                                            <table class="table" id="<?=$key?>-new-table">
                                                <tr>
                                                    <th>题目难度</th>
                                                    <th>题目阶段</th>
                                                    <th>题目总数</th>
                                                    <th>题目数量</th>
                                                    <th>每题分值</th>
                                                    <th>操作</th>
                                                </tr>
                                                <?php foreach ($val as $keys=>$vals) {foreach ($vals as $k => $v){?>
                                                    <tr id="<?=$key?>-<?=$v['difficulty']?>-<?=$v['stage']?>-rm">
                                                        <td><?=$v['diff_name']?></td>
                                                        <td id="<?=$key?>-<?=$v['difficulty']?>-<?=$v['stage']?>-stage"><?=$v['stage_name']?></td>
                                                        <td id="<?=$key?>-<?=$v['difficulty']?>-<?=$v['stage']?>-question-sum"><?=$v['ques_num']?></td>
                                                        <td><input value="<?=$v['QuestionTypeNumber']?>" data="<?=$key?>-<?=$v['difficulty']?>-<?=$v['stage']?>" id="<?=$key?>-Num" class="number2" name="Num[<?=$key?>][<?=$v['difficulty']?>][<?=$v['stage']?>]" onchange="javascript:checkYesOrNo(<?=$key?>,<?=$v['difficulty']?>,<?=$v['stage']?>);"></td>
                                                        <td><input value="<?=$v['EveryQuestionSocre']?>" dataOne="<?=$key?>-<?=$v['difficulty']?>-<?=$v['stage']?>"  id="<?=$key?>-Score" name="Score[<?=$key?>][<?=$v['difficulty']?>][<?=$v['stage']?>]" onchange="javascript:SumScore(<?=$key?>,<?=$v['difficulty']?>,<?=$v['stage']?>);"></td>
                                                        <td id="<?=$key?>-<?=$v['difficulty']?>-<?=$v['stage']?>-del"><button type="button" style="height:25px; width: 50px;" onclick="javascript:delCol(<?=$key?>,<?=$v['difficulty']?>,<?=$v['stage']?>)">删除</button></td>
                                                    </tr>
                                                <?php }}?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <?php }?>

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
        if(Tmp_One != true && Tmp_Code!='0') {
            $('#question-type').append('<li role="presentation"><a href="#'+ Tmp_Code +'" data-toggle="tab">' + Tmp + '</a></li>');
            $('#question-type-text').append('<div class="tab-pane fade  row" id="'+ Tmp_Code +'">' +
                '<h1></h1>' +
                '<div class="col-xs-6 col-xs-offset-3">' +
                '<table class="table table-bordered" id="'+ Tmp_Code +'-type">' +
                '<tr><td>题目数量</td><td>' +
                '<input id="'+ Tmp_Code +'-num" class="form-control" name="'+ Tmp_Code +'-number"></td></tr>' +
                '<tr><td>题目难度</td>' +
                '<td><?php foreach ($diff as $value){?><label class="checkbox-inline" id="'+ Tmp_Code +'-diff"><input type="radio" name="diff" id="'+ Tmp_Code +'-'+ <?=$value["CuitMoon_DictionaryCode"]?> +'-diff" value="<?=$value["CuitMoon_DictionaryCode"]?>"><?=$value["CuitMoon_DictionaryName"]?></label><?php }?></td></tr><tr><td>题目阶段</td><td><?php foreach ($stage as $value){?><label class="checkbox-inline" id="'+ Tmp_Code +'-stage"><input type="radio" name="Stages['+ Tmp_Code +'][]" id="'+ Tmp_Code +'-stage" value="<?=$value["CuitMoon_DictionaryCode"]?>" onclick="Stage('+ Tmp_Code +')"><?=$value["CuitMoon_DictionaryName"]?></label><?php }?></td></tr><tr><td>每种难度题目数量</td><td><table class="table" id="'+ Tmp_Code +'-new-table">' +
                '<tr><th>题目难度</th><th>题目阶段</th><th>题目总数</th><th>题目数量</th><th>每题分值</th><th>操作</th></tr></table></td></tr></table></div>')
        }
    });

    //add question difficulty
    //function Diff(Tmp_Code,diff_code) {
    //    $.ajax({
    //        type:'GET',
    //        url:'<?//=Url::toRoute('exam-module/fool')?>//',
    //        dataType:'JSON',
    //        data:{code:diff_code},
    //        success:function (Value) {
    // if($('input[id='+ Tmp_Code +'-'+ diff_code +'-diff]').is(':checked')){
    //     $('#'+ Tmp_Code +'-new-table').append('<tr id="'+ Tmp_Code +'-'+ diff_code +'-rm"><td>'+ Value +'</td>' +
    //         '<td id="'+ Tmp_Code +'-'+ diff_code +'-question-sum">0</td>' +
    //         '<td id="'+ Tmp_Code +'-'+ diff_code +'-question-sum">0</td>' +
    //         '<td><input data="'+ Tmp_Code +'-'+ diff_code +'" id="'+ Tmp_Code +'-Num" class="number2" name="Num['+ Tmp_Code +']['+ diff_code +']" onchange="javascript:checkYesOrNo('+ Tmp_Code +','+  diff_code +');"></td>' +
    //         '<td><input dataOne="'+ Tmp_Code +'-'+ diff_code +'"  id="'+ Tmp_Code +'-Score" name="Score['+ Tmp_Code +']['+ diff_code +']" onchange="javascript:SumScore('+ Tmp_Code +','+  diff_code +');"></td></tr>')
    //         Stage(Tmp_Code);
    // }else{
    //     $('#'+ Tmp_Code +'-'+ diff_code +'-rm').remove();
    // }
    //         }
    //     })
    // }

    //Asynchronous get the number of questions
    function Stage(Tmp_Code) {
        var Stage = []
        var Diff = []
        //loop get stages
        $('label[id='+ Tmp_Code +'-stage]').each(function (i) {
            if($(this).children().is(':checked')){
                Stage.push($(this).children().val());
            }
        });
        //loop get diificult
        $('label[id='+ Tmp_Code +'-diff]').each(function (i) {
            if($(this).children().is(':checked')){
                Diff.push($(this).children().val());
            }
        });
        if(Diff[0] != null){
            if($("#"+Tmp_Code+"-"+Diff[0]+"-"+Stage[0]+"-rm").length==0) {
                console.log('s')
                if (Diff.length != 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?=Url::toRoute("exam-module/get-question-sum")?>',
                        dataType: 'JSON',
                        data: {QuestionType: Tmp_Code, Stage: Stage, Diff: Diff},
                        success: function (value) {
                            if ($('input[id=' + Tmp_Code + '-' + Diff[0] + '-diff]').is(':checked')) {
                                $('#' + Tmp_Code + '-new-table').append('<tr id="' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '-rm"><td>' + value.diff + '</td>' +
                                    '<td id="' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '-stage">' + value.stage + '</td>' +
                                    '<td id="' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '-question-sum">0</td>' +
                                    '<td><input data="' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '" id="' + Tmp_Code + '-Num" class="number2" name="Num[' + Tmp_Code + '][' + Diff[0] + '][' + Stage[0] + ']" onchange="javascript:checkYesOrNo(' + Tmp_Code + ',' + Diff[0] + ',' + Stage[0]+ ');"></td>' +
                                    '<td><input dataOne="' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '"  id="' + Tmp_Code + '-Score" name="Score[' + Tmp_Code + '][' + Diff[0] + '][' + Stage[0] + ']" onchange="javascript:SumScore(' + Tmp_Code + ',' + Diff[0] + ',' + Stage[0] + ');"></td>' +
                                    '<td id="' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '-del"><button style="height:25px; width: 50px;" onclick="javascript:delCol(' + Tmp_Code + ',' + Diff[0] + ',' + Stage[0] + ')">删除</button></td></tr>'
                                )

                            } else {
                                $('#' + Tmp_Code + '-' + diff_code + '-rm').remove();
                            }

                            if (value.sum == 0) {
                            } else {
                                $('td[id=' + Tmp_Code + '-' + Diff[0] + '-' + Stage[0] + '-question-sum]').text(value.sum)
                            }
                        }
                    })
                }
            }
        }else{
            alert('请先选择难度。');
            $('label[id='+ Tmp_Code +'-stage]').each(function (i) {
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
        if(confirm('当前分值:'+getSum()+',是否确认')) {
            $('#examModuleAdd').submit();
        }
    });

    $('#examModuleAdd').bind('submit',function (e) {
        e.preventDefault();
        $(this).ajaxSubmit({
            type:'POST',
            url:'<?=Url::toRoute("exam-module/update")?>',
            dataType:'JSON',
            success:function (value) {
                if(value.error == 0){
                    alert(value.info)
                    window.location.href = '<?=Url::toRoute("exam-module/index")?>'
                }else{
                    alert(value.info);
                }
            }
        })
    });


</script>

<?php $this->endBlock(); ?>
