<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:46
 */
$this->title = 'ServerWrapper - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "ServerWrapper";
?>
<h2>Поддерживаемые ядра серверов</h2>
<p>Протестированные ядра: Sponge, Thermos, KCaldron, Spigot/Bukkit. Некоторые можно скачать тут: <a class="link-animated" href="http://mirror.gravitlauncher.ml/servers/">mirror.gravitlauncher.ml</a><br></p>
<p>Непротестированы: Atom, Ultramine, BungeeCord и другие</p>
<h2>Основы привязки лаунчера к серверу</h2>
<p><b>Main-Class</b> - точка входа, то с чего начинается выполнение. Его можно найти открыв jar файл ядра и посмотрев содержимое манифеста, либо скопировать из старого скрипта запуска</p>
<p><b>Class-Path</b> - путь, где JVM будет искать классы. Его можно найти открыв jar файл ядра и посмотрев содержимое манифеста, либо скопировать из старого скрипта запуска</p>
<h3>Указание Main-Class в строке запуска</h3>
<pre class="prettyprint">
java -cp ServerWrapper.jar:{ClassPath вашего сервера} ru.gravit.launcher.server.ServerWrapper {ваш MainClass}
</pre>
<h3>Указание Main-Class в конфигурации</h3>
<p>Можно указать Main-Class в ServerWrapperConfig.json , тогда строка запуска будет выглядеть так:</p>
<pre class="prettyprint">
java -cp ServerWrapper.jar:{ClassPath вашего сервера} ru.gravit.launcher.server.ServerWrapper
</pre>
<h2>Конфигурация ServerWrapperConfig.json</h2>
<p>Необходимо скопировать public.key из директории лаунчсервера в директорию ServerWrapper</p>
<p>Для успешной авторизации сервера необходимо наличие в базе данных специального аккаунта, от имени которого будет совершен вход</p>
<p>Аккаунт обязан обладать правом canServer, см ниже как прописать права</p>
<pre class="prettyprint">
{
  "title": "Test1.7.10", //Имя профиля, к которому принадлежит сервер
  "projectname": "MineCraft", //Имя проекта, к которому принадлежит сервер
  "address": "127.0.0.1", //Адрес лаунчсервера
  "port": 7240, //Порт лаунчсервера
  "reconnectCount": 10, //Максимальное число попыток авторизации
  "reconnectSleep": 1000, //Таймаут между попытками
  "customClassPath": false, //Использование функции customClassPath
  "autoloadLibraries": false, //Включить автозагрузку библиотек из папки libraries. Трубует указания -javaagent:ServerWrapper.jar
  "syncAuth": true, //Синхронная авторизация
  "mainclass": "", //Альтернативный способ указания Main-Class (см. указание Main-Class в конфиге)
  "login": "ServerBot", //Логин аккаунта сервера
  "password": "password" //Пароль аккаунта сервера
}
</pre>
<h3>Добавление права canServer в jsonPermissionsHandler</h3>
<p>Добавьте это в <span>permissions.json</span></p>
<pre class="prettyprint">
{
    "ServerBot": {
      "canAdmin": false,
      "canServer": true
    }
}
</pre>
<p>После внесения изменений нужно перезапустить лаунчсервер или выполнить <span>reload permissionsHandler</span></p>

