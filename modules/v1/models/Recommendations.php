<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recommendations".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $title
 * @property integer $kind
 * @property integer $location
 * @property string $sellerphone
 * @property string $reason
 * @property string $picture1
 * @property string $picture2
 * @property string $picture3
 * @property string $picture4
 * @property string $picture5
 * @property string $picture6
 * @property string $picture7
 * @property string $picture8
 * @property string $picture9
 * @property integer $created_at
 *
 * @property Recommendationcomments[] $recommendationcomments
 * @property Kindsofrecommendation $kind0
 * @property Users $user
 */
class Recommendations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recommendations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'kind', 'location', 'created_at'], 'integer'],
            [['title', 'kind', 'location'], 'required'],
            [['picture1', 'picture2', 'picture3', 'picture4', 'picture5', 'picture6', 'picture7', 'picture8', 'picture9'], 'string'],
            [['title', 'sellerphone', 'reason'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'title' => 'Title',
            'kind' => 'Kind',
            'location' => 'Location',
            'sellerphone' => 'Sellerphone',
            'reason' => 'Reason',
            'picture1' => 'Picture1',
            'picture2' => 'Picture2',
            'picture3' => 'Picture3',
            'picture4' => 'Picture4',
            'picture5' => 'Picture5',
            'picture6' => 'Picture6',
            'picture7' => 'Picture7',
            'picture8' => 'Picture8',
            'picture9' => 'Picture9',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendationcomments()
    {
        return $this->hasMany(Recommendationcomments::className(), ['recommendationid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKind0()
    {
        return $this->hasOne(Kindsofrecommendation::className(), ['id' => 'kind']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
