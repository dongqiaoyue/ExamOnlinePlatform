<?php
namespace app\modules\system\controllers;

use app\controllers\BaseController;
use app\models\system\AuthItem;
use app\models\system\AuthItemChild;
use app\models\system\TbcuitmoonModule;
use common\commonFuc;
use Yii;
use yii\rbac\DbManager;


class RoleController extends BaseController
{


    public $enableCsrfValidation=false;

    public function actionIndex()
     {
        $m_Item = new AuthItem();
        $list = $m_Item->getRole();
        return $this->render('index',[
            'list' => $list,
        ]);
    }


    /**
     * Add role
     * @return json
     */
    public function actionCreate()
    {
        $info = Yii::$app->request->post();
        $auth = Yii::$app->authManager;
        $com = new commonFuc();
        $role = $auth->createRole($info['name']);
        $role->description = $info['des'];
        if($auth->add($role)){
            $com->JsonSuccess('添加成功');
        }else{
            $com->JsonFail('添加失败');
        }
    }


    /**
     *
     * @return json
     */
    public function actionGetPermission()
    {
        $m_module = new TbcuitmoonModule();
        $auth = Yii::$app->authManager;

        $Module = $m_module->find()->select(['CuitMoon_ModuleName'])->where([
            'CuitMoon_ParentModuleID' => '0',
        ])->all();
        $Name = Yii::$app->request->get('roleId');
        $User_Permission = $auth->getPermissionsByRole($Name);
        foreach ($User_Permission as $item) {
            $Choice[$item->name] = 1;
        }

        $mid = 1;
        $fid = 1;
        $rid = 1;
        foreach ($Module as $k=>$item) {
            $Tmp = $auth->getChildren($item->CuitMoon_ModuleName);
            $Data[$k]['mid'] = $mid;
            $Data[$k]['selectable'] = false;
            $Data[$k]['state']['checked'] = false;
            $Data[$k]['text'] = $item->CuitMoon_ModuleName;
            $Data[$k]['type'] = 'm';
            $mid++;
            $key = 0;
            foreach ($Tmp as $value) {
                $Data[$k]['nodes'][$key]['fid'] = $fid;
                $Data[$k]['nodes'][$key]['selectable'] = false;
                $Data[$k]['nodes'][$key]['state']['checked'] = false;
                $Data[$k]['nodes'][$key]['text'] = $value->name;
                $Data[$k]['nodes'][$key]['type'] = 'f';
                $Tmp_A = $auth->getChildren($value->name);
                $key++;
                $fid++;
                $Rid = 0;
                foreach ($Tmp_A as $va) {
                    $Data[$k]['nodes'][$key-1]['nodes'][$Rid]['rid'] = $va->name;
                    $Data[$k]['nodes'][$key-1]['nodes'][$Rid]['selectable'] = false;
                    $Data[$k]['nodes'][$key-1]['nodes'][$Rid]['state']['checked'] = false;
                    if (isset($Choice[$va->name])) {
                        $Data[$k]['nodes'][$key-1]['nodes'][$Rid]['state']['checked'] = true;
                        $Data[$k]['nodes'][$key-1]['state']['checked'] = true;
                        $Data[$k]['state']['checked'] = true;
                    }
                    $Data[$k]['nodes'][$key-1]['nodes'][$Rid]['text'] = $va->description;
                    $Data[$k]['nodes'][$key-1]['nodes'][$Rid]['type'] = 'r';
                    $Rid++;
                    $rid++;
                }
            }
        }
        echo json_encode($Data);
    }


    /**
     * @return json
     */
    public function actionPermission()
    {
        $auth = Yii::$app->authManager;
        $com = new commonFuc();

        $Role = Yii::$app->request->post('roleId');
        $Per = Yii::$app->request->post('rids');
        $Role = $auth->getRole($Role);
        $auth->removeChildren($Role);
        foreach ($Per as $item) {
            $Tmp_Per = $auth->getPermission($item);
            $auth->addChild($Role, $Tmp_Per);
        }
        $com->JsonSuccess('修改成功');
    }


    public function actionDelete()
    {
        if(\Yii::$app->request->isGet)
        {
            $get = \Yii::$app->request->get();
            {
                if(isset($get['ids']))
                {
                    foreach ($get['ids'] as $key => $value) {
                        AuthItemChild::deleteAll(['parent'=>$value]);
                        AuthItem::deleteAll(['name'=>$value]);
                    }
                    echo "删除成功";
                }
                else
                    echo "删除失败";
            }
        }
    }
}