<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RiwayatPajak;

/**
 * RiwayatPajakSearch represents the model behind the search form about `common\models\RiwayatPajak`.
 */
class RiwayatPajakSearch extends RiwayatPajak
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pajak', 'kendaraan_id', 'instansi_id','jumlah_bayar'], 'integer'],
            [['tanggal_bayar', 'tanggal_expired'], 'safe'],
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
        $query = RiwayatPajak::find();

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
            'id_pajak' => $this->id_pajak,
            'kendaraan_id' => $this->kendaraan_id,
            'tanggal_bayar' => $this->tanggal_bayar,
            'tanggal_expired' => $this->tanggal_expired,
            'instansi_id' => (Yii::$app->user->identity->level != 'administrator' ? Yii::$app->user->identity->instansi:$this->instansi_id),
            'jumlah_bayar' => $this->jumlah_bayar,
        ]);

        if(Yii::$app->user->identity->level != 'administrator'){
            $query->orFilterWhere(['in', 'instansi_id', $s]);
        }

        return $dataProvider;
    }
}
