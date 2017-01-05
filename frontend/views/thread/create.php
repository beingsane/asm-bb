<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Thread */
/* @var $newCommentModel common\models\Comment */

$this->title = Yii::t('app', 'Create Thread');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Threads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thread-create content-block">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'newCommentModel' => $newCommentModel,
    ]) ?>

</div>
