<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ThreadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Thread list');
?>
<div class="thread-index threads_list">

    <div class="row">
        <div class="col-sm-9">
            <?= $this->render('_search', ['model' => $searchModel]) ?>
        </div>

        <?php if (!Yii::$app->user->isGuest) { ?>
            <div class="col-sm-3 text-right">
                <?= Html::a(Yii::t('app', 'Create Thread'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_thread.php',
        'layout' => '{pager}{summary}{items}',
    ]); ?>
</div>
