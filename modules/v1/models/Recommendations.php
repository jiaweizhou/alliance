<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recommendations".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $title
 * @property integer $kindid
 * @property string $location
 * @property string $sellerphone
 * @property string $reason
 * @property integer $created_at
 * @property string $pictures
 * @property double $longitude
 * @property double $latitude
 *
 * @property Recommendationcomments[] $recommendationcomments
 * @property Kindsofrecommendation $kind
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
            [['userid', 'kindid', 'created_at'], 'integer'],
            [['title', 'kindid'], 'required'],
            [['longitude', 'latitude'], 'number'],
            [['title', 'location', 'sellerphone', 'reason'], 'string', 'max' => 255],
            [['pictures'], 'string', 'max' => 2550]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => '用户',
            'title' => '标题',
            'kindid' => '类型',
            'location' => '位置',
            'sellerphone' => '卖家电话',
            'reason' => '推荐理由',
            'created_at' => '创建时间',
           // 'pictures' => 'Pictures',
            //'longitude' => 'Longitude',
            //'latitude' => 'Latitude',
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
    public function getKind()
    {
        return $this->hasOne(Kindsofrecommendation::className(), ['id' => 'kindid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
