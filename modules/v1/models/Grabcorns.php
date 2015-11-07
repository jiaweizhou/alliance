<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "grabcorns".
 *
 * @property integer $id
 * @property string $picture
 * @property string $title
 * @property string $version
 * @property integer $needed
 * @property integer $remain
 * @property integer $created_at
 * @property integer $date
 * @property integer $end_at
 * @property integer $islotteried
 * @property integer $winneruserid
 * @property integer $winnerrecordid
 * @property integer $winnernumber
 */
class Grabcorns extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grabcorns';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'version', 'needed', 'remain', 'created_at', 'date', 'end_at'], 'required'],
            [['needed', 'left', 'created_at', 'date', 'end_at', 'islotteried', 'winneruserid','winnerrecordid','winnernumber'], 'integer'],
            [['picture', 'title', 'version'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture' => 'Picture',
            'title' => 'Title',
            'version' => 'Version',
            'needed' => 'Needed',
            'left' => 'Left',
            'created_at' => 'Created At',
            'date' => 'Date',
            'end_at' => 'End At',
            'islotteried' => 'Islotteried',
            'winnerid' => 'Winnerid',
        ];
    }
}
