<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "kindsofrecommendation".
 *
 * @property integer $id
 * @property string $kind
 *
 * @property Recommendations[] $recommendations
 */
class Kindsofrecommendation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kindsofrecommendation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kind'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kind' => 'Kind',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendations()
    {
        return $this->hasMany(Recommendations::className(), ['kind' => 'id']);
    }
}
