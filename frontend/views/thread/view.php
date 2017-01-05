<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Thread */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Threads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thread-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.username',
            'name',
            'created_at',
        ],
    ]) ?>

    <br><br>

    <?= ListView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getComments()]),
        'itemView' => '_comment.php',
    ]); ?>

</div>
