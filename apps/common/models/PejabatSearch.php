<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pejabat;

/**
 * PejabatSearch represents the model behind the search form about `common\models\Pejabat`.
 */
class PejabatSearch extends Pejabat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jabatan', 'jenis_jabatan', 'nip_pejabat', 'instansi_id'], 'integer'],
            [['nama_pejabat'], 'safe'],
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
        $query = Pejabat::find();

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
            'id_jabatan' => $this->id_jabatan,
            'jenis_jabatan' => $this->jenis_jabatan,
            'nip_pejabat' => $this->nip_pejabat,
            'instansi_id' => $this->instansi_id,
        ]);

        $query->andFilterWhere(['like', 'nama_pejabat', $this->nama_pejabat]);

        return $dataProvider;
    }
}
