<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Histori;

/**
 * HistoriSearch represents the model behind the search form about `common\models\Histori`.
 */
class HistoriSearch extends Histori
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','instansi_id'], 'integer'],
            [['nopol_awal', 'nopol_akhir',  'nama_pemegang', 'tanggal', 'kendaraan_id'], 'safe'],
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
        $query = Histori::find();

        //$query->joinWith(['kendaraan']);

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
            'kendaraan_id' => $this->kendaraan_id,
            'nopol_akhir' => $this->nopol_akhir,
            'tanggal' => $this->tanggal,
        ]);

        if(Yii::$app->user->identity->level !='administrator'){

            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>Yii::$app->user->identity->instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }

            $query->andFilterWhere([
                'instansi_id' => Yii::$app->user->identity->instansi,
            ]);
        }else{
            $query->andFilterWhere([
                'instansi_id' => $this->instansi_id,
            ]);
        }

        $query->andFilterWhere(['like', 'nopol_awal', $this->nopol_awal])
            //->andFilterWhere(['like', 'kendaraan.nomor_polisi', $this->kendaraan_id])
            //->andFilterWhere(['like', 'kendaraan.nomor_mesin', $this->kendaraan_id])
            ->andFilterWhere(['like', 'nama_pemegang', $this->nama_pemegang]);

        if(Yii::$app->user->identity->level != 'administrator'){
            $query->orFilterWhere(['in', 'instansi_id', $s]);
        }

        return $dataProvider;
    }
}
