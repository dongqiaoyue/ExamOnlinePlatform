
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
    input[type='radio']{
        background-color: #fff !important;
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
                    <?php foreach($type as $model){?>
                    <h2> <?=$model?></h2>
                    <?php }?>
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
                            <div class="<?=$k;?> row" name="<?=$item['QuestionBh'];?>">
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

    function toggle(id) {
        var display =$('#'+id).css('display');
        if (display == 'none') {
            $('#'+id).slideDown(500);
        } else {
            $('#'+id).slideUp(500);
        }
    }

    function compile(id) {
        var CourseName = "<?=$type['CuitMoon_DictionaryName']?>";
        console.log(CourseName);
        var code = $('textarea[name="'+ id +'"]').val();
        var max = Number(document.getElementById('score_'+id).placeholder.substring(2));
        if (code == ""){
            alert("请输入代码");
        }else {
            $('#compile'+ id +'').text('正在编译');
            $('#compile'+ id +'').attr("disabled","disabled");
            if(CourseName=="数据库原理及其应用")
            {
                console.log("sql");
                var data={
                    "stuNum":"",
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
                var flag = 1;//设置超时

                var score_flag = 0;
                websocket.onopen = function(event){
                    $('#score' + id + '').text("正在编译");

                    $('#compile'+id+'').parent('.noDiv').mouseenter(function(){
                        $(this).siblings('.message').css('display','block');
                    });
                    $('#compile'+id+'').parent('.noDiv').mouseleave(function(){
                        $(this).siblings('.message').css('display','none');
                    });

                    $.ajax({
                        type: 'POST',
                        url: 'http://222.18.158.42:8801/producer/compile/student',
                        timeout: 5000, //设置超时时间
                        contentType:'application/json;charset=UTF-8',
                        dataType: "JSON",
                        data: JSON.stringify(data),
                        success: function (data) {
                            //console.log(data);
                            $('#compile'+ id +'').text('编译该题');
                            //$('#score' + id + '').text(data.msg);
                        },
                        error:function(){
                            $('#compile'+ id +'').text('编译该题');
                            $('#score' + id + '').text('编译失败');
                        },
                        complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                            if(status=='timeout'){//超时,status还有success,error等值的情况
                                ajaxTimeoutTest.abort();
                                $('#compile'+ id +'').text('编译该题');
                                $('#score' + id + '').text('编译超时');
                                closeWebSocket();
                            }
                        }
                    })
                    //setMessageInnerHTML("open");
                }
                //接收到消息的回调方法
                websocket.onmessage = function(event){
                    //console.log(event);
                    if(event.data == 100)
                    {
                        score_flag = 100;
                        //console.log(score_flag);
                    }else{
                        $("#compile"+id+'').parent('.noDiv').siblings('.message').css('display','none');
                        $("#compile"+id+'').removeAttr('disabled');
                        $("#compile"+id+'').parent('.noDiv').unbind('mouseenter');
                        $("#compile"+id+'').parent('.noDiv').unbind('mouseleave');
                    }
                    //console.log("Receive");
                    flag = 0;
                    setMessageInnerHTML(event.data);
                }
                var waitTime = 0;
                setTimeout(function(){
                    //console.log(score_flag+"a");
                    waitTime++;
                    if(score_flag==0&&waitTime==1){
                        $("#compile"+id+'').parent('.noDiv').siblings('.message').css('display','none');
                        $("#compile"+id+'').removeAttr('disabled');
                        $("#compile"+id+'').parent('.noDiv').unbind('mouseenter');
                        $("#compile"+id+'').parent('.noDiv').unbind('mouseleave');
                    }
                },10500)

                setTimeout(function () {
                    if(flag == 1)
                    {
                        $('#score' + id + '').text("编译超时");
                        websocket.close();
                    }
                },10000)

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
                    if(!score)
                    {
                        $('#score' + id + '').text("请重新编译");
                    }else{
                        $('#score' + id + '').text(score*max/100);
                    }
                    //
                    if(score == 100)
                    {
                        //$('#score' + id + '').attr('disabled');
                        $.ajax({
                            type: 'POST',
                            url: '<?=Url::toRoute("exam/save-score")?>',
                            dataType: "JSON",
                            data: {"paperID": "<?=$paperID?>", "QuestionBh": id, "tSocre": score},
                            success: function(content){

                            },
                            error:function(){

                            }
                        });
                    }
                    closeWebSocket();
                }
                //关闭连接
                function closeWebSocket(){
                    //console.log("close");
                    websocket.close();
                }
            }else{
                $.ajax({
                    type: 'POST',
                    url: '<?=Url::toRoute("/common/compile")?>',
                    dataType: "JSON",
                    data: {"id": id, "code": code},
                    success: function (value) {
                        $('#compile'+ id +'').text('编译');
                        $('#compile'+ id +'').removeAttr('disabled');
                        $('#score' + id + '').text(value*max/100);
                    },
                    error:function(){
                        $('#compile'+ id +'').text('编译');
                        $('#compile'+ id +'').removeAttr('disabled');
                        $('#score' + id + '').html('');
                        $('#score' + id + '').text('编译失败');
                    }
                })
            }
        }
    }

    function score(id) {//手动批阅中，保存每道题目的分数
        var max = Number(document.getElementById('score_'+id).placeholder.substring(2));  //最大分值
        var dis = $('#score_'+id).attr('disabled');
        var paperID = '<?=$paperID?>';
        var tmp_score = Number(document.getElementById('score_'+id).value);
        var first_score = Number(document.getElementById('score'+id).innerText);
        var total_score = Number(document.getElementById('score').value);  //总分
        if(tmp_score<0 || tmp_score>max){
            alert("请勿超出打分范围！");
        }else{
            if(isNaN(tmp_score)){
                alert("分数为非数字，请重新打分");
                $('#score_'+id).val('');
            }else{
                if (dis == 'disabled') {
                    $('#get_score_'+id).text('打分');
                    $('#score_'+id).removeAttr('disabled');
                    total_score +=first_score;
                    total_score -=tmp_score;
                    $("#score").val(total_score);
                }else{
                    if(isNaN(first_score)){
                        first_score = 0;
                    }
                    $('#get_score_'+id).text('重新打分');
                    total_score -= first_score;
                    total_score += tmp_score;
                    $("#score").val(total_score);
                    $.ajax({
                        type: 'POST',
                        url: '<?=Url::toRoute("mark/save-score")?>',
                        dataType: "JSON",
                        data: {"QuestionBh": id, "score": tmp_score, "PaperID": paperID},
                        success: function (value) {
                            $('#compile'+ id +'').removeAttr('disabled');
                            $('#score' + id + '').text(value.msg);
                        },
                        error:function(value){
                            $('#compile'+ id +'').removeAttr('disabled');
                            $('#score' + id + '').html('');
                            $('#score' + id + '').text("value.msg");
                        }
                    })
                    $('#score_'+id).attr('disabled', 'disabled');
                }
            }
        }
    }

    function submit() {
        $('#submit-paper').submit();
    }

    $('#submit-paper').bind('submit',function (e) {
        e.preventDefault();
        var Url = '<?=Url::toRoute("mark/save-paper")?>';
        $(this).ajaxSubmit({
            url:Url,
            type:'post',
            dataType:'json',
            data:{"score": parseFloat($('#score').val())},
            success:function (value) {
                if (value.error == 0 && $('#save-paper').attr('value') != true) {
                    //alert("成绩修正成功！");
                    alert(value.msg);
                    window.history.back();
                }else {
                    alert(value.msg);
                }
            }
        })
    });

    $(document).ready(function(){
        $(".1000204").each(function(){
              var _name = $(this).attr('name');
              var name = $(this).attr('name')+'[]';
              var self = $(this);
              self.find('input').each(function(i){
                  var id = i+self.attr('name');
                  $(this).attr('name',name);
                  $(this).attr('id',id);
                  // $(this).attr('disabled','disabled');
              });
              $(this).find(".100204").removeAttr('disabled');
              $(this).find(".100204").removeAttr('id');
              $(this).find(".100204").attr('id',"score_"+$(this).attr('name'));
          });
/*
        $("input:radio").hasAttr("checked").each(function(){
            alert(1);
        });*/

        $('input[type="radio"]:checked').each(function(){   
                var Fan = $(this).val();
                var Fan1 = '"'+Fan+'"';
                var Fan2 = $(this).siblings('label').text().NoSpace();

                if(Fan1==Fan2){
                        $(this).parents('.row').children('button').css('background-color','#F5E490');
                        $(this).attr('disabled','disabled');
                        $(this).siblings('input:radio').attr('disabled','disabled');
                    }else{
                        $(this).removeAttr('disabled');
                }
        });

       $("input:radio").click(function(){
        var an = $(this).val();
        var an1 = '"'+an+'"';
        var an2 = $(this).siblings('label').text().NoSpace();
        var add = parseFloat($(this).parents('.row').children('button').attr("name"));
        $(this).parents('.row').children('button').css('background-color','#F5E490');

        if(an1==an2){
           var score = parseFloat($('#score').val()) || 0;
           score +=add;
           $('#score').val(score);
        }else{
           var score = parseFloat($('#score').val()) || 0;
           score -=add;
           $('#score').val(score);
           $(this).parents('.row').children('button').css('background-color','#e6e6e6');
        }
    });


        // $(".hasCheck").bind('click',function(){
        //     var dis = $(this).prev('.getScore').attr('disabled');
        //     var tmp_score = parseFloat($(this).prev('.getScore').val());  //打分
        //     var first_score = parseFloat($(this).prev('.getScore').prev(".first_score").attr('name')) || 0;
        //     var score = parseFloat($('#score').val()) || 0;  //总分
        //     if(isNaN(tmp_score)){
        //           alert("分数为非数字，请重新打分！");
        //           $(this).prev('.getScore').val('');
        //     }else{
        //         if(dis == 'disabled'){
        //             $(this).text("打分");
        //             $(this).prev('.getScore').removeAttr('disabled');
        //             score +=first_score;
        //             score -=tmp_score;
        //             $("#score").val(score);
        //         }else{
        //             $(this).text("重新打分");
        //             if(isNaN(tmp_score)){
        //               alert("分数为非数字，请重新打分！");
        //               $(this).prev('.getScore').val('');
        //             }else{
        //                 score -= first_score;
        //                 score += tmp_score;
        //                 $("#score").val(score);
        //                 $(this).prev('.getScore').attr('disabled','disabled');
        //             }
        //         $(this).prev('.getScore').attr('disabled','disabled');
        //         }
        //     }
        // });
    });

    $(document).ready(function () {
        var term = <?=$answer?>;
        for (var tmp in term) {
            switch (term[tmp].Memo) {
                case '1000203':
                case '100020101':
                    $('input[name=' + term[tmp].QuestionBh + '][value=' + term[tmp].Answer + ']').attr("checked", "checked");
                     $('input[name=' + term[tmp].QuestionBh + '][value=' + term[tmp].Answer + ']').attr('disabled','disabled');
                    break;
                case '1000204':
                    var NewAnswer = new Array();
                    NewAnswer = term[tmp].Answer.split('@');
                    for (var i=0; i<NewAnswer.length - 1 ; i++) {
                        $('#'+i+term[tmp].QuestionBh).val(NewAnswer[i]);
                    }
                    break;
                case '1000206':
                    var test = $('[name='+ term[tmp].QuestionBh+']').val(term[tmp].Answer);
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
     $Tmp_score = $question['Score'];
     $get_score = $question['get_score'];
     $QuestionBh = $question['QuestionBh'];
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
            echo '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$QuestionBh.'" class="first_score" name="'.$get_score.'">'.$get_score.'</strong></br></br>';
            echo '<input class="100204 getScore" type="text" id="score_'.$QuestionBh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$QuestionBh.'" type="button" class="btn btn-info hasCheck" onclick="score('."'$QuestionBh'".')">打分</button>';
            /* $Tmp_score = $question['Score'];
             $QuestionBh = $question['QuestionBh'];
             echo '<input type="text" class="getScore"  placeholder="0~''" /><button type="button" class="btn btn-info hasCheck">打分</button>';*/
            break;
        case '1000205':

            break;
        case '1000206':
             if($get_score==null){
                $get_score = 0;
             }
            if ($question['IsProgramBlank'] == '100001') {
                echo '<h1></h1><textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'" >';
                echo '</textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$QuestionBh.'" class="first_score" name="'.$get_score.'">'.$get_score.'</strong><p>编译分数，无需计算，直接使用</p>';
             echo '<input placeholder="0~'.$Tmp_score.'" id="score_'.$QuestionBh.'" class="getScore" /><button id="get_score_'.$QuestionBh.'" type="button" class="btn btn-info hasCheck" onclick="score('."'$QuestionBh'".')">打分</button>';
            } else {
                echo '<h1></h1><textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$QuestionBh.'" class="first_score" name="'.$get_score.'">'.$get_score.'</strong><p>编译分数，无需计算，直接使用</p>';
             echo '<input type="text" class="getScore" id="score_'.$QuestionBh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$QuestionBh.'" type="button" class="btn btn-info hasCheck" onclick="score('."'$QuestionBh'".')">打分</button>';
            }

            break;
        case '1000207':
                $QuestionBh = $question['QuestionBh'];
                echo '<h1></h1><textarea disabled="disabled" class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="compile'.$question['QuestionBh'].'" class="btn btn-default"  type="button" onclick="compile('."'$QuestionBh'".')">编译</button><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'" class="first_score">'.$get_score.'</strong></br></br>';
            echo '<input type="text" class="getScore" id="score_'.$QuestionBh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$QuestionBh.'" type="button" class="btn btn-info hasCheck" onclick="score('."'$QuestionBh'".')">打分</button>';
            break;
        case '1000208':
             $QuestionBh = $question['QuestionBh'];

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
            echo '<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong id="score'.$question['QuestionBh'].'">'.$get_score.'</strong></br></br><p>编译分数，无需计算，直接使用</p>';
           echo '<input type="text" class="getScore" id="score_'.$QuestionBh.'" placeholder="0~'.$Tmp_score.'" /><button id="get_score_'.$QuestionBh.'" type="button" class="btn btn-info hasCheck" onclick="score('."'$QuestionBh'".')">打分</button>';
            break;
    }
}
?>
