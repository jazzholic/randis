<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Perawatan;

/**
 * PerawatanSearch represents the model behind the search form about `common\models\Perawatan`.
 */
class PerawatanSearch extends Perawatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perawatan', 'kendaraan_id', 'bbm_id', 'jumlah_liter', 'jumlah_kilometer', 'total_biaya', 'instansi_id'], 'integer'],
            [['tanggal', 'rekanan', 'keterangan', 'lampiran'], 'safe'],
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
        $query = Perawatan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(Yii::$app->user->identity->level !='administrator'){

            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>Yii::$app->user->identity->instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }
        }

        $query->andFilterWhere([
            'id_perawatan' => $this->id_perawatan,
            'kendaraan_id' => $this->kendaraan_id,
            'tanggal' => $this->tanggal,
            'bbm_id' => $this->bbm_id,
            'jumlah_liter' => $this->jumlah_liter,
            'jumlah_kilometer' => $this->jumlah_kilometer,
            'total_biaya' => $this->total_biaya,
            'instansi_id' => (Yii::$app->user->identity->level != 'administrator' ? Yii::$app->user->identity->instansi:$this->instansi_id),
        ]);

        $query->andFilterWhere(['like', 'rekanan', $this->rekanan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran]);

        if(Yii::$app->user->identity->level != 'administrator'){
            $query->orFilterWhere(['in', 'instansi_id', $s]);
        }

        return $dataProvider;
    }
}
