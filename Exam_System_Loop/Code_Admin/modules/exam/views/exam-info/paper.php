
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>
<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->
<style type="text/css">
    input[type=radio]{
        margin-left:20px;
    }
    #time{
        margin-top: -18px;
        margin-bottom: 10px;
        float:right;
        width:100%;
        height:25px;
        line-height: 25px;
        text-align: right;
        border-bottom: 1px solid gray;
    }
    *{
        font-size: 14px;
        font-family: "微软雅黑";
        font-weight: normal;
    }
    button{
        white-space:nowrap;
        text-overflow:ellipsis;
        -o-text-overflow:ellipsis;
        overflow-x: hidden;
    }

</style>

<html>
<body>
<?php $this->endBlock(); ?>

<section class="content">
    <h1 class="text-center">过程化考核平台</h1>
    <div class="row" >
        <div class="col-xs-8 col-xs-offset-2">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <?php foreach ($info as $key=>$data){?>
                                <li name="<?=$key?>-href"><a href="#"><?=$com->codeTranName($key)?></a></li>
                            <?php }?>
                        </ul>

                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="row">
                <div class="col-xs-12">
                 <div id="theGrade" style="float:right; margin-left: 20px; position: fixed; right:2%; z-index: 999;">
                        <button  class="btn btn-success">分数</button>
                        <input value="<?=$score?>" id="score" style="width:100px;"></input>
                    </div>

                    <div id="myBut" style="float:right; position: fixed; right:15%; z-index: 999;">
                        <button  class="btn btn-success" onclick="submit()">完成修正</button>
                    </div>
                    <h2> C语言考试试卷</h2>
                </div>
            </div>

            <?php ActiveForm::begin(["id" => "submit-paper", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]);?>
            <input id="paperId" name="PaperID" value="<?=$paperID?>" type="hidden">
            <?php foreach ($info as $k=>$value) {?>
                <div class="">
                    <div class="row">
                        <div class="col-xs-1">
                            <button type="button"  id="<?=$k?>-href" class="btn btn-lg btn-primary" onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                        </div>
                    </div>
                    <h1></h1>
                    <div style="display: none" id="<?=$k;?>">
                        <?php foreach ($value as $key=>$item) {?>
                            <div class="row" id="<?=$k;?>" >
                                <button type="button" name="<?=$item['Score'];?>" class="btn btn-default col-xs-10 col-xs-offset-1" onclick="toggle(<?=$i?>)">(<?=$item['Score'];?> 分) <?=$i.'.'.$item['CustomBh'];?>   <?=$item['name']?></button>

                                <div class="col-xs-10 col-xs-offset-1" style="display: none; float:left; " id="<?=$i;?>">
                                    <?=$item['Description'];?>
                                    <?=switchType($k, $item);?>

                                </div>

                            </div>
                            <h6></h6>
                            <?php $i++; }?>
                    </div>
                </div>
            <?php }?>
            <?php ActiveForm::end();?>

        </div>
    </div>
</section>

<?php $this->beginBlock('footer');  ?>
</body>
</html>
<!-- <body></body>后代码块 -->
<script>
    $(".answ").click(function(){
        if($(this).next('.Answer11').css("display")=="none")
        {
            $(this).next('.Answer11').css("display","block");
        }
        else
        {
            $(this).next('.Answer11').css("display","none");
        }
    });
    String.prototype.NoSpace = function() 
    { 
        return this.replace(/\s+/g, ""); 
    }

    $('input:radio').each(function(){
            if($(this).attr('checked','checked')){
                var Fan = $(this).val();
                var Fan1 = '"'+Fan+'"';
                var Fan2 = $(this).siblings('label').text().NoSpace();
                if(Fan1==Fan2){
                $(this).parents('.row').children('button').css('background-color','#EFE29F');
                $(this).attr('disabled','true');
                $(this).siblings('input:radio').attr('disabled','true');
                }else{
                    $(this).parents('.row').children('button').css('background-color','#e6e6e6');
                    $(this).removeAttr('disabled');
                    $(this).siblings('input:radio').removeAttr('disabled');
                }
            }
    });

    $("input:radio").click(function(){
        var an = $(this).val();
        var an1 = '"'+an+'"';
        var an2 = $(this).siblings('label').text().NoSpace();
        var add = parseFloat($(this).parents('.row').children('button').attr("name"));
        $(this).parents('.row').children('button').css('background-color','#EFE29F');

        if(an1==an2){
           var score = parseFloat($('#score').val());
           score +=add;
           $('#score').val(score);
        }else{
           var score = parseFloat($('#score').val());
           score -=add;
           $('#score').val(score);
           $(this).parents('.row').children('button').css('background-color','#e6e6e6');
        }
    });

    function toggle(id) {
        var display =$('#'+id).css('display');
        if (display == 'none') {
            $('#'+id).slideDown(500);
        } else {
            $('#'+id).slideUp(500);
        }
    }

    function compile(id) {
        var code = $('textarea[name="'+ id +'"]').val();
        if (code == ""){
            alert("请输入代码");
        }else {
            $('#compile'+ id +'').text('正在编译');
            $('#compile'+ id +'').attr("disabled","disabled");
            $.ajax({
                type: 'POST',
                url: '<?=Url::toRoute("/common/compile")?>',
                dataType: "JSON",
                data: {"id": id, "code": code},
                success: function (value) {
                    $('#compile'+ id +'').text('编译');
                    $('#compile'+ id +'').removeAttr('disabled');
                    $('#score' + id + '').text(value);

                    var score = parseFloat($('#score').val());
                    score +=5;
                    $('#score').val(score);
                },
                error:function(){
                    $('#compile'+ id +'').text('编译');
                    $('#compile'+ id +'').removeAttr('disabled');
                    $('#score' + id + '').text('编译失败');
                }
            })
        }
    }

    function submit() {
        $('#submit-paper').submit();
    }

    $('#submit-paper').bind('submit',function (e) {
        e.preventDefault();
        var Url = '<?=Url::toRoute("exam-info/save-paper")?>';
        $(this).ajaxSubmit({
            url:Url,
            type:'post',
            dataType:'json',
            data:{},
            success:function (value) {
                if (value.error == 0 && $('#save-paper').attr('value') != true) {
                    window.location.href = '<?=Url::toRoute($param)?>';
                }
            }
        })
    });

    $(document).ready(function () {
        var term = <?=$answer?>;
        for (var tmp in term) {
            switch (term[tmp].Memo) {
                case '1000203':
                case '100020101':
                    $('input[name=' + term[tmp].QuestionBh + '][value=' + term[tmp].Answer + ']').attr("checked", 'checked');
                    break;
                case '1000206':
                    var test = $('[name='+ term[tmp].QuestionBh+']').val(term[tmp].Answer);
                    break;
                case '1000208':
                    var NewAnswer = new Array();
                    NewAnswer = term[tmp].Answer.split('@');
                    for (var i=0; i<NewAnswer.length - 1 ; i++) {
                        $('#'+i+term[tmp].QuestionBh).val(NewAnswer[i]);
                    }
                    break;
            }
        }
    });


    $(".nav li").click(function(){
        var _rel = $(this).attr("name");
        var pos = $('#'+_rel).offset().top;
        $("html,body").animate({scrollTop:pos},300);
    });

</script>
<?php $this->endBlock(); ?>

<?php
function switchType($type, $question){
    switch ($type){
        case '100020101':
            echo '<input type="radio" value="A" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;A
            <input type="radio" value="B" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;B
            <input type="radio" value="C" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;C
            <input type="radio" value="D" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;D';
            echo '<label style="float: right">"'.$question['Answer'].'"</label></br></br>';
            break;
        case '100020102':
            echo '<input type="checkbox" value="A" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;A
            <input type="checkbox" value="B" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;B
            <input type="checkbox" value="C" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;C
            <input type="checkbox" value="D" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;D';
            echo '<label style="float: right">"'.$question['Answer'].'"</label></br></br>';

            break;
        case '1000203':
            echo '<input type="radio" value="1" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;对
            <input type="radio" value="0" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;错';
            echo '<label style="float: right">"'.$question['Answer'].'"</label></br></br>';
            break;
        case '1000204':

            break;
        case '1000205':

            break;
        case '1000206':
            $QuestionBh = $question['QuestionBh'];
            if ($question['IsProgramBlank'] == '100001') {
                echo '<h1></h1><textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'" >';
                echo '</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'"></strong>';
            } else {
                echo '<h1></h1><textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'"></strong>';
            }

            break;
        case '1000207':

            break;
        case '1000208':
            $m_find_error = new \app\models\question\FindError();
            $Tmp_Error = $m_find_error->find()->where([
                'QuestionBh' => $question['QuestionBh']
            ]);
            $Error = $Tmp_Error->asArray()->all();
            for ($i = 0; $i<$Tmp_Error->count(); $i++) {
                $Tmp_Answer = json_decode($Error[$i]['Answer']);
                echo $i+1 .':<input id="'.$i.$question['QuestionBh'].'" type="text" name="'.$question['QuestionBh'].'[]"/>';
                echo '<label style="float: right">"'.$Tmp_Answer->key[0]->Answer.'"</label></br></br>';
            }
            break;
    }
}
?>
