<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Grabcornrecords;

/**
 * GrabcornrecordsSearch represents the model behind the search form about `app\modules\v1\models\Grabcornrecords`.
 */
class GrabcornrecordsSearch extends Grabcornrecords
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'grabcornid', 'count', 'type', 'created_at'], 'integer'],
            [['numbers'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Grabcornrecords::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'grabcornid' => $this->grabcornid,
            'count' => $this->count,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'numbers', $this->numbers]);

        return $dataProvider;
    }
}
