<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search results');
?>
<div class="comment-index content-block">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_comment.php',
        'emptyText' => Yii::t('app', 'No results found'),
        'layout' => '{pager}{summary}{items}{pager}',
    ]) ?>
</div>
