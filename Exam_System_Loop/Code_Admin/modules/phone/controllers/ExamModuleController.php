<?php
namespace app\modules\phone\controllers;

use app\controllers\BaseController;
use app\models\phone\Tresourceexaminfo;
use app\models\phone\Tresourceexaminfoset;
use app\models\phone\Tresources;
use app\models\question\Knowledgepoint;
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

        $w = [];
        $where = [];
        $m_sou = new Tresources();
        $m_ExamConfig = new Tresourceexaminfo();


        $Info = Yii::$app->request->get();
        $where['CourseID'] = Yii::$app->session->get('courseCode');


        if (isset($Info['Type'])) {
            $where['Type'] = $Info['Type'];
            $list = $m_sou->find()->select(['ID'])->where($where)->asArray()->all();

            foreach ($list as $value) {
                $w[] = $value['ID'];
            }

            $info = $m_ExamConfig->find()
                ->where(['in', 'ResourcesID', $w])->groupBy('BH')->orderBy('AddAt DESC')->all();
        }
        else{
            $info = $m_ExamConfig->find()
                ->where($where)->groupBy('BH')->orderBy('AddAt DESC')->all();
        }

        return $this->render('index',[
            'info' => $info,
        ]);
    }


    /**
     * 返回模板详细信息
     * @return json
     */
    public function actionView(){
        $m_sou = new Tresources();
        $m_exam_config = new Tresourceexaminfo();
        $m_paper_config = new Tresourceexaminfoset();
        $com = new commonFuc();


        $id = Yii::$app->request->get('id');
        if(isset($id)){
            $info['tmp'] = $m_exam_config->find()->where([
                'BH' => $id
            ])->asArray()->one();
            $info['tmp']['CourseID'] = $com->codeTranName($info['tmp']['CourseID']);
            $info['tmp']['ResourcesID'] = $m_sou->Resources($info['tmp']['ResourcesID']);
            $info['data'] = $m_paper_config->find()->where([
                'BH' => $id,
            ])->orderBy('QuestionType desc')->addOrderBy('difficulty desc')->asArray()->all();
            $info['totalScore'] = 0;
            $info['totalNumber'] = 0;
            foreach ($info['data'] as $key=>$value){
                $info['data'][$key]['QuestionType'] = $com->codeTranName($info['data'][$key]['QuestionType']);
                $info['data'][$key]['difficulty'] = $com->codeTranName($info['data'][$key]['difficulty']);
                $info['data'][$key]['EveryQuestionScore'] = $value['EveryQuestionScore'];
                $tmp = explode('|',$info['data'][$key]['KnowledgeBh']);
                $tmp_name = [];
                foreach ($tmp as $item){
                    $t = Knowledgepoint::find()->select('KnowledgeName')->where(['KnowledgeBh'=>$item])->asArray()->one();
                    $tmp_name[]=$t['KnowledgeName'];
                }
                $info['data'][$key]['KnowledgeName'] = implode('|',$tmp_name);
                $info['totalScore'] = $info['totalScore']+($value['EveryQuestionScore']*$value['QuestionTypeNumber']);
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
        $m_course = Yii::$app->session->get('courseCode');
        $stage = $m_Dic->getDictionaryList('题目阶段');
        $m= Knowledgepoint::find()->select(['KnowledgeName','CourseID','KnowledgeBh','Stage'])->where(['CourseID'=>$m_course])->asArray()->all();
        $id = Yii::$app->request->get('id');

        return $this->render('add',[
            'type' => $m_Dic->find()->select([
                'CuitMoon_DictionaryName',
                'CuitMoon_DictionaryCode'
            ])->where(['CuitMoon_DictionaryCode'=>['1000203','100020101','1000204']])->all(),
            'stage' => $stage,
            'diff' => $m_Dic->getDictionaryList('题目难度'),
            'id' => $id
        ]);
    }
  //获取阶段对应知识点
    public function actionGetKonwledge(){
        $m_know = new Knowledgepoint();
        $stage = Yii::$app->request->get('Stage');
        $data = $m_know->find()
            ->select([
                'KnowledgeName','KnowledgeBh','CourseID'
            ])->where(['Stage' => $stage,'CourseID'=>Yii::$app->session->get('courseCode')])->asArray()->all();
        echo json_encode($data);
    }

    /**
     * Asynchronous get the number of questions
     * @return json
     */
    public function actionGetQuestionSum(){
        $m_dic = new TbcuitmoonDictionary();
        $m_knowledge = new Knowledgepoint();
        $m_question = new Questions();

        $info = Yii::$app->request->post();
        //获取难度信息
        $Tmp = $m_dic->find()->select(['CuitMoon_DictionaryName'])->where([
            'CuitMoon_DictionaryCode' => $info['Diff']['0'],
        ])->asArray()->all();
        $data['diff'] = $Tmp[0]['CuitMoon_DictionaryName'];

        $data['sum'] = [];
        if(!isset($info['Knowledge']['0'])){
            echo 0;
        }else {
            //获取题目数量
            $data['sum'] = $m_question->find()->select(['QuestionBh'])->where([
                'Difficulty' => $info['Diff']['0'],
                'KnowledgeBh'=> $info['Knowledge']['0'],
                'CourseID' => Yii::$app->session->get('courseCode'),
                'QuestionType' => $info['QuestionType'],
                'Checked' => 100001,
            ])->count();
            //获取题目阶段
            $data['Knowledge'] = $m_knowledge->find()->select(['KnowledgeName'])->where([
                'KnowledgeBh' => $info['Knowledge']['0'],
            ])->asArray()->one();

            echo json_encode($data);
        }
    }


    /**
     * Add exam module(use transaction)
     * @return json
     */
    public function actionCreate(){
        $m_exam_config = new Tresourceexaminfo();
        $com = new commonFuc();

        $info = Yii::$app->request->post();
        $RecordID = $com->create_id();
        if($m_exam_config->load($info)){
            $m_exam_config->BH = $RecordID;
            $m_exam_config->AddAt = date('Y-m-d H:i:s');
            $m_exam_config->CourseID = Yii::$app->session->get('courseCode');
            $m_exam_config->AddBy = Yii::$app->session->get('UserName');
            $m_exam_config->ResourcesID = $RecordID;

            $sql = 'insert into tresourceexaminfoset (XH,QuestionType,QuestionTypeNumber,EveryQuestionScore,KnowledgeBh,difficulty,BH) values';
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
        $m_exam_config = new Tresourceexaminfo();
        $m_paper_config = new Tresourceexaminfoset();

        $ids = Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                $Transaction = Yii::$app->db->beginTransaction();
                try {
                    $m_paper_config->deleteAll([
                        'BH' => $item
                    ]);
                    $m_exam_config->deleteAll(['BH' => $item]);
                    $Transaction->commit();
                    $com->JsonSuccess('删除成功');
                } catch (Exception $e) {
                    $Transaction->rollBack();
                    $com->JsonFail('删除失败');
                }
            }
        }
    }

    /**
     * 修改模板名称
     * @return json
     */
    public function actionUpdate(){
        $m_exam_config = new Tresourceexaminfo();
        $com = new commonFuc();

        $info = Yii::$app->request->post();

        $update  = $m_exam_config->findOne($info['editName_ExamConfigRecordID']);
        $update->PaperName = $info['newModleName'];

        if ($update->validate() && $update->save()) {
            echo json_encode('修改成功');
        }else{
            echo json_encode('修改失败');
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