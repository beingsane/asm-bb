<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Thread */
/* @var $newCommentModel common\models\Comment */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Thread list'), 'url' => ['index']];
?>
<div class="thread-view thread">

    <h1 class="thread_caption"><?= Html::encode($this->title) ?></h1>

    <br>

    <?= ListView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $model->getComments()]),
        'itemView' => '_comment.php',
        'emptyText' => Yii::t('app', 'No comments found'),
        'layout' => '{pager}{summary}{items}{pager}',
    ]); ?>

    <br><br>

</div>

<?php if (!Yii::$app->user->isGuest) { ?>
    <?= $this->render('_commentForm', ['model' => $newCommentModel]) ?>
<?php } ?>
