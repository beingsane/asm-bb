<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
?>
<div class="thread-comment-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'thread_id',
            'user_id',
            'text:ntext',
            'created_at',
        ],
    ]) ?>

</div>
