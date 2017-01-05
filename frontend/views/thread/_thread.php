<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Thread */

$commentsCount = $model->getComments()->count();
?>
<div class="thread-view">

    <div class="thread_summary">
        <div class="thread_info">

            <div class="post_cnt">
                <?= Yii::t('app', '{count, number} {count, plural, =1{post} other{posts}}', ['count' => $commentsCount]) ?>
            </div>

            <div class="changed">
                <img src="/images/edit.svg" width="16" height="16" alt="#"/>
                <?= Yii::$app->formatter->asDateTime(
                    $commentsCount > 0
                        ? $model->getComments()->orderBy(['created_at' => SORT_DESC])->limit(1)->one()->created_at
                        : $model->created_at
                ) ?>
            </div>
        </div>

        <div class="thread_link">
            <?= Html::a(Html::encode($model->name), ['thread/view', 'id' => $model->id]) ?>
            <br>

            <span class="small">
                <?= Yii::t('app', 'started by:') ?>
                <b>
                    <?= Html::a(Html::encode($model->user->username), ['site/user-profile', 'username' => $model->user->username]) ?>
                </b>

                <br>

                <?php
                    if (count($model->joinedUsers)) {
                        echo Yii::t('app', 'joined:') . ' ';
                        foreach ($model->joinedUsers as $user) {
                            echo Html::a(Html::encode($user->username), ['site/user-profile', 'username' => $user->username]);
                        }
                    }
                ?>
            </span>
        </div>

        <div class="thread_tags">
            <?php
                if (count($model->tags)) {
                    echo Yii::t('app', 'Tags:') . ' ';
                    $links = [];
                    foreach ($model->tags as $tag) {
                        $links[] = Html::a(Html::encode($tag->name), ['thread/index', 'ThreadSearch[tag]' => $tag->name]);
                    }
                    echo implode(', ', $links);
                }
            ?>
        </div>
    </div>


</div>
