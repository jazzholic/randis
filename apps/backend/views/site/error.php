<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$a = substr($statusCode,0,1);
$b = substr($statusCode,1,1);
$c = substr($statusCode,2,1);
?>   

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h3><?= nl2br(Html::encode($message)) ?></h3>
                <h1><span><?=$a?></span><span><?=$b?></span><span><?=$c?></span></h1>

            </div>
            <h2>Please contact Administrator if you think this is a server error. Thank you.</h2>
        </div>
    </div>