<?php
namespace app\modules\v1\models;
use Yii;
/**
 * This is the model class for table "consignment".
 *
 * @property integer $id
 * @property integer $addressid
 * @property integer $grabcommodityid
 * @property integer $created_at
 * @property integer $status
 *
 */
class Consignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consignment';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addressid','grabcommodityid','created_at','status'], 'required'],
            [['addressid','grabcommodityid','created_at','status'], 'integer']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }
}
