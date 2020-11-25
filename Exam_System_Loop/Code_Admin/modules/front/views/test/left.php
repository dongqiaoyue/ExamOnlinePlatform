<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<?php $this->beginBlock('header');  ?>

<link rel="stylesheet" href="<?=Url::base()?>/front/css/exam_style.css" type="text/css">
<!-- <head></head>中代码块 -->
<?php $this->endBlock(); ?>

<style type="text/css">
    body{
        /* background-color: #f9f9f9; */
    }
</style>

<section class="content">
    <div id="Bigbox">
        <div id="Right_nav">
            <button type="button" class="btn  btn-primary btn-block active" >知识点选择</button>

            <div id="nav_down">
                <ul class="nav nav-pills nav-stacked Nmenu1">   <!--"nav "-->
                    <?php foreach ($list as $key=>$item) {?>
                     <li class="slide" id="<?=$key?>" onclick="tab('<?=$key?>')"><div class="tt"><a><?=$key?></a></div>
                         <?php foreach ($item as $k=>$va) {?>
                         <ul class="Nmenu2" id="<?=$key?>-a">
                                <li class="MyMouse" ><div class="dd"><a class="MyMouse1" href="#">*<?=$k?></a></div>
                                    <ul class="Nmenu3" id="<?=$k?>">
                                        <?php foreach ($va as $value) {?>
                                        <li class="sstop"><a style="display:block; width:100%; height:auto;" target="view_frame" href="<?=Url::toRoute('test/questions')?>&course=<?=$key?>&know=<?=$value['KnowledgeBh']?>&stage=<?=$k?>"><?=$value['KnowledgeName']?></a></li>
                                        <?php }?>
                                    </ul>
                                </li>
                            </ul>
                         <?php }?>
                     </li>
                    <?php }?>
                </ul>
            </div>
        </div>  <!--right_nav-->
</div>
</section>

<script type="text/javascript">
    function tab(id) {
        var tmp = $('#'+id+'-a').css('display');
        if (tmp == 'none') {
            $('#'+id+'-a').slideDown(500);
            $('#'+id).siblings().children(".Nmenu2").slideUp(500);
        }
    };

     $(".sstop").on('click',function(){
      $(this).parents(".slide").find(".sstop").children('a').css('color','black');
      $(this).children('a').css('color','red');
      $(this).parents(".MyMouse").siblings().find('a').css('color','black');
     })


     $('.tt').on('click',function(){
        if($(this).parent('li').find('.Nmenu2').css('display') == 'block'){
            $(this).parent('li').find('.Nmenu2').slideUp(300);
        }else{
             $(this).parent('li').find('.Nmenu2').slideDown(300);
             $(this).parent('li').siblings().find('.Nmenu2').slideUp(300);
        }
     })

     $('.dd').on('click',function(){
        if($(this).parent('li').find('.Nmenu3').css('display') == 'block'){
            $(this).parent('li').find('.Nmenu3').slideUp(300);
        }else{
            $(this).parent('li').find('.Nmenu3').slideDown(300);
        }
     })
    </script>
