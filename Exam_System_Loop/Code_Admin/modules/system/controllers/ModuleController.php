<?php
namespace app\modules\system\controllers;

use common\commonFuc;
use app\controllers\BaseController;
use app\models\system\TbcuitmoonModule;

use yii;

class ModuleController extends BaseController{


    /**
     * 模块管理主页
     * @return string
     */
    public function actionIndex(){
        $get = Yii::$app->request->get();
        $id = isset($get['id']) ? $get['id'] : null ;
        $m_Module = new TbcuitmoonModule();
        $info = $m_Module->getModule($id);
        return $this->render('index',[
            'id' => $id,
            'info' => $info
        ]);
    }


    /**
     * 添加模块
     * @echo json
     */
    public function actionCreate(){
        $auth = Yii::$app->authManager;
        $comFuc = new commonFuc();
        $m_Module = new TbcuitmoonModule();
        if($m_Module->load(Yii::$app->request->post())){
            //添加权限
            $permission = $auth->createPermission($m_Module->CuitMoon_ModuleName);
            $permission->description = $m_Module->CuitMoon_ModuleURL;
            $auth->add($permission);
            $m_Module->CuitMoon_ModuleID = $comFuc->create_id();
            //判断添加一级模块还是二级模块
            if($m_Module->CuitMoon_ParentModuleID == null){
                $m_Module->CuitMoon_ParentModuleID = '0' ;
            }else{
                //添加子权限
                $Tmp = $m_Module->find()->select(['CuitMoon_ModuleName'])->where(['CuitMoon_ModuleID' => $m_Module->CuitMoon_ParentModuleID])->asArray()->one();
                $parentPre = $auth->getPermission($Tmp['CuitMoon_ModuleName']);
                $auth->addChild($parentPre,$permission);
            }
            $m_Module->CuitMoon_ModuleStatus = '1' ;
            if($m_Module->validate() == true && $m_Module->save()){
                $msg = array('error' => 0,'msg' => '保存成功');
                echo json_encode($msg);
            }else{
                $msg = array('error' => 2, 'msg' => $m_Module->getErrors());
                echo json_encode($msg);
            }
        }else{
            $msg = array('error' => 2,'msg' => '数据出错');
            echo json_encode($msg);
        }
    }


    /**
     * 渲染权限列表
     * 获取控制器action
     * @return string
     */
    public function actionItem(){
//        $m_Module = new TbcuitmoonModule();
        $url = Yii::$app->request->get('id');
//        $name = $m_Module->getModuleNameByURL($url);
//        $sql = "select name,description,created_at from auth_item where type = 2 and name in(select child from auth_item_child where parent='$name')";
//        $perList = Yii::$app->db->createCommand($sql);
        $Tmp = Yii::$app->authManager->getChildren(Yii::$app->request->get('name'));



        //获取每个控制器的所有actions
        $url = explode('/',$url);
        $Con = explode('-',$url[2]);
        $newCon = '';
        foreach ($Con as $value){
            $newCon .= ucfirst($value);
        }
        $actions = get_class_methods('app\modules\\'.$url[1].'\controllers\\'.$newCon.'Controller');
        foreach ($actions as $k => $value){
            if($value != 'actions' && yii\helpers\StringHelper::startsWith($value, 'action') !== false){
                $actionName = substr($value,6,strlen($value));
                $aUrl = yii\helpers\Inflector::camel2id($actionName);
                $allAction[] = '/'.$url[1].'/'.$url[2].'/'.$aUrl;
            }
        }
        return $this->render('item',[
            'controllerData' => $allAction,
            'id' => Yii::$app->request->get('id'),
            'per' => $Tmp,
        ]);
    }

    /**
     * 添加路由(权限)
     * @return json
     */
    public function actionCreatePer(){
        $m_Module = new TbcuitmoonModule();
        $com = new commonFuc();
        $info = Yii::$app->request->post();
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission($info['Name']);
        $permission->description = $info['Des'];
        $parentPer = $auth->getPermission($m_Module->getModuleNameByURL($info['url']));
        $auth->add($permission);
        $auth->addChild($parentPer,$permission);
        $com->JsonSuccess('添加成功');
    }




    public function actionPer(){
        $m_Tb = new TbcuitmoonModule();
        $auth = Yii::$app->authManager;
        $info = $m_Tb->find()
            ->select([
                'CuitMoon_ModuleName',
                'CuitMoon_ModuleURL',
            ])->where(['CuitMoon_ParentModuleID' => '0'])->asArray()->all();
        foreach ($info as $value){
            $permission = $auth->createPermission($value['CuitMoon_ModuleName']);
            $permission->description = $value['CuitMoon_ModuleURL'];
            $auth->add($permission);
        }
    }

    public function actionView()
    {
        if(\Yii::$app->request->isGet)
        {
            $post = \Yii::$app->request->get();
            if(isset($post['id']))
                echo json_encode(TbcuitmoonModule::find()->where(['CuitMoon_ModuleID'=>$post['id']])->asArray()->one());

        }

    }
    // public function actionDelete()
    // {
    //     if(\Yii::$app->request->isGet)
    //     {
    //         $get = \Yii::$app->request->get();
    //         if(isset($post['ids']))
    //         {
    //             foreach ($get['ids'] as $key => $value) {
    //                 $auth = Yii::$app->authManager;
    //                 $auth->revokeAll($value);
    //             }
    //         }
    //     }
    // }

    // public function actionUpdate()
    // {
    //     if(\Yii::$app->request->isPost)
    //     {
    //         $post = \Yii::$app->request->post();
    //         if(isset($post['TbcuitmoonModule']['CuitMoon_ModuleID']))
    //         {
    //             $aim = TbcuitmoonModule::find()->where(['CuitMoon_ModuleID'=>$post['TbcuitmoonModule']['CuitMoon_ModuleID']])->one();
    //                 if($aim->load($post) && $aim->save())
    //                     echo "修改成功";
    //                 else
    //                     echo $aim->getErrors();
    //         }
    //     }
    // }

}