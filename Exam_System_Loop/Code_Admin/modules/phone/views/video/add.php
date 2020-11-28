<?php
/**
 * Created by PhpStorm.
 * User: wangxixi
 * Date: 2017/2/21
 * Time: 15:07
 */

use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
use app\models\phone\Tresources;

$com = new commonFuc();
$m_know = new \app\models\question\Knowledgepoint();
/*$m = new \app\models\phone\UploadFile();*/
?>


<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>



<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>

<?php
    $m_user = new \app\models\TbcuitmoonUser();
    $user_name =  $m_user->find()->where([
    'CuitMoon_UserID' => Yii::$app->user->getId(),
])->asArray()->one()['CuitMoon_UserName'];
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a href="<?=Url::toRoute("video/index")?>">视频管理-></a>>视频添加</h3>
                </div>
                <h1></h1>
                <div class="box-body">
                    <!-- 弹出框 -->
                    <div class="container">
                        <div class="view-body">
                            <div class="keypoint  bg-inverse radius text-center csbg">
                                <p>
                                    <br />
                                    <button class="button  bg-main button-big icon-arrow-circle-up" id="upid">
                                        立即上传</button>
                                </p>
                            </div>
                            <div class="progress progress-small">
                                <div class="progress-bar bg-yellow" id="myProgress" style="width: 0%;">
                                </div>
                            </div>
                        </div>



                    </div>
                    <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("video/index"),'options'=> ['enctype' => 'multipart/form-data']]); ?>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">视频路径</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="urlGO" name="Tresources[ResourcesURL]" readonly>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <br>


                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">自定义编号</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="moduleName" name="Tresources[CustomBh]">
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <br>

                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">所属阶段</label>
                            <div class="col-xs-4">
                                <select class="form-control" id="video_StageCode" value="0">
                                    <?php foreach ($stage as $model){?>
                                        <option id="<?=$model->CuitMoon_DictionaryCode?>" value="<?=$model->CuitMoon_DictionaryCode?>" ><?=$model->CuitMoon_DictionaryName?></option>
                                    <?php }?>
                                    <option id="okk" selected></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <br>
                    <div class="row">
                    <div  class="form-group" >
                        <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1" >知识点</label>
                        <label  id="video_KnowledgeBhCode" value="0" name="Tresources[KnowledgeBh]">

                        </label>
                    </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">是否考核</label>
                            <div class="col-xs-2">
                            <select class="form-control" id="video_BeforeID" value="0" name="Tresources[IsExam]" >
                                <!-- Name="IsExam" -->
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
                            </div>
                        </div>
                    <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">前置资源</label>
                            <div class="col-xs-2">
                                <select class="form-control" id="video_BeforeID" value="0" name="Tresources[BeforeID]">
                                    <option value="0" ></option>
                                    <?php
                                    $list = (new Tresources())->aaa();
                                    foreach ($list as $model){?>
                                        <option value="<?=$model->ID?>" ><?=$model->Name?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <h1></h1>

                        </div>

                    </div>


                    <br>
                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">视频标题</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="moduleName" name="Tresources[Name]" placeholder="必填">
                            </div>
                        </div>
                    </div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label col-md-offset-1">视频描述</label>
                            <div class="col-xs-6">
                                <script type="text/plain" id="video_Description" name="Tresources[Description]"></script>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <h1></h1>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-xs-10 col-md-offset-10">
                                <button id="videoSubmit" type="button" class="btn btn-primary">提交</button>
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
<script src="<?=Url::base()?>/fcup/fcup/js/jquery.fcup.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    var ue = UE.getEditor('video_Description');





    $("#video_StageCode").change(function(){
        //alert();
        getKnowledge($("#video_StageCode").val(),$("#video_StageCode option:selected").text());
    });

    //添加框获取知识点
    function getKnowledge(stageId,stageName)
    {
        //alert();
        $.ajax({
            type:'GET',
            url:'<?=Url::toRoute('video/knowledge-list')?>',
            data:{'stageId':stageId},
            catch:false,
            async : false,
            dataType:'json',
            success:function (value) {
                var html='';
                //alert(stageName);
                html += stageName+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                for(var Tmp in value){
                    html += '<span id="'+value[Tmp]['KnowledgeBh']+'" ><input  id= "'+value[Tmp]['KnowledgeName']+'" type="checkbox" name="KnowledgeBhCode[]" value="'+value[Tmp]['KnowledgeBh']+'">';
                    html += '<label for="'+value[Tmp]['KnowledgeName']+'" style="font-size:15px;" >'+value[Tmp]['KnowledgeName']+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
                    $('#video_StageCode').children('#'+stageId).hide();
                }
                html += '<br>';
                $('#video_KnowledgeBhCode').append(html);

            }
        });
    }
    //Asynchronous request stage knowledge points

    $('#videoSubmit').click(function (e) {
        e.preventDefault();
        e.preventDefault();
        $('#admin-role-form').submit();
    });

    //ajax Request compilation
    $('#admin-role-form').bind('submit',function (e) {

        e.preventDefault();

        $(this).ajaxSubmit({

            type:'POST',
            dataType:'json',
            url:'<?=Url::toRoute("video/create")?>',

            success:function (value) {
                //alert();
                if(value.error == 0){
                    alert('添加成功');
                    window.location.href = '<?=Url::toRoute("video/index")?>';
                }else{
                    alert('添加失败');
                }
            }
        })
    })

    // 进度条
    function Progress(value) {
        $('#myProgress').css('width', value + '%');
        // if(value == 100){
        //     window.location.reload();
        // }
    }

    function CloseDialog() {
        $('#mydialog').hide();
    }


    $.fcup({

        upId: 'upid', //上传dom的id

        upShardSize: '', //切片大小,(单次上传最大值)单位M，默认2M

        upMaxSize: '', //上传文件大小,单位M，不设置不限制

        upUrl: '<?=Url::base()?>/fcup/php/file.php', //文件上传接口

        upType: 'FLV,mp4,AVI,MPG,flv,MP4,avi,mpg', //上传类型检测,用,号分割

        //接口返回结果回调，根据结果返回的数据来进行判断，可以返回字符串或者json来进行判断处理
        upCallBack: function (res) {

            // 状态
            var status = res.status;
            // 信息
            var msg = res.message;
            // url
            var url = res.url;

            // 已经完成了
            if (status == 2) {
                alert(msg);
                $('#pic').attr("src", url);
                $("#urlGO").attr("value", url)
                $('#mydialog').show();
            }

            // 还在上传中
            if (status == 1) {
                console.log(msg);
            }

            // 接口返回错误
            if (status == 0) {
                // 停止上传并且提示信息
                $.upStop(msg);
            }
        },

        // 上传过程监听，可以根据当前执行的进度值来改变进度条
        upEvent: function (num) {
            // num的值是上传的进度，从1到100
            Progress(num);
        },

        // 发生错误后的处理
        upStop: function (errmsg) {
            // 这里只是简单的alert一下结果，可以使用其它的弹窗提醒插件
            alert(errmsg);
        },

        // 开始上传前的处理和回调,比如进度条初始化等
        upStart: function () {
            Progress(0);
            $('#mydialog').hide();
            alert('开始上传');
        }

    });





</script>
<?php $this->endBlock(); ?>

