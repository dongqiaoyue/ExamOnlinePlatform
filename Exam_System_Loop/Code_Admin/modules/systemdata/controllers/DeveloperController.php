<?php
namespace app\modules\systemdata\controllers;

use app\controllers\BaseController;
use app\models\systemdata\Developerinfo;
use common\commonFuc;
use Yii;


class DeveloperController extends BaseController
{

    public function actionIndex()
    {
        $m_deve = new developerinfo();
        $com = new commonFuc();
        $where = ['and'];
        $developer = $m_deve->find()->all();
        $res = Yii::$app->request->get();
        if (isset($res['name'])) {
            $deveName = $res['name'];
            $where = ['like', 'DeveloperName', "$deveName"];
        }
        $Info = $m_deve->find()->where($where);
        $countInfo = clone $Info;
        $pages = $com->Tab($countInfo);
        return $this->render('index', [
            'developer' => $Info->limit($pages->limit)->offset($pages->offset)->all(),
            'pages' => $pages,
        ]);
    }

    //查看信息
    public function actionView()
    {
        $m_deve = new developerinfo();

        $id = Yii::$app->request->get('id');
        if ($id) {
            $developer = $m_deve->find()->where([
                'DeveloperID' => $id,
            ])->asArray()->one();
            echo json_encode($developer);
        }

    }

    //添加信息
    public function actionCreate()
    {
        if (isset($_FILES["file"])) {
            if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/pjpeg"))
            ) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                } else {
                    $file=pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
                    //$filename=explode('.',$file);
                    if ($file == "jpg" || $file == "jpeg" || $file == "png" || $file == "gif") {
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                            "upload/tmp_file/" . date("YmdHis") . $_FILES["file"]["name"]);
                        $data = date("YmdHis") . $_FILES["file"]["name"];

                    }
                }
            } else {
                echo "请上传图片";
            }
        } else {
            echo "不存在文件";
        }
        $com = new commonFuc();
        $m_deve = new developerinfo();
        if ($m_deve->load(Yii::$app->request->post())) {
            $m_deve->DeveloperID = $com->create_id();
            if (isset($data)) {
                $m_deve->Src = $data;
            }
            if ($m_deve->validate() && $m_deve->save()) {
                $com->JsonSuccess('添加成功');
            } else {
                $com->JsonFail($m_deve->getErrors());
            }
        } else {
            $com->JsonFail('添加失败');
        }
        //echo json_encode($file);
    }

	
	//更新信息
	
	public function actionUpdate(){
        if (isset($_FILES["file"])) {
            if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/pjpeg"))
            ) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                } else {
                    $file=pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
                    //$filename=explode('.',$file);
                    if ($file == "jpg" || $file == "jpeg" || $file == "png" || $file == "gif") {
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                            "upload/tmp_file/" . date("YmdHis") . $_FILES["file"]["name"]);
                        $data = date("YmdHis") . $_FILES["file"]["name"];

                    }
                }
            } else {
                echo "请上传图片";
            }
        } else {
            echo "不存在文件";
        }
        $com = new commonFuc();
        $m_deve = new developerinfo();

        $id = Yii::$app->request->post('id');
        $update = $m_deve->findOne($id);
        if(isset($update->Src)) {
            unlink('upload/tmp_file/' . $update->Src);
        }
        if($update->load(Yii::$app->request->post())){
            if(isset($data)){
                $update->Src = $data;
            }
            if($update->validate() && $update->save()){
                $com->JsonSuccess('更新成功');
            }else{
                $com->JsonFail($m_deve->getErrors());
            }
        }else{
            $com->JsonFail('更新失败');
        }
    }
	
	//删除信息
	
	public function actionDelete(){
        $com = new commonFuc();
        $m_deve = new developerinfo();

        $ids = Yii::$app->request->get('ids');
        if(count($ids)>0){
            foreach ($ids as $item)
            {
                    $m_pc=$m_deve->findOne($item);
                  $m_deve->deleteAll(['DeveloperID'=>$item]);
                if(isset($m_pc->Src)) {
                    unlink('upload/tmp_file/' . $m_pc->Src);
                }
                    $com->JsonSuccess('删除成功');

            }
        }
    }

    //查找信息

    public function actionSearch(){
        $com = new commonFuc();
        $m_deve = new developerinfo();

        $id = Yii::$app->request->post('$id');
        if ($id) {
            $devep = $m_deve->find()->select(['developerinfo'])->where([
                'DeveloperName' => $id,
            ])->asArray()->all();
            echo json_encode($devep);
        }
    }

}

?>