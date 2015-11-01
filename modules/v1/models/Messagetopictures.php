<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "messagetopictures".
 *
 * @property integer $id
 * @property integer $messageid
 * @property string $picture
 *
 * @property Messages $message
 */
class Messagetopictures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messagetopictures';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['messageid', 'picture'], 'required'],
            [['messageid'], 'integer'],
            [['picture'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'messageid' => 'Messageid',
            'picture' => 'Picture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Messages::className(), ['id' => 'messageid']);
    }
}
