<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "text".
 *
 * @property integer $id
 * @property integer $phone
 * @property integer $text
 * @property integer $created_at
 * @property integer $type
 */
class Text extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'text', 'created_at', 'type'], 'required'],
            [['phone', 'text', 'created_at', 'type'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'text' => 'Text',
            'created_at' => 'Created At',
            'type' => 'Type',
        ];
    }
}
