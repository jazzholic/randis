<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= Yii::$app->request->baseUrl ?>/img/favicon.ico" type="image/x-icon">
</head>
<body class="hold-transition skin-green sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render('header.php') ?>

        <?= $this->render('left.php')   ?>

        <?= $this->render('content.php',['content' => $content]) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>