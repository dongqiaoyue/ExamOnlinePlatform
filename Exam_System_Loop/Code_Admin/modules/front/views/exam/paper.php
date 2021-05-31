
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
    *{
        font-size: 14px;
        font-family: "微软雅黑";
        font-weight: normal;
        color:black;
    }
    button{
        border:none;
        outline-style:none !important;
    }
    input{
        outline-style:none !important;
    }
    input[type=radio]{
        margin-left:20px;
    }
    .title{
        text-align: left !important;
    }
    .topNav{
        border:0px solid #ECECEC;

        border-radius: 0px;
        height:50px !important;
        background-color: #fff;
        box-sizing: border-box;
        box-shadow: 0 1px 2px rgba(0,0,0,.3);
    }
    .topLi a{
        height:32px;
        margin:9px 10px;
        padding: 5px 10px !important;
        line-height: 32px;
        margin-left: 0px;
        border:0px solid #CDCDCD;
        color:#545353 !important;
    }
    .topLi a:hover{
        color:red;
        background-color: #fff !important;
    }
    .btn-default{
        background-color: #fbad6c;
        border-radius: 5px;
        border:1px solid #F0F0F0;
        color:black;
        overflow:hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .BY,.BY:hover,.BY:visited,.BY:focus{
        background-color: #feb115 !important;
        color:#fff;
        display: block;
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

    .testContent{
        margin-top: 10px;
        width:100%;
        height:auto;
        box-shadow: 5px 5px 5px #e1e1e1;
        box-shadow: -5px -5px 5px #e1e1e1;
    }
    .testContent1{
        box-shadow: 5px 5px 5px #e1e1e1;
    }
    .wrap{
        padding:10px;
        padding-top: 30px;
    }
    #minutes{
        color:red;
    }
    .stuScore{
        color:red;
    }
    .message{
        display: none;
        position: relative;
        top: -80px;
        left: 0px;
        color:red;
    }
    .fileName:link,.fileName:hover,.fileName:visited,.fileName:active{
        margin-right: 15px;
        color:blue;
        text-decoration: underline;
    }
    .friendFile{
        margin: 10px 0px;
        color:black;
        font-weight: bold;
        font-size: 12px;
    }
    textarea{
        width:80% !important;
        height: 400px !important;
        overflow-y: auto;
        margin-right: 18px;
    }

</style>

<html>
<body>
<?php $this->endBlock(); ?>
<section class="content">

    <h1 class="text-center">过程化考核平台</h1>
    <div class="row" >
        <div class="col-xs-8 col-xs-offset-2">
            <nav class="navbar navbar-default topNav" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="topLi" name=""><a href="#">题型：</a></li>
                            <?php foreach ($info as $key=>$data){?>
                                <li class="topLi" name="<?=$key?>-href"><a href="#"><?=$com->codeTranName($key)?></a></li>
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
                    <div id="myBut" style="float:left; ">
                        <button class="btn btn-success" onclick="submit()">提交试卷</button>
                        <button class="btn btn-success" id="save-paper">保存试卷</button>
                    </div>
                    <!--  name="<?=$endTime?>" -->
                    <?php date('Y-m-d ');?>
                    <div id="time" name="<?=$endTime?>">考试时间还剩<span id="minutes"></span>分钟</div>
                    <span style="display: none;" id="ExamTime" name="<?=$ExamTime?>">考试时长</span>
                    <span style="display: none;" id="PassTime" name="<?=$PassTime?>">已做时长</span>
                    <span style="display: none;" id="nowTime" name="<?=$now?>">当前时间</span>
                    <h2 style="float:left;"> <?=$type?></h2><h1 id="stuName" style="float:right; font-family:'华文新魏'; color:red; "><?=$StuName?><apsn style="font-family:'华文新魏'; font-size: 26px;">同学</apsn></h1><h2 id="stuNumber" style="float:right; margin-right: 30px;"><?=$StuNumber?></h2>
                </div>
            </div>

            <div class="testContent">
                <div class="testContent1">
                    <div class="wrap">
                        <?php ActiveForm::begin(["id" => "submit-paper", "class"=>"form-horizontal", "action"=>Url::toRoute("admin-role/save")]);?>
                        <input name="PaperID" value="<?=$paperID?>" type="hidden">
                        <?php foreach ($info as $k=>$value) {?>
                            <div class="">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="button"  id="<?=$k?>-href" class="btn btn-lg btn-primary " onclick="toggle(<?=$k;?>)"><?=$com->codeTranName($k);?></button>
                                    </div>
                                </div>
                                <h1></h1>
                                <div style="display: none" id="<?=$k;?>">
                                    <?php foreach ($value as $key=>$item) {?>
                                        <div class="row <?=$k;?>" id="<?=$k;?>"  name="<?=$item['QuestionBh'];?>">
                                            <button type="button" class="btn btn-default col-xs-10 col-xs-offset-1 title" onclick="toggle(<?=$i?>)"><div class="noFlow">(<?=$item['Score'];?> 分) <?=$i.'.';/*.$item['CustomBh'];*/?> <?=$item['name']?></div></button>

                                            <div class="col-xs-10 col-xs-offset-1" style="display: none; float:left; padding-top: 10px;" id="<?=$i;?>">
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
            </div>  <!-- testContent -->
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


    setInterval(function(){
        $('#save-paper').click();
    },300000);
    //每五分钟提交一次
    $('#save-paper').click(function (e) {
        e.preventDefault();
        $(this).attr('value','true');
        submit();
    });

    function toggle(id) {
        var display =$('#'+id).css('display');
        if (display == 'none') {
            $('#'+id).slideDown(500);
        } else {
            $('#'+id).slideUp(500);
        }
    }

    function revertAnswer(id) {
        $.ajax({
            type: 'get',
            url: '<?=Url::toRoute("exam/get-source-code")?>',
            dataType: "JSON",
            data: {"id": id},
            success: function (value) {
                $('[name='+ id +']').val(value.key[0].code);
            }
        });
    }

    function compile(id) {
        var CourseName = "<?=$type?>";
        var code = $('textarea[name="'+ id +'"]').val();
        if (code == ""){
            alert("请输入代码");
        }else {
            $('#compile'+ id +'').text('正在编译');
            $('#compile'+ id +'').attr("disabled","disabled");
            if(CourseName=="数据库原理及其应用")
            {
                var data={
                    "stuNum":"",
                    "stuName":"<?=$StuName?>",
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
                        $('#score' + id + '').text(score);
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
                // $.ajax({
                //     type: 'POST',
                //     url: 'http://222.18.158.42:8801/producer/compile/student',
                //     timeout: 5000, //设置超时时间
                //     contentType:'application/json;charset=UTF-8',
                //     dataType: "JSON",
                //     data: JSON.stringify(data),
                //     success: function (data) {
                //         //console.log(data);
                //         $('#compile'+ id +'').text('编译该题');
                //         //$('#score' + id + '').text(data.msg);
                //     },
                //     error:function(){
                //         $('#compile'+ id +'').text('编译该题');
                //         $('#score' + id + '').text('编译失败');
                //     },
                //     complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                //         if(status=='timeout'){//超时,status还有success,error等值的情况
                //             ajaxTimeoutTest.abort();
                //             $('#compile'+ id +'').text('编译该题');
                //             $('#score' + id + '').text('编译超时');
                //             closeWebSocket();
                //         }
                //     }
                //
                // })
                // var waitTime = 0;
                // setTimeout(function(){
                //     //console.log(score_flag+"a");
                //     waitTime++;
                //     if(score_flag==0&&waitTime==1){
                //         $("#compile"+id+'').parent('.noDiv').siblings('.message').css('display','none');
                //         $("#compile"+id+'').removeAttr('disabled');
                //         $("#compile"+id+'').parent('.noDiv').unbind('mouseenter');
                //         $("#compile"+id+'').parent('.noDiv').unbind('mouseleave');
                //     }
                // },10500)
            }
            else{
                $.ajax({
                    type: 'POST',
                    url: '<?=Url::toRoute("/common/compile")?>',
                    dataType: "JSON",
                    data: {"id": id, "code": code},
                    success: function (value) {
                        $('#compile'+ id +'').text('编译该题');
                        $('#score' + id + '').text(value);
                        var tSocre = value;
                        if(tSocre == 100)
                        {
                            $.ajax({
                                type: 'POST',
                                url: '<?=Url::toRoute("exam/save-score")?>',
                                dataType: "JSON",
                                data: {"paperID": "<?=$paperID?>", "QuestionBh": id, "tSocre": tSocre},
                                success: function(content){

                                },
                                error:function(){

                                }
                            });
                        }
                    },
                    error:function(){
                        $('#compile'+ id +'').text('编译该题');
                        $('#score' + id + '').text('编译失败');
                    }
                })
                var waitTime = 0;
                $('#compile'+id+'').parent('.noDiv').mouseenter(function(){
                    $(this).siblings('.message').css('display','block');
                });
                $('#compile'+id+'').parent('.noDiv').mouseleave(function(){
                    $(this).siblings('.message').css('display','none');
                });
                setTimeout(function(){
                    waitTime++;
                    if(waitTime==1){
                        $("#compile"+id+'').parent('.noDiv').siblings('.message').css('display','none');
                        $("#compile"+id+'').removeAttr('disabled');
                        $("#compile"+id+'').parent('.noDiv').unbind('mouseenter');
                        $("#compile"+id+'').parent('.noDiv').unbind('mouseleave');
                    }
                },5000)
            }
            // var waitTime = 0;
            // $('#compile'+id+'').parent('.noDiv').mouseenter(function(){
            //     $(this).siblings('.message').css('display','block');
            // });
            // $('#compile'+id+'').parent('.noDiv').mouseleave(function(){
            //     $(this).siblings('.message').css('display','none');
            // });
            // setTimeout(function(){
            //     waitTime++;
            //     if(waitTime==1){
            //         $("#compile"+id+'').parent('.noDiv').siblings('.message').css('display','none');
            //         $("#compile"+id+'').removeAttr('disabled');
            //         $("#compile"+id+'').parent('.noDiv').unbind('mouseenter');
            //         $("#compile"+id+'').parent('.noDiv').unbind('mouseleave');
            //     }
            // },5000)

        }
    }

    function submit() {
        $('#submit-paper').submit();
    }

    $('#submit-paper').bind('submit',function (e) {
        e.preventDefault();
        if ($('#save-paper').attr('value') == 'true') {
            var Url = '<?=Url::toRoute("exam/save")?>';
            $('#save-paper').attr('value','false');
        } else {
            var Url = '<?=Url::toRoute("exam/submit")?>';
        }
        $(this).ajaxSubmit({
            url:Url,
            type:'post',
            dataType:'json',
            data:{},
            success:function (value) {
                if (value.error == 0 && $('#save-paper').attr('value') != true) {
                    alert(value.msg);
                    window.location.href = '<?=Url::toRoute("exam/index")?>';
                }else if(value.error==1){
                    alert("当前页面存在错误，请刷新后重新进入！");
                    window.location.reload();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if(XMLHttpRequest.status!=200){
                    alert("当前页面存在错误，请刷新后重新进入！");
                    window.location.reload();
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
                case '1000204':
                    var NewAnswer = new Array();
                    NewAnswer = term[tmp].Answer.split('@');
                    for (var i=0; i<NewAnswer.length - 1 ; i++) {
                        $('div[name='+term[tmp].QuestionBh+']').find('input:eq('+i+')').val(NewAnswer[i]);
                    }
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
                default:
                    var test = $('[name='+ term[tmp].QuestionBh+']').val(term[tmp].Answer);
                    break;
            }
        }
    });

    $(document).ready(function(){
        //给每个input加个name;
        $(".1000204").each(function(){
            var id = $(this).attr('name');
            var name = $(this).attr('name')+'[]';
            var self = $(this);
            self.find('input').each(function(){
                $(this).attr('name',name);
                $(this).attr('id',id);
            });
        });
        $("input:text").each(function(index,element){
            if($(this).val()){
                $(this).closest(".row").find("button").css('background-color','#d6f8fe');
            }
        });
        $("input:radio").each(function(index,element){
            if($(this).attr("checked")){
                $(this).closest(".row").find("button").css('background-color','#d6f8fe');
            }
        });
        $('input:radio').on('click',function(){
            if(!$(this).attr("checked")){
                $(this).closest(".row").find("button").css('background-color','#d6f8fe');
            }
        });
        $('input').blur(function(){
            if($(this).val()){
                $(this).closest(".row").find("button").css('background-color','#d6f8fe');
            }
        });
        $('textarea').each(function(index,element){
            if($(this).val()){
                $(this).closest(".row").find("button").css('background-color','#d6f8fe');
            }
        });
    });
    $(".nav li").click(function(){
        var _rel = $(this).attr("name");
        var pos = $('#'+_rel).offset().top;
        $("html,body").animate({scrollTop:pos},300);
    });

    function showTime(){
        var ExamTime=document.getElementById("ExamTime").getAttribute("name");
        var nowTime=document.getElementById("nowTime").getAttribute("name");
        var passTime=document.getElementById("PassTime").getAttribute("name");

        ExamTime = ExamTime-passTime;
        var n_Hours=parseInt(nowTime.split(" ")[1]);
        var n_minutes=parseInt(nowTime.split(":")[1]);

        var EndTime=document.getElementById("time").getAttribute("name");  //获取结束时间，转换为数字类型
        var e_Hours=parseInt(EndTime.split(":")[0]);
        var e_minutes=parseInt(EndTime.split(":")[1]);

        var lastTime;
        var testTime = (e_Hours*60+e_minutes)-(n_Hours*60+n_minutes);
        if(testTime<=ExamTime){
            lastTime = testTime;
        }else{
            lastTime = ExamTime;
        }
        // console.log(ExamTime,nowTime,e_Hours,testTime,ExamTime);
        document.getElementById("minutes").innerHTML=lastTime;
        // if(lastTime<1){
        //     alert("考试结束，自动提交试卷！");
        //     submit();
        // }
        setInterval(
            function(){
                lastTime -=1;
                document.getElementById("minutes").innerHTML=lastTime;
                if(lastTime<1){
                    alert("考试结束，自动提交试卷！");
                    submit();
                }
            }
            ,60000)
    }
    window.onload=showTime;

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
            break;
        case '100020102':
            echo '<input type="checkbox" value="A" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;A
            <input type="checkbox" value="B" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;B
            <input type="checkbox" value="C" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;C
            <input type="checkbox" value="D" name="'.$question['QuestionBh'].'[]"/>&nbsp;&nbsp;D';
            break;
        case '1000203':
            echo '<input type="radio" value="1" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;对
            <input type="radio" value="0" name="'.$question['QuestionBh'].'"/>&nbsp;&nbsp;错';
            break;
        case '1000204':

            break;
        case '1000205':
            echo '<textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>';
            break;
            break;
        case '1000206':

            $QuestionBh = $question['QuestionBh'];
            if ($question['IsProgramBlank'] == '100001') {
                //这里需要加个是否存在文件的判断，然后再显示吧
                echo '<p class="friendFile">题目所用文件：';
                foreach ($question['file'] as $key => $value) {
                    echo '<a class="fileName" href="'.$value.'" target="_blank">'.$key.'</a>';
                }
                echo '</p>';

                echo '<textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'" >';
                echo '</textarea>
            <button id="revert'.$question['QuestionBh'].'" class="btn btn-default BY"  type="button" onclick="revertAnswer('."'$QuestionBh'".')">还原代码</button>
            <div class="noDiv" style="margin:0; padding:0;"><button id="compile'.$question['QuestionBh'].'" class="btn BY"  type="button" onclick="compile('."'$QuestionBh'".')">编译该题</button></div><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong class="stuScore" id="score'.$question['QuestionBh'].'"></strong><div class="message" style="top:-53px; left:85px;">请勿频繁操作</div>';
            } else {
                //这里需要加个是否存在文件的判断，然后再显示吧
                echo '<p class="friendFile">题目所用文件：';
                foreach ($question['file'] as $key => $value) {
                    echo '<a class="fileName" href="'.$value.'" target="_blank">'.$key.'</a>';
                }
                echo '</p>';
                echo '<textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="noDiv" style="margin:0; padding:0;"><button id="compile'.$question['QuestionBh'].'" class="btn BY"  type="button" onclick="compile('."'$QuestionBh'".')">编译该题</button></div><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分数:</label>&nbsp;&nbsp;<strong class="stuScore" id="score'.$question['QuestionBh'].'"></strong><div class="message">请勿频繁操作</div>';
            }

            break;
        case '1000207':
            echo '<textarea class="col-xs-8" rows="20" name="'.$question['QuestionBh'].'"></textarea>';
            break;
        case '1000208':
            $m_find_error = new \app\models\question\FindError();
            $Tmp_Error = $m_find_error->find()->where([
                'QuestionBh' => $question['QuestionBh']
            ]);
            for ($i = 0; $i<$Tmp_Error->count(); $i++) {
                echo $i+1 .':<input id="'.$i.$question['QuestionBh'].'" type="text" name="'.$question['QuestionBh'].'[]"/></br></br>';
            }
            break;
    }
}
?>
