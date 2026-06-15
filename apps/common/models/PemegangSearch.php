<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pemegang;

/**
 * PemegangSearch represents the model behind the search form about `common\models\Pemegang`.
 */
class PemegangSearch extends Pemegang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pemegang', 'nip_pemegang', 'golongan_id', 'instansi_id'], 'integer'],
            [['nama_pemegang', 'jenis_kelamin', 'email', 'jabatan', 'alamat', 'no_telp', 'namafile'], 'safe'],
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
        $query = Pemegang::find();

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
            'id_pemegang' => $this->id_pemegang,
            'nip_pemegang' => $this->nip_pemegang,
            'golongan_id' => $this->golongan_id,
            'instansi_id' => (Yii::$app->user->identity->level != 'administrator' ? Yii::$app->user->identity->instansi:$this->instansi_id),
        ]);

        $query->andFilterWhere(['like', 'nama_pemegang', $this->nama_pemegang])
            ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'namafile', $this->namafile]);

        if(Yii::$app->user->identity->level != 'administrator'){
            $query->orFilterWhere(['in', 'instansi_id', $s]);
        }

        return $dataProvider;
    }
}
