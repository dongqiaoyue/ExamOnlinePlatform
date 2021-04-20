<?php
namespace app\modules\phone\controllers;

use app\controllers\BaseController;
use app\models\phone\Tresourceexamrecord;
use app\models\phone\Tresourceslearn;
use app\models\system\TbcuitmoonDictionary;
use app\models\teachplan\Teachingclassmannage;
use app\models\teachplan\Teachingclassdetails;
use app\models\systembase\Studentinfo;
use app\models\exam\Stutest;
use app\models\exam\Stutestrecorddetails;
use app\models\question\Questions;
use app\models\phone\Tresources;
use common\commonFuc;
use Yii;

require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';

class LearnController extends BaseController
{
    public function actionIndex()
    {
        $m_tec = new Teachingclassmannage();
        $m_tecd = new Teachingclassdetails();
        $m_dic = new TbcuitmoonDictionary();
        $m_student = new Studentinfo();
        $m_sou = new Tresources();
        $com = new commonFuc();
        $where = [];
        $w = '';

        $Info = Yii::$app->request->get();
        $name = Yii::$app->session->get('UserName');
        $where['CourseID'] = Yii::$app->session->get('courseCode');
        $term = $m_dic->getDictionaryList('学期');


        $myClass = $m_tec->find()->where(['TeacherName' => $name]);
        $termc = $m_dic->find()->select('CuitMoon_DictionaryCode');
        if(isset($Info['term']))
        {
            $myClass = $myClass->andWhere(['Term' => $Info['term']])->asArray()->all();
            $termc = $termc->where(['CuitMoon_DictionaryName'=>$Info['term']])->one();
        }else{
            $myClass = $myClass->andWhere(['Term' => $term[0]->CuitMoon_DictionaryName])->asArray()->all();
            $termc = $termc->where(['CuitMoon_DictionaryName'=>$term[0]->CuitMoon_DictionaryName])->one();
        }
        $where['Term'] = $termc->CuitMoon_DictionaryCode;

        $doc = $m_sou->find()->where(['and',$where,['Type' => '1000801']])->orderBy('ID DESC')->limit(3)->all();
        $ppt = $m_sou->find()->where(['and',$where,['Type' => '1000802']])->orderBy('ID DESC')->limit(3)->all();
        $vid = $m_sou->find()->where(['and',$where,['Type' => '1000803']])->orderBy('ID DESC')->limit(3)->all();

        if (isset($Info['TeachingClassID'])) {$w = $Info['TeachingClassID'];}
//        $ClassList = $m_student->find()->groupBy('MajorName')->asArray()->all();
//        $where = [];



//        if (isset($Info['class'])) {
//            $where['ClassName'] = $Info['class'];
//            $where['MajorName'] = $Info['major'];
//            $Choice['class'] = $Info['class'];
//            $Choice['major'] = $Info['major'];
//        } else {
//            $Choice['major'] = false;
//            $Choice['class'] = false;
//        }

        if(isset($Info['TeachingClassID'])){
            $StuN = $m_tecd->find()->where(['TeachingClassID' => $Info['TeachingClassID']])->asArray()->all();
        }else{
            $StuN = $m_tecd->find()->where(['in','TeachingClassID',array_column($myClass,'TeachingClassID')])->asArray()->all();
        }
        $Stu = $m_student->find()->where(['in','StuNumber',array_column($StuN,'StuNumber')]);

        $countList = clone $Stu;
        $pages = $com->Tab($countList);
        return $this->render('index', [
            'list' => $Stu->offset($pages->offset)->limit($pages->limit)->all(),
            'pages' => $pages,
//            'class_list' => $ClassList,
//            'choice' => $Choice,
            'myClass' => $myClass,
            'term' => $m_dic->getDictionaryList('学期'),
            'w' => $w,
            'doc' => $doc,
            'ppt' => $ppt,
            'vid' => $vid,
            'key' => 0
        ]);
    }
    

    public function actionView()
    {
//        $m_lea = new Tresourceslearn();
        $m_dic = new TbcuitmoonDictionary();
        $m_sou = new Tresources();
        $m_stu = new Studentinfo();

        $Info = Yii::$app->request->get();
        $i = 0; $j = 0; $z = 0;
        $where = [];
        $doc = [];
        $ppt = [];
        $vid = [];

        $term = $m_dic->getDictionaryList('学期');
        $termc = $m_dic->find()->select('CuitMoon_DictionaryCode');
        if(isset($Info['term']))
        {
            $termc = $termc->where(['CuitMoon_DictionaryName'=>$Info['term']])->one();
        }else{
            $termc = $termc->where(['CuitMoon_DictionaryName'=>$term[0]->CuitMoon_DictionaryName])->one();
        }
        $where['Term'] = $termc->CuitMoon_DictionaryCode;

//        $data = $m_lea->find()->where(['StuID' => $id])->all();
        $name = $m_stu->find()->where(['StuNumber' => $Info['id']])->asArray()->one();
        $list = $m_sou->find()->where($where)->asArray()->all();
        foreach ($list as $key => $value){
            if ($value['Type'] == 1000801){
                $doc[$i] = $value['ID'];
                $i++;
            }elseif ($value['Type'] == 1000802){
                $ppt[$j] = $value['ID'];
                $j++;
            }elseif ($value['Type'] == 1000803){
                $vid[$z] = $value['ID'];
                $z++;
            }
        }
        return $this->render('view',[
            'id' => $Info['id'],
            'name' => $name['Name'],
            'doc' => $doc,
            'ppt' => $ppt,
            'vid' => $vid,
            'i' =>$i,
            'j' =>$j,
            'z' =>$z
        ]);
    }

    public function actionScore()
    {
        $m_exa = new Tresourceexamrecord();

        $sou_id = Yii::$app->request->get('id1');
        $stu_id = Yii::$app->request->get('id2');
        $data = $m_exa->find()->where(['ResourcesID' => $sou_id,'StuID' => $stu_id])->orderBy('AddAt DESC')->asArray()->all();
        echo json_encode($data);
    }

    public function actionOutputExcel()
    {
        $PHPExcel = new \PHPExcel();
        $Teachingclassdetails = new Teachingclassdetails();

        //垂直居中
        $PHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $Info = Yii::$app->request->get();
        $TeachingClassID = Yii::$app->request->get('TeachingClassID');
        $where['CourseID'] = Yii::$app->session->get('courseCode');

        if (empty($Info['TeachingClassID']))
        {
//            $StuID = $Teachingclassdetails->find()->orderBy("StuNumber")->asArray()->all();
//            $ClassName = '全部班级';
            die();//全部内容导出会卡
        }else{
            $StuID = $Teachingclassdetails->find()->where(['TeachingClassID' => $Info['TeachingClassID']])->orderBy("StuNumber")->asArray()->all();
            $ClassName = Teachingclassmannage::findOne(['TeachingClassID' =>$TeachingClassID])['TeachingName'];
        }

//        $StuID = Teachingclassdetails::find()->where(['TeachingClassID' => $TeachingClassID])->orderBy("StuNumber")->asArray()->all();
        $Stu = Studentinfo::find()->where(['in','StuNumber',$StuID])->asArray()->all();


        $list = Tresources::find()->where($where)->orderBy("Type")->all();
        $PHPExcel->getProperties()->setTitle($ClassName);
        $PHPExcel->setActiveSheetIndex(0);

        $i = 3; $j = "C"; $k = "B" ;$flag = 1; $z ='';
        $PHPExcel->getActiveSheet()->setCellValue("A2",'学号');
        $PHPExcel->getActiveSheet()->setCellValue("B2",'姓名');
        $PHPExcel->getActiveSheet()->setCellValue("B1",'资源名称');

        $key = 'C';
        foreach ($list as $value){$key++;}
        foreach ($list as $item) {
            $PHPExcel->getActiveSheet()->setCellValue($j."2",$item->Name);
            if ($item->Type == 1000802 && $flag == 1)
            {
                $z = $k;
                $flag = $k;
                if ($flag != "C")
                    $PHPExcel->getActiveSheet()->mergeCells('C1:'.$flag.'1');
                $PHPExcel->getActiveSheet()->setCellValue("C1",'文档资源');
            }
            if ($item->Type == 1000803 && $z == $flag )
            {
                $z = $k;
                if ($flag++ != $k)
                    $PHPExcel->getActiveSheet()->mergeCells($flag.'1:'.$k.'1');
                $PHPExcel->getActiveSheet()->setCellValue($flag."1",'ppt资源');
            }
            $j++;
            $k++;
            if ($j == $key)
            {
                if ($z++ != $key)
                    $PHPExcel->getActiveSheet()->mergeCells($z.'1:'.$k.'1');
                $PHPExcel->getActiveSheet()->setCellValue($z."1",'视频资源');
            }

        }



        foreach ($Stu as $item) {
                $aa = 'C';
                $Score=(new Tresourceslearn)->findScore($item['StuNumber'],$list);
                foreach ($Score as $value){
                    if ($value == null)
                        $value = "未学习";
                    $PHPExcel->getActiveSheet()->setCellValue($aa.$i,$value);
                    $aa++;
                }
                $PHPExcel->getActiveSheet()->setCellValue('A'.$i,$item['StuNumber']);
                $PHPExcel->getActiveSheet()->setCellValue('B'.$i,$item['Name']);
                $i++;
        }


        //header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.$ClassName.'.xls"');
        $objWriter= \PHPExcel_IOFactory::createWriter($PHPExcel,'Excel5');
        $objWriter->save('php://output');
    }
}