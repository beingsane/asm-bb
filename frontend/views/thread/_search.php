<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ThreadSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thread-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->label(false)->textInput(['placeholder' => Yii::t('app', 'Thread name')]) ?>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
