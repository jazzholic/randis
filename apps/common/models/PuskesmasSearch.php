<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Puskesmas;

/**
 * PuskesmasSearch represents the model behind the search form about `common\models\Puskesmas`.
 */
class PuskesmasSearch extends Puskesmas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_puskesmas', 'nama_puskesmas', 'alamat', 'no_telp', 'jenis_puskesmas', 'status_poned'], 'safe'],
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
        $query = Puskesmas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kode_puskesmas', $this->kode_puskesmas])
            ->andFilterWhere(['like', 'nama_puskesmas', $this->nama_puskesmas])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'jenis_puskesmas', $this->jenis_puskesmas])
            ->andFilterWhere(['like', 'status_poned', $this->status_poned]);

        return $dataProvider;
    }
}
