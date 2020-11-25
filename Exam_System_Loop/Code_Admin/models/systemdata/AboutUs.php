<?php

namespace app\models\systemdata;

use Yii;

/**
 * This is the model class for table "aboutUs".
 *
 * @property string $aboutUsID
 * @property string $title
 * @property string $info
 */
class AboutUs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aboutUs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aboutUsID'], 'required'],
            [['info'], 'string'],
            [['aboutUsID'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aboutUsID' => 'About Us ID',
            'title' => 'Title',
            'info' => 'Info',
        ];
    }
}
