<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Applyjobs;

/**
 * ApplyjobsSearch represents the model behind the search form about `app\modules\v1\models\Applyjobs`.
 */
class ApplyjobsSearch extends Applyjobs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'jobproperty', 'degree', 'work_at', 'hidephone', 'professionid', 'created_at'], 'integer'],
            [['title', 'status', 'content'], 'safe'],
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
        $query = Applyjobs::find();

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
            'jobproperty' => $this->jobproperty,
            'degree' => $this->degree,
            'work_at' => $this->work_at,
            'hidephone' => $this->hidephone,
            'professionid' => $this->professionid,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
