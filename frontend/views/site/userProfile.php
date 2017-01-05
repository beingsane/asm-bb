<?php

/* @var $this yii\web\View */
/* @var $user \common\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;

?>

<div class="site-user-profile content-block">

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h1><?= Yii::t('app', 'User info:') ?></h1>
            <?= DetailView::widget([
                'model' => $user,
                'attributes' => [
                    'id',
                    'username',
                    'created_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>
