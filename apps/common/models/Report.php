<?php

namespace common\models;

use Yii;
use yii\db\Query;

class Report
{
    /**
     * Ambil daftar instansi yang boleh dilihat
     */
    private function getInstansiFilter($instansi)
    {
        if ((int) $instansi === 0) {
            return Instansi::find()->select('id_instansi')->column();
        }

        $ids = [$instansi];

        $child = Instansi::find()
            ->select('id_instansi')
            ->where(['parent_id' => $instansi])
            ->column();

        if (!empty($child)) {
            $ids = array_merge($ids, $child);
        }

        return $ids;
    }

    public function arrayAll($model)
    {
        $instansiIds = $this->getInstansiFilter($model->instansi);

        return (new Query())
            ->select([
                'u.jenis_id',
                'u.merk_id',
                'u.type_id',
                'u.isi_silinder',
                'u.tahun_pembelian',
                'u.kondisi_id',
                'u.harga_pembelian',
                'u.nomor_rangka',
                'u.nomor_mesin',
                'u.nomor_polisi',
                'u.nomor_bpkb',
                'u.pemegang_id',
                'u.keterangan',
                'p.jenis_barang',
                'q.nama_merk',
                'r.nama_type',
                's.nama_pemegang',
                'k.kondisi AS kondisi'
            ])
            ->from('kendaraan u')
            ->leftJoin('jenis_barang p', 'u.jenis_id=p.id_jenis_barang')
            ->leftJoin('merk q', 'u.merk_id=q.id_merek')
            ->leftJoin('type r', 'u.type_id=r.id_type')
            ->leftJoin('pemegang s', 'u.pemegang_id=s.id_pemegang')
            ->leftJoin('kondisi k', 'u.kondisi_id=k.id_kondisi')
            ->where(['IN', 'u.instansi_id', $instansiIds])
            ->orderBy([
                'u.jenis_id' => SORT_ASC,
                'u.tahun_pembelian' => SORT_ASC
            ])
            ->all();
    }

    public function arrayKondisi($model)
    {
        $instansiIds = $this->getInstansiFilter($model->instansi);

        return (new Query())
            ->select([
                'u.jenis_id',
                'u.merk_id',
                'u.type_id',
                'u.isi_silinder',
                'u.tahun_pembelian',
                'u.nomor_rangka',
                'u.nomor_mesin',
                'u.nomor_polisi',
                'u.nomor_bpkb',
                'u.pemegang_id',
                'p.jenis_barang',
                'q.nama_merk',
                'r.nama_type',
                's.nama_pemegang'
            ])
            ->from('kendaraan u')
            ->leftJoin('jenis_barang p', 'u.jenis_id=p.id_jenis_barang')
            ->leftJoin('merk q', 'u.merk_id=q.id_merek')
            ->leftJoin('type r', 'u.type_id=r.id_type')
            ->leftJoin('pemegang s', 'u.pemegang_id=s.id_pemegang')
            ->where(['IN', 'u.instansi_id', $instansiIds])
            ->groupBy('u.type_id')
            ->orderBy([
                'u.jenis_id' => SORT_ASC,
                'u.tahun_pembelian' => SORT_ASC
            ])
            ->all();
    }

    public function arrayBulanan($model)
    {
        $tglAwal = new \DateTime($model->tahun . '-' . $model->bulan . '-01');
        $tglAkhir = new \DateTime($tglAwal->format('Y-m-t'));

        $data = [];

        for ($x = $tglAwal; $x <= $tglAkhir; $x->modify('+1 day')) {
            $data[] = clone $x;
        }

        return $data;
    }

    public function arrayPajak($model)
    {
        $instansiIds = $this->getInstansiFilter($model->instansi);

        return (new Query())
            ->select([
                'u.kendaraan_id',
                'u.tanggal_bayar',
                'u.jumlah_bayar',
                'u.tanggal_expired',
                'p.nomor_mesin',
                'p.nomor_polisi',
                'q.jenis_barang',
                'r.nama_merk',
                's.nama_pemegang',
                't.nama_type'
            ])
            ->from('riwayat_pajak u')
            ->leftJoin('kendaraan p', 'u.kendaraan_id=p.id_kendaraan')
            ->leftJoin('jenis_barang q', 'p.jenis_id=q.id_jenis_barang')
            ->leftJoin('merk r', 'p.merk_id=r.id_merek')
            ->leftJoin('pemegang s', 'p.pemegang_id=s.id_pemegang')
            ->leftJoin('type t', 'p.type_id=t.id_type')
            ->where(['IN', 'u.instansi_id', $instansiIds])
            ->orderBy([
                'u.tanggal_expired' => SORT_ASC
            ])
            ->all();
    }

    public function arrayPerawatan($model)
    {
        $instansiIds = $this->getInstansiFilter($model->instansi);

        return (new Query())
            ->select([
                'u.kendaraan_id',
                'u.bbm_id',
                'u.tanggal',
                'u.rekanan',
                'u.jumlah_liter',
                'u.jumlah_kilometer',
                'u.total_biaya',
                'u.keterangan',
                'u.lampiran',
                'u.instansi_id',
                'p.nomor_mesin',
                'p.nomor_polisi',
                'q.jenis_barang',
                'r.nama_merk',
                's.nama_pemegang',
                't.nama_type',
                'w.jenis_bbm'
            ])
            ->from('perawatan u')
            ->leftJoin('kendaraan p', 'u.kendaraan_id=p.id_kendaraan')
            ->leftJoin('jenis_barang q', 'p.jenis_id=q.id_jenis_barang')
            ->leftJoin('merk r', 'p.merk_id=r.id_merek')
            ->leftJoin('pemegang s', 'p.pemegang_id=s.id_pemegang')
            ->leftJoin('type t', 'p.type_id=t.id_type')
            ->leftJoin('jenis_bbm w', 'u.bbm_id=w.id_bbm')
            ->where(['IN', 'u.instansi_id', $instansiIds])
            ->orderBy([
                'u.tanggal' => SORT_ASC
            ])
            ->all();
    }
}