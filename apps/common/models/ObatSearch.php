<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Obat;

/**
 * ObatSearch represents the model behind the search form about `common\models\Obat`.
 */
class ObatSearch extends Obat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_obat', 'nama_obat', 'satuan', 'created_date', 'updated_date'], 'safe'],
            [['harga_beli', 'harga_jual', 'stok', 'created_user', 'updated_user'], 'integer'],
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
        $query = Obat::find();

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
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'created_user' => $this->created_user,
            'created_date' => $this->created_date,
            'updated_user' => $this->updated_user,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'kode_obat', $this->kode_obat])
            ->andFilterWhere(['like', 'nama_obat', $this->nama_obat])
            ->andFilterWhere(['like', 'satuan', $this->satuan]);

        return $dataProvider;
    }
}
