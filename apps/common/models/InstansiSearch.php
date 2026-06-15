<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Instansi;

/**
 * InstansiSearch represents the model behind the search form about `common\models\Instansi`.
 */
class InstansiSearch extends Instansi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_instansi','parent_id'], 'integer'],
            [['nama_instansi', 'alamat', 'telp', 'fax', 'email'], 'safe'],
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
        $query = Instansi::find();

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
            'id_instansi' => $this->id_instansi,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'nama_instansi', $this->nama_instansi])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
