<?php
use yii\widgets\LinkPager;
use yii\base\Object;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\commonFuc;
$com = new commonFuc();
$i = 1;
?>
<style media="screen">
.pan{
		display: none;
	}
	.panel-body{
		display: none;
	}
</style>
<div class="page-title">
	<span class="title">进入考试</span>
	<div class="description">
				在这里你可以进入考试
	</div>
</div>
<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">
					<?php foreach ($ExamList as $key=>$value) { $i=1?>
  			<div class="panel panel-default">
  						<div class="panel-heading flip" id="<?=$key;?>"  onclick='TestClick("<?=$key;?>")'>
											<?=$key?>
  						</div>
							<div class="panel-body " id="1<?=$key;?>">
										<p>点击标题收缩</p>
							</div>
      						<div class="pan" id="2<?=$key;?>">


									<table  class="table  table-hover " >
												<thead>
													 <tr>
															<th>#</th>
															<th>考试名称</th>
															<th>开考时间</th>
															<th>结束时间</th>
															<th>考试状态</th>

													 </tr>
												</thead>
                        <?php foreach ($value as $va) {?>
												<tbody>

													<tr class="">
														 <th ><?php echo "$i"; $i++;?></th>
														 <th><?=$va->ExamPlanName?></th>
														 <th><?=$va->StarTime?></th>
														 <th><?=$va->EndTime?></th>
														 <th><?php
                                    $m_exam_paper = new \app\models\exam\Exampaper();
                                    $SubmitStage = $m_exam_paper->
                                    find()->where([
                                        'ExamPlanBh' => $va->ExamPlanBh,
                                        'StudentID' => Yii::$app->session->get('StudentNum')
                                    ])->orderBy("ExamBeginTime DESC")->one();
                                    // findOne([
                                    //     'ExamPlanBh' => $va->ExamPlanBh,
                                    //     'StudentID' => Yii::$app->session->get('StudentNum'),
                                    // ]);
                                    isset($SubmitStage) ? $SubmitStage = $SubmitStage->SubmitStage : $SubmitStage = '0';

                                        if (date('Y-m-d H:i:s') <= $va->StarTime) {
                                            echo '等待考试';

                                        } else if (date('Y-m-d H:i:s') <= $va->EndTime && date('Y-m-d H:i:s') >= $va->StarTime) {
                                           if ($SubmitStage == '1') {
                                               echo '已交卷';
                                           } else {
                                               echo '<a style="color:red;" class="InExam" href=' . Url::toRoute('exam/enter-exam') . '&ExamPlanBh=' . $va->ExamPlanBh . '>进入考试</a>';
                                           }
                                        } else {
                                            echo '考试结束';
                                        }
                                    ?></th>

													</tr>

												</tbody>
                        <?php }?>
									</table>
											</div>

							</div><?php } ?>
  			</div>
  		</div>
  </div>
</div>
<script  type="application/javascript">
function TestClick(a){//定义了2个参数a,b
	// console.log(".pan"+a);
		$("#1"+a).stop().slideToggle(500);
	$("#2"+a).stop().slideToggle(500);
  }

window.onload = function(){
    var x = 0;
    $(".InExam").click(function(){
        x = x + 1;
        console.log(x);
        if(x == '2'){
        	alert('请勿重复操作');
        	x = 1;
            return false;
        }
    })
}
</script>
