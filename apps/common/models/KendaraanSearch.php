<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Kendaraan;

/**
 * KendaraanSearch represents the model behind the search form about `common\models\Kendaraan`.
 */
class KendaraanSearch extends Kendaraan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kendaraan', 'jenis_id', 'merk_id', 'type_id', 'isi_silinder', 'tahun_pembelian', 'pemegang_id', 'kondisi_id', 'harga_pembelian', 'pagu_perawatan', 'instansi_id'], 'integer'],
            [['nomor_rangka', 'nomor_mesin', 'nomor_polisi', 'nomor_bpkb', 'tampak_depan', 'tampak_belakang', 'tampak_samping_r', 'tampak_samping_l'], 'safe'],
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
        $query = Kendaraan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(Yii::$app->user->identity->level != 'administrator'){
            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>Yii::$app->user->identity->instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }
        }

        $query->andFilterWhere([
            'id_kendaraan' => $this->id_kendaraan,
            'jenis_id' => $this->jenis_id,
            'merk_id' => $this->merk_id,
            'type_id' => $this->type_id,
            'isi_silinder' => $this->isi_silinder,
            'tahun_pembelian' => $this->tahun_pembelian,
            'pemegang_id' => $this->pemegang_id,
            'kondisi_id' => $this->kondisi_id,
            'harga_pembelian' => $this->harga_pembelian,
            'pagu_perawatan' => $this->pagu_perawatan,
            'instansi_id' => (Yii::$app->user->identity->level != 'administrator' ? Yii::$app->user->identity->instansi:$this->instansi_id),
        ]);

        $query->andFilterWhere(['like', 'nomor_rangka', $this->nomor_rangka])
            ->andFilterWhere(['like', 'nomor_mesin', $this->nomor_mesin])
            ->andFilterWhere(['like', 'nomor_polisi', $this->nomor_polisi])
            ->andFilterWhere(['like', 'nomor_bpkb', $this->nomor_bpkb])
            ->andFilterWhere(['like', 'tampak_depan', $this->tampak_depan])
            ->andFilterWhere(['like', 'tampak_belakang', $this->tampak_belakang])
            ->andFilterWhere(['like', 'tampak_samping_r', $this->tampak_samping_r])
            ->andFilterWhere(['like', 'tampak_samping_l', $this->tampak_samping_l]);
            
        if(Yii::$app->user->identity->level != 'administrator'){
            $query->orFilterWhere(['in', 'instansi_id', $s]);
        }
        return $dataProvider;
    }
}
