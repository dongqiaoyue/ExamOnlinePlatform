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
    margin-top: 0px;
}
.wrap{
    max-width:86%;
    height:500px;
    margin:0 auto;

    background-color: white;
}
.content{
    max-width:35%;
    height:425px;
    margin:0 auto;
    margin-top:30px;
    padding-top: 10px;
    background-color: #f9f9f9;

    background-repeat: no-repeat;
    background-size:cover;
    background-position:center;
    border-radius: 8px;
    text-align: center;
}
.content .IfoName{
    max-width: 80%;
    font-weight: bold;
    letter-spacing: 2px;
    margin:0 auto;
    margin-top: 10px;
    text-align: center;
    height: 35px;
    font-size: 30px;
    margin-bottom: -15px;

}
.content .password{
    max-width:60%;
    margin:0 auto;
    margin-top: 30px;
    height:250px;

}
#pass{
    max-width:80%;
    margin: 0 auto;
    line-height: 25px;
    margin-top: 5px;
    font-size: 14px;
    font-weight: bold;
}
input{
    height:23px;
    border:0px solid gray;

}

.fff{
    background-color: #fff;
}
#sub{
    height:30px;

    border-radius: 0px;
    width:50%;
    margin:0 auto;
    margin-top: 20px;
    margin-bottom: 15px;

    text-align: center;

    font-weight: bold;
    letter-spacing: 8px;
    color: white;
    cursor: pointer;
}
.left{
    max-width:110px;
    text-align: right;
    margin-right: 8px;
    font-weight: bold;
    line-height: 31px;
}
.right{
    max-width: 240px;
    text-align: left;
}
.password{
    min-width: 406px;
    min-height: 300px;
}
</style>
</head>

 <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function() {

                var oldID = "1234";  //如果方便可以先保存起其原始身份证号，避免无修改提交;如果不保存此数据，则需要修改下面的ajax请求
                $("#sub").click(function(){
                    var oldID = $("#OldID").val();
                    var newID = $("#NewID").val();
                    if(!newID){
                        alert("请输入身份证号！");
                    }else if(newID==oldID){
                        alert("你未修改身份证号，不用再次提及！");
                    }else{
                        $.ajax({
                            type:"post",
                            dataType:'json',
                            url:"<?=Url::toRoute('site/change-info')?>",
                            data:{ "StuNumber":$('#user').html(),"oldID":oldID,"newID":$('#NewID').val() },
                            success:function(data){
                                // alert(date);
                                if(data.error == 0){
                                    alert('修改成功');
                                    window.location.reload();
                                }else{
                                    alert("修改失败，请稍后再试!");
                                }
                            },
                            cache:false,
                        });
                    }
                });
            });

</script>

<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">
<div class="wrap">
    <div class="content">
        <div class="IfoName"><span>学员信息</span>
        </div>
        <div class="password">
            <table id="pass">
                <tr><td class="left" >用户名：</td><td class="right" id="user" name="StuNumber"><?=Yii::$app->session->get('StudentNum')?></td></tr>

                <tr><td class="left"><label>姓名：</label></td><td class="right"><input class="form-control" id="uasrName" type="text" name="oldpassword" disabled="disabled" value="<?=$student_info['Name']?>"></td></tr>
                <tr><td class="left"><label>性别：</label></td><td class="right"><input class="form-control" type="text" name="newpassword" disabled="disabled" value="<?=$student_info['Sex']?>"></td></tr>
                <tr><td class="left"><label>身份证号：</label></td><td class="right"><input class="form-control" class="fff" id="NewID" type="text" maxlength="18" value="<?=$student_info['ICNumber']?>"></td></tr>

                 <tr><td class="left"><label>班级：</label></td><td class="right"><input class="form-control" type="text" name="oldpassword" disabled="disabled" value="<?=$student_info['ClassName']?>"></td></tr>
                  <tr><td class="left"><label>专业：</label></td><td class="right"><input class="form-control" type="text" name="oldpassword" disabled="disabled" value="<?=$student_info['MajorName']?>"></td></tr>
                   <tr><td class="left"><label>学院：</label></td><td class="right"><input class="form-control" type="text" name="oldpassword" disabled="disabled" value="<?=$student_info['DepartmentName']?>"></td></tr>
                    <tr><td class="left"><label>备注信息：</label></td><td class="right"><input class="form-control" type="text" name="oldpassword" disabled="disabled" value="<?=$student_info['Memo']?>"></td></tr>
            </table>
            <button id="sub" type="submint" value="提交" class="btn btn-primary">提交</button>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
