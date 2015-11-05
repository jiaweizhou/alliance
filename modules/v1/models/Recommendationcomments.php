<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "recommendationcomments".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $recommendationid
 * @property string $content
 * @property integer $created_at
 *
 * @property Recommendations $recommendation
 * @property Users $user
 */
class Recommendationcomments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recommendationcomments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'recommendationid', 'created_at'], 'integer'],
            [['recommendationid', 'content'], 'required'],
            [['content'], 'string', 'max' => 255]
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
            'recommendationid' => 'Recommendationid',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendation()
    {
        return $this->hasOne(Recommendations::className(), ['id' => 'recommendationid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
}
