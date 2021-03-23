<?php


namespace app\modules\teachplan\controllers;

use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use app\models\systembase\Studentinfo;
use app\models\TbcuitmoonUser;
use app\models\teachplan\Teachingclassdetails;
use app\models\teachplan\Teachingclassmannage;
use app\models\UploadForm;
use yii\base\Exception;
use yii\helpers\BaseJson;
use yii\web\UploadedFile;
use common\commonFuc;
use yii\helpers\Url;
use Yii;

ini_set('max_execution_time', '0');

require_once __DIR__.'/../../../web/component/excel/PHPExcel/IOFactory.php';


class TeachPlanController extends BaseController{


    /**
     * 渲染教学计划班 主页
     * @return string
     */
    public function actionIndex()
    {
        $m_teaching = new Teachingclassmannage();
        $m_Dic = new TbcuitmoonDictionary();
        $m_user = new TbcuitmoonUser();
        $com = new commonFuc();

        $term = YII::$app->request->get();
        $courseCode = Yii::$app->session->get('courseCode');
        $TeacherName = $m_user->findOne([
            'CuitMoon_UserID' => Yii::$app->user->getId(),
        ])->CuitMoon_UserName;
        $where['TeacherName'] = $TeacherName;
        $where = ['and',"CourseID='$courseCode'"];
        if (isset($term['term'])) {
            if ($term['term'] != 0) {
                $Tmp = $term['term'];
                $where[] = "Term='$Tmp'";
            }
            $Term_Choice = $term['term'];
        } else {
            $Term_Choice = null;
        }
        if (isset($term['type'])) {
            if ($term['type'] != 'all') {
                if ($term['type'] == '1') {
                    $where[] = "TeacherName='$TeacherName'";
                }
                $Type = $term['type'];
                $where[] = "Type='$Type'";
            }
            $Type_Choice = $term['type'];
        } else {
            $Type_Choice = 'all';
        }
        if (isset($term['search'])) {
            $search = $term['search'];
            $where[]  = ['like','TeachingName',"$search"];
        }
        $my = Yii::$app->session->get('UserName');
        $where[] = "TeacherName='$my'";
        $Info = $m_teaching->find()->where($where);
        $CountInfo = clone $Info;
        $pages = $com->Tab($CountInfo);
        $CourseName = $com->codeTranName(Yii::$app->session->get('courseCode'));
        $user = TbcuitmoonUser::find()->select("CuitMoon_UserName,CuitMoon_UserRealName")->asArray()->all();
        return $this->render('index',[
            'project' => $m_Dic->getDictionaryList('课程'),
            'college' => $m_Dic->getDictionaryList('学院'),
            'term' => $m_Dic->getDictionaryList('学期'),
            'CourseName' => $CourseName,
            'list' => $Info->limit($pages->limit)->offset($pages->offset)->all(),
            'pages' => $pages,
            'term_choice' => $Term_Choice,
            'type_choice' => $Type_Choice,
            'teacher' => $user,
            'now_term' => $com->getNowTerm(),
        ]);
    }


    /**
     * View Schedule Details
     * @return json
     */
    public function actionView(){
        $m_teach = new Teachingclassmannage();

        $id = Yii::$app->request->get('id');
        if($id){
            $info = $m_teach->find()->where(['TeachingClassID'=>$id,'CourseID' => Yii::$app->session->get('courseCode')])->asArray()->one();
            echo json_encode($info);
        }
    }


    /**
     * Update Schedule
     * @return  json
     */
    public function actionUpdate(){
        $com = new commonFuc();
        $m_teachManage = new Teachingclassmannage();

        $id = Yii::$app->request->post('id');
        $update = $m_teachManage->findOne($id);
        if($update->load(Yii::$app->request->post())){
            $update->CourseID = Yii::$app->session->get('courseCode');
            $update->TeacherName = Yii::$app->session->get('UserName');
            if($update->validate() && $update->save()){
                $com->JsonSuccess('修改成功');
            }else{
                $com->JsonFail($m_teachManage->getErrors());
            }
        }else{
            $com->JsonFail('数据出错');
        }
    }


    /**
     * Delete Schedule
     * @return json
     */
    public function actionDelete(){
        $com = new commonFuc();
        $m_class_manage = new Teachingclassmannage();
        $m_class_detail = new Teachingclassdetails();

        $ids = Yii::$app->request->get('ids');
        if(count($ids)>0){
            foreach ($ids as $item){
                $Transaction = Yii::$app->db->beginTransaction();
                try{
                    $m_class_detail->deleteAll(['TeachingClassID'=>$item]);
                    $m_class_manage->deleteAll(['TeachingClassID'=>$item]);
                    $Transaction->commit();
                    $com->JsonSuccess('删除成功');
            }catch (Exception $e){
                    $Transaction->rollBack();
                    $com->JsonFail('删除失败');
                }
            }
        }
    }


    /**
     * 添加教学计划班
     * @return json
     */
    public function actionCreate(){
        $com = new commonFuc();
        $m_teachManage = new Teachingclassmannage();
        if($m_teachManage->load(Yii::$app->request->post())){
            $m_teachManage->TeachingClassID = $com->create_id();
            $m_teachManage->CourseID = Yii::$app->session->get('courseCode');
            $m_teachManage->TeacherName = Yii::$app->session->get('UserName');
            $m_teachManage->Type = '1';
            if($m_teachManage->validate() && $m_teachManage->save()){
                $com->JsonSuccess('添加成功');
            }else{
                $com->JsonFail($m_teachManage->getErrors());
            }
        }else{
            $com->JsonFail('数据出错');
        }
    }


    /**
     * 渲染学生列表页面
     * @return string
     */
    public function actionStudent(){
        $m_teach = new Teachingclassmannage();
        $m_detail = new Teachingclassdetails();
        $com = new commonFuc();

        $id = Yii::$app->request->get('classId');
        $Tmp = $m_teach->findOne([
            'TeachingClassID' => $id
        ]);
        $info = $m_detail->find()->where([
            'TeachingClassID' => $id
        ]);
        $countInfo = clone $info;
        $pages = $com->Tab($countInfo);
        $Test = [];
        $newInfo = $info->orderBy("CAST(StuNumber AS SIGNED) ASC")->offset($pages->offset)->limit($pages->limit)->all();
        foreach ($newInfo as $item){
            $Tmp_One = $item->student;
            $Test[] = $Tmp_One;
        }
        // sort($Test);
        return $this->render('student',[
            'classId' => $Tmp['TeachingClassID'],
            'className' => $Tmp['TeachingName'],
            'list' => $Test,
            'pages' => $pages,
        ]);
    }


    /**
     * excel导入学生信息
     * @return json
     */
    public function actionAddStudents(){
        $upload = new UploadForm();
        $com = new commonFuc();

        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->post('id');
            $upload->excel = UploadedFile::getInstance($upload, 'excel');
            if($upload->excel && $upload->validate()){
                $newtime = time();//使用时间戳区别上传的文件
                $filename = md5($upload->excel->baseName.$newtime);
                $upload
                    ->excel
                    ->saveAs(__DIR__.'/../../../upload/tmp_file/'.
                        $filename.'.'.$upload->excel->extension);
                $reader = \PHPExcel_IOFactory::createReader('Excel5');
                $PHPExcel = $reader
                    ->load(__DIR__.'/../../../upload/tmp_file/'.
                        $filename.'.'.$upload->excel->extension);
                $sheet = $PHPExcel->getSheet(0);
                $row = $sheet->getHighestRow();
                for ($i =  2; $i <= $row; $i++){//行数是以第1行开始
                    $m_student = new Studentinfo();
                    $m_classDetail = new Teachingclassdetails();
                    if($sheet->getCell('A'.$i)->getValue() == null){
                        break;
                    }

                    $m_classDetail->StuNumber = (string)$sheet->getCell('A'.$i)->getValue();
                    $m_classDetail->TeachingClassDetailsID = $com->create_id();
                    $m_classDetail->TeachingClassID = $id;
                    //-------------------------//
                    $m_student->StuNumber = (string)$sheet->getCell('A'.$i)->getValue();
                    $m_student->ICNumber = (string)$sheet->getCell('B'.$i)->getValue();
                    $m_student->Name = (string)$sheet->getCell('C'.$i)->getValue();
                    $m_student->Sex = (string)$sheet->getCell('D'.$i)->getValue();
                    // Yii::$app->security->generatePasswordHash
                    $m_student->Password = (string)md5($sheet->getCell('A'.$i)->getValue());
                    $m_student->ClassName = (string)$sheet->getCell('F'.$i)->getValue();
                    $m_student->DepartmentName = (string)$sheet->getCell('G'.$i)->getValue();
                    $m_student->MajorName = (string)$sheet->getCell('H'.$i)->getValue();
                    $m_student->Memo = (string)$sheet->getCell('I'.$i)->getValue();

                    try{
                        $m_student->save();
                    }catch (Exception $e){

                    }
                    $m_classDetail->save();

                }

                $data = [
                    'error' => 0,
                    'msg' => '错误',
                ];
                echo json_encode($data);
            }else{
                $com->JsonFail($upload->getErrors());
            }
        }else{
            $com->JsonFail('请用post方式传输');
        }
    }


    /**
     * 查询学生信息返回
     * @return json
     */
    public function actionViewStudent()
    {
        $m_student = new Studentinfo();

        $info = $m_student->find()->where([
            'StuNumber' => Yii::$app->request->get('id')
        ])->asArray()->One();
        echo json_encode($info);
    }


    /**
     * 添加学生到教学计划班
     * @return json
     */
    public function actionAddStudent()
    {
        $m_student = new Studentinfo();
        $m_class_detail = new Teachingclassdetails();
        $com = new commonFuc();

        if ($m_student->load(Yii::$app->request->post())) {
            // Yii::$app->security->generatePasswordHash($m_student->StuNumber)
            $m_student->Password = Yii::$app->request->post('Password') == null ?
                md5($m_student->StuNumber) :
                md5(Yii::$app->request->post('Password'));
            try {
                $m_student->save();
            } catch (Exception $e) {

            }
            $m_class_detail->TeachingClassID = Yii::$app->request->post('classId');
            $m_class_detail->StuNumber = $m_student->StuNumber;
            $m_class_detail->TeachingClassDetailsID = $com->create_id();
            if ($m_class_detail->save()) {
                $com->JsonSuccess('添加成功');
            } else {
                $com->JsonFail($m_student->getErrors());
            }
        }

    }

    public function actionUpdateStudent()
    {
        $m_student = new Studentinfo();
        $com = new commonFuc();

        $update = $m_student->findOne([
            'StuNumber' => Yii::$app->request->post('StudentNumber')
        ]);
        if ($update->load(Yii::$app->request->post())) {
            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('修改成功');
            } else {
                $com->JsonFail($update->getErrors());
            }
        } else {
            $com->JsonFail('数据错误');
        }
    }


    /**
     * 删除教学计划班中的学生
     * @return json
     */
    public function actionDeleteStudent()
    {
        $com = new commonFuc();
        $m_class_detail = new Teachingclassdetails();

        $ids = Yii::$app->request->get('ids');
        foreach ($ids as $item) {
            $m_class_detail->deleteAll(['StuNumber' => $item, 'TeachingClassID' => Yii::$app->request->get('classId')]);
        }
        $com->JsonSuccess('删除成功');
    }

    //获取EXCEL模板信息
    public function actionGetExcel()
    {
        $content = '';
        // Url::base()
        $content = file_get_contents(Url::base()."upload/ExcelExample/StudentInfo.xls");
        if(!$content)
            throw new CHttpException('500','该文件内容为空，没有找到该文件！');
        \Yii::$app->request->sendFile("Studentinfo.xls", $content);
    }

    public function actionChangeClassTeacher()
    {
        if(\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post();
            if(isset($post['id']) && isset($post['teacher']))
            {
                Teachingclassmannage::updateAll(['TeacherName'=>$post['teacher']],['TeachingClassID'=>$post['id']]);
                echo "修改成功";
            }  else {
                echo json_encode("参数错误");
            }
        }
    }
}
