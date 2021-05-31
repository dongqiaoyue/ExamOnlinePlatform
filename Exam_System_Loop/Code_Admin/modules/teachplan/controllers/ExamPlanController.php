<?php
namespace app\modules\teachplan\controllers;

use app\controllers\BaseController;
use app\models\exam\Createpaper;
use app\models\exam\Examconfigrecord;
use app\models\exam\Exampaper;
use app\models\exam\Examprocess;
use app\models\exam\Paper;
use app\models\exam\Paperconfigure;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Examplan;
use app\models\teachplan\ExamPlanDetails;
use app\models\teachplan\Teachingclassdetails;
use app\models\teachplan\Teachingclassmannage;
use app\models\TbcuitmoonUser;
use common\commonFuc;
use app\models\systembase\Studentinfo;
use Yii;
use yii\base\Exception;

class ExamPlanController extends BaseController{


    public $enableCsrfValidation=false;

    /**
     * 渲染考试计划首页
     * @return string
     * 期末考试保存的格式和平时考试不一样，期末考试分很多场，每子考试计划有个父id，CreateUser保存的是
     * 父id
     * 比如某场期末考试有两场考试，那么保存的是一个父考试计划，三个子考试计划，三个字考试计划CreateUser是
     * 父考试计划的id，父考试计划是不作为考试用的
     * 今天（2017-04-15）因为这个原因，想把不作为考试计划用的父考试计划给隐藏，用CreateUser进行筛选，
     * 特么的怎么都不对，
     */
    public function actionIndex(){
        $m_exam_plan = new Examplan();
        $com = new commonFuc();
        $m_dic = new TbcuitmoonDictionary();


        $Term = Yii::$app->request->get();
        $UserID = Yii::$app->user->getId();
        $courseCode = Yii::$app->session->get('courseCode');
        $Where = ['and',"CourseID=$courseCode"];
        if (isset($Term['term'])) {
            if ($Term['term'] != '0') {
                $Tmp = $Term['term'];
                $Where[] = "Term='$Tmp'";
            }
            $TermChoice = $Term['term'];
        } else {
            $TermChoice = 0;
        }
        if (isset($Term['type'])) {
            if ($Term['type'] != 'all') {
                // if ($Term['type'] == '2') {
                //     $Where[] = "CreateUser='$UserID'";
                // }
                // if ($Term['type'] == '1') {
                //     $Where[] = "TeachingClassID IS NOT NULL";
                // }
                $Tmp = $Term['type'];
                $Where[] = "Type='$Tmp'";
            }
            $TypeChoice = $Term['type'];
        } else {
          $TypeChoice = 'all';
        }

        // $Where['CreateUser'] = Yii::$app->user->getId();
        // $my = \Yii::$app->user->getId();
        $my = TbcuitmoonUser::find()->where(['CuitMoon_UserName'=>Yii::$app->session->get('UserName')])->asArray()->one()['CuitMoon_UserID'];
        $allExam = Examplan::find()->select("ExamPlanBh")->where(['type'=>1])->asArray()->all();
        foreach ($allExam as $key => $value) {
            $allExam[$key] = $value['ExamPlanBh'];
        }
        $allExam[] = $my;
        $Info = $m_exam_plan->find()->orderBy("StarTime DESC")->where($Where)->andWhere(['in','CreateUser',$allExam])->andWhere(['Memo'=>'']);
        $CountInfo = clone $Info;
        //$pages = $com->Tab($CountInfo);
        $CourseName = $com->codeTranName(Yii::$app->session->get('courseCode'));

        if($CourseName !==NULL){
            $pages = $com->Tab($CountInfo);
        }else{
            return $this->render('error');
        }
        // print_r($Where);
        // print_r($allExam);
        return $this->render('index',[
            'list' => $Info->limit($pages->limit)->offset($pages->offset)->all(),
            'CourseName' => $CourseName,
            'pages' => $pages,
            'Terms' => $m_dic->getDictionaryList('学期'),
            'TermChoice' => $TermChoice,
            'TypeChoice' => $TypeChoice,
            'now_term' => $com->getNowTerm(),
        ]);
    }


    /**
     * 渲染考试计划添加页面
     * @return string
     */
    public function actionAdd(){
        $m_dic = new TbcuitmoonDictionary();
        return $this->render('add',[
            'college' => $m_dic->getDictionaryList('学院'),
            'term' => $m_dic->getDictionaryList('学期'),
            'project' => Yii::$app->session->get('courseCode'),
        ]);
    }


    /**
     * 添加考试计划
     * @return json
     */
    public function actionCreate(){
        $m_examPlan = new Examplan();
        $com = new commonFuc();

        $Info = Yii::$app->request->post();

        if (isset($Info['teachingClass'])) {
            switch ($Info['Examplan']['Type']) {
                //期末考试考试计划添加
                case '1' :
                    $Where = ['or'];
                    foreach ($Info['teachingClass'] as $item) {
                        $Where[] = "TeachingClassID='$item'";
                    }
                    $PPlan = clone $m_examPlan;
                    $PPlan->Type = $Info['Examplan']['Type'];
                    $PPlan->ExamPlanBh = $com->create_id();
                    $PPlan->ExamPlanName = $Info['Examplan']['ExamPlanName'];
                    $PPlan->ExamTime = $Info['Examplan']['ExamTime'];
                    $PPlan->Term = $Info['Examplan']['Term'];
                    $PPlan->Weights = (string)$Info['Examplan']['Weights'];
                    $PPlan->NumOfExam = $Info['ExamNum'];
                    $PPlan->CourseID = (string)Yii::$app->session->get('courseCode');
                    $PPlan->Memo = implode('|',$Info['teachingClass']);
                    $PPlan->IsFixedPlace = '0';
                    $PPlan->PassScore =  $Info['Examplan']['PassScore'];
                    $PPlan->CreateUser = Yii::$app->user->getId();
                    $PPlan->StarTime = $Info['StartTime'][0];
                    $PPlan->Department = $Info['Examplan']['Department'];
                    $PPlan->EndTime = $Info['EndTime'][0];
                    if (!$PPlan->save()) {
                        print_r($PPlan->getErrors());
                    } else {
                        //print_r($Info);
                        foreach ($Info['StartTime'] as $key => $item) {
                            $Tmp = $key + 1;
                            $ClassID = $com->create_id();
                            $m_examPlan = new Examplan();
                            $m_teach_class = new Teachingclassmannage();

                            $m_teach_class->TeachingClassID = $ClassID;
                            $m_teach_class->TeacherName = '期末考试';
                            $m_teach_class->TeachingName = $PPlan->ExamPlanName . '-' . $Tmp;
                            $m_teach_class->Term = $Info['Examplan']['Term'];
                            $m_teach_class->CourseID = (string)Yii::$app->session->get('courseCode');
                            $m_teach_class->Memo = '期末考试班';
                            $m_teach_class->Type = '0';
                            $m_teach_class->Department = $Info['Examplan']['Department'];

                            $m_examPlan->TeachingClassID = $ClassID;
                            $m_examPlan->ExamPlanBh = $com->create_id();
                            $m_examPlan->ExamPlanName = $PPlan->ExamPlanName . '-' . $Tmp;
                            $m_examPlan->ExamTime = $Info['Examplan']['ExamTime'];
                            $m_examPlan->Weights = $Info['Examplan']['Weights'];
                            $m_examPlan->StarTime = $item;
                            $m_examPlan->NumOfExam = $Info['ExamNum'];
                            $m_examPlan->EndTime = $Info['EndTime'][$key];

                            $m_examPlan->CourseID = Yii::$app->session->get('courseCode');
                            $m_examPlan->Term = $Info['Examplan']['Term'];
                            $m_examPlan->Type = '1';
                            $m_examPlan->Department=$Info['Examplan']['Department'];
                            $m_examPlan->IsFixedPlace = '0';
                            $m_examPlan->PassScore = $Info['Examplan']['PassScore'];
                            $m_examPlan->CreateUser = $PPlan->ExamPlanBh;
                            $m_examPlan->IsProcessExam = $Info['Examplan']['IsFixedPlace'];
                            $StartNum = $key * $Info['ExamStuNum'];
                            //查找学生
                            $m_class_detail = new Teachingclassdetails();
                            $Tmp_Student = $m_class_detail->find()
                                ->where($Where)->orderBy('StuNumber')
                                ->limit($Info['ExamStuNum'])
                                ->offset($StartNum)
                                ->asArray()->all();

                            $tran = Yii::$app->db->beginTransaction();
                            try {
                                $m_teach_class->save();
                                $m_examPlan->save();
                                $tran->commit();

                                //添加学生到班级详情表里
                                foreach ($Tmp_Student as $va) {
                                    $m_class_detail = new Teachingclassdetails();
                                    $m_class_detail->TeachingClassID = $ClassID;
                                    $m_class_detail->StuNumber = $va['StuNumber'];
                                    $m_class_detail->TeachingClassDetailsID = $com->create_id();
                                    $m_class_detail->save();
                                }
                            } catch (Exception $e) {
                                $tran->rollBack();
                            }
                        }
                        $com->JsonSuccess('添加成功');
                    }
                    break;
                //过程化考核考试计划添加
                case '2':

                        $m_examPlan->TeachingClassID = implode('|', $Info['teachingClass']);
                        $m_examPlan->Type = $Info['Examplan']['Type'];
                        $m_examPlan->Weights = $Info['Examplan']['Weights'];
                        $m_examPlan->ExamTime = $Info['Examplan']['ExamTime'];
                        $m_examPlan->Term = $Info['Examplan']['Term'];
                        $m_examPlan->CreateUser = Yii::$app->user->getId();
                        $m_examPlan->StarTime = $Info['StartTime'];
                        $m_examPlan->EndTime = $Info['EndTime'];
                        $m_examPlan->NumOfExam = $Info['ExamNum'];
                        $m_examPlan->CourseID = Yii::$app->session->get('courseCode');
                        $m_examPlan->ExamPlanName = $Info['Examplan']['ExamPlanName'];
                        $m_examPlan->CreateUser = Yii::$app->user->getId();
                        $m_examPlan->ExamPlanBh = $com->create_id();
                        $m_examPlan->IsFixedPlace = '0';
                        $m_examPlan->PassScore = $Info['Examplan']['PassScore'];
                        $m_examPlan->IsProcessExam = $Info['Examplan']['IsFixedPlace'];
                        if ($m_examPlan->validate() && $m_examPlan->save()) {
                            $com->JsonSuccess('添加成功');
                        } else {
                            $com->JsonFail($m_examPlan->getErrors());
                        }
                    break;
                case '3':
                    break;
                default:
                    break;
            }
        }
    }

    public function actionPublish()
    {
        $com = new commonFuc();
        $m_exam_plan = new Examplan();

        $ID = Yii::$app->request->get('id');
        $Tmp = $m_exam_plan->findOne([
            'ExamPlanBh' => $ID
        ]);
        $Tmp->IsFixedPlace = (string)(((int)$Tmp->IsFixedPlace+1)%2);
        if ($Tmp->save()) {
            $com->JsonSuccess('成功');
        } else {
            $com->JsonFail('失败');
        }
    }

    public function actionView()
    {
        if(\Yii::$app->request->isGet)
        {
            $get = \Yii::$app->request->get();
            $exam = Examplan::find()->where(['ExamPlanBh'=>$get['id']])->asArray()->one();
            $teachingClass = explode("|",$exam['TeachingClassID']);
            foreach ($teachingClass as $key => $value)
            {
                $teaName = Teachingclassmannage::find()->select("TeachingName")->where(['TeachingClassID' => $value])->asArray()->one()['TeachingName'];
                $exam['class'][$teaName] = Teachingclassdetails::find()->select(Studentinfo::tableName().".StuNumber,Name")
                ->leftJoin(Studentinfo::tableName(),Studentinfo::tableName().".StuNumber=".Teachingclassdetails::tableName().".StuNumber")
                ->where(['TeachingClassID'=>$value])->asArray()->all();
            }

            echo json_encode($exam);
        }
    }

    /**
     * 设置计划所使用的模块
     */
    public function actionSetModule(){
        $m_paper = new Paperconfigure();
        $com = new commonFuc();

        $info = Yii::$app->request->post();
        $Tmp = $m_paper->isExamModule($info['ExamPlanBh']);
        // if($Tmp){
        //     $Tmp = $info['ExamPlanBh'];
        //     $m_paper->deleteAll("ExamPlanBh='$Tmp'");
        // }
        Paperconfigure::deleteAll(['ExamPlanBh'=>$info['ExamPlanBh']]);
        //查询添加
        $data = $m_paper->find()->where([
            'ExamConfigRecordID' => $info['ExamConfigRecordID'],
            'ExamPlanBh' => "",
        ])->asArray()->all();
        foreach ($data as $value){
            $m_paper = new Paperconfigure();
            $m_paper->ExamPlanBh = $info['ExamPlanBh'];
            $m_paper->QuestionType = $value['QuestionType'];
            $m_paper->QuestionTypeNumber = $value['QuestionTypeNumber'];
            $m_paper->EveryQuestionSocre = $value['EveryQuestionSocre'];
            $m_paper->difficulty = $value['difficulty'];
            $m_paper->stage = $value['stage'];
            $m_paper->PaperConfigureID = $com->create_id();
            $m_paper->ExamConfigRecordID = $info['ExamConfigRecordID'];
            $m_paper->save();
        }
        echo $com->JsonSuccess('修改成功');
    }

    /**
     * ajax请求教学班级
     * @return json
     */
    public function actionGetClass(){
        $info = Yii::$app->request->post();
        $m_techClass = new Teachingclassmannage();

        $Tmp = $m_techClass->find()
            ->select(['TeachingClassID','TeachingName'])
            ->where([
            'Type'=>'1',
            'Department'=>$info['Department'],
            'CourseID' =>$info['CourseID'],
            'Term' => $info['Term'],
            ])->asArray()->all();
        echo json_encode($Tmp);
    }

    public function actionAddStudent(){

        $com = new commonFuc();
        $student0 = new Teachingclassdetails();
        $student1 = new Teachingclassdetails();
        $data = Yii::$app->request->post();
        $ExamPlanBh = $data['Examplan'];
        $techclassid=Examplan::find()->select(['TeachingClassID'])->where(['ExamPlanBh'=>$ExamPlanBh])->one()['TeachingClassID'];
        //在基础班中添加学生
        $student0->TeachingClassDetailsID=$com->create_id();
        $student0->TeachingClassID=$data['Teachingclass'];
        $student0->StuNumber=$data['studentcode'];

        //在期末班中添加学生
        $student1->TeachingClassDetailsID=$com->create_id();
        $student1->TeachingClassID=$techclassid;
        $student1->StuNumber=$data['studentcode'];
        if ($student0->save() && $student1->save()) {
            echo $techclassid;
        } else {
            $com->JsonFail('失败');
        }

    }

    public function actionGetClassOne() {
        $info = Yii::$app->request->post();
        $m_techClass = new Teachingclassmannage();
        $Tmp = $m_techClass->find()
            ->select(['TeachingClassID','TeachingName'])
            ->where([
            'Type' => '1',
            'TeacherName' => Yii::$app->session->get('UserName'),
            'Department'=>$info['Department'],
            'CourseID' =>$info['CourseID'],
            'Term' => $info['Term'],
            ])->asArray()->all();
        echo json_encode($Tmp);
    }


    /**
     * ajax请求试卷模块
     * @return json
     */
    public function actionGetModule(){
        $m_paper = new Paperconfigure();
        $m_examModule = new Examconfigrecord();

        $exam_module = $m_examModule->find()->select(['ExamConfigRecordID','ExamPaperName','ConfigTeacherName'])
            ->orderBy("ExamPaperName DESC")
            ->where([
                'CourseID' => Yii::$app->session->get('courseCode')
            ])->asArray()->all();
        $id = Yii::$app->request->get('id');
        $Tmp = $m_paper->isExamModule($id);
        if($Tmp){
            $info['ExamConfigRecordID'] = $Tmp['ExamConfigRecordID'];
        }
        $info['data'] = $exam_module;
        echo json_encode($info);
    }


    /**
     * 删除考试计划
     * 会删除考试计划所有内容
     * 包括已生成的试卷和 学生考卷
     */
    public function actionDelete()
    {
        $m_exam_plan = new Examplan();
        $m_exam_paper = new Exampaper();
        $m_paper = new Paper();
        $m_exam_process = new Examprocess();
        $m_crete_paper = new Createpaper();
        $m_paper_config = new Paperconfigure();
        $m_class_detail = new Teachingclassdetails();
        $m_class_manage = new Teachingclassmannage();

        $ids = Yii::$app->request->get('ids');
        foreach ($ids as $item) {
            if ($item == 'on') {
                break;
            } else {
                if($Delete = $m_exam_plan->findOne([
                    'ExamPlanBh' => $item])){
                    //检测是期末考试还是其他考试计划
                    if ($Delete->Type == '1') {
                        $ParentExamPlanBh = $m_exam_plan->findOne([
                            'ExamPlanBh' => $item
                        ]);
                        //是否仅剩唯一一个子计划
                        if ($m_exam_plan->find()->where([
                            'CreateUser' => $ParentExamPlanBh->CreateUser
                        ])->count() == 1 ) {
                            //最后一个 把总的计划一起删
                            $m_exam_plan->deleteAll(['ExamPlanBh' => $ParentExamPlanBh->CreateUser]);
                        }
                        //删除期末考试班学生
                        $m_class_detail->deleteAll(['TeachingClassID' => $ParentExamPlanBh->TeachingClassID]);
                        //删除期末考试班
                        $m_class_manage->deleteAll(['TeachingClassID' => $ParentExamPlanBh->TeachingClassID]);
                    }
                    //各种删
                    $PPaper = clone $m_paper;
                    $PExamPaper = clone $m_exam_paper;
                    $PaperBh = $PPaper->find()->select(['PaperBh'])->where([
                        'ExamPlanBh' => $item
                    ])->asArray()->all();
                    $PaperID = $PExamPaper->find()->select(['PaperID'])->where([
                        'ExamPlanBh' => $item
                    ])->asArray()->all();
                    $Tran = Yii::$app->db->beginTransaction();
                    try{
                        //删除考试计划
                        $m_exam_plan->deleteAll([
                            'ExamPlanBh' => $item
                        ]);
                        //删除学生考试试卷
                        $m_exam_paper->deleteAll([
                            'ExamPlanBh' => $item
                        ]);
                        //删除生成的试卷
                        $m_paper->deleteAll([
                            'ExamPlanBh' => $item
                        ]);
                        //删除学生试卷答案
                        $m_exam_process->deleteAll(['in','PaperID',$PaperID]);
                        //删除试卷
                        $m_crete_paper->deleteAll(['in','PaperBh',$PaperBh]);
                        //删除计划配置的模块
                        $m_paper_config->deleteAll([
                            'ExamPlanBh' => $item
                        ]);
                        $Tran->commit();
                        $ids_success[] = $item;
                    }catch (Exception $e) {
                        $Tran->rollBack();
                    }
                }
            }
        }
        echo json_encode($ids_success);
    }

    public function actionGetStudentNum()
    {
        $m_class_detail = new Teachingclassdetails();

        $ids = Yii::$app->request->get();
        if (isset($ids['ids'])) {
            $Where = ['or'];
            foreach ($ids['ids'] as $k=>$item) {
                $Where[] = "TeachingClassID='$item'";
            }
            $Num = $m_class_detail->find()->where($Where)->count();
            echo json_encode($Num);
        } else {
            echo json_encode(0);
        }
    }

    public function actionGetTechclass(){
        $ExamPlanBh=Yii::$app->request->get();
        $techclassid=Examplan::find()->select(['CreateUser'])->where(['ExamPlanBh'=>$ExamPlanBh])->one()['CreateUser'];
        $techClassid=Examplan::find()->select(['Memo'])->where(['ExamPlanBh'=>$techclassid])->one()['Memo'];
        $a=explode('|',$techClassid);
        foreach($a as $id){
            $data[]=Teachingclassmannage::find()->select(['TeachingClassID','TeachingName'])->where([
                'TeachingClassID'=>$id,
                 'Type'=>'1',
                 ])->asArray()->one();
        }
        if(isset($data)){
            return json_encode($data);
        }else{
            echo "没有配置教学班级";
        }
    }

    public function actionUpdate()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $aim = Examplan::findOne(['ExamPlanBh'=>$post['Examplan']['ExamPlanBh']]);
            if($aim->load($post))
            {
                // $aim['EndTime'] = date('Y-m-d H:i:s', strtotime ("+".$post['Examplan']['ExamTime']." minute", strtotime($post['Examplan']['StarTime'])));
                if($aim->save())
                    echo "修改成功";
                else
                    print_r($aim->getErrors());
            }
            else
                print_r($aim->getErrors());

        }
    }

}
