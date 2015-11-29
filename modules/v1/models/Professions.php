<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "professions".
 *
 * @property integer $id
 * @property string $profession
 *
 * @property Applyjobs[] $applyjobs
 */
class Professions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'professions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profession'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profession' => '职业类型',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplyjobs()
    {
        return $this->hasMany(Applyjobs::className(), ['professionid' => 'id']);
    }
}
