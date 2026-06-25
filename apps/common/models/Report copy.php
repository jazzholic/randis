<?php

namespace common\models;

use Yii;
use yii\db\Query;
use common\models\Kendaraan;


/**
 * Description of Report 
 *
 * @author Iwan Susyanto
 */
class Report {
    //put your code here
    public function arrayAll($model) {

        $instansi = $model->instansi;

        if(Yii::$app->user->identity->level !='administrator'){

            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }
        }else{
            $s = [];
        }
                   
        $allModels = (new Query())->select(['u.jenis_id','u.merk_id','u.type_id','u.isi_silinder','u.tahun_pembelian','u.nomor_rangka','u.nomor_mesin','u.nomor_polisi','u.nomor_bpkb','u.pemegang_id','p.jenis_barang','q.nama_merk','r.nama_type','s.nama_pemegang'])
            ->from('kendaraan u')
            ->leftJoin('jenis_barang p','u.jenis_id=p.id_jenis_barang')
            ->leftJoin('merk q','u.merk_id=q.id_merek')
            ->leftJoin('type r','u.type_id=r.id_type')
            ->leftJoin('pemegang s','u.pemegang_id=s.id_pemegang')
            ->leftJoin('instansi t','u.instansi_id=t.id_instansi')
            ->where(['u.instansi_id'=>$instansi])
            ->orWhere(['IN','u.instansi_id',$s])
            //->addParams([':instansi'=>$model->instansi_id])
            ->orderBy(['u.jenis_id' => SORT_ASC,'u.tahun_pembelian'=>SORT_ASC])
            ->all();
              
        return $allModels;   
    }

    public function arrayKondisi($model) {

        $instansi = $model->instansi;

        if(Yii::$app->user->identity->level !='administrator'){

            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }
        }else{
            $s = [];
        }
                   
        $allModels = (new Query())->select(['u.jenis_id','u.merk_id','u.type_id','u.isi_silinder','u.tahun_pembelian','u.nomor_rangka','u.nomor_mesin','u.nomor_polisi','u.nomor_bpkb','u.pemegang_id','p.jenis_barang','q.nama_merk','r.nama_type','s.nama_pemegang'])
            ->from('kendaraan u')
            ->leftJoin('jenis_barang p','u.jenis_id=p.id_jenis_barang')
            ->leftJoin('merk q','u.merk_id=q.id_merek')
            ->leftJoin('type r','u.type_id=r.id_type')
            ->leftJoin('pemegang s','u.pemegang_id=s.id_pemegang')
            ->leftJoin('instansi t','u.instansi_id=t.id_instansi')
            ->where(['u.instansi_id'=>$instansi])
            ->orWhere(['IN','u.instansi_id',$s])
            ->groupBy('u.type_id')
            ->orderBy(['u.jenis_id' => SORT_ASC,'u.tahun_pembelian'=>SORT_ASC])
            ->all();
              
        return $allModels;   
    }

    public function arrayBulanan($model) {
                
        $tglAwal  = new \DateTime($model->tahun.'-'.$model->bulan.'-01');        

        $tglAkhir = new \DateTime($tglAwal->format( 'Y-m-t' ));   
                
        $data = [];
        for($x = $tglAwal; $x <= $tglAkhir; $x->modify('+1 day')) {

            $data[] = $x;
            
        }
        return $data;
    }

    public function arrayPajak($model) {

        $instansi = $model->instansi;

        if(Yii::$app->user->identity->level !='administrator'){

            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }
        }else{
            $s = [];
        }
                   
        $allModels = (new Query())->select(['u.kendaraan_id','u.tanggal_bayar','u.jumlah_bayar','u.tanggal_expired','p.nomor_mesin','p.nomor_polisi','q.jenis_barang','r.nama_merk','s.nama_pemegang','t.nama_type'])
            ->from('riwayat_pajak u')
            ->leftJoin('kendaraan p','u.kendaraan_id=p.id_kendaraan')
            ->leftJoin('jenis_barang q','p.jenis_id=q.id_jenis_barang')
            ->leftJoin('merk r','p.merk_id=r.id_merek')            
            ->leftJoin('pemegang s','p.pemegang_id=s.id_pemegang')
            ->leftJoin('type t','p.type_id=t.id_type')
            ->leftJoin('instansi v','u.instansi_id=v.id_instansi')
            ->where(['u.instansi_id'=>$instansi])
            ->orWhere(['IN','u.instansi_id',$s])
            ->orderBy(['u.tanggal_expired' => SORT_ASC])
            ->all();
              
        return $allModels;   
    }

    public function arrayPerawatan($model) {

        $instansi = $model->instansi;

        if(Yii::$app->user->identity->level !='administrator'){

            $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$instansi])->all();
            $s = [];
            foreach ($r as $key) {
                $s[] = $key['id_instansi'];
            }
        }else{
            $s = [];
        }
                   
        $asllModels = \common\models\Perawatan::find()
            ->where(['instansi_id'=>$instansi])
            ->orderBy(['tanggal' => SORT_ASC])
            ->all();

        $allModels = (new Query())->select(['u.kendaraan_id','u.bbm_id','u.tanggal','u.rekanan','u.jumlah_liter','u.jumlah_kilometer','u.total_biaya','u.keterangan','u.lampiran','p.nomor_mesin','p.nomor_polisi','q.jenis_barang','r.nama_merk','s.nama_pemegang','t.nama_type','w.jenis_bbm'])
            ->from('perawatan u')
            ->leftJoin('kendaraan p','u.kendaraan_id=p.id_kendaraan')
            ->leftJoin('jenis_barang q','p.jenis_id=q.id_jenis_barang')
            ->leftJoin('merk r','p.merk_id=r.id_merek')            
            ->leftJoin('pemegang s','p.pemegang_id=s.id_pemegang')
            ->leftJoin('type t','p.type_id=t.id_type')
            ->leftJoin('instansi v','u.instansi_id=v.id_instansi')
            ->leftJoin('jenis_bbm w','u.bbm_id=w.id_bbm')
            ->where(['u.instansi_id'=>$instansi])
            ->orWhere(['IN','u.instansi_id',$s])
            ->orderBy(['u.tanggal' => SORT_ASC])
            ->all();
              
        return $allModels;   
    }
}