<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\LoginaAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
LoginaAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::$app->request->baseUrl ?>/img/favicon.png" type="image/x-icon">
    <link rel="icon" href="<?= Yii::$app->request->baseUrl ?>/img/favicon.png" type="image/x-icon">   
    <!-- open sans font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400italic,700italic,400,700" rel="stylesheet" type="text/css">
    <style>
        body{
            background-size: cover;
            background-position: center;
            background-image: url("<?= Yii::$app->request->baseUrl ?>/img/bg.jpg");
            background-color: #cccccc;  
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>