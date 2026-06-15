<?php

use yii\web\JsExpression;
use miloschuman\highcharts\Highcharts;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
CrudAsset::register($this);

$this->title = 'Selamat Datang';
$this->params['breadcrumbs'][] = $this->title;
function datetimes($tgl,$Jam=false){

    $tanggal   = strtotime($tgl);
    $bln_array = array (
        '01'=>'Januari',
        '02'=>'Februari',
        '03'=>'Maret',
        '04'=>'April',
        '05'=>'Mei',
        '06'=>'Juni',
        '07'=>'Juli',
        '08'=>'Agustus',
        '09'=>'September',
        '10'=>'Oktober',
        '11'=>'November',
        '12'=>'Desember'
    );
    $hari_arr = Array ( 
        '0'=>'Minggu',
        '1'=>'Senin',
        '2'=>'Selasa',
        '3'=>'Rabu',
        '4'=>'Kamis',
        '5'=>'Jum`at',
        '6'=>'Sabtu'
    );
    $hari = @$hari_arr[date('w',$tanggal)];
    $tggl = date('j',$tanggal);
    $bln  = @$bln_array[date('m',$tanggal)];
    $thn  = date('Y',$tanggal);
    $jam  = $Jam ? date ('H:i:s',$tanggal) : '';

    return '<h2 style="margin-top: 10px;">'.$hari.'</h2><div>'.$tggl.' '.$bln.' '.$thn.'</div>';        
}
if(Yii::$app->user->identity->level != 'administrator') {
  $instansi  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>Yii::$app->user->identity->instansi])->all();
  $a = [];
  foreach ($instansi as $key) {
    $a[] = $key['id_instansi'];
  }

  $kendaraan = \common\models\Kendaraan::find()->where(['instansi_id'=>Yii::$app->user->identity->instansi])->orWhere(['in', 'instansi_id',$a])->count();

  $pemegang  = \common\models\Pemegang::find()->where(['instansi_id'=>Yii::$app->user->identity->instansi])->orWhere(['in','instansi_id',$a])->count();

  $statistik = common\models\Kendaraan::find()->where(['kondisi_id'=> 1])->andWhere(['instansi_id'=>Yii::$app->user->identity->instansi])->orWhere(['in','instansi_id',$a])->count();

}else{
  $kendaraan = \common\models\Kendaraan::find()->count();

  $pemegang = \common\models\Pemegang::find()->count();

  $statistik = common\models\Kendaraan::find()->where(['kondisi_id'=> 1])->count();
}
?>


<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=$kendaraan?></h3>
                <p>Data Kendaraan</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-car"></i>
            </div>
            <a href="#" class="small-box-footer">Kota Mataram <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=$pemegang?></h3>
                <p>Pemegang Kendaraan</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-contacts"></i>
            </div>
            <a href="#" class="small-box-footer">Kota Mataram <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?=$statistik?></h3>
              <p>Data Kendaraan Baik</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-checkmark-circle"></i>
            </div>
            <a href="#" class="small-box-footer">Kota Mataram <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?=common\models\Log::find()->where(['logout'=>'0000-00-00 00:00:00'])->count()?></h3>
                <p>User Online</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-radio"></i>
            </div>
            <a href="#" class="small-box-footer">Kota Mataram <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-md-8">
      <?php Pjax::begin(['id' => 'kendaraan']) ?>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa  fa-car text-maroon"></i> Data Kendaraan Terbaru</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Nomor Polisi</th>
                  <th>Merk</th>
                  <th>Type</th>
                  <th>Pemegang</th>
                </tr>
                <?php 
                if(isset($_GET['page'])){
                  $i = ((int) $_GET['page'] -1)*8+1;
                }else{
                  $i = 1; 
                }
                
                foreach ($model as $key) {
                ?>
                <tr>
                  <td><?=$i?></td>
                  <td><?=$key['nomor_polisi']?></td>
                  <td><?=$key['merk']['nama_merk']?></td>
                  <td><?=$key['type']['nama_type']?></td>
                  <td><?=$key['pemegang']['nama_pemegang']?></td>
                </tr>
              <?php $i++;}?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <?php
              // display pagination
              echo LinkPager::widget([
                  'pagination' => $pages,
              ]);
              ?>
            </div>
          </div>
        <?php Pjax::end() ?>
    </div>
    <div class="col-md-4">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-area-chart text-green"></i> Statistik Kondisi Kendaraan</h3>
        </div>
        <div class="box-body">
          <?php
          $kondisis = \common\models\Kondisi::find()->select(['id_kondisi','kondisi' ])->asArray()->all();

          $kondisi  = [];
          $series = [];
          foreach( $kondisis as $value){
            if(Yii::$app->user->identity->level != 'administrator') {

              $r  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>Yii::$app->user->identity->instansi])->all();
              $s = [];
              foreach ($r as $key) {
                $s[] = $key['id_instansi'];
              }
              $jumlah = common\models\Kendaraan::find()->where(['instansi_id'=>Yii::$app->user->identity->instansi])->orWhere(['in','instansi_id',$s])->andWhere(['kondisi_id'=>$value['id_kondisi']])->count();

              $instansis = \common\models\Instansi::find()->select(['id_instansi','nama_instansi' ])->andWhere(['id_instansi'=>Yii::$app->user->identity->instansi])->orWhere(['in','id_instansi',$s])->asArray()->all();
            }else{
              $jumlah = common\models\Kendaraan::find()->where(['kondisi_id'=>$value['id_kondisi']])->count();

              $instansis = \common\models\Instansi::find()->select(['id_instansi','nama_instansi' ])->asArray()->all();
            }

            $count = [];
            foreach ($instansis as $key) {

              $p  = \common\models\Instansi::find()->select(['id_instansi' ])->where(['parent_id'=>$key['id_instansi']])->all();
              $q = [];
              foreach ($p as $key) {
                $q[] = $key['id_instansi'];
              }

              $jml = common\models\Kendaraan::find()->where(['instansi_id'=>$key['id_instansi']])->orWhere(['in','instansi_id',$q])->andWhere(['kondisi_id'=>$value['id_kondisi']])->all();
                
              $count[] = [$key['nama_instansi'], count($jml)*1];
              
            }
            $kondisi[] = ['name'=>$value['kondisi'], 'y'=>$jumlah*1, 'drilldown'=>$value['kondisi']];

            $series[] = ['name'=>$value['kondisi'], 'id'=>$value['kondisi'], 'data'=>$count];
          }
          //print_r($jumlah);
          // Create the chart
          echo Highcharts::widget([
            'scripts' => [
              'modules/drilldown', // in fact, this is mandatory :)
              'modules/exporting', // adds Exporting button/menu to chart
            ],
            'options' => [
              'chart'=> [
                  'type'=> 'column'
              ],
              'title'=> [
                  'text'=> ''
              ],
              'subtitle'=> [
                  'text'=> ''
              ],
              'xAxis'=> [
                  'type'=> 'category'
              ],
              'yAxis'=> [
                  'title'=> [
                      'text'=> 'Jumlah'
                  ]

              ],
              'legend'=> [
                  'enabled'=> false
              ],
              'plotOptions'=> [
                  'series'=> [
                      'borderWidth'=> 0,
                      'dataLabels'=> [
                          'enabled'=> true,
                          'format'=> '{point.y:.0f}'
                      ]
                  ]
              ],

              'tooltip'=> [
                  'headerFormat'=> '<span style="font-size:11px">{series.name}</span><br>',
                  'pointFormat'=> '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
              ],

              'series'=> [
                [
                  'name'=> 'Kondisi',
                  'colorByPoint'=> true,
                  'data'=> $kondisi,
              ]],
              'drilldown'=> [
                  'series'=> $series,
              ]
            ]
          ]);
          ?>
        </div>
      </div>
    </div>
</div>
<?php Modal::begin([
    'options' => [
        'id' => 'ajaxCrudModal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'footer' => '',// always need it for jquery plugin
    'size' => 'modal-lg'
])?>
<?php Modal::end(); ?>