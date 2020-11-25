<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>


<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">新闻数据管理->新闻添加添加</h3>
                </div>
                <h1></h1>
                <div class="modal-body">
                <?php $form = ActiveForm::begin(["id" => "admin-role-form", "class"=>"form-horizontal", "action"=>Url::toRoute("news/index")]); ?>

                <input type="hidden" class="form-control" id="id" name="id" />

                <div id="Title_div" class="form-group">
                    <label for="name" class="col-sm-2 control-label">新闻标题</label>
                    <div class="col-sm-10">
                        <input  class="form-control" id="NewsTitle" name="Newsinfo[newstitle]" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="Type_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">新闻类型</label>
                    <div class="col-sm-10">
                        <select class="form-group" name="Newsinfo[newstype]" id="NewsType">
                            <option value="all">请选择</option>
                            <?php
                            foreach($type as $key=>$data){
                                echo "<option value='" . $data->CuitMoon_DictionaryName . "'>". $data->CuitMoon_DictionaryName."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="remarks_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">新闻内容</label>
                    <div class="col-sm-10">
                        <script type="text/plain" id="NewsContent" name="Newsinfo[newscontent]"></script>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="User_div" class="form-group">
                    <label for="des" class="col-sm-2 control-label">新闻发布者</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Newsinfo[releaseUser]" id="ReleaseUser" placeholder="必填" />
                    </div>
                    <div class="clearfix"></div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
                <a id="edit_dialog_ok" href="#" class="btn btn-primary">确定</a>
            </div>
</section>




<?php $this->beginBlock('footer');  ?>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.config.js"></script>
<script type="text/javascript" src="<?=Url::base()?>/component/editor/ueditor.all.min.js"></script>
<script type="text/javascript">
    //ueditor编辑器
    var ue = UE.getEditor('NewsContent');
</script>
<script>
        $('#edit_dialog_ok').click(function (e) {
            e.preventDefault();
            $('#admin-role-form').submit();
        });

        //ajax Request compilation
        $('#admin-role-form').bind('submit',function (e) {
            e.preventDefault();
            $(this).ajaxSubmit({
                type:'POST',
                dataType:'json',
                url:'<?=Url::toRoute("news/create")?>',
                success:function (value) {
                    if(value.error == 0){
                        alert('添加成功');
                        window.location.href = '<?=Url::toRoute("news/index")?>'
                    }else{
                        alert('添加失败');
                    }
                }
            })
        })


    </script>
<?php $this->endBlock(); ?>
