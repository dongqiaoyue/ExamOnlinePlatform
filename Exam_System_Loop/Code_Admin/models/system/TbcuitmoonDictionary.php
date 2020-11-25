<?php

namespace app\models\system;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "tbcuitmoon_dictionary".
 *
 * @property string $CuitMoon_DictionaryID
 * @property string $CuitMoon_DictionaryName
 * @property string $CuitMoon_DictionaryCode
 * @property string $CuitMoon_ParentDictionaryID
 * @property integer $CuitMoon_DictionaryOrderNum
 * @property string $CuitMoon_DictionaryRemarks
 */


class TbcuitmoonDictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbcuitmoon_dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CuitMoon_DictionaryID', 'CuitMoon_DictionaryName', 'CuitMoon_DictionaryCode'], 'required'],
            [['CuitMoon_DictionaryOrderNum'], 'integer'],
            [['CuitMoon_DictionaryID'], 'string', 'max' => 32],
            [['CuitMoon_DictionaryName', 'CuitMoon_DictionaryCode', 'CuitMoon_ParentDictionaryID'], 'string', 'max' => 50],
            [['CuitMoon_DictionaryRemarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CuitMoon_DictionaryID' => 'Cuit Moon  Dictionary ID',
            'CuitMoon_DictionaryName' => 'Cuit Moon  Dictionary Name',
            'CuitMoon_DictionaryCode' => 'Cuit Moon  Dictionary Code',
            'CuitMoon_ParentDictionaryID' => 'Cuit Moon  Parent Dictionary ID',
            'CuitMoon_DictionaryOrderNum' => 'Cuit Moon  Dictionary Order Num',
            'CuitMoon_DictionaryRemarks' => 'Cuit Moon  Dictionary Remarks',
        ];
    }


    /**
     * @param $id 存在id则返回子字典,不存在则返回所有父级字典
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getDic($id){

        $id = isset($id) ? $id : '0';
        $field = [
            'CuitMoon_DictionaryID',
            'CuitMoon_DictionaryName',
            'CuitMoon_DictionaryCode',
            'CuitMoon_ParentDictionaryID',
            'CuitMoon_DictionaryOrderNum',
        ];
        $info = self::find()
            ->select($field)
            ->where(['CuitMoon_ParentDictionaryID' => $id]);

        $countInfo = clone $info;
        $pages = new Pagination([
            'totalCount' => $countInfo->count(),
            'pageSize' => '15',
            'pageParam' => 'page',
            'pageSizeParam' => 'per-page'
        ]);

        $data['info'] = $info->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $data['pages'] = $pages;

        return $data;
    }


    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getQuestionCon($id){
        return self::find()
            ->select([
                'CuitMoon_DictionaryName',
                'CuitMoon_DictionaryCode'
            ])->where(['CuitMoon_ParentDictionaryID' => $id])->all();
    }


    /**
     * 返回子字典列表
     * @param $name
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getDictionaryList($name){
        $Tmp_id = self::find()->select(['CuitMoon_DictionaryID'])
            ->where(['CuitMoon_DictionaryName' => $name])->asArray()->one();
        return self::find()
            ->select([
                'CuitMoon_DictionaryName',
                'CuitMoon_DictionaryCode'
            ])->where(['CuitMoon_ParentDictionaryID' => $Tmp_id['CuitMoon_DictionaryID']])
            ->all();
    }
    public static function getDictionaryListAsArray($name){
        $Tmp_id = self::find()->select(['CuitMoon_DictionaryID'])
            ->where(['CuitMoon_DictionaryName' => $name])->asArray()->one();
        return self::find()
            ->select([
                'CuitMoon_DictionaryName',
                'CuitMoon_DictionaryCode'
            ])->where(['CuitMoon_ParentDictionaryID' => $Tmp_id['CuitMoon_DictionaryID']])
            ->asArray()
            ->all();
    }

    public function getDictionaryListByType($type){
        $res = [];
        $i = 0;
        foreach($type as $key){
            $res['name'][$i] = self::find()->where(['CuitMoon_DictionaryCode' => $key])->one()->CuitMoon_DictionaryName;
            $i++;
        }
        $res['code'] = $type;

        return $res;
    }
}
