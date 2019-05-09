<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:49
 */
$this->title = 'HWIDHandler - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Modify Runtime";
?>
<h2>Создание своего дизайна в JavaFX Scene Builder</h2>
<p>Дизайн задается набором fxml и css файлов. В 5.0 были добавлены библиотеки, без которых попытка открыть fxml в JavaFX Scene Builder закончится неудачей</p>
<ul>
    <li>Подключите библиотеки fontawesomefx-8.9(<a href="https://mvnrepository.com/artifact/de.jensd/fontawesomefx">maven</a>) и jfoenix-8.0.8(<a href="https://mvnrepository.com/artifact/com.jfoenix/jfoenix">maven</a>)</li>
    <li>Взять нужный билд scenebuilder а именно 8.5.0  <a href="https://gluonhq.com/products/scene-builder/">отсюда</a></li>
</ul>
<p>Подключение библиотек к JavaFX Scene Builder (screenshot by DrLeonardo)</p>
<img src="https://media.discordapp.net/attachments/478146720790741012/571717423586082847/unknown.png?width=582&height=474">
<h2>Структура runtime</h2>
<p>Файлы, изменять которые без серьезной необходимости НЕЛЬЗЯ</p>
<ul>
    <li>runtime/engine/*</li>
    <li>runtime/dialog/overlay/settings/settings.js</li>
    <li>runtime/dialog/scenes/console/console.js</li>
    <li>runtime/dialog/scenes/options/options.js</li>
</ul>
<p>Файлы <span>.css</span>, <span>.fxml</span>, <span>.jpg/.png</span> можно изменять без риска потерять совместимость при обновлении</p>
<h3>Использование Git при разработке дизайна</h3>
<p>Если вы собрались делать собственный дизайн крайне желательно иметь на своем ПК копию git репозитория</p>
<p>Установите на ПК Git и TortoiseGit(по желанию)</p>
<ul>
    <li>Склонируйте репозиторий в желаемую папку. Крайне желательно использовать SSH ключ для доступа</li>
    <li>Перейдите в нужную ветку, соответствующую версии вашего лаунчсервера</li>
    <li>Создайте новую ветку, в качестве базы выберите ветку, в которую только что перешли</li>
    <li>Убедитесь, что вас перебросило в новую ветку. Если этого не произошло - перейдите в неё сами</li>
</ul>
<p>Каждый раз когда вы будете менять runtime не забывайте сделать следующие шаги</p>
<ul>
    <li>Скопируйте содержимое вашей папки runtime в Launcher/runtime с заменой</li>
    <li>Сделайте коммит в репозиторий, указав кратко что вы изменили в runtime</li>
</ul>
<p>При обновлении до новой версии лаунчсервера где был изменен runtime выполните следующие шаги</p>
<ul>
    <li>Убедитесь, что в репозитории, в вашей ветке лежит последняя версия вашего runtime</li>
    <li>Сделайте git pull. Если вы обновляетесь не до последней доступной версии вам нужно будет найти тег с номером версий и сделать checkout туда</li>
    <li>Сделайте merge вашей ветки с веткой/тегом вашего релиза. Обратите внимание - изменения из ветки/тега релиза должны вливаться в вашу ветку. а не наоборот</li>
</ul>
<p>Если все не сделать все эти шаги, то при обновлении runtime вам будет необходимо самостоятельно портировать изменения в ваш runtime<br>
Иногда сделать это будет проблематично</p>