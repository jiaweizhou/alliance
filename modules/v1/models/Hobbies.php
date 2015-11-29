<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "hobbies".
 *
 * @property integer $id
 * @property string $hobby
 *
 * @property Daters[] $daters
 */
class Hobbies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hobbies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hobby'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hobby' => '爱好',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDaters()
    {
        return $this->hasMany(Daters::className(), ['hobbyid' => 'id']);
    }
}
