<?php
namespace app\modules\question\controllers;

use app\modules\question\controllers\QuestionbaseController;
use app\models\question\Knowledgepoint;
use app\models\question\Questions;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use Yii;
use yii\data\Pagination;
use app\models\question\FindError;

class CorrectController extends QuestionbaseController
{


    /**
     * 渲染首页
     * @return string
     */
    public $enableCsrfValidation=false;
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
        $where['QuestionType'] = ['1000208'];
        $whereKnow['CourseID'] = Yii::$app->session->get('courseCode');

        $list = $m_ques->find()->select(['QuestionBh', 'name', 'KnowledgeBh', 'Score','CustomBh', 'Stage','Checked','AddTime','UpdateTime'])
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
    //新增改错题
    public function actionAdd(){
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            $com = new commonFuc();
            $new_q = new Questions();

            foreach ($post as $key => $value) {
                if($key != 'answer')
                    $new_q[$key] = $value;
            }
            $new_q['QuestionBh'] = $com->create_id();
            $new_q['IsProgramming'] = '100002';
            $new_q['Checked'] = '100002';
            $new_q['QuestionType'] = '1000208';
            $new_q['AddTime'] = date('Y-m-d H:i:s');
            $new_q['UpdateTime'] = date('Y-m-d H:i:s');

            $new_q['CourseID'] = \Yii::$app->session->get('courseCode');
            if($new_q->save() && isset($post['answer']))
            {
                $i = 1;
                $sum = 0;
                foreach ($post['answer'] as $key => $value)
                    if(is_numeric($value['Score']))
                        $sum += $value['Score'];
                if($sum > 100)
                {
                    echo "添加失败，分数之后和大于一百";
                    die;
                }
                $m = 0;
                foreach ($post['answer'] as $key => $value) {

                    if($value['Score'] && is_numeric($value['Score']))
                    {
                        $new_a = new FindError();
                        $new_a['QuestionBh'] = $new_q['QuestionBh'];
                        $new_a['ErrorCount'] = $i;
                        $new_a['ErrorStartTag'] = $new_q['StartTag'];
                        $new_a['Content'] = $post['AnswerDescript'];
                        $array = '';
                        $j = 0;

                        foreach ($value as $x => $info) {

                            if((string)$x != 'Score' && $info != ''){

                                $array['key'][$j]['AnswerID'] = (string)$j;
                                $array['key'][$j]['Answer'] = $info;
                                $j++;
                            }
                        }
                        $new_a['Answer'] = json_encode($array);
                        $new_a['Proportion'] = $value['Score'];
                        $new_a->save();
                        $i++;
                    }
                    else
                        $m++;
                }
                if($m)
                    echo $m.'个答案添加失败';
                else
                    echo '添加成功';
            }
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
                FindError::deleteAll(['QuestionBh'=>$item]);
                $m_ques->deleteAll(['QuestionBh' => $item]);
            }
            $com->JsonSuccess('删除成功');

        }
    }
    /**
     * 添加改错题
     * @return json
     */
    // public function actionCreate()
    // {
    //     $m_ques = new Questions();
    //     $com = new commonFuc();
    //     if ($m_ques->load(Yii::$app->request->post())) {
    //         $m_ques->QuestionBh = $com->create_id();
    //         $m_ques->CourseID = Yii::$app->session->get('courseCode');
    //         $answer = Yii::$app->request->post('Answer');
    //         $m_ques->Answer = implode('|', $answer);
    //         $m_ques->QuestionType = '1000208';
    //         if ($m_ques->validate() && $m_ques->save()) {
    //             $com->JsonSuccess('添加成功');
    //         } else {
    //             $com->JsonFail($m_ques->getErrors());
    //         }
    //     } else {
    //         $com->JsonFail('数据出错');
    //     }

    // }
    public function actionGetCorrect()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
                echo json_encode(Questions::find()->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->one());
        }
    }
    public function actionGetAnswer()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
            {

                $answer = FindError::find()->select(['Answer','Proportion','ErrorCount','QuestionBh'])->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->all();
                foreach ($answer as $key => $value) {
                    $answer[$key]['Answer'] = json_decode($answer[$key]['Answer']);
                }

                echo json_encode($answer);
            }
        }
    }
    public function actionUpdate()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['QuestionBh']) && $post['QuestionBh'])
            {
                // print_r($post);
                $arr = [];
                foreach ($post as $key => $value)
                    if($key != 'answer' && $key != 'old')
                        $arr[$key] = $value;
                $arr['UpdateTime'] =  date('Y-m-d H:i:s');
                Questions::updateAll($arr,['QuestionBh'=>$post['QuestionBh']]);
                //更新旧的
                foreach ($post['old'] as $key => $value) {
                    $j = 0;
                    $array = [];
                    $new_a = [];
                    $new_a['ErrorStartTag'] = $post['StartTag'];
                    $new_a['Content'] = $post['AnswerDescript'];
                    foreach ($value as $key1 => $value1) {

                        if((string)$key1 != "Score" && $value1 != '')
                        {
                            $array['key'][$j]['AnswerID'] = (string)$j;
                            $array['key'][$j]['Answer'] = $value1;
                            $j++;

                        }
                    }
                    $new_a['Answer'] = json_encode($array);
                    $new_a['Proportion'] = $value['Score'];
                    FindError::updateAll($new_a,['QuestionBh'=>$post['QuestionBh'],'ErrorCount'=>$key]);
                }
                //添加新的
                $p = count(FindError::find()->where(['QuestionBh'=>$post['QuestionBh']])->asArray()->all())+1;
                if(isset($post['answer']))
                {
                    foreach ($post['answer'] as $key => $value) {

                        if($value['Score'] && is_numeric($value['Score']))
                        {
                            $new_a = new FindError();
                            $new_a['QuestionBh'] = $post['QuestionBh'];
                            $new_a['ErrorCount'] = $p++;
                            $new_a['ErrorStartTag'] = $post['StartTag'];
                            $new_a['Content'] = $post['AnswerDescript'];
                            $array = '';
                            $j = 0;

                            foreach ($value as $x => $info) {

                                if($x != 'Score' && $info){

                                    $array['key'][$j]['AnswerID'] = (string)$j;
                                    $array['key'][$j]['Answer'] = $info;
                                    $j++;
                                }
                            }
                            $new_a['Answer'] = json_encode($array);
                            $new_a['Proportion'] = $value['Score'];
                            $new_a->save();
                        }
                    }
                }

                echo "修改成功";
            }
        }
    }

    public function actionSearchCorrect()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['key']))
            {
                $aim = Questions::find()
                ->where("QuestionType=:QuestionType and CourseID=:CourseID and CustomBh like :CustomBh or QuestionType=:QuestionType and CourseID=:CourseID  and name like :name ", [
                    ':QuestionType' => '1000208',
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




    // //
    // public function actionCheck()
    // {
    //     $m_ques = new Questions();
    //     $com = new commonFuc();
    //     $id = Yii::$app->request->get();
    //     if ($id) {
    //         $ques = $m_ques->findOne([
    //             'QuestionBh'=>$id,
    //         ]);
    //         if ($ques->Checked== '100001') {
    //             $ques->Checked= '100002';
    //         } else {
    //             $ques->Checked= '100001';
    //         }
    //         if ($ques->validate() && $ques->save()) {
    //             $com->JsonSuccess('操作成功');
    //         } else {
    //             $com->JsonFail($m_ques->getErrors());
    //         }
    //     } else {
    //         $com->JsonFail('操作失败');
    //     }

    // }


}
