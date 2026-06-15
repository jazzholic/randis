<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JenisBbm;

/**
 * JenisBbmSearch represents the model behind the search form about `common\models\JenisBbm`.
 */
class JenisBbmSearch extends JenisBbm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_bbm'], 'integer'],
            [['jenis_bbm'], 'safe'],
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
        $query = JenisBbm::find();

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
            'id_bbm' => $this->id_bbm,
        ]);

        $query->andFilterWhere(['like', 'jenis_bbm', $this->jenis_bbm]);

        return $dataProvider;
    }
}
