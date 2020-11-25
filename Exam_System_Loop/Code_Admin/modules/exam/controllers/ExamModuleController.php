<?php
namespace app\modules\exam\controllers;

use app\controllers\BaseController;
use app\models\aid\Question;
use app\models\exam\Examconfigrecord;
use app\models\exam\Paperconfigure;
use app\models\question\Questions;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;
use yii\base\Exception;

class ExamModuleController extends BaseController{


    public $enableCsrfValidation=false;


    /**
     * 渲染考试模块配置页面
     * @return string
     */
    public function actionIndex(){
        $m_ExamConfig = new Examconfigrecord();
        $info = $m_ExamConfig->getExamConfigRecord();
        return $this->render('index',[
            'info' => $info,
        ]);
    }


    /**
     * 返回模板详细信息
     * @return json
     */
    public function actionView(){
        $m_exam_config = new Examconfigrecord();
        $m_paper_config = new Paperconfigure();
        $com = new commonFuc();

        $id = Yii::$app->request->get('id');
        if(isset($id)){
            $info['tmp'] = $m_exam_config->find()->where([
                'ExamConfigRecordID' => $id
            ])->asArray()->one();
            $info['tmp']['CourseID'] = $com->codeTranName($info['tmp']['CourseID']);
            $info['data'] = $m_paper_config->find()->where([
                'ExamConfigRecordID' => $id,
                'ExamPlanBh' => ''
            ])->orderBy('QuestionType desc')->addOrderBy('difficulty desc')->asArray()->all();
            $info['totalScore'] = 0;
            $info['totalNumber'] = 0;
            foreach ($info['data'] as $key=>$value){
                $info['data'][$key]['QuestionType'] = $com->codeTranName($info['data'][$key]['QuestionType']);
                $info['data'][$key]['difficulty'] = $com->codeTranName($info['data'][$key]['difficulty']);
                $info['data'][$key]['EveryQuestionSocre'] = $value['EveryQuestionSocre'];
                $tmp = explode('|',$info['data'][$key]['stage']);
                $tmp_name = [];
                foreach ($tmp as $item){
                    $tmp_name[] = $com->codeTranName($item);
                }
                $info['data'][$key]['stage'] = implode('|',$tmp_name);
                $info['totalScore'] = $info['totalScore']+($value['EveryQuestionSocre']*$value['QuestionTypeNumber']);
                $info['totalNumber'] += $value['QuestionTypeNumber'];
            }
            echo json_encode($info);
        }
    }

    /**
     * 渲染添加考试模块页面并传值
     * @return string
     */
    public function actionAddView(){
        $m_Dic = new TbcuitmoonDictionary();

        return $this->render('add',[
            'type' => $m_Dic->getDictionaryList('题目类型'),
            'stage' => $m_Dic->getDictionaryList('题目阶段'),
            'diff' => $m_Dic->getDictionaryList('题目难度')
        ]);
    }

    /**
     * 渲染更新考试模块页面并传值
     * @return string
     */
    public function actionUpdateView(){
        $m_Dic = new TbcuitmoonDictionary();

        $id = Yii::$app->request->get('id');

        $config['info'] = Examconfigrecord::find()->where(['ExamConfigRecordID' => $id])->asArray()->one();
        $config['papers'] = Paperconfigure::find()->where(['ExamConfigRecordID' => $id])->asArray()->all();
        //获取题目类型
        $type = [];
        foreach ($config['papers'] as $key){
            $type[] = $key['QuestionType'];
        }
        $type = array_unique($type);
        $type = array_merge($type);
        $config['type'] = $m_Dic->getDictionaryListByType($type);
        //根据题目类型分组 再根据难度
        $res = [];
        foreach($config['papers'] as $k=>$v){
            $res[$v['QuestionType']][] = $v;
        }
        $i=0;
        foreach ($res as $key=>$val){
            foreach ($val as $k=>$v){
                $res[$key][$v['difficulty']][$i] = $v;
                $res[$key][$v['difficulty']][$i]['diff_name'] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode' => $res[$key][$v['difficulty']][$i]['difficulty']])->one()->CuitMoon_DictionaryName;
                $res[$key][$v['difficulty']][$i]['stage_name'] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode' => $res[$key][$v['difficulty']][$i]['stage']])->one()->CuitMoon_DictionaryName;
                $res[$key][$v['difficulty']][$i]['ques_num'] = Questions::find()->select(['QuestionBh'])->where([
                    'Stage' => $res[$key][$v['difficulty']][$i]['stage'],
                    'Difficulty' => $res[$key][$v['difficulty']][$i]['difficulty'],
                    'QuestionType' => $res[$key][$v['difficulty']][$i]['QuestionType'],
                    'CourseID' => Yii::$app->session->get('courseCode'),
                    'Checked' => 100001
                ])->count();
                unset($res[$key][$k]);
                $i++;
            }
        }
        $config['papers'] = $res;

        return $this->render('edit',[
            'id' => $id,
            'config' => $config,
            'type' => $m_Dic->getDictionaryList('题目类型'),
            'stage' => $m_Dic->getDictionaryList('题目阶段'),
            'diff' => $m_Dic->getDictionaryList('题目难度')
        ]);
    }

    /**
     * Asynchronous get the number of questions
     * @return json
     */
    public function actionGetQuestionSum(){
        $m_dic = new TbcuitmoonDictionary();
        $m_question = new Questions();

        $info = Yii::$app->request->post();
        //获取难度信息
        $Tmp = $m_dic->find()->select(['CuitMoon_DictionaryName'])->where([
            'CuitMoon_DictionaryCode' => $info['Diff']['0'],
        ])->asArray()->all();
        $data['diff'] = $Tmp[0]['CuitMoon_DictionaryName'];

        $data['sum'] = [];
        if(!isset($info['Stage']['0'])){
            echo 0;
        }else {
            //获取题目数量
            $data['sum'] = $m_question->find()->select(['QuestionBh'])->where([
                'Stage' => $info['Stage']['0'],
                'Difficulty' => $info['Diff']['0'],
                'CourseID' => Yii::$app->session->get('courseCode'),
                'QuestionType' => $info['QuestionType'],
                'Checked' => 100001,
            ])->count();
            //获取题目阶段
            $data['stage'] = $m_dic->find()->select(['CuitMoon_DictionaryName'])->where([
                'CuitMoon_DictionaryCode' => $info['Stage']['0'],
            ])->asArray()->one()['CuitMoon_DictionaryName'];

            echo json_encode($data);
        }
    }

    /**
     * 修改模板
     * @return json
     */
    public function actionUpdate(){
        $m_exam_config = new Examconfigrecord();
        $com = new commonFuc();

        $info = Yii::$app->request->post();

        $exam_config = $m_exam_config->findOne($info['configId']);
        //删除原有的配置项
        Paperconfigure::deleteAll(['ExamConfigRecordID' => $info['configId']]);
        if($exam_config->load($info)){
            foreach ($info['Num'] as $key=>$value){
                foreach ($value as $ke=>$va){
                    foreach ($va as $k=>$v){
                        if ($v == 0)
                            break;
                        $paper_config = new Paperconfigure();
                        $paper_config->PaperConfigureID = $com->create_id();
                        $paper_config->QuestionType = (string)$key;
                        $paper_config->difficulty = (string)$ke;
                        $paper_config->stage = (string)$k;
                        $paper_config->EveryQuestionSocre = $info['Score'][$key][$ke][$k];
                        $paper_config->QuestionTypeNumber = $v;
                        $paper_config->ExamConfigRecordID = $info['configId'];
                        if(!$paper_config->save()){
                            $t = false;break;
                        }else{
                            $t = true;
                        }
                    }
                }
            }
            $exam_config->ConfigTime = date('Y-m-d H:i:s');
        }

        if ($exam_config->validate() && $exam_config->save() && $t) {
            echo json_encode(['error' => 0, 'info' => '修改成功']);
        }else{
            echo json_encode(['error' => -1, 'info' => '修改失败']);
        }
    }

    /**
     * Add exam module(use transaction)
     * @return json
     */
    public function actionCreate(){
        $m_exam_config = new Examconfigrecord();
        $com = new commonFuc();

        $info = Yii::$app->request->post();

        $RecordID = $com->create_id();
        if($m_exam_config->load($info)){
            $m_exam_config->ExamConfigRecordID = $RecordID;
            $m_exam_config->ConfigTime = date('Y-m-d H:i:s');
            $m_exam_config->CourseID = Yii::$app->session->get('courseCode');
            $m_exam_config->ConfigTeacherName = Yii::$app->session->get('UserName');
            $m_exam_config->Academy = Yii::$app->session->get('UserName');
            $sql = 'insert into paperconfigure (PaperConfigureID,QuestionType,QuestionTypeNumber,EveryQuestionSocre,stage,difficulty,ExamConfigRecordID) values';
            //Splicing sql
            //题目类型
            foreach ($info['Num'] as $key=>$value){
                //题目难度
                foreach ($info['Num'][$key] as $ke=>$val){
                    //题目阶段
                    foreach($info['Num'][$key][$ke] as $k=>$v){
                        if($val != null && $info['Score'][$key][$ke][$k] != null && $v != 0) {
                            $Tmp = $com->create_id();
                            $score = $info['Score'][$key][$ke][$k];
                            $stage = $k;
                            $sql .= "('$Tmp','$key','$v','$score','$stage','$ke','$RecordID'),";
                        }
                    }
                }
            }
            $sql = substr($sql,0,strlen($sql)-1);
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $m_exam_config->save();
                $connection = Yii::$app->db;
                $insert = $connection->createCommand($sql);
                $insert->execute();
                $transaction->commit();
                $com->JsonSuccess('添加成功');
            }catch (Exception $e){
                $transaction->rollBack();
                $com->JsonFail($m_exam_config->getErrors());
            }
        }else{
            echo $com->JsonFail('数据错误');
        }
    }

    /**
     * 删除模板
     * @return json
     */
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_exam_config = new Examconfigrecord();
        $m_paper_config = new Paperconfigure();

        $ids = Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                $Transaction = Yii::$app->db->beginTransaction();
                try {
                    $m_paper_config->deleteAll([
                        'ExamConfigRecordId' => $item,
                        'ExamPlanBh' => ''
                    ]);
                    $m_exam_config->deleteAll(['ExamConfigRecordId' => $item]);
                    $Transaction->commit();
                    $com->JsonSuccess('删除成功');
                } catch (Exception $e) {
                    $Transaction->rollBack();
                    $com->JsonFail('删除失败');
                }
            }
        }
    }


    public function actionFool(){
        $m_dic = new TbcuitmoonDictionary();

        $Tmp = $m_dic->find()->select(['CuitMoon_DictionaryName'])->where([
            'CuitMoon_DictionaryCode' => Yii::$app->request->get('code'),
        ])->asArray()->all();
        echo json_encode($Tmp[0]['CuitMoon_DictionaryName']);
    }
}