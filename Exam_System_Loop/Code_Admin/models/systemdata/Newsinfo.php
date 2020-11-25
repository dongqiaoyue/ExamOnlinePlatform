<?php

namespace app\models\systemdata;

use Yii;

/**
 * This is the model class for table "newsinfo".
 *
 * @property string $newsBh
 * @property string $newstype
 * @property string $newstitle
 * @property string $newscontent
 * @property string $releaseUser
 * @property string $releasetime
 * @property string $Memo
 * @property string $Childtype
 * @property string $ImgUrl
 * @property integer $ClickCount
 * @property integer $State
 */
class Newsinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newsinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newsBh'], 'required'],
            [['newscontent', 'Memo'], 'string'],
            [['ClickCount', 'State'], 'integer'],
            [['newsBh', 'newstype', 'releaseUser', 'releasetime'], 'string', 'max' => 32],
            [['newstitle'], 'string', 'max' => 50],
            [['Childtype'], 'string', 'max' => 10],
            [['ImgUrl'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newsBh' => 'News Bh',
            'newstype' => 'Newstype',
            'newstitle' => 'Newstitle',
            'newscontent' => 'Newscontent',
            'releaseUser' => 'Release User',
            'releasetime' => 'Releasetime',
            'Memo' => 'Memo',
            'Childtype' => 'Childtype',
            'ImgUrl' => 'Img Url',
            'ClickCount' => 'Click Count',
            'State' => 'State',
        ];
    }
}
