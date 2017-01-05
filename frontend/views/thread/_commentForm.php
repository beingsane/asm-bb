<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form new_editor">

    <?php $form = ActiveForm::begin(['id' => 'editform']); ?>

    <?= Html::activeHiddenInput($model, 'thread_id') ?>

    <p><?= Yii::t('app', 'Post content:') ?></p>
    <?= $form->field($model, 'text')->textarea(['rows' => 6, 'class' => 'editor'])->label(false) ?>

    <div class="panel">
        <?= Html::submitButton(Yii::t('app', 'Submit')) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
