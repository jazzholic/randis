<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Kondisi;

/**
 * KondisiSearch represents the model behind the search form about `common\models\Kondisi`.
 */
class KondisiSearch extends Kondisi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kondisi'], 'integer'],
            [['kondisi'], 'safe'],
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
        $query = Kondisi::find();

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
            'id_kondisi' => $this->id_kondisi,
        ]);

        $query->andFilterWhere(['like', 'kondisi', $this->kondisi]);

        return $dataProvider;
    }
}
