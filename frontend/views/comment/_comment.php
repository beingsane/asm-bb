<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
?>
<div class="thread-comment-view">

    <div class="post">
        <div class="search_info">
            <img class="unread_icon" src="/images/onepost.svg"/>

            <?= Html::a(Html::encode($model->user->username), ['site/user-profile', 'username' => $model->user->username],
                ['class' => 'user_name']
            ) ?>

            <div class="center">
                <img class="smallavatar" src="/images/anon.png">
            </div>

            <div class="changed" style="margin-left: 8px">
                <img src="/images/edit.svg" width="16" height="16" alt="#"/>
                <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
            </div>
        </div>

        <div class="post_thread">
            <?= Yii::t('app', 'Thread:') ?>
            <?= Html::a(Html::encode($model->thread->name), ['thread/view', 'id' => $model->thread_id]) ?>
            <?= Yii::t('app', 'Post:') ?>
            <?= Html::a(Html::encode('#' . $model->id), ['thread/view', 'id' => $model->thread_id, '#' => $model->id]) ?>
        </div>

        <div class="post_sum">
            <div class="post_text">
                <?= $model->html() ?>
            </div>

            <div class="post_link">
                <?= Html::a(Html::encode(Yii::t('app', 'read more...')), ['thread/view', 'id' => $model->thread_id, '#' => $model->id]) ?>
            </div>
        </div>

    </div>

</div>
