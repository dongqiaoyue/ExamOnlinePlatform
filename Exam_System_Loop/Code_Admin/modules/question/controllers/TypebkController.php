<?php
namespace app\modules\question\controllers;

use app\modules\question\controllers\QuestionbaseController;
use app\models\question\Knowledgepoint;
use app\models\question\Questions;
use app\models\question\Apfill;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;
use yii\data\Pagination;

class TypebkController extends QuestionbaseController
{


    /**
     * 渲染首页
     * @return string
     */
    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $m_know = new Knowledgepoint();
        $m_ques = new Questions();
        $com = new commonFuc();

        $whereKnow = [];
        $where = [];
        //是否选择阶段
        $stage = Yii::$app->request->get();
        if (isset($stage['stage'])) {
            $where = [
                'Stage' => $stage['stage'],
            ];
            $whereKnow['Stage'] = $stage['stage'];

        }
        $where['CourseID'] = Yii::$app->session->get('courseCode');
        $whereKnow['CourseID'] = Yii::$app->session->get('courseCode');

        $where['QuestionType'] = ['1000204'];
        $list = $m_ques->find()->select(['QuestionBh', 'name', 'KnowledgeBh', 'CustomBh', 'Score' , 'Stage','Checked','AddTime','UpdateTime'])
            ->where($where)->orderBy("AddTime ASC, UpdateTime DESC");
        $knowledgepoint = knowledgepoint::find()->where($whereKnow)->asArray()->all();

        //Tab
        $countList = clone $list;
        $pages = $com->Tab($countList);

        return $this->render('index', [
            'list' => $list->offset($pages->offset)->limit($pages->limit)->all(),
            'pages' => $pages,
            'stageChoice' => $stage,
            'stage' => $m_dic->getDictionaryList('题目阶段'),
            'dif' => $m_dic->getDictionaryList('题目难度'),
            //默认显示第一阶段知识点
            'defaultKnow' => $m_know->getByStage(1000301),
            'knowledgepoint'=>$knowledgepoint,

        ]);
    }




    /**
     * 添加填空题
     * @return json
     */
    public function actionAdd()
    {
        $m_ques = new Questions();
        $com = new commonFuc();
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $question = new Questions();
            $com = new commonFuc();
            //处理数据
            $form = null;
            foreach ($post['formBasic'] as $key => $val){
                $form[$val] = substr($key, 10);
            }
            $form = array_flip($form);
            foreach ($form as $key => $val){
                $question->$key = $val;
            }

            $question['QuestionBh'] = $com->create_id();
            $question['QuestionType'] = '1000204';
            $question['AddTime'] = date('Y-m-d H:i:s');
            $question['UpdateTime']= date('Y-m-d H:i:s');
            $question['CourseID'] = \Yii::$app->session->get('courseCode');
            if($question->save())
            {
                $i = 1;
                if(isset($post['Apfill_ans']))
                {
                    for ($i=0; $i<sizeof($post['Apfill_ans']); $i++){
                        $newApfill = new Apfill();
                        $newApfill['QuestionBh'] = $question['QuestionBh'];
                        $newApfill['Answer'] = $post['Apfill_ans'][$i];
                        $newApfill['Proportion'] = $post['Apfill_pro'][$i];
                        $newApfill['ApfillPosition'] = (string)($i+1);
                        if($newApfill->save()){}else{
                            echo "提交数据失败";
                        }
                    }
                }
                echo '添加成功';
            }
            else
                var_dump($question->getErrors());

        }
    }


    public function actionUpdate()
    {
      if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();

            $question = Questions::findOne($post['formBasic']['Questions[QuestionBh']);
//            $res = array_flip($post['formBasic']);
            $form = null;
            foreach ($post['formBasic'] as $key => $val){
                $form[$val] = substr($key, 10);
            }
            $form = array_flip($form);
//          foreach ($post['formBasic'] as $key){
//              $form[] = $key;
//          }
            foreach ($form as $key => $val){
                $question->$key = $val;
            }
            $question->UpdateTime= date('Y-m-d H:i:s');
            if($question->save())
            {
                if(isset($post['Apfill_ans']))
                {
                    Apfill::deleteAll(['QuestionBh'=>$post['formBasic']['Questions[QuestionBh']]);
//                    $i=1;
//                    foreach ($post['Apfill'] as $key => $value) {
//                        $newApfill = new Apfill();
//                        if($newApfill->load($value))
//                        {
//                            $newApfill['QuestionBh'] = $post['formBasic']['Questions[QuestionBh'];
//                            $newApfill['ApfillPosition'] = (string)$i;
//                            $newApfill->save();
//                        }
//                        else
//                            echo "提交数据有误";
//                        $i++;
//                    }
                    for ($i=0; $i<sizeof($post['Apfill_ans']); $i++){
                        $newApfill = new Apfill();
                        $newApfill['QuestionBh'] = $post['formBasic']['Questions[QuestionBh'];
                        $newApfill['Answer'] = $post['Apfill_ans'][$i];
                        $newApfill['Proportion'] = $post['Apfill_pro'][$i];
                        $newApfill['ApfillPosition'] = (string)($i+1);
                        if($newApfill->save()){}else{
                            echo "提交数据失败";
                        }
                    }
                }
                echo "修改完成";
            }
            else
                echo "题目信息有误，请检查选项是否完整".json_encode($question->getErrors());

        }
    }


    //重写删除方法
    public function actionDelete()
    {
        $com = new commonFuc();
        $m_ques = new Questions();

        $ids = \Yii::$app->request->get('ids');
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                Apfill::deleteAll(['QuestionBh'=>$item]);
                $m_ques->deleteAll(['QuestionBh' => $item]);
            }
            $com->JsonSuccess('删除成功');
        }
    }


    //获取一个填空题
    public function actionGetTypebk()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
                echo json_encode(Questions::find()->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->one());

        }
    }
    //获取答案
    public function actionGetAnswer()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
                echo json_encode(Apfill::find()->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->all());

        }
    }

    public function actionSearchTypebk()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['key']))
            {
                $aim = Questions::find()
                ->where("QuestionType=:QuestionType and CourseID=:CourseID and CustomBh like :CustomBh or QuestionType=:QuestionType and CourseID=:CourseID  and name like :name ", [
                    ':QuestionType' => '1000204',
                    ':CourseID' => \Yii::$app->session->get('courseCode'),
                    ':CustomBh' => '%'.$post['key'].'%',
                    ':name' => '%'.$post['key'].'%'
                ])
                ->limit(10)
                ->asArray()->all();
                foreach ($aim as $key => $value) {
                    $aim[$key]['DifficultyCode'] = $aim[$key]['Difficulty'];
                    $aim[$key]['Difficulty'] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$aim[$key]['Difficulty']])->asArray()->one()['CuitMoon_DictionaryName'];
                    $aim[$key]['StageCode'] = $aim[$key]['Stage'];
                    $aim[$key]['SourceCode'] = json_decode($aim[$key]['SourceCode'],true)['key']['0']['code'];
                    $aim[$key]['Stage'] = TbcuitmoonDictionary::find()->where(['CuitMoon_DictionaryCode'=>$aim[$key]['Stage']])->asArray()->one()['CuitMoon_DictionaryName'];
                    $aim[$key]['KnowledgeBhCode'] = $aim[$key]['KnowledgeBh'];
                    $aim[$key]['KnowledgeBh'] = (new Knowledgepoint())->idTranName($aim[$key]['KnowledgeBh']);

                }


                echo json_encode($aim);
            }
        }
    }


}
