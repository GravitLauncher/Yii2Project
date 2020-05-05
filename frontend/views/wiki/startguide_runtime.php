<?php

/* @var $this yii\web\View */

$this->title = 'Начало работы: Установка Runtime';
$this->params['breadcrumbs'][] = "Runtime";
?>
<h2><a name="runtime_guide"></a>Сборка лаунчера на 5.1.0+ <div class="gtag gtag-important">Важно</div></h2>
<p>Если вы соберете лаунчер командой build сразу после настройки лаунчсервера - вы можете получить ошибку "GUI часть лаунчера не найдена"</p>
<p>Это происходит потому, что начиная с 5.1.0 рантайм(GUI часть лаунчера) отделена от самого лаунчера и находится в отдельном репозитории.<br>
<b>Ссылка на репозиторий рантайма</b>: <a href="https://github.com/GravitLauncher/LauncherRuntime">GitHub</a><br>
<p><b>Для ветки dev лаунчсервера используется ветка dev рантайма. Для ветки master лаунчесрвера используется ветка master рантайма</b></p>
<b>Ссылка на CI рантайма</b>: <a href="https://github.com/GravitLauncher/LauncherRuntime/actions">GitHub Actions</a><br>
<b>Если вы не можете скачать файлы с GitHub Actions войдите/зарегистрируйтесь на GitHub либо скачайте из раздела релизов</b><br>
Инструкция по установке нового рантайма:</p>
<ol>
<li>Скачайте последний билд рантайма с GitHub actions или GitHub releases по ссылкам выше. Вы должны получить runtime.zip, содержащий дизайн и локализацию(fxml/css/png/runtime_**.properties) и JavaRuntime-xxxx.jar, содержащий код отображения этого дизайна и взаимодействия с пользователем.</li>
<li>Скопируйте содержимое архива runtime.zip с css/fxml/png в папку runtime лаунчсервера</li>
<li>Установите модуль LauncherModuleLoader_module на лаунчсервер в папку modules (<b>только для версий от 5.1.0 до 5.1.3</b>, на версиях 5.1.4+ этот модуль встроен)</li>
<li>Скопируйте файл JavaRuntime-xxxx.jar в папку launcher-modules(если её нет - создайте)</li>
<li>Перезапустите лаунчсервер и пропишите build</li>
<li>Убедитесь, что сборка прошла без ошибок и лаунчер успешно запускается и отображает GUI</li>
</ol>
