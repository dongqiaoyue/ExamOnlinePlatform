
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

    .noFlow{
        width:100%;
        overflow:hidden;
        text-overflow: ellipsis;
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
    #myBut{
        position: fixed;
        top:80px;
        right:5%;
        z-index: 2;
    }
    #total_score{
        border:1px solid gray;
    }
</style>

<html>
<body>
<?php $this->endBlock(); ?>

<section class="content">
<!--     <h1 class="text-center">过程化考核平台</h1> -->
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
                    <div id="myBut" style="float:right; ">
                        <label >总分:</label><input type="text" disabled="disabled" id="total_score" value="<?=$score?>"/>
                        <button  class="btn btn-success" onclick="submit()">完成批阅</button>
                    </div>
                    <?php foreach($type as $model){?>
                    <h2> <?=$model?></h2>
                </div>
            </div>

            <?php ActiveForm::begin(["id" => "submit-paper", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]);?>
            <input name="PaperID" value="<?=$paperID?>" type="hidden">
            <?php if($model=="C语言程序设计" || $model=="数据结构"){?>
            <?php foreach ($info as $k=>$value) {if($k!="100020101"&&$k!="1000203"&&$k!="1000206"){?>
                <div class="BigBox">
                    <div class="row">
                        <div class="col-xs-1">
                            <button type="button" id="<?=$k?>-href" class="btn btn-lg btn-primary" onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                        </div>
                    </div>
                    <h1></h1>
                    <div style="" id="<?=$k;?>">
                        <?php foreach ($value as $key=>$item) {?>

                             <div class="row box1 <?=$k;?>" id="<?=$k;?>" name="<?=$item['QuestionBh'];?>">
                                <button type="button" id="<?=$k;?>-1" class="btn btn-default col-xs-10 col-xs-offset-1" onclick="toggle(<?=$i?>)"><div class="noFlow">(<?=$item['Score'];?> 分) <?=$i.'.'.$item['CustomBh'];?>   <?=$item['name']?></div></button>

                                <div class="col-xs-10 col-xs-offset-1" style="float:left; " id="<?=$i;?>">
                                    <?=$item['Description'];?>
                                    <?=switchType($k, $item,$answer);?>

                                </div>

                            </div>
                            <h6></h6>
                            <?php $i++; }?>
                    </div>
                </div>
            <?php }?>
            <?php }?>

            <?php } else if($model=="JSP课程"){?>
                <?php foreach ($info as $k=>$value) {if($k!="100020101"&&$k!="1000203"){?>
                    <div class="BigBox">
                        <div class="row">
                            <div class="col-xs-1">
                                <button type="button"  id="<?=$k?>-href" class="btn btn-lg btn-primary" onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                            </div>
                        </div>
                        <h1></h1>
                        <div style="" id="<?=$k;?>">
                            <?php foreach ($value as $key=>$item) {?>

                                 <div class="row box1 <?=$k;?>" id="<?=$k;?>" name="<?=$item['QuestionBh'];?>">
                                    <button type="button" id="<?=$k;?>-1" class="btn btn-default col-xs-10 col-xs-offset-1" onclick="toggle(<?=$i?>)"><div class="noFlow">(<?=$item['Score'];?> 分) <?=$i.'.'.$item['CustomBh'];?>   <?=$item['name']?></div></button>

                                    <div class="col-xs-10 col-xs-offset-1" style="float:left; " id="<?=$i;?>">
                                        <?=$item['Description'];?>
                                        <?=switchType($k, $item,$answer);?>

                                    </div>

                                </div>
                                <h6></h6>
                                <?php $i++; }?>
                        </div>
                    </div>
                <?php }?>
                <?php }?>
              <?php } else{?>
                <?php foreach ($info as $k=>$value) {if($k!="100020101"&&$k!="1000203"){?>
                    <div class="BigBox">
                        <div class="row">
                            <div class="col-xs-1">
                                <button type="button"  id="<?=$k?>-href" class="btn btn-lg btn-primary" onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                            </div>
                        </div>
                        <h1></h1>
                        <div style="" id="<?=$k;?>">
                            <?php foreach ($value as $key=>$item) {?>

                                <div class="row box1" id="<?=$k;?>" >
                                    <button type="button" id="<?=$k;?>-1" class="btn btn-default col-xs-10 col-xs-offset-1" onclick="toggle(<?=$i?>)"><div class="noFlow">(<?=$item['Score'];?> 分) <?=$i.'.'.$item['CustomBh'];?>   <?=$item['name']?></div></button>

                                    <div class="col-xs-10 col-xs-offset-1" style="float:left; " id="<?=$i;?>">
                                        <?=$item['Description'];?>
                                        <?=switchType($k, $item,$answer);?>

                                    </div>

                                </div>
                                <h6></h6>
                                <?php $i++; }?>
                        </div>
                    </div>
                <?php }?>
                  <?php }?>
                  <?php }?>
            <?php ActiveForm::end();?>
            <?php }?>

        </div>
    </div>
</section>

<?php $this->beginBlock('footer');  ?>
</body>
</html>
<!-- <body></body>后代码块 -->
<script>
$(document).ready(function(){
        $(".1000204").each(function(){
        var _name = $(this).attr('name');
        var name = $(this).attr('name')+'[]';
        var self = $(this);
        self.find('input').each(function(i){
            var id = i+self.attr('name');
            $(this).attr('name',name);
            $(this).attr('id',id);
            $(this).attr('disabled','disabled');
        });
        $(this).find(".100204").removeAttr('disabled');
        $(this).find(".100204").removeAttr('id');
        $(this).find(".100204").attr('id',"score_"+$(this).attr('name'));
    });

});

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
        var max = parseFloat($("#get_score_"+id).attr("data-score"));
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
                    $('#score' + id + '').text(value*max/100);
                }
            })
        }
    }

    function submit() {
        $.ajax({
            type: 'get',
            url: '<?=Url::toRoute("mark/manual-mark-deal")?>',
            dataType: "JSON",
            data: {"id": '<?=$paperID?>', "score": parseFloat($('#total_score').val())},
            success: function (value) {
                if (value.error == '0') {
                    //window.location.href = '<//=Url::toRoute($param)?>//';
                    window.history.go(-1);
                } else {
                    alert(value.msg);
                }
            }
        })
    }

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
                case '1000204':
                     var NewAnswer = new Array();
                    NewAnswer = term[tmp].Answer.split('@');
                    // console.log(NewAnswer)
                    for (var i=0; i<NewAnswer.length - 1 ; i++) {
                        $('#'+i+term[tmp].QuestionBh).val(NewAnswer[i]);
                    }
                    break;
                 case '1000207':
                    var test = $('[name='+ term[tmp].QuestionBh+']').val(term[tmp].Answer);
                    break;
                case '1000208':
                    var NewAnswer = new Array();
                    NewAnswer = term[tmp].Answer.split('@');
                    for (var i=0; i<NewAnswer.length - 1 ; i++) {
                        $('#'+i+term[tmp].QuestionBh).val(NewAnswer[i]);
                    }
                    break;
                 default:
                  var test = $('[name='+ term[tmp].QuestionBh+']').val(term[tmp].Answer);
                    break;

            }
        }
    });

    $(".nav li").click(function(){
        var _rel = $(this).attr("name");
        var pos = $('#'+_rel).offset().top;
        $("html,body").animate({scrollTop:pos},300);
    });

    function right(id, score) {
         $('#right_'+id).parents('.box1').children('button').css('background-color','#d6f8fe');
        var tmp = parseFloat($('#total_score').val());
        var total = parseFloat((tmp +score).toFixed(2));
        $('#total_score').val(total);
        $('#right_'+id).attr('disabled','disabled');
        $('#error_'+id).removeAttr('disabled');
    }

    function error(id, score) {
        $('#right_'+id).parents('.box1').children('button').css('background-color','#d6f8fe');
        var dis = $('#right_'+id).attr('disabled');
        if (dis == 'disabled') {
            var tmp = parseFloat($('#total_score').val());
            var total = parseFloat((tmp-score).toFixed(2));
            $('#total_score').val(total);
            $('#right_'+id).removeAttr('disabled');
            $('#error_'+id).attr('disabled', 'disabled');
        } else {
            $('#error_'+id).attr('disabled', 'disabled');
        }
    }

    function score(id) {
        var max = parseFloat($("#get_score_"+id).attr("data-score"));  //最大分值
        var dis = $('#score_'+id).attr('disabled');
        var tmp = parseFloat($('#total_score').val());
        var score = parseFloat($('#score_'+id).val());
        var first_score = Number(document.getElementById('score'+id).innerText);
        var paperID = '<?=$paperID?>';
        if(score<0 || score>max){
            alert("请勿超出打分范围！");
        }else{
            if(isNaN(score)){
            alert("分数为非数字，请重新打分");
            $('#score_'+id).val('');
        }else{
                if (dis == 'disabled') {
                tmp += first_score;
                tmp -= score;
                $('#total_score').val(tmp);
                $('#score_'+id).removeAttr('disabled');
                $('#get_score_'+id).text('打分');
                $('#get_score_'+id).parents('.box1').children('button').css('background-color','#f5f5f5');
            } else {
                if(isNaN(first_score)){
                        first_score = 0;
                }
                tmp -= first_score;
                tmp += score;
                $('#total_score').val(tmp);
                $('#score_'+id).attr('disabled', 'disabled');
                $('#get_score_'+id).text('重新打分');
                $.ajax({
                    type: 'POST',
                    url: '<?=Url::toRoute("mark/save-score")?>',
                    dataType: "JSON",
                    data: {"QuestionBh": id, "score": score, "PaperID": paperID},
                    success: function (value) {
                        $('#compile'+ id +'').removeAttr('disabled');
                        $('#score' + id + '').text(value.msg);
                    },
                    error:function(value){
                        $('#compile'+ id +'').removeAttr('disabled');
                        $('#score' + id + '').html('');
                        $('#score' + id + '').text(value.msg);
                    }
                })
                $('#get_score_'+id).parents('.box1').children('button').css('background-color','#d6f8fe');
                $("#get_score_"+id).parents(".col-xs-10").slideUp(100);
            }
        }
        }

    }


</script>
<?php $this->endBlock(); ?>

<?php
function switchType($type, $question,$answer){
    $Tmp_score = $question['Score'];
    $Tmp_Bh = $question['QuestionBh'];
    $answer = json_decode($answer);
    foreach ($answer as $key => $val) {
        if($question['QuestionBh'] == $val->QuestionBh){
            $get_score = $val->Score;
        }
    }
    if($type != '1000204')
        echo '<p style="color:red">标准答案</p>'.$question['Answer'];
    switch ($type){
        case '100020101':
          //  echo '<input disabled="disabled" type="radio" value="A" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;A
          //   <input disabled="disabled" type="radio" value="B" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;B
          //   <input disabled="disabled" type="radio" value="C" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;C
          //   <input disabled="disabled" type="radio" value="D" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;D';
          //   echo '<label style="float: right">"'.$question['Answer'].'"</label></br></br>';
          //   echo '<button id="error_'.$Tmp_Bh.'" type="button" style="float: right" class="btn btn-danger" onclick="error('."'$Tmp_Bh'".', '.$Tmp_score.')">❌</button>';
          //   echo '<button id="right_'.$Tmp_Bh.'" type="button" class="btn btn-info" style="float: right" onclick="right('."'$Tmp_Bh'".', '.$Tmp_score.')">✔️</button>';
            break;
        case '100020102':
            // echo '<input disabled="disabled"  type="checkbox" value="A" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;A
            // <input disabled="disabled" type="checkbox" value="B" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;B
            // <input disabled="disabled" type="checkbox" value="C" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;C
            // <input disabled="disabled" type="checkbox" value="D" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;D';
            // echo '<label style="float: right">"'.$question['Answer'].'"</label></br></br>';
            // echo '<button id="error_'.$Tmp_Bh.'" type="button" style="float: right" class="btn btn-danger hasCheck" onclick="error('."'$Tmp_Bh'".', '.$Tmp_score.')">❌</button>';
            // echo '<button id="right_'.$Tmp_Bh.'" type="button" class="btn btn-info hasCheck" style="float: right" onclick="right('."'$Tmp_Bh'".', '.$Tmp_score.')">✔️</button>';

            break;
        case '1000203':
            // echo '<input disabled="disabled" type="radio" value="1" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;对
            // <input disabled="disabled" type="radio" value="0" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;错';
            // echo '<label style="float: right">"'.$question['Answer'].'"</label></br></br>';
            // echo '<button id="error_'.$Tmp_Bh.'" type="button" style="float: right" class="btn btn-danger" onclick="error('."'$Tmp_Bh'".', '.$Tmp_score.')">❌</button>';
            // echo '<button id="right_'.$Tmp_Bh.'" type="button" class="btn btn-info" style="float: right" onclick="right('."'$Tmp_Bh'".', '.$Tmp_score.')">✔️</button>';
            break;
        case '1000204':
        echo "<br>";














            echo '<p style="color:red">student答案</p>';
            //$answer = json_decode($answer);
             foreach ($answer as $key => $val) {
               // var_dump($val->Answer);
               if($question['QuestionBh']==$val->QuestionBh)
               echo '<input size="35" value="'.$val->Answer.'"><br>';
               // print($val);
             }












            echo '<p style="color:red">标准答案</p>';
            foreach ($question['Answer'] as $key => $value) {
               echo '<input size="35" value="'.$value['Answer'].'"><br>';
               // echo "123213213123213213";
            }
            echo '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'">'.$get_score.'</strong></br></br>';
             echo '<br><br><input class="100204" type="text" id="score_'.$Tmp_Bh.'" placeholder="0~'.$Tmp_score.'" />';

             echo '<button data-score="'.$Tmp_score.'" id="get_score_'.$Tmp_Bh.'" type="button" class="btn btn-info hasCheck" onclick="score('."'$Tmp_Bh'".')">打分</button>';

            break;
        case '1000205':
            $QuestionBh = $question['QuestionBh'];
                echo '<h1></h1><textarea disabled="disabled" class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'">'.$get_score.'</strong></br></br>';
            echo '<input type="text" id="score_'.$Tmp_Bh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$Tmp_Bh.'" type="button" class="btn btn-info hasCheck" data-score="'.$Tmp_score.'" onclick="score('."'$Tmp_Bh'".')">打分</button>';
            break;
        case '1000206':
            $QuestionBh = $question['QuestionBh'];
                echo '<h1></h1><textarea disabled="disabled" class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'">'.$get_score.'</strong></br></br>';
            echo '<input type="text" id="score_'.$Tmp_Bh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$Tmp_Bh.'" type="button" class="btn btn-info hasCheck" data-score="'.$Tmp_score.'" onclick="score('."'$Tmp_Bh'".')">打分</button>';
            break;
        case '1000207':
            $QuestionBh = $question['QuestionBh'];
                echo '<h1></h1><textarea disabled="disabled" class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'">'.$get_score.'</strong></br></br>';
            echo '<input type="text" id="score_'.$Tmp_Bh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$Tmp_Bh.'" type="button" class="btn btn-info hasCheck" data-score="'.$Tmp_score.'" onclick="score('."'$Tmp_Bh'".')">打分</button>';
            break;
        case '1000208':
            $m_find_error = new \app\models\question\FindError();
            $Tmp_Error = $m_find_error->find()->where([
                'QuestionBh' => $question['QuestionBh']
            ]);
            $Error = $Tmp_Error->asArray()->all();
            for ($i = 0; $i<$Tmp_Error->count(); $i++) {
                $Tmp_Answer = json_decode($Error[$i]['Answer']);
                echo $i+1 .':<input disabled="disabled" id="'.$i.$question['QuestionBh'].'" type="text" name="'.$question['QuestionBh'].'[]"/>';
                echo '<label style="float: right">"'.$Tmp_Answer->key[0]->Answer.'"</label></br></br>';
            }
            echo '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'">'.$get_score.'</strong></br></br>';
            echo '<input id="score_'.$Tmp_Bh.'" type="text" id="score_'.$Tmp_Bh.'"  placeholder="0~'.$Tmp_score.'"/><button id="get_score_'.$Tmp_Bh.'" type="button" data-score="'.$Tmp_score.'" class="btn btn-info" onclick="score('."'$Tmp_Bh'".')" >打分</button>';
            break;
        default:
            break;
    }
}
?>
