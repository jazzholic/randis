<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Type;

/**
 * TypeSearch represents the model behind the search form about `common\models\Type`.
 */
class TypeSearch extends Type
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_type', 'jenis_id', 'merk_id'], 'integer'],
            [['nama_type'], 'safe'],
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
        $query = Type::find();

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
            'id_type' => $this->id_type,
            'jenis_id' => $this->jenis_id,
            'merk_id' => $this->merk_id,
        ]);

        $query->andFilterWhere(['like', 'nama_type', $this->nama_type]);

        return $dataProvider;
    }
}
