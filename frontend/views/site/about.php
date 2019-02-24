<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Мы - некоммерческая группа программистов, развивающая в свободное время свои проекты</p>

    <p>Наш главный продукт GravitLauncher - Лучший лаунчер Minecraft, находящийся в свободном доступе</p>

    <code><?= __FILE__ ?></code>
</div>
