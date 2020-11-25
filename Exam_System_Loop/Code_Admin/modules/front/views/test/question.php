
<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
use app\models\systembase\Studentinfo;
$com = new commonFuc();
$i = 1;
$paperID = $com->create_id();//数据库编译需要用paperID.
$stuNum = Yii::$app->session->get('StudentNum');//数据库编译需要用stuNum.
$stuName = Studentinfo::findOne(['StuNumber' => $stuNum])['Name'];//数据库编译需要用stuName.
?>
<?php $this->beginBlock('header');  ?>
<!-- <head></head>中代码块 -->

<style type="text/css">
*{
    font-size: 14px;
    font-family: "微软雅黑";
    font-weight: normal;
    color:black;
}
button{
    border:none;
    outline-style:none !important;
    text-align: left !important;
}
input{
    outline-style:none !important;
}
input[type=radio]{
    margin-left:20px;
}
input[maxlength="50"]{
    margin-right: 5px;
    margin-bottom: 5px;
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
.noFlow{
    width:100%;
    overflow:hidden;
    text-overflow: ellipsis;
}

.Answer11{
    display: none;
    font-weight:bold;
    float:left;
    margin-left:10px;
    color:red;
}
.Answer22{
    margin-top: 10px;
    width:76%;
    height:320px;
    border:1px solid gray;
    padding:5px;
    overflow:auto;
    display: none;
}
.btn-default{

    border-radius: 5px;
    border:1px solid #F0F0F0;
    color:black;
}
.minContent{
    margin:10px auto;
}
.message{
    display: none;
    position: relative;
    top: -45px;
    left: -70px;
    color:red;
}
.fileName:link,.fileName:hover,.fileName:visited,.fileName:active{
	margin-right: 15px;
	color:blue;
	text-decoration: underline;
}

textarea{
    height:400px !important;
    width:100% !important;
    color:black !important;
    overflow-y: auto;
}
hr{
    border:1px dashed gray;
}
body{
    /* background-color: #f9f9f9; */
}
.row{
  margin-top: 20px;
}
.navbar-default {
    border-radius: 0px;
    background-color: #fff;
    box-sizing: border-box;
    box-shadow: 0 3px 5px rgba(0,0,0,.3);
}
</style>

<html>
<body>
<?php $this->endBlock(); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <nav class="navbar navbar-default topNav" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav ">
                            <li class="topLi" ><a href="#">题型：</a></li>
                            <?php foreach ($info as $key=>$data){
                                ?>
                                <li class="topLi" name="<?=$key?>"><a href="#"><?=$com->codeTranName($key)?></a></li>
                            <?php
                            }?>
                        </ul>

                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
    <div class="row" style="margin:10px auto; padding-top:-30px;">
        <div class="col-xs-11 minContent col-xs-offset-2" style="margin-left:4%; margin-top:-30px;">
            <div class="row">
                <div class="col-xs-12">
                    <h2> <?=$couresname?></h2>
                </div>
            </div>
            <?php ActiveForm::begin(["id" => "submit-paper1", "class"=>"form-horizontal"]);
            ?>
            <?php foreach ($info as $k=>$value) {?>
                <div class="">
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="button"  id="<?=$k?>-href" class="btn btn-lg btn-default btn-block" onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                        </div>    <!--  题型按钮 -->
                    </div>
                    <h1></h1>
                    <div style="display: none" id="<?=$k;?>">
                        <?php foreach ($value as $key=>$item) {?>
                            <div class="row <?=$k;?>" id="<?=$k;?>" >
                                <button name="<?=$item['Score'];?>"" type="button" class="but1 btn btn-default col-xs-10 col-xs-offset-1" onclick="toggle(<?=$i?>)"><div class="noFlow">(<?=$item['Score'];?> 分) <?=$i.'.'.$item['CustomBh'];?>   <?=$item['name']?></div></button>

                                <div class="col-xs-10 col-xs-offset-1 _patent" style="display: none; float:left; padding-top: 10px;" id="<?=$i;?>">
                                    <?=$item['Description'];?>
                                    <?=switchType($k, $item['QuestionBh'],$item['Answer'],$item['IsProgramBlank'],$item['SourceCode']['key'][0]['code'],$item['StuAnswer'],$item['AnswerScore'],$item['file'],$item['Memo'])?>
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

$(document).ready(function(){
    $("input:text").each(function(index,element){
        if($(this).val()){
            $(this).closest(".row").find("button").css('background-color','#d6f8fe');
        }
    });
    $("input:radio").each(function(index,element){
        if($(this).attr("checked")){
            var selfAnsw = $(this).val();
            var rightAnsw = $(this).parent().siblings(".Answer11").html();
            rightAnsw = $.trim(rightAnsw);
            selfAnsw = $.trim(selfAnsw);
            if(selfAnsw==rightAnsw){
                $(this).parent().siblings('.grade').html("正确率：100%");
            }else{
                $(this).parent().siblings('.grade').html("正确率：0%");
            }
            $(this).closest(".row").find("button").css('background-color','#d6f8fe');
        }
    });
    $('textarea').each(function(index,element){
        if($(this).is(".Code")){
            $(this).css('color','red');
        }else if($(this).html()){
            $(this).closest(".row").find("button").css('background-color','#d6f8fe');
        }
        if($(this).is(".tkCode")){
        	$(this).closest(".row").find("button").css('background-color','#fbad6c');
        }
    });
    $('input:radio').on('click',function(){
            var selfAnsw = $(this).val();
            var rightAnsw = $(this).parent().siblings(".Answer11").html();
            var theScore = $(this).closest(".row").find("button").attr('name');
            rightAnsw = $.trim(rightAnsw);
            selfAnsw = $.trim(selfAnsw);
            if(selfAnsw==rightAnsw){
                $(this).parent().siblings('.grade').html("正确率：100%");
                tScore = 100;
            }else{
                $(this).parent().siblings('.grade').html("正确率：0%");
                tScore = 0;
            }
                $(this).closest(".row").find("button").css('background-color','#d6f8fe');
                $.ajax({
                    type: 'POST',
                    url: '<?=Url::toRoute('test/add-test-info')?>',
                    dataType: "JSON",
                    data: {"QuestionBh": $(this).attr('name'), "StuAnswer":selfAnsw, "Score":tScore},
                    success: function (value) {
                   // alert('success');
                    },
                    error:function(){
                       // alert("失败！");
                    }
            })
    });

    $('input:text').blur(function(){
        if($(this).val()){
             $(this).closest('.row').children('button').css('background-color','#d6f8fe');
        }
    });

});

  $(".nav li").click(function(){
            var _rel = $(this).attr("name");
            var nn = '#'+_rel+'-href';
            var pos = $(nn).offset().top;
            $('html,iframe').animate({scrollTop:pos},300);
        });

    $(".answ").click(function(){
        if($(this).next('.Answer11').css("display")=="none")
        {
            $(this).next('.Answer11').css("display","block");
            $(this).val("隐藏答案");
        }
        else
        {
            $(this).next('.Answer11').css("display","none");
            $(this).val("显示答案");
        }
    });

    $(".resetCode").click(function(){
        var answerCode = $(this).parents("._patent").find(".anCode").val();
        $(this).parents("._patent").find(".Code").val(answerCode);
    });

    $(".bigAnswer").click(function(){
        if($(this).parents(".col-xs-10").find(".Answer22").css('display')=='none'){
            $(this).parents(".col-xs-10").find(".Answer22").css('display','block');
            $(this).val("隐藏答案");
        }else{
            $(this).parents(".col-xs-10").find(".Answer22").css('display','none');
            $(this).val("显示答案");
        }
    });

    function toggle(id) {
        var display =$('#'+id).css('display');
        if (display == 'none') {
            $('#'+id).slideDown(200);
        } else {
            $('#'+id).slideUp(200);
        }
    }

    function compile(id) {
        var CourseName = "<?=$couresname?>";

        var code = $('textarea[name="'+ id +'"]').val();
        if (code == ""){
            alert("请输入代码");
        }else {
            $('#compile'+ id +'').closest(".row").find("button").css('background-color','#d6f8fe');
            $('#compile'+ id +'').val('正在编译');
            $('#compile'+ id +'').attr("disabled","disabled");
            if(CourseName=="数据库原理及其应用")
            {
                var data={
                    "stuNum":"<?=$stuNum?>",
                    "stuName":"<?=$stuName?>",
                    "paperId":"<?=$paperID?>",
                    "questionBh": id,
                    "answer": code
                }
                var websocket = null;

                //判断当前浏览器是否支持WebSocket
                if('WebSocket' in window){
                    //console.log("Hello");
                    websocket = new WebSocket("ws://222.18.158.42:8801/producer/webSocket/"+"<?=$paperID?>&"+id);//使用websocket获取分数
                }
                else{
                    alert('Not support websocket')
                }

                //连接发生错误的回调方法
                websocket.onerror = function(){
                    $('#score' + id + '').text("连接失败");
                };

                //连接成功建立的回调方法
                websocket.onopen = function(event){
                    $('#score' + id + '').text("正在编译");
                    //setMessageInnerHTML("open");
                }

                //接收到消息的回调方法
                websocket.onmessage = function(event){
                    //console.log("Receive");
                    setMessageInnerHTML(event.data);
                }

                //连接关闭的回调方法
                websocket.onclose = function(){
                    //setMessageInnerHTML("close");
                }

                //监听窗口关闭事件，当窗口关闭时，主动去关闭websocket连接，防止连接还没断开就关闭窗口，server端会抛异常。
                window.onbeforeunload = function(){
                    websocket.close();
                }

                //将消息显示在网页上
                function setMessageInnerHTML(score){
                    //console.log(score);
                    $('#compile'+ id +'').val('编译该题');
                    $('#score' + id + '').text(score);
                    closeWebSocket();
                }

                //关闭连接
                function closeWebSocket(){
                    //console.log("close");
                    websocket.close();
                }
                $.ajax({
                    type: 'POST',
                    url: 'http://222.18.158.42:8801/producer/compile/student',
                    contentType:'application/json;charset=UTF-8',
                    dataType: "JSON",
                    data: JSON.stringify(data),
                    success: function (data) {
                        $('#compile'+ id +'').val('编译该题');
                        //$('#score' + id + '').text(data.msg);
                    },
                    error:function(){
                        $('#compile'+ id +'').text('编译该题');
                        $('#score' + id + '').text('编译失败');
                        $('#compile'+ id +'').removeAttr('disabled');
                    }
                })
            }else{
                $.ajax({
                    type: 'POST',
                    url: '<?=Url::toRoute("/common/compile")?>',
                    dataType: "JSON",
                    data: {"id": id, "code": code},
                    success: function (value) {
                        $('#compile'+ id +'').val('编译该题');
                        // $('#compile'+ id +'').removeAttr('disabled');
                        $('#score' + id + '').text(value);
                        var tScore = value;
                        var selfAnsw = code;
                        $.ajax({
                            type:'POST',
                            url:'<?=Url::toRoute('test/add-test-info')?>',
                            dataType: "JSON",
                            data: {"QuestionBh": id, "StuAnswer":selfAnsw, "Score":tScore},
                            success: function (content){
                                // alert('success');
                            },
                            error:function(){
                                // alert("失败！");
                            }
                        });
                    },
                    error:function(){
                        // alert("编译失败！");
                        $('#compile'+ id +'').val('编译该题');
                        $('#score' + id + '').text('编译失败');
                        $('#compile'+ id +'').removeAttr('disabled');
                    }
                });
            }
            var waitTime = 0;
            $("#compile"+id+'').bind('mouseover',function(){
                $(this).siblings('.message').css('display','block');
            });
            $("#compile"+id+'').bind('mouseout',function(){
                $(this).siblings('.message').css('display','none');
            });
            setTimeout(function(){
                waitTime++;
                if(waitTime==1){
                    $("#compile"+id+'').removeAttr('disabled');
                    $("#compile"+id+'').unbind('mouseover');
                    $("#compile"+id+'').unbind('mouseout');
                }
            },5000)

        }
    }

    $(".nav li").click(function(){
        var _rel = $(this).attr("name");
        var pos = $('#'+_rel).offset().top;
        $("html,body").animate({scrollTop:pos},300);
    });

     $(".TKanswer").click(function(){
         if($(this).val()=='隐藏答案'){
            var mythis = $(this);
            $.ajax({
            type:'POST',
            url:'<?=Url::toRoute('test/get-fill-answer')?>',
           // dataType:"json",
            data:{"QuestionBh":$(this).attr('name')},
            success:function(data){
                //alert("成功");
                var obj = eval(data);
                for(var i in obj){
                    var answer = obj[i].Answer;
                    mythis.next(".Answer11").children("input:eq("+i+")").val(answer);
                }
                //$(this).next(".Answer11").html(data);
            },
            error:function(){
             //  alert("error");
            }
        })
        }
    })
     $(".JDanswer").click(function(){
        if($(this).val()=='隐藏答案'){
            var mythis = $(this);
             $.ajax({
            type:'POST',
            url:'<?=Url::toRoute('test/get-correct-answer')?>',
            dataType:"json",
            data:{"QuestionBh":$(this).attr('name')},
            success:function(data){
                for(var i in data){
                    var answer = data[i].Answer[0];
                    var _index = data[i].ErrorCount-1;
                    for(var key in answer){
                        if(key=='Answer'){
                           mythis.next(".Answer11").children("input:eq("+_index+")").val(answer[key]);
                        }
                    }
                }
            },
            error:function(){
              //  alert("error");
            }
        })
        }
    })
</script>
<?php $this->endBlock(); ?>

<?php
function switchType($type, $questionBh,$Answer,$IsProgramBlank,$SourceCode,$StuAnswer,$AnswerScore,$file,$Memo){
    switch ($type){
        case '100020101':
        if($StuAnswer=='A'){
            echo '<div style="float:left;"><input type="radio" value="A" checked name="'.$questionBh.'"/>&nbsp;&nbsp;A
            <input type="radio" value="B" name="'.$questionBh.'"/>&nbsp;&nbsp;B
            <input type="radio" value="C" name="'.$questionBh.'"/>&nbsp;&nbsp;C
            <input type="radio" value="D" name="'.$questionBh.'"/>&nbsp;&nbsp;D</div>';
        }else if($StuAnswer=='B'){
            echo '<div style="float:left;"><input type="radio" value="A" checked name="'.$questionBh.'"/>&nbsp;&nbsp;A
            <input type="radio" value="B" checked name="'.$questionBh.'"/>&nbsp;&nbsp;B
            <input type="radio" value="C" name="'.$questionBh.'"/>&nbsp;&nbsp;C
            <input type="radio" value="D" name="'.$questionBh.'"/>&nbsp;&nbsp;D</div>';
        }else if($StuAnswer=='C'){
            echo '<div style="float:left;"><input type="radio" value="A" checked name="'.$questionBh.'"/>&nbsp;&nbsp;A
            <input type="radio" value="B" name="'.$questionBh.'"/>&nbsp;&nbsp;B
            <input type="radio" value="C" checked name="'.$questionBh.'"/>&nbsp;&nbsp;C
            <input type="radio" value="D" name="'.$questionBh.'"/>&nbsp;&nbsp;D</div>';
        }else if($StuAnswer=='D'){
            echo '<div style="float:left;"><input type="radio" value="A" checked name="'.$questionBh.'"/>&nbsp;&nbsp;A
            <input type="radio" value="B" name="'.$questionBh.'"/>&nbsp;&nbsp;B
            <input type="radio" value="C" name="'.$questionBh.'"/>&nbsp;&nbsp;C
            <input type="radio" value="D" checked name="'.$questionBh.'"/>&nbsp;&nbsp;D</div>';
        }else{
            echo '<div style="float:left;"><input type="radio" value="A" name="'.$questionBh.'"/>&nbsp;&nbsp;A
            <input type="radio" value="B" name="'.$questionBh.'"/>&nbsp;&nbsp;B
            <input type="radio" value="C" name="'.$questionBh.'"/>&nbsp;&nbsp;C
            <input type="radio" value="D" name="'.$questionBh.'"/>&nbsp;&nbsp;D</div>';
        }
        echo '<div class="grade" style="float:left; margin-left:20px; width:100px; color:red; display: block;">正确率：</div>
            <input class="answ" type="button" style="float:left; margin-left:20px;" value="显示答案">
            <div class="Answer11" style="float:left; margin-left:10px;color:red; display: none;">'.$Answer.'</div>';
            break;
        case '100020102':
            echo '<div style="float:left"><input type="checkbox" value="A" name="'.$questionBh.'[]"/>&nbsp;&nbsp;A
            <input type="checkbox" value="B" name="'.$questionBh.'[]"/>&nbsp;&nbsp;B
            <input type="checkbox" value="C" name="'.$questionBh.'[]"/>&nbsp;&nbsp;C
            <input type="checkbox" value="D" name="'.$questionBh.'[]"/>&nbsp;&nbsp;D</div>
             <div class="grade" style="float:left; margin-left:20px; width:100px; color:red; display: block;">正确率：</div>
            <input class="answ" type="button" style="float:left; margin-left:20px;" value="显示答案">
            <div class="Answer11">'.$Answer.'</div>
            ';
            break;
        case '1000203':
        if($StuAnswer=='对'){
            echo '<div style="float:left;"><input type="radio" checked value="对" name="'.$questionBh.'"/>&nbsp;&nbsp;对
            <input type="radio" value="错" name="'.$questionBh.'"/>&nbsp;&nbsp;错</div>';
        }else if($StuAnswer=='错'){
             echo '<div style="float:left;"><input type="radio" value="对" name="'.$questionBh.'"/>&nbsp;&nbsp;对
            <input type="radio" checked value="错" name="'.$questionBh.'"/>&nbsp;&nbsp;错</div>';
        }else{
             echo '<div style="float:left;"><input type="radio" value="对" name="'.$questionBh.'"/>&nbsp;&nbsp;对
            <input type="radio" value="错" name="'.$questionBh.'"/>&nbsp;&nbsp;错</div>';
        }
            echo '<div class="grade" style="float:left; margin-left:20px; width:100px; color:red; display: block;">正确率：</div>
            <input class="answ" type="button" style="float:left; margin-left:20px;" value="显示答案">';
            if($Answer==0){
                $an = '错';
            }else if($Answer==1){
                $an = '对';
            }
            echo '<div class="Answer11" style="float:left; margin-left:10px;color:red; display: none;">'.$an.'</div>
            ';
            break;
        case '1000204':
            $m_apfill = new app\models\question\Apfill();
            $Tmp_apfill = $m_apfill->find()->where([
                'QuestionBh' => $questionBh
            ]);
            echo '<input class="answ TKanswer" name="'.$questionBh.'" type="button" style="float:left; margin:5px 20px;" value="显示答案"><div class="Answer11">';
            for($i=0;$i<$Tmp_apfill->count();$i++){
                echo $i+1 .':<input type="text" value=""/>&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            echo '</div>';

            break;
        case '1000205':

            break;
        case '1000206':
        if($IsProgramBlank==100001){
            if($AnswerScore==NULL){
                $AnswerScore=='';
            }
            echo '<hr><span style="float:left; margin-right:15px;">';
            //在这个echo里将需要用的文件用循环成a标签即可
            foreach ($file as $key => $value) {
                echo '<a class="fileName" href="'.$value.'" target="_blank">'.$key.'</a>';
            }

            echo '</span><input class="answ bigAnswer" type="button" style="float:left; margin-right:20px;" value="显示答案"></input><input style="margin-right:15px;" type="button" name='.$questionBh.' id="compile'.$questionBh.'" value="编译该题" onclick="compile('."'$questionBh'".')"></input><input type="button" value="还原代码" class="resetCode"></input>
            <textarea class="Answer22 cairo_scaled_font_text_extents(scaledfont, text)" style="line-height:25px;">'.$Memo.'</textarea><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong  class="StuScore" style="color:red;" id="score'.$questionBh.'">'.$AnswerScore.'</strong><div class="message" style="left:0px;">请勿频繁操作</div><textarea style="display:none;" class="anCode">'.$SourceCode.'</textarea>';

            if($StuAnswer!=NULL){
                echo '<h1></h1><textarea class="col-xs-8 Code" rows="20" name="'.$questionBh.'">'.$StuAnswer.'</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }else{
                echo '<h1></h1><textarea class="col-xs-8 Code tkCode" rows="20" name="'.$questionBh.'">'.$SourceCode.'</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }else{
             if($StuAnswer==NULL){
                $StuAnswer=='';
            }
            echo '<hr><div class="answTop" style="min-width:45%; width:auto; height:30px; float:left;"><span style="float:left; margin-right:15px;">';
            //在这个echo里将需要用的文件用循环成a标签即可
            foreach ($file as $key => $value) {
                echo '<a class="fileName" href="'.$value.'" target="_blank">'.$key.'</a>';
            }

            echo '</span><input class="answ bigAnswer" type="button" style="float:left; margin-right:20px;" value="显示答案"><input type="button" id="compile'.$questionBh.'" value="编译该题" style="float:left;" onclick="compile('."'$questionBh'".')"></input><label style="margin-left:-10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong class="StuScore" style="color:red;" id="score'.$questionBh.'">'.$AnswerScore.'</strong><div class="message">请勿频繁操作</div></div>

             <textarea class="Answer22 cairo_scaled_font_text_extents(scaledfont, text)" style="line-height:25px;">'.$SourceCode.'</textarea><h1></h1><textarea class="col-xs-8 Code" rows="20" name="'.$questionBh.'">'.$StuAnswer.'</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
            break;
        case '1000207':
            echo '<input class="answ" type="button" style="float:left; margin-left:20px;" value="显示答案">
            <div class="Answer11">'.$Answer.'</div>';
            break;
        case '1000208':
            $m_find_error = new \app\models\question\FindError();
            $Tmp_Error = $m_find_error->find()->where([
                'QuestionBh' => $questionBh
            ]);
            for ($i = 0; $i<$Tmp_Error->count(); $i++) {
                echo $i+1 .':<input type="text" name="'.$questionBh.'[]"/></br></br>';
            }
            echo '<input class="answ JDanswer" name="'.$questionBh.'" type="button" style="float:left; margin:5px 20px;" value="显示答案"><div class="Answer11">';
             for ($i = 0; $i<$Tmp_Error->count(); $i++) {
                echo $i+1 .':<input type="text" value=""/>&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            echo '</div>';
            break;
    }
}
?>
