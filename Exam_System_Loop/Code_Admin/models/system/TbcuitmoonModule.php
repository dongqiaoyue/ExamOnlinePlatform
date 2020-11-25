<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "tbcuitmoon_module".
 *
 * @property string $CuitMoon_ModuleID
 * @property string $CuitMoon_ModuleName
 * @property string $CuitMoon_ModuleURL
 * @property string $CuitMoon_ModuleIcon
 * @property string $CuitMoon_ParentModuleID
 * @property string $CuitMoon_ModuleStatus
 * @property integer $CuitMoon_ModuleOrderNum
 * @property string $CuitMoon_ModuleDescription
 * @property string $CuitMoon_ModuleRemarks
 */
class TbcuitmoonModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbcuitmoon_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CuitMoon_ModuleID', 'CuitMoon_ModuleName'], 'required'],
            [['CuitMoon_ModuleOrderNum'], 'integer'],
            [['CuitMoon_ModuleID', 'CuitMoon_ParentModuleID'], 'string', 'max' => 32],
            [['CuitMoon_ModuleName'], 'string', 'max' => 20],
            [['CuitMoon_ModuleURL', 'CuitMoon_ModuleIcon', 'CuitMoon_ModuleDescription', 'CuitMoon_ModuleRemarks'], 'string', 'max' => 200],
            [['CuitMoon_ModuleStatus'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CuitMoon_ModuleID' => 'Cuit Moon  Module ID',
            'CuitMoon_ModuleName' => 'Cuit Moon  Module Name',
            'CuitMoon_ModuleURL' => 'Cuit Moon  Module Url',
            'CuitMoon_ModuleIcon' => 'Cuit Moon  Module Icon',
            'CuitMoon_ParentModuleID' => 'Cuit Moon  Parent Module ID',
            'CuitMoon_ModuleStatus' => 'Cuit Moon  Module Status',
            'CuitMoon_ModuleOrderNum' => 'Cuit Moon  Module Order Num',
            'CuitMoon_ModuleDescription' => 'Cuit Moon  Module Description',
            'CuitMoon_ModuleRemarks' => 'Cuit Moon  Module Remarks',
        ];
    }


    /**
     * 获取所有模板
     * @return array
     */
    public function getAllModules()
    {

        $filed = [
            'CuitMoon_ModuleID',
            'CuitMoon_ModuleName',
            'CuitMoon_ModuleURL',
            'CuitMoon_ParentModuleID',
        ];
        $Role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        $Tmp_Rule = [];
        foreach ($Role as $Item) {
            $Modules = Yii::$app->authManager->getChildren($Item->name);
            foreach ($Modules as $Va) {
                $Tmp = explode("/", $Va->name);
                $Tmp_Rule[] = '/'.$Tmp[1];
            }
        }

        $info = self::find()
            ->select($filed)
            //某些模块的隐藏。使用时把代码注释掉
            //->where(['and','CuitMoon_ParentModuleID="0"'/*,['in','CuitMoon_ModuleUrl',$Tmp_Rule]*/])
            ->where(['and','CuitMoon_ParentModuleID="0"',['in','CuitMoon_ModuleUrl',$Tmp_Rule]])
            ->asArray()->all();
        foreach ($info as $k=>$value){
            $info[$k]['funcList'] = self::find()
                ->select($filed)
                ->where(['CuitMoon_ParentModuleID' => $value['CuitMoon_ModuleID']])->orderBy('CuitMoon_ModuleOrderNum')
                ->asArray()->all();
        }
//        print_r($info);
        return $info;
    }


    /**
     * url 查父级id
     * @param $url
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getParentID($url){
        $info = self::find()
            ->select('CuitMoon_ParentModuleID')
            ->where(['CuitMoon_ModuleURL' => $url])
            ->asArray()->one();
        return $info;
    }


    /**
     * @param $id 存在id则返回子模块,不存在则返回父模块
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getModule($id){

        $id = isset($id) ? $id : '0';
        $field = [
            'CuitMoon_ModuleID',
            'CuitMoon_ModuleName',
            'CuitMoon_ModuleURL',
            'CuitMoon_ParentModuleID',
            'CuitMoon_ModuleStatus',
            'CuitMoon_ModuleOrderNum',
        ];
        $info = self::find()
            ->select($field)
            ->where(['CuitMoon_ParentModuleID' => $id])
            ->all();

        return $info;
    }

    public function getModuleNameByURL($url){
        $Tmp = self::find()
            ->select(['CuitMoon_ModuleName'])
            ->where(['CuitMoon_ModuleURL' => $url ])
            ->asArray()->one();
        return $Tmp['CuitMoon_ModuleName'];
    }
}
