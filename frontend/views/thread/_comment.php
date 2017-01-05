<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
?>
<div class="thread-comment-view">
    <a id="<?= $model->id ?>"></a>

    <div class="post">
        <div class="user_info">
            <img class="unread_icon" src="<?= Yii::$app->homeUrl ?>images/onepost.svg">

            <?= Html::a(Html::encode($model->user->username), ['site/user-profile', 'username' => $model->user->username],
                ['class' => 'user_name']
            ) ?>

            <div class="center">
                <img class="avatar" src="<?= Yii::$app->homeUrl ?>images/anon.png">
            </div>

            <div class="user_pcnt">
                <?= Yii::t('app', 'Posts: {count}', ['count' => $model->user->getComments()->count()]) ?>
            </div>
        </div>

        <div class="post_info">
            <a href="#<?= $model->id ?>">#<?= $model->id ?></a>
            <?= Yii::t('app', 'Last edited:') ?> <?= Yii::$app->formatter->asDatetime($model->created_at) ?>,
            <?= Yii::t('app', 'read:') ?> <?= Yii::t('app', '{count, number} {count, plural, =1{time} other{times}}', ['count' => 0]) ?>
        </div>

        <div class="post_text">
            <?= $model->html() ?>
        </div>
    </div>
</div>
