<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JenisBarang;

/**
 * JenisBarangSearch represents the model behind the search form about `common\models\JenisBarang`.
 */
class JenisBarangSearch extends JenisBarang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jenis_barang'], 'integer'],
            [['jenis_barang'], 'safe'],
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
        $query = JenisBarang::find();

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
            'id_jenis_barang' => $this->id_jenis_barang,
        ]);

        $query->andFilterWhere(['like', 'jenis_barang', $this->jenis_barang]);

        return $dataProvider;
    }
}
