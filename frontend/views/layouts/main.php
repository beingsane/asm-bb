<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\models\CommentSearch;
use common\widgets\Alert;
use common\models\ThreadTag;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <link rel="stylesheet" href="/css/all.css">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#d80027">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicons/mstile-144x144.png">
    <meta name="theme-color" content="#d80027">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

        <div class="header">
            <div class="login_interface">
                <?php if (Yii::$app->user->isGuest) { ?>
                    <a href="<?= Url::to(['site/login']) ?>">Login</a><br>
                    <a href="<?= Url::to(['site/signup']) ?>">Register</a>
                <?php } else { ?>
                    <?= Yii::$app->user->identity->username ?> |
                    <a href="<?= Url::to(['site/logout']) ?>" data-method="POST">
                        Logout (<?= Html::encode(Yii::$app->user->identity->username) ?>)
                    </a><br>
                    <a href="<?= Url::to(['site/user-profile']) ?>">User profile</a>
                <?php } ?>
            </div>


            <?php
                $commentSearch = new CommentSearch();
                $commentSearch->load(Yii::$app->request->get());
            ?>
            <form class="tags" id="search_form" action="<?= Url::to(['comment/index']) ?>" method="get">
                <input class="search_line" type="edit" size="40"
                    name="CommentSearch[text]"
                    placeholder="<?= Html::encode(Yii::t('app', 'Search')) ?>"
                    value="<?= Html::encode($commentSearch->text) ?>"
                /><img class="icon_btn" src="/images/search.svg" alt="?"/>
            </form>

            <h1>AsmBB demo</h1>
        </div>

        <div class="tags">
            <a class="taglink" title="Show all threads" href="<?= Yii::$app->homeUrl ?>">
                <img src="/images/posts.svg" alt="All"/>
            </a>
            <?php
                $tags = ThreadTag::getTagsCountInfo();
                $maxCount = 0;
                foreach ($tags as $tag) {
                    if ($tag['thread_count'] > $maxCount) {
                        $maxCount = $tag['thread_count'];
                    }
                }
                if ($maxCount == 0) $maxCount = 1;

                foreach ($tags as $tag) {
                    $fontSize = $tag['thread_count'] * 100 / $maxCount;
                    if ($fontSize <= 30) $fontSize = 30;

                    echo Html::a(Html::encode($tag['name']), ['thread/index', 'ThreadSearch[tag]' => $tag['name']],
                        [
                            'class' => 'taglink',
                            'style' => 'font-size: ' . $fontSize . '%',
                            'title' => Yii::t('app', '{count, number} {count, plural, =1{thread} other{threads}}', ['count' => $tag['thread_count']]),
                        ]
                    );
                }
            ?>
        </div>


    <div class="content-block">
        <?php if (isset($this->params['breadcrumbs'])) { ?>
            <div class="ui">
                <?php
                    foreach ($this->params['breadcrumbs'] as $breadcrumb) {
                        if (is_string($breadcrumb)) {
                            $label = $breadcrumb;
                            $url = null;
                        } else {
                            $label = $breadcrumb['label'];
                            $url = $breadcrumb['url'];
                        }
                        echo Html::a(Html::encode($label), $url, ['class' => 'ui', 'style' => 'color: white']);
                    }
                ?>
            </div>
        <?php } ?>

        <?= Alert::widget() ?>
    </div>

    <?= $content ?>
</div>


<footer class="footer">
    <div class="content-block clearfix">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
