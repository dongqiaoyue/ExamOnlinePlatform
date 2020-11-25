<?php
use yii\helpers\Url;
?>

<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/lib/codemirror.css">
<script src="<?=Url::base()?>/plugins/codeEditor/lib/codemirror.js"></script>
<script src="<?=Url::base()?>/plugins/codeEditor/code/clike.js"></script>

<!--括号匹配-->
<script src="<?=Url::base()?>/plugins/codeEditor/addon/edit/matchbrackets.js"></script>
<!--引入css文件，用以支持主题-->
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/pastel-on-dark.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/night.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/the-matrix.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/xq-dark.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/panda-syntax.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/monokai.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/colorforth.css">
<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/eclipse.css">

<link rel="stylesheet" href="<?=Url::base()?>/plugins/codeEditor/theme/duotone-light.css">

<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">
<div style="height:100%; width:100%;">
  <textarea id="code"style="height:430px; width:100%;" ></textarea>
  <br>


  <span class="input-group-addon">编译情况</span>
  <div class="input-group col-sm-5" style="float: left;">
      <span class="input-group-addon">输入</span>
      <textarea class="form-control" id="Input" rows="7"  placeholder="运行程序时输入" ></textarea>
  </div>
  <!-- <br>  -->
  <div class="input-group col-sm-2" style="float: left;height: 20px;">
  <br>

    <div class="input-group col-sm-6" style="margin:auto;">
      <select class="form-control" id="compiler-choice">
          <option value="-1"  selected = "selected" >请选择编译器</option>
          <?php foreach ($compiler as $value){?>
              <option value="<?=$value['CuitMoon_DictionaryName']?>"><?=$value['CuitMoon_DictionaryCode']?></option>
          <?php }?>
      </select>
    </div>
    <br>

    <div class="input-group col-sm-6" style="margin:auto;">
      <select class="form-control" id="skype">
          <option value="-1"  selected = "selected" >选择皮肤</option>

      </select>
    </div>

      <p style="text-align: center;"> <a href="#" id=""><img src="<?=Url::base()?>/front/img/run.svg" style="height:50px; margin:auto;" /></a></p>
      <p style="text-align: center;"> <button id="run" type="button" class="btn btn-xs btn-primary" ">运行</button></p>
  </div>

  <div class="input-group col-sm-5" style="float: left;">
      <span class="input-group-addon">输出</span>
      <textarea class="form-control" id="res" rows="7" placeholder="运行结果" ></textarea>

  </div>
</div>
</div>
</div>
</div>
</div>

<?php $this->beginBlock('footer');  ?>
<script type="text/javascript">

    var defaultCode = ["#include <stdio.h>\nint main()\n{\n    return 0;\n}",
      "#include <iostream>\nusing namespace std;\nint main()\n{\n\n    return 0;\n}",
        "",
        "public class Main{\n    public static void main(String[] args){\n        \n    }\n}",
        "",
        "",
        "# coding=utf-8\n",
        "\<\?php\n    \n\?\>"];
    var editor=CodeMirror.fromTextArea(document.getElementById("code"),{
        indentUnit:4,
        smartIndent:true,
    	  // fullScreen:true,
        mode:"text/x-c",
        lineNumbers:true,
        theme:"pastel-on-dark",
        matchBrackets:true,
        extraKeys:{
        "Ctrl-B":function(){run();},
        "Ctrl-S":function () {

                  }

    }

    });
    $('#compiler-choice').change(function(e){
        var compiler = $(this).val();
        $('#run').attr('disabled',true);
        $.post(
          "<?=Url::toRoute('test/change-compiler')?>",
          {compiler:compiler},
          function(res){
            $('#run').attr('disabled',false);
            editor.setValue(defaultCode[compiler]);

          }
        )
    })
    function run(){
      var code = editor.getValue();
      var compiler = $('#compiler-choice').val();
      if( compiler == "-1")
      {
        alert("请先选择编译器");
      }

      else if($.trim(code) == '')
      {
        alert("请输入代码");
      }
      else
      {
        $('#run').attr('disabled',true);
        $.post(
          "<?=Url::toRoute('test/run')?>",
          {
            input_text:$('#Input').val(),
            code:code
          },

          function(res){
            $('#res').val(res);
            $('#run').attr('disabled',false);
          }

        )
      }
    }
    $('#run').click(function(){
      run();
    })
    function a(){
      var skype = ["pastel-on-dark","night","the-matrix","xq-dark","panda-syntax","monokai","colorforth","eclipse","duotone-light"];
      for(var i=0; i<skype.length; i++)
      {
        $('#skype').append('<option class="change_skype" value="'+skype[i]+'">'+skype[i]+'</option>');
      }
    }
    editor.setValue("//Ctrl+B 快捷运行")
    a();
    $('.change_skype').click(function(){
      editor.setOption("theme",$(this).val());
    })
</script>
<?php $this->endBlock(); ?>
