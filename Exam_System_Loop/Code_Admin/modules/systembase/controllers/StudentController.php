<?php
namespace app\modules\systembase\controllers;

use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use app\models\systembase\Studentinfo;
use app\models\teachplan\Teachingclassdetails;
use common\commonFuc;
use Yii;

class StudentController extends BaseController
{


    public function actionIndex()
    {
        $m_dic = new TbcuitmoonDictionary();
        $m_student = new Studentinfo();
        $com = new commonFuc();

        $Info = Yii::$app->request->get();
        $ClassList = $m_student->find()->groupBy('MajorName')->asArray()->all();
        $where = [];
        if (isset($Info['class'])) {
            $where['ClassName'] = $Info['class'];
            $where['MajorName'] = $Info['major'];
            $Choice['class'] = $Info['class'];
            $Choice['major'] = $Info['major'];
        } else {
            $Choice['major'] = false;
            $Choice['class'] = false;
        }
        $Stu = $m_student->find()->where($where);
        $CloneStu = clone $Stu;
        $Pages = $com->Tab($CloneStu);
        return $this->render('index',[
            'class_list' => $ClassList,
            'pages' => $Pages,
            'list' => $Stu->limit($Pages->limit)->offset($Pages->offset)->all(),
            'choice' => $Choice,
        ]);
    }

    public function actionGetMajorClass()
    {
        $m_student = new Studentinfo();


        $Major = Yii::$app->request->get('major');
        $Class = $m_student->find()->where([
            'MajorName' => $Major
        ])->groupBy('ClassName')->asArray()->all();
        return json_encode($Class);
    }
    public function actionDelete()
    {
        $com = new commonFuc();
        $stu = new Studentinfo();

        $ids = \Yii::$app->request->get('ids');
        // var_dump($ids);
        if (count($ids) > 0) {
            foreach ($ids as $item) {
                Teachingclassdetails::deleteAll(['StuNumber'=>$item]);
                $stu->deleteAll(['StuNumber' => $item]);
            }
            $com->JsonSuccess('删除成功');

        }
    }


    public function actionUpdate()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['StudentNumber']) && $post['StudentNumber'])
            {
                $stu = Studentinfo::find()->where(['StuNumber'=>$post['StudentNumber']])->one();
                if($stu->load($post) && $stu->save())
                    echo "修改成功";
                else
                    echo "修改失败";
            }

        }
    }

    public function actionAdd()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['Studentinfo']['StuNumber']) && $post['Studentinfo']['StuNumber'] && $post['Studentinfo']['Name'] && $post['Studentinfo']['ICNumber'] && $post['Studentinfo']['Sex'])
            {
                $new = new Studentinfo();
                if($new->load($post))
                {
                    $new['Password'] = $post['Password'] ? md5($post['Password']) : md5($post['Studentinfo']['StuNumber']);
                    if($new->save())
                        echo "添加成功";
                    else
                        echo "添加失败";
                }
                else 
                    var_dump($new->getErrors());
            }
            else 
                echo "必填内容不能为空";
        }
        else 
            echo "提交方式不正确";
    }

    public function actionResetPasswd()
    {
        if(\Yii::$app->request->isPost)
        {
            $post = \Yii::$app->request->post();
            if(isset($post['StuNumber']))
            {
                $aim = Studentinfo::find()->where(['StuNumber'=>$post['StuNumber']])->one();
                $aim['Password'] = md5($post['StuNumber']);
                if($aim->save())
                    echo json_encode("密码已初始化为学号");
                else
                    echo json_encode("密码重置失败");
            }
        }
    }
    //fuck you svn
}