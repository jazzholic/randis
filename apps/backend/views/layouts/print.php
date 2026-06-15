<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\PrintAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

PrintAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= Yii::$app->request->baseUrl ?>/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        *{
            margin:0;padding:0;
        }
        body{
            font-family:arial,tahoma,verdana;
            font-size:12px;
        }
        .page-header {
            margin: 0 auto;
            padding: 0 auto;
            text-align: center;
            margin-bottom: 20px;
        }
        
        table.data{
            margin: 1%;
            width:98%;
            border-collapse:collapse;
        }
        div.status {
            margin: 1%;
        }
        td{
            font-size:12px;   
        }
        table.data, table.data td, table.data th {
            border: 1px solid #000;
        }
        td, th {
            padding: 5px;
        }
        th {
            font-size: 12px;
        }
        #print {
            padding: 5px;
        }
        @media print {
            #print {
                display: none;
            }
        }
        table.noborder {
            border:none;
        }
        table.noborder th, table.noborder td {
            border: none;
        }

        span.block {
            width: 10px;
            height: 10px;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 5px 0 0;
            border: 1px solid #222;
        }
    </style>

</head>
<body onload="window.print();">
<?php $this->beginBody() ?>
<div class="wrapper">
    <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>