<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>
<style type="text/css">
    body{
        background:#ECF0F5;
    }
    .wrap{
        width:76%;
        height:500px;
        margin:0 auto;
        border:1px solid orange;
        background-color: white;
    }
    .content{
        width:80%;
        height:400px;
        margin:0 auto;
        margin-top:50px;
        padding-top: 20px;
        background-color: #72C1F4;
        background:url(<?=Url::base()?>/front/img/changeBg.jpg);
        background-repeat: no-repeat;
        background-size:cover;
        background-position:center;
        border-radius: 8px;
        text-align: center;
    }
    .content .IfoName{
        width: 80%;
        margin:0 auto;
        margin-top: 20px;
        text-align: center;
        height: 35px;
        line-height: 35px;
        background-color:#fff;
    }
    .content .password{
        width:60%;
        margin:0 auto;
        margin-top: 30px;
        height:250px;
        border:1px solid gray;
    }
    #pass{
        width:80%;
        margin: 0 auto;
        line-height: 50px;
        margin-top: 20px;
        font-size: 18px;
    }
    input{
        height:26px;
        border-radius: 3px;
    }
    #sub{
        height:30px;
        line-height: 30px;
        border-radius: 0px;
        width:50%;
        margin:0 auto;
        margin-top: 20px;
        background-color: orange;
        border:0px solid white;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        letter-spacing: 8px;
        color: white;
        cursor: pointer;
    }
    .left{
        text-align: right;
        margin-right: 8px;
    }
    .right{
        text-align: left;
    }
</style>
</head>

<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#sub").click(function(){
            var oldWord = $("#OldPW").val();
            var newWord1 = $("#NewPw1").val();
            var newWord2 = $("#NewPw2").val();
            if(newWord1!=newWord2){
                alert("请重新确认新密码!");
            }else{
                $.ajax({
                    type:"post",
                    dataType:'json',
                    url:'<?=Url::toRoute("/site/change")?>',
                    data:{ "StuNumber":$('#user').html(),"oldpassword":$('#OldPW').val(),"newpassword":$('#NewPw1').val() },
                    success:function(data){
                        if(data.error == 0){
                            alert('修改成功');
                            window.location.href = '<?=Url::toRoute("/site/index")?>';
                        }else{
                            alert("原始密码输入错误！");
                        }
                    },
                    cache:false,
                });
            }
        });
    });

</script>

<body>
<div class="wrap">
    <div class="content">
        <div class="IfoName"><span>修改个人密码</span>
        </div>
        <div class="password">
            <table id="pass">
                <tr><td class="left" >用户名：</td><td class="right" id="user" name="StuNumber"><?=Yii::$app->session->get('UserName')?></td></tr>
                <tr><td class="left"><label>原密码：</label></td><td class="right"><input id="OldPW" type="password" name="oldpassword" maxlength="20"></td></tr>
                <tr><td class="left"><label>新密码：</label></td><td class="right"><input id="NewPw1" type="password" name="newpassword" maxlength="20"></td></tr>
                <tr><td class="left"><label>确认密码：</label></td><td class="right"><input id="NewPw2" type="password" maxlength="20"></td></tr>
            </table>
            <button id="sub" type="submint" value="提交">提交</button>
        </div>
    </div>
</div>
