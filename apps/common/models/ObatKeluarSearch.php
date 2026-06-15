<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ObatKeluar;

/**
 * ObatKeluarSearch represents the model behind the search form about `common\models\ObatKeluar`.
 */
class ObatKeluarSearch extends ObatKeluar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_transaksi', 'tanggal_masuk', 'kode_obat', 'created_date'], 'safe'],
            [['jumlah_keluar', 'created_user'], 'integer'],
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
        $query = ObatKeluar::find();

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
            'tanggal_masuk' => $this->tanggal_masuk,
            'jumlah_keluar' => $this->jumlah_keluar,
            'created_user' => $this->created_user,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'kode_transaksi', $this->kode_transaksi])
            ->andFilterWhere(['like', 'kode_obat', $this->kode_obat]);

        return $dataProvider;
    }
}
