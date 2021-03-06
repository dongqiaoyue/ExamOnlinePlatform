<?php

namespace app\modules\exam\controllers;

use app\models\exam\Examprocess;
use app\models\system\TbcuitmoonDictionary;
use app\modules\front\controllers\ExamController;
use common\commonFuc;
use app\models\exam\Exampaper;
use app\models\teachplan\Examplan;
use app\models\teachplan\Teachingclassmannage;
use app\models\teachplan\Teachingclassdetails;
use app\models\systembase\Studentinfo;
use app\models\exam\Paper;
use Yii;

class ResitController extends \app\controllers\BaseController
{
	public function actionIndex()
	{
		$com = new commonFuc();
		return $this->render("index",['now_term'=>$com->getNowTerm(),]);
	}

	public function actionGetExam()
	{
		if(\Yii::$app->request->isPost)
    	{
    		$info = [];
    		$post=\Yii::$app->request->post();
    		if(isset($post['ExamPlanBh']) && isset($post['TeachClass']) && isset($post['Time']))
    		{
    			$info['PassScore'] = Examplan::find()->where(['ExamPlanBh'=>$post['ExamPlanBh']])->asArray()->one()['PassScore'];
    			$info['TotalNum'] = Teachingclassdetails::find()->where(['TeachingClassID'=>$post['TeachClass']])->count();
    			$info['ExamNum'] = Exampaper::find()->where(['ExamPlanBh'=>$post['ExamPlanBh'],'TeachingClassID'=>$post['TeachClass'],'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time']])->count();
    			$info['No'] = Teachingclassdetails::find()
	    		->select(Studentinfo::tableName().".StuNumber,".Studentinfo::tableName().".Name")
	    		->where("TeachingClassID = :tea 
	    			and ".Teachingclassdetails::tableName().".StuNumber"." NOT IN (SELECT StudentID FROM exampaper WHERE ExamPlanBh = :exam and DealState!='0')",
	    			[':tea'=>$post['TeachClass'],
	    			':exam'=>$post['ExamPlanBh']
	    			])
	    		->leftJoin(Studentinfo::tableName(),Studentinfo::tableName().".StuNumber=".Teachingclassdetails::tableName().".StuNumber")
	    		->asArray()
	    		->all();
	    		$info['NotPass'] = [];
	    		$info['IsPass'] = [];
	    		$info['NotPass'] = Exampaper::find()
	    		->select("StuName,StudentID,Score")
	    		->where([
	    			'ExamPlanBh'=>$post['ExamPlanBh'],
	    			'TeachingClassID'=>$post['TeachClass'],
	    			// 'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time']
	    			])
	    		->andWhere("CAST(Score as SIGNED) < :score",
	    			[':score'=>(double)$info['PassScore']
	    			])
	    		->andWhere("DealState!='0'")
	    		// ->andWhere("PaperName != '1'")
	    		->groupBy("StudentID")
	    		->asArray()
	    		->all();

	    		$info['IsPass'] = Exampaper::find()
	    		->select("StuName,StudentID,Score")
	    		->where([
	    			'ExamPlanBh'=>$post['ExamPlanBh'],
	    			'TeachingClassID'=>$post['TeachClass'],
	    			// 'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time']
	    			])
	    		->andWhere("CAST(Score as SIGNED) >= :score",
	    			[':score'=>(double)$info['PassScore']
	    			])
	    		->andWhere("DealState!='0'")
	    		->andWhere("PaperName = '1'")
	    		->groupBy("StudentID")
	    		->asArray()
	    		->all();
	    		// foreach ($tmp['NotPass'] as $key => $value) {
	    		// 	$isPass = Exampaper::find()
	    		// 	->where([
	    		// 		'StudentID'=>$value['StudentID'],
	    		// 		'ExamPlanBh'=>$post['ExamPlanBh'],
	    		// 		'TeachingClassID'=>$post['TeachClass'],
	    		// 		'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time']
	    		// 		])
	    		// 	->andWhere("DealState!='0'")
	    		// 	->asArray()
	    		// 	->one()['Score'];

    			// 	$value['Score'] = (double)$isPass;
    			// 	if((double)$info['PassScore'] > (double)$isPass)
	    		// 		$info['NotPass'][] = $value;
	    		// 	else
	    		// 		$info['IsPass'][] = $value;

	    			
	    		// }
	    		foreach ($info['NotPass'] as $key => $value) {
	    			$info['NotPass'][$key]['num'] = Exampaper::find()->where(['StudentID'=>$value['StudentID'],'ExamPlanBh'=>$post['ExamPlanBh']])->count();
	    		}
	    		foreach ($info['IsPass'] as $key => $value) {
	    			$info['IsPass'][$key]['num'] = Exampaper::find()->where(['StudentID'=>$value['StudentID'],'ExamPlanBh'=>$post['ExamPlanBh']])->count();
	    		}

    		}
    	}

        echo json_encode($info);
	}

	public function actionGetExamDate()
	{
		if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();

    		if(isset($post['ExamPlanBh']) && isset($post['TeachClass']))
    		{

    			// $time = Exampaper::find()->select(['DATE_FORMAT(ExamEndTime,\'%Y-%m-%d\') as time'])->where(['ExamPlanBh'=>$post['ExamPlanBh'],'TeachingClassID'=>$post['TeachClass']])->orderBy("ExamEndTime ASC")->asArray()->one()['time'];
    			// ->andWhere("ExamBeginTime > :time",[':time'=>$time])
    			// $time = Examplan::find()->where(['ExamPlanBh'=>$post['ExamPlanBh']])->asArray()->one()['EndTime'];
    			$date = Exampaper::find()->select(['DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\') as time'])->where(['ExamPlanBh'=>$post['ExamPlanBh'],'TeachingClassID'=>$post['TeachClass'],'PaperName'=>'1'])->groupBy(["DATE_FORMAT(ExamBeginTime,'%Y-%m-%d')"])->asArray()->all();
    			echo json_encode($date);
    		}
    	}
    }

    //???????????????????????????
    public function actionGetCanStu()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post = \Yii::$app->request->post();
    		if(isset($post['ExamPlanBh']) && isset($post['TeachClass']))
    		{
    			$info['PassScore'] = Examplan::find()->where(['ExamPlanBh'=>$post['ExamPlanBh']])->asArray()->one()['PassScore'];
    			//?????????????????????????????????
    			$tmp['NotPass'] = Exampaper::find()
	    		->select("StuName,StudentID,Score")
	    		->where([
	    			'ExamPlanBh'=>$post['ExamPlanBh'],
	    			'TeachingClassID'=>$post['TeachClass'],
	    			// 'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time']
	    			])
	    		->andWhere("CAST(Score as SIGNED) < :score",
	    			[':score'=>(double)$info['PassScore']
	    			])
	    		->andWhere("DealState!='0'")
	    		->orderBy("CAST(Score as SIGNED) DESC")
	    		->groupBy("StudentID")
	    		->asArray()
	    		->all();
	    		//???????????????????????????
	    		foreach ($tmp['NotPass'] as $key => $value) {
	    			$isPass = Exampaper::find()
	    			->where([
	    				'StudentID'=>$value['StudentID'],
	    				'ExamPlanBh'=>$post['ExamPlanBh'],
	    				'TeachingClassID'=>$post['TeachClass']
	    				// 'PaperName'=>'1'
	    				// 'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time']
	    				])
	    			->andWhere("DealState!='0'")
	    			->orderBy("CAST(Score as SIGNED) DESC")
	    			->asArray()
	    			->one()['Score'];

    				$value['Score'] = (double)$isPass;
    				if((double)$info['PassScore'] > (double)$isPass)
	    				$info['NotPass'][] = $value;
	    			
	    		}
	    		//????????????
	    		$info['No'] = Teachingclassdetails::find()
	    		->select(Studentinfo::tableName().".StuNumber,".Studentinfo::tableName().".Name")
	    		->where("TeachingClassID = :tea 
	    			and ".Teachingclassdetails::tableName().".StuNumber"." NOT IN (SELECT StudentID FROM exampaper WHERE ExamPlanBh = :exam and DealState!='0')",
	    			[':tea'=>$post['TeachClass'],
	    			':exam'=>$post['ExamPlanBh']
	    			])
	    		->leftJoin(Studentinfo::tableName(),Studentinfo::tableName().".StuNumber=".Teachingclassdetails::tableName().".StuNumber")
	    		->asArray()
	    		->all();

	    		echo json_encode($info);
    		}
    	}
    }

    public function actionGetResitStu()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$info = [];
    		$post=\Yii::$app->request->post();
    		if(isset($post['ExamPlanBh']) && isset($post['TeachClass']) && isset($post['Time']))
    		{
		    	$tmp['NotPass'] = Exampaper::find()
				->select("StuName,StudentID,Score")
				->where([
					'ExamPlanBh'=>$post['ExamPlanBh'],
					'TeachingClassID'=>$post['TeachClass'],
					'DATE_FORMAT(ExamBeginTime,\'%Y-%m-%d\')'=>$post['Time'],
					'PaperName'=>'1'
					])
				->orderBy("StudentID")
				->asArray()
				->all();
				echo json_encode($tmp);
			}
		}
    }

    public function actionSaveResit()
    {
    	if(\Yii::$app->request->isPost)
    	{
    		$post=\Yii::$app->request->post();
    		if(isset($post['ExamPlanBh']) && isset($post['StarTime']) && isset($post['stu']) && isset($post['TeachingClass']))
    		{
    			$com = new commonFuc();
    			$aim = Examplan::find()->where(['ExamPlanBh'=>$post['ExamPlanBh']])->one();
    			if(strtotime($post['StarTime']) > time())
    			{
    				$aim['StarTime'] = $post['StarTime'];
    				$aim['EndTime'] =date("Y-m-d H:i:s",(strtotime($post['StarTime'])+($aim->ExamTime)*60));

    				// var_dump($post['stu']);
    				if($aim->save())
    				{

    					$str = '';
    					foreach ($post['stu'] as $key => $value) {
    						$exam = Exampaper::find()->select("DealState")->where(['ExamPlanBh'=>$post['ExamPlanBh'],'StudentID'=>$value])->asArray()->all();
    						//??????????????????????????????
    						$i = 0;
    						foreach ($exam as $key1 => $value1) {
    							if($value1['DealState'] != '2')
    							{
    								$i = 1;
    								break;
    							}	
    						}
    						//????????????
    						if($i == 0)
    						{
    							$new = new Exampaper();
    							$new['PaperID'] = $com->create_id();
    							$new['StuName'] = Studentinfo::find()->where(['StuNumber'=>$value])->asArray()->one()['Name'];
    							$new['StudentID'] = $value;
    							$new['Score'] = '0';
    							$new['ExamBeginTime'] = $post['StarTime'];
    							$new['DealState'] = '0';
    							$new['Memo'] = '1';
    							$new['ExamPlanBh'] = $post['ExamPlanBh'];
    							$new['SubmitStage'] = '0';
    							//?????????1??????
    							$new['PaperName'] = '1';
    							$new['TeachingClassID'] = $post['TeachingClass'];
    							$new['PaperBh'] = Paper::find()->where(['ExamPlanBh' => $post['ExamPlanBh'] ])
								                ->orderBy('rand()')
								                ->asArray()
								                ->one()['PaperBh'];
								if($new->save())
									$str .= $value."????????????\n";
								else
									$str .= $value."????????????\n";
    						}
    						else
    							$str .= $value."??????????????????????????????????????????\n";
    					}

    					echo $str;
    				}
    			}
    			else
    				echo "???????????????";
    		}
    	}

    }
}