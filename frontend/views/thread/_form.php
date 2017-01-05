<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Thread */
/* @var $newCommentModel common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thread-form new_editor">

    <?php $form = ActiveForm::begin(['id' => 'editform']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= Html::activeHiddenInput($newCommentModel, 'thread_id') ?>

    <p><?= Yii::t('app', 'Post content:') ?></p>
    <?= $form->field($newCommentModel, 'text')->textarea(['rows' => 6, 'class' => 'editor'])->label(false) ?>


    <?php $tags = implode(', ', ArrayHelper::getColumn($model->tags, 'name')); ?>
    <?= $form->field($model, 'tagString')->textInput() ?>

    <div class="panel">
        <?= Html::submitButton(Yii::t('app', 'Submit')) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
