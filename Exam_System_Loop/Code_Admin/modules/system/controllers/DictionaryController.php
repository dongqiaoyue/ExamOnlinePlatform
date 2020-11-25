<?php

namespace app\modules\system\controllers;

use app\controllers\BaseController;
use app\models\system\TbcuitmoonDictionary;
use common\commonFuc;
use yii;

class DictionaryController extends BaseController{


    /**
     * 字典主页
     * @return string
     */
    public function actionIndex(){
        $m_Dic = new TbcuitmoonDictionary();
        $id = Yii::$app->request->get();
        $id = isset($id['id']) ? $id['id'] : null;
        $info = $m_Dic->getDic($id);
        return $this->render('index',[
            'info' => $info['info'],
            'pages' => $info['pages'],
            'id' => $id,
        ]);
    }


    /**
     * 添加字典
     * @return json
     */
    public function actionCreate(){
        $comFuc = new commonFuc();
        $m_Dic = new TbcuitmoonDictionary();
        if($m_Dic->load(Yii::$app->request->post())){
            if($m_Dic->CuitMoon_ParentDictionaryID == null){
                $m_Dic->CuitMoon_ParentDictionaryID = '0';
            }
            $m_Dic->CuitMoon_DictionaryID = $comFuc->create_id();
            if($m_Dic->validate() && $m_Dic->save()){
                $msg = array('error' => 0,'msg' => '添加成功');
                echo json_encode($msg);
            }else{
                $msg = array('error' => 2,'msg' => $m_Dic->getErrors());
                echo json_encode($msg);
            }
        }else{
            $msg = array('error' => 2,'msg' => '数据出错');
            echo json_encode($msg);
        }
    }
    
    public function actionView()
    {
        $m_dic = new TbcuitmoonDictionary();

        $Info = $m_dic->find()->where([
            'CuitMoon_DictionaryID' => Yii::$app->request->get('id')
        ])->asArray()->One();
        echo json_encode($Info);
    }

    public function actionUpdate()
    {
        $com = new commonFuc();
        $m_dic = new TbcuitmoonDictionary();

        $update = $m_dic->findOne([
            'CuitMoon_DictionaryID' => Yii::$app->request->post('CuitMoon_DictionaryID')
        ]);
        if ($update->load(Yii::$app->request->post())) {
            $update->CuitMoon_ParentDictionaryID == null ?
                $update->CuitMoon_ParentDictionaryID = '0' :
                true;
            if ($update->validate() && $update->save()) {
                $com->JsonSuccess('修改成功');
            } else {
                $com->JsonFail($update->getErrors());
            }
        } else {
            $com->JsonFail('数据出错');
        }
    }

    public function actionDelete()
    {
        $m_dic = new TbcuitmoonDictionary();
        $com = new commonFuc();

        $Ids = Yii::$app->request->get('ids');
        foreach ($Ids as $item) {
            $Tmp_ID = $m_dic->findOne([
                'CuitMoon_DictionaryID' => $item
            ]);
            if ($Tmp_ID->CuitMoon_ParentDictionaryID == '0') {
                $m_dic->deleteAll([
                    'CuitMoon_ParentDictionaryID' => $item
                ]);
            }
            $m_dic->deleteAll([
                'CuitMoon_DictionaryID' => $item
            ]);
        }
        $com->JsonSuccess('删除成功');
    }
}