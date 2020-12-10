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
		display: none
	}
</style>
<div class="page-title">
	<span class="title">查看成绩</span>
	<div class="description">
				在这里你可以查看你的考试成绩
	</div>
</div>
<div class="row">
  <div class="col-xs-12">
  		<div class="card">
				<div class="card-body">
					<?php foreach ($info as $key=>$item) {?>
  			            <div class="panel panel-default">
                            <div class="panel-heading flip" id="<?=$key;?>"  onclick='TestClick("<?=$key;?>")'><?=$key?></div>
							<div class="panel-body " id="1<?=$key;?>">
										<p>你可以点击标题</p>
							</div>
                            <?php foreach ($item as $ke=>$it) {?>
      						<div class="panel-heading flip" id="2<?=$ke;?>" onclick='TestClick1("<?=$ke;?>")'><?=$ke?></div>
                                <div class="pan" id="3<?=$ke;?>">
                                    <table  class="table  table-hover " >
												<thead>
													 <tr>
															<th>#</th>
															<th>考试名称</th>
															<th>第几次考试</th>
															<th>开始时间</th>
															<th>交卷时间</th>
															<th>成绩</th>
													 </tr>
												</thead>
													<?php foreach ($it as $va) { ?>
												<tbody>

													<tr class="">
														 <th ><?php echo "$i"; $i++;?></th>
														 <th><?=\app\models\teachplan\Examplan::find()->where(['ExamPlanBh' => $va->ExamPlanBh])->asArray()->one()['ExamPlanName']?></th>
														 <th><?=$va->NumOfExam?></th>
														 <th><?=$va->StarTime?></th>
														 <th><?=$va->EndTime?></th>
														 <th><?=$va->ExamScore?></th>
													</tr>

												</tbody>
												<?php }?>
									</table>
                                </div>

                            <?php }?>
                        </div>
                    <?php } ?>
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

function TestClick1(a){//定义了2个参数a,b
    // console.log(".pan"+a);
    $("#3"+a).stop().slideToggle(500);
}
</script>
