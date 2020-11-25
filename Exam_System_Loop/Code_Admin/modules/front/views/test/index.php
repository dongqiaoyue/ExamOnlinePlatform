<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<script>
function reinitIframe1(){
var iframe = document.getElementById("frame1");
try{
var bHeight = iframe.contentWindow.document.body.scrollHeight;
var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;

var height = bHeight > dHeight ? bHeight:dHeight;
iframe.height = height;
}catch (ex){}
};

function reinitIframe2(){
var iframe = document.getElementById("frame2");
try{
var bHeight = iframe.contentWindow.document.body.scrollHeight;
var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;

var height = bHeight > dHeight ? bHeight:dHeight;
iframe.height = height;
}catch (ex){}
};

window.setInterval("reinitIframe1()", 20);
window.setInterval("reinitIframe2()", 20);



</script>
<div class="page-title">
  <span class="title">习题练习</span>
  <div class="description">
        在这里你可以习题练习
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">

    <div id="Bigbox">

        <iframe onLoad="reinitIframe1();" src="<?=Url::toRoute("test/left")?>" id="frame1" style=" width:20%; " frameborder="0" scrolling="no"></iframe>
        <iframe onLoad="reinitIframe2();" src="" id="frame2" name="view_frame" frameborder="0" scrolling="no" style="width:80%;    float:right;"></iframe>
    </div> <!--BigBOX-->
</div>
</div>
</div>
</div>
<?php $this->beginBlock('footer');  ?>

<script type="text/javascript">
    function tab(id) {
        var tmp = $('#'+id+'-a').css('display');
        if (tmp == 'none') {
            $('#'+id+'-a').slideDown(500);
        } else {
            $('#'+id+'-a').slideUp(500);
        }
    }
        $(".MyMouse").hover(
            function(){
                $(this).children(".Nmenu3").show();
            },
            function(){
                $(this).children(".Nmenu3").hide();
            });

    //下面是试卷的样式
    $(document).ready(function(){
        $(".toggle").click(function(){
            var _index = $(this).index();

            if($(this).html()=="展开")
            {
                $(this).html("收起");
            }else
            {
                $(this).html("展开");
            }
         $(this).parent('.Tet').siblings('.Mid_Text').slideToggle();

        });
        $(".T-name").click(function(){
            $(this).next('.My_Text').slideToggle("fast");
        });
        $("#Head-top li").click(function(){
            var _rel = $(this).attr("name");
            var pos = $('#'+_rel).offset().top;
            $("html,body").animate({scrollTop:pos},300);
        });
    });



  </script>

<?php $this->endBlock(); ?>
