<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Wiki', 'url' => ['/wiki/index'], "items" => [
            ['label' => 'Главная', 'url' => ['/wiki/index']],
            ['label' => 'Настройка AuthProvider', 'url' => ['/wiki/page', 'page' => 'authprovider']],
            ['label' => 'Настройка AuthHandler', 'url' => ['/wiki/page', 'page' => 'authhandler']],
            ['label' => 'Настройка ServerWrapper', 'url' => ['/wiki/page', 'page' => 'serverwrapper']],
            ['label' => 'Настройка ProtectHandler', 'url' => ['/wiki/page', 'page' => 'protecthandler']],
            ['label' => 'Настройка профиля', 'url' => ['/wiki/page', 'page' => 'profile']],
            ['label' => 'Проксирование/Netty', 'url' => ['/wiki/page', 'page' => 'nettyconfig']],
            ['label' => 'Сборка клиента', 'url' => ['/wiki/page', 'page' => 'clientbuild']],
            ['label' => 'Написание модулей', 'url' => ['/wiki/page', 'page' => 'modules']],
            ['label' => 'Hibernate', 'url' => ['/wiki/page', 'page' => 'hibernate']],
	        ['label' => 'Подпись лаунчера', 'url' => ['/wiki/page', 'page' => 'signlauncher']],
	]
        ],
        ['label' => 'О нас', 'url' => ['/site/about']],
    ];
    if (Yii::$app->user->isGuest) {
        
    } else {
        $menuItems[] = ['label' => 'Личный кабинет', 'url' => ['/cabinet/index']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
