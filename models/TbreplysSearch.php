<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Tbreplys;

/**
 * TbreplysSearch represents the model behind the search form about `app\modules\v1\models\Tbreplys`.
 */
class TbreplysSearch extends Tbreplys
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tbmessageid', 'fromid', 'toid', 'isread', 'created_at'], 'integer'],
            [['content'], 'safe'],
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
        $query = Tbreplys::find();

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
            'tbmessageid' => $this->tbmessageid,
            'fromid' => $this->fromid,
            'toid' => $this->toid,
            'isread' => $this->isread,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
