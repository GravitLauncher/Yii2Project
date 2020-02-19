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
<p>Протестированные ядра: Sponge, Thermos, KCaldron, UltraMine, Waterfall/BungeeCoed, Spigot/Bukkit. Некоторые можно скачать тут: <a class="link-animated" href="https://mirror.gravit.pro/servers/">mirror.gravit.pro</a><br></p>
<p>Непротестированы: Atom и другие</p>
<h2>Скрипт развертывания ServerWrapper</h2>
<p>В 5.0.0 введен новый способ установки ServerWrapper'а - с помощью скрипта установки. Для его запуска выполните:</p>
<pre class="prettyprint">
    java -jar ServerWrapper.jar setup
</pre>
<p>И следуйте инструкции по установке</p>
<h2>Основы привязки лаунчера к серверу</h2>
<p><b>Main-Class</b> - точка входа, то с чего начинается выполнение. Его можно найти открыв jar файл ядра и посмотрев содержимое манифеста, либо скопировать из старого скрипта запуска</p>
<p><b>Class-Path</b> - путь, где JVM будет искать классы. Его можно найти открыв jar файл ядра и посмотрев содержимое манифеста, либо скопировать из старого скрипта запуска</p>
<p><b>Profile title</b> - имя профиля клиента, его можно посмотреть открыв в лаунчсервере папку profiles, открыв файл своего профиля и посмотрев на поле title. title в конфигурации ServerWrapper и title в профиле должны совпадать на 100%</p>
<p><b>Аккаунт сервера</b> - полноценный аккаунт с логином и паролем, который будет использоватья для авторизации сервера</p>
<h3>Указание Main-Class в строке запуска</h3>
<pre class="prettyprint">
java -cp ServerWrapper.jar:{ClassPath вашего сервера} pro.gravit.launcher.server.ServerWrapper {ваш MainClass}
</pre>
<h3>Указание Main-Class в конфигурации</h3>
<p>Можно указать Main-Class в ServerWrapperConfig.json , тогда строка запуска будет выглядеть так:</p>
<pre class="prettyprint">
java -cp ServerWrapper.jar:{ClassPath вашего сервера} pro.gravit.launcher.server.ServerWrapper
</pre>
<h2>Конфигурация ServerWrapperConfig.json</h2>
<p>Необходимо скопировать public.key из директории лаунчсервера в директорию ServerWrapper</p>
<p>Для успешной авторизации сервера необходимо наличие в базе данных специального аккаунта, от имени которого будет совершен вход</p>
<p>Для 5.0.10 и ниже аккаунт сервера обязан обладать правом canServer, см ниже как прописать права</p>
<pre class="prettyprint">
{
  "title": "Action1.12", //Заголовок профиля, к которому привязывается сервер
  "projectname": "MineCraft", //Название вашего проекта
  "address": "localhost", //Адрес лаунчсервера(LEGACY)
  "port": 7240, // Порт лаунчсервера(LEGACY)
  "reconnectCount": 10, //максимальное число переподключений(LEGACY)
  "reconnectSleep": 1000, //Время ожидания перед новым подключением(LEGACY)
  "customClassPath": false, //Указание кастомного classPath в конфигурации
  "autoloadLibraries": false, //Автозагрузка библиотек из папки librariesDir
  "stopOnError": true, //Останавливать запуск при возникновении исключения
  "syncAuth": true, //Синхронность авторизации
  "mainclass": "org.bukkit.craftbukkit.Main", //Ваш Main-Class
  "login": "ServerBot", //Логин аккаунта, от имени котого будет совершен вход
  "password": "1111", //Пароль от аккаунта
  "auth_id": "std", //Тип авторизации
  "websocket":
  {
    "enabled": true,
    "address": "ws://localhost:9274/api" //Адрес лаунчсервера
  },
  "env": "STD" //Окружение
}
</pre>
<h3>Добавление права canServer в jsonPermissionsHandler</h3>
<p><b>Для 5.0.11 и 5.1.0+ это делать не требуется</b></p>
<p>Добавьте это в <span>permissions.json</span></p>
<pre class="prettyprint">
{
    "ServerBot": {
      "canAdmin": false,
      "canServer": true
    }
}
</pre>
<p>После внесения изменений нужно перезапустить лаунчсервер или выполнить команду <span>reload permissionsHandler</span></p>

