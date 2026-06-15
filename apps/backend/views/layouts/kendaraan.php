<?php

use backend\assets\KendaraanAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

KendaraanAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        body{
            background-size: cover;
            background-position: center;
            background-image: url("<?= Yii::$app->request->baseUrl ?>/img/lombok.jpg");
            background-color: #cccccc; 
            background-repeat: no-repeat;
            background-attachment: fixed; 
        }
    </style>
    
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body>
<?php $this->beginBody() ?>
<section class="content">
<?= $content ?>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>