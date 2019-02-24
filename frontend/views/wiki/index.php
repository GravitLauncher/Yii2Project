<?php

/* @var $this yii\web\View */

$this->title = 'Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Wiki";
?>
<p><b>GravitLauncher - проффессиональный лаунчер с лучшей защитой</b></p>
<h2>Начало работы</h2>
<h3>Вариант 1: Скачивание релиза</h3>
<p>Скачиваем последний релиз с <a class="link-animated" href="https://github.com/GravitLauncher/Launcher/releases">GitHub</a> вместе с библиотеками<br>
    Распаковываем в нужную папку</p>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
<h3>Вариант 2: Скрипт установки</h3>
<p>Выполните в консоли <span class="codes">curl -s http://mirror.gravitlauncher.ml/setup.sh | sh</span></p>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
<h3>Вариант 3: Сборка из исходников</h3>
<p>Открываем репозиторий на <a class="link-animated" href="https://github.com/GravitLauncher/Launcher">GitHub</a>, жмем <span class="codes">Clone or Download</span><br>
    Выполняем <span class="codes">git clone https://github.com/GravitLauncher/Launcher.git</span> или скачиваем zip архив с исходниками<br>
    Если вы хотите собрать модули, то выполните <span>git submodule update</span><br>
    Устанавливаем <a class="link-animated" href="https://www.oracle.com/technetwork/java/javase/downloads/2133151">JDK</a><br>
    Открываем в консоли папку с исходниками и выполняем <span class="codes">gradlew.bat build</span>(Windows) <span class="codes">gradlew build</span>(Linux)</p>
<p>Готовый результат появится в <span class="codes">LaunchServer/build/libs</span>. Туда же будут скопированы все необходимые библиотеки, кроме Launch4J, его нужно будет поставить отдельно.</p>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
<hr>
<h2>Рекомендуемые настройки безопасности для проектов</h2>
<p>Рекомендуется выделить лаунчсерверу отдельного пользователя и папку в <span class="codes">/home</span><br>
    Права на папку должны быть <b>755</b>, на private.key <b>640</b><br>
    Рекомендуется использовать <span class="codes">screen</span> для удобного контроля за работой лаунчсервера<br>
    Рекомендуется использовать systemd для автоматического рестарта, контроля за потреблением памяти и автозапуска при перезапуске VDS<br>
    Скрипты для systemd будут приведены ниже</p>
<h2>Настройка лаунчсервера</h2>
<h3>Базовые параметры</h3>
<p></p>
<pre class="prettyprint">
{
  "port": 7240, //Порт, который будет слушать лаунчсервер
  "address": "localhost", //Адрес, к которому будут подключаться клиенты. Как правило это внешний адрес вашей VDS
  "bindAddress": "0.0.0.0", //Адрес, который будет прослушивать лаунчсервер. Не меняйте без необходимости
  "projectName": "MyProjectName", //Имя вашего проекта
  "mirrors": [
    "http://mirror.gravitlauncher.ml/" //Зеркало, с которого будет скачиваться assets и client командами ownloadAsset/downloadClient
  ],
  "binaryName": "Launcher", //Имя jar и exe после сборки
  "env": "STD", //Окружение лаунчсервера
  //DEV - на текущий момент аналогичен DEBUG, но в дальнейшем в этом режиме можно будет видеть особые отладочные сообщения
  //DEBUG - по умолчанию включен режим отладки
  //STD - стандартная полтитка. Дебаг включается -Dlauncher.debug=true, stacktrace -Dlauncher.stacktrace=true
  //PROD - Запрет установки флагов debug и stacktrace. Никакого отладочного вывода вы не получите
  "threadCount": 4, //Параметры производительности. Не трогать
  "threadCoreCount": 0, //Параметры производительности. Не трогать
  "launch4j": {
    "enabled": false, //Включение сборки EXE через Launch4J
    "productName": "GravitLauncher",
    "productVer": "4.3.0.0",
    "fileDesc": "GravitLauncher 4.3.0",
    "fileVer": "4.3.0.0",
    "internalName": "Launcher",
    "copyright": "© GravitLauncher Team",
    "trademarks": "This product is licensed under GPLv3",
    "txtFileVersion": "%s, build %d",
    "txtProductVersion": "%s, build %d"
  },
  "compress": false, //Сжатие файлов при передаче
  "authRateLimit": 0, //Максимальное колличество попыток авторизации
  "authRateLimitMilis": 0, //Время "бана" IP при исчерпании попыток
  "authRejectString": "Превышен лимит авторизаций", //Сообщение при превышении лимита
  "whitelistRejectString": "Вас нет в белом списке", //Сообщение при отсутствии пользователя в белом списке
  "genMappings": false, //Генерация маппингов ProGuard. Помогает понять что пошло не так
  "isUsingWrapper": false, //Активация врапперов. Необходима для новой нативной защиты
  "isDownloadJava": false, //Скачивание своей JVM (требуется правка рантайма)
  "isWarningMissArchJava": true, //Предупреждения о неверной разрядности Java
  "enabledProGuard": true, //Активировать ProGuard
  "stripLineNumbers": true, //С помощью ASM убирать номера строк
  "deleteTempFiles": true, //Удалять временные файлы после сборки(папка build)
  "enableRcon": false, //Включение удаленного доступа
  "startScript": "./start.sh", //Скрипт, который выполняется при команде restart
  "updatesNotify": true //Уведомлять о новой версии
}
</pre>
<p>P.S. В json нет коментариев. <b>Не пытайтесь копировать этот конфиг себе</b></p>
<h2>Команды LaunchServer</h2>
<p>Существует много команд лаунчсервера, которые можно выполнять из консоли</p>
<pre class="prettyprint">
2019.02.03 13:48:49 [INFO]  unindexAsset dir index output-dir - Деиндексировать папку с ассетами (1.7.10+)
2019.02.03 13:48:49 [INFO]  syncUpdates [subdirs...] - Синхронизировать папку обновлений
2019.02.03 13:48:49 [INFO]  serverStatus [nothing] - Вывод информации о состоянии сервера
2019.02.03 13:48:49 [INFO]  auth login password - Проверка авторизации
2019.02.03 13:48:49 [INFO]  dumpSessions [load/unload] [filename] - Загрузка и выгрузка сессий.Можно использовать для сохранения авторизации клиентов при рестарте лаунчсервера
2019.02.03 13:48:49 [INFO]  configList [name] - Вывести все модули, которые можно перенастроить без перезапуска LaunchServer
2019.02.03 13:48:49 [INFO]  ban [username] - Забанить username по HWID
2019.02.03 13:48:49 [INFO]  reload [name] - Перезагрузить конфигурацию name
2019.02.03 13:48:49 [INFO]  dumpEntryCache [load/unload] [filename] - Загрузка и выгрузка CachedAuthHandler
2019.02.03 13:48:49 [INFO]  usernameToUUID username - Конвертировать username в UUID
2019.02.03 13:48:49 [INFO]  proguardClean [nothing] - Пересоздать конфигурацию ProGuard
2019.02.03 13:48:49 [INFO]  gc [nothing] - Запуск Garbage Collection
2019.02.03 13:48:49 [INFO]  indexAsset dir index output-dir - Индексировать папку с ассетами (1.7.10+)
2019.02.03 13:48:49 [INFO]  downloadClient version dir - Скачивание клиенета с зеркала
2019.02.03 13:48:49 [INFO]  debug [true/false] (true/false) - Включение/выключение debug/stacktrace
2019.02.03 13:48:49 [INFO]  test [nothing] - Тестовая команда. test start запускает Netty сервер
2019.02.03 13:48:49 [INFO]  restart [nothing] - Перезапуск LaunchServer
2019.02.03 13:48:49 [INFO]  reloadList  - Вывести все конфигурации, которые можно перезагрузить без перезапуска LaunchServer
2019.02.03 13:48:49 [INFO]  clear [nothing] - Почистить окно терминала
2019.02.03 13:48:49 [INFO]  reloadAll  - Перезагрузить все конфигурации
2019.02.03 13:48:49 [INFO]  configHelp [name] - Вывести помощь по конфигурации модуля name
2019.02.03 13:48:49 [INFO]  proguardMappingsRemove [nothing] - Удалить маппинги ProGuard
2019.02.03 13:48:49 [INFO]  loadModule [jar] - Загрузка модуля по полному путю до jar
2019.02.03 13:48:49 [INFO]  version [nothing] - Print LaunchServer version
2019.02.03 13:48:49 [INFO]  syncProfiles [nothing] - Синхронизировать папку профилей
2019.02.03 13:48:49 [INFO]  modules [nothing] - Вывести все модули
2019.02.03 13:48:49 [INFO]  help [command name] - Вывод справки
2019.02.03 13:48:49 [INFO]  syncBinaries [nothing] - Синхронизировать jar и exe
2019.02.03 13:48:49 [INFO]  unban [username] - разбанить username по HWID
2019.02.03 13:48:49 [INFO]  stop [nothing] - Остановить LaunchServer
2019.02.03 13:48:49 [INFO]  build [nothing] - Собрать jar и exe лаунчера
2019.02.03 13:48:49 [INFO]  rebind [nothing] - Пересоздать серверный сокет
2019.02.03 13:48:49 [INFO]  uuidToUsername uuid - Преобразование UUID в username
2019.02.03 13:48:49 [INFO]  downloadAsset version dir - Скачать assets с зеркала
2019.02.03 13:48:49 [INFO]  swapAuthProvider [index] [accept/reject/undo] [message(for reject)] - Смена AuthProvider, например swapAuthProvider reject Технические работы
2019.02.03 13:48:49 [INFO]  proguardDictRegen [nothing] - Регенерировать словарь ProGuard
2019.02.03 13:48:49 [INFO]  config [name] [action] [more args] - Вызов метода перенастройки модуля name с действием action
2019.02.03 13:48:49 [INFO]  logConnections [true/false] - Включить логгирование соеденений
</pre>
<h3>Настройка опциональных модов</h3>
<p>Информация приведена для версии 4.3 и выше</p>
<pre class="prettyprint">
"updateOptional": [
    {
       "type": "FILE", //Тип опционального мода. Может быть FILE, CLIENTARGS, JVMARGS, CLASSPATH
       "list": ["mods/1.7.10/NotEnoughItems-1.7.10-1.0.5.118-universal.jar"], //Список файлов или аргументов
       "info": "Мод, показывающий рецепты", //Описание
       "visible": true, //Видимость
       "permissions": 0, //Маска привилегий. 0 - мод для всех, 1 - только для админов.
       "name": "NotEnoughItems" //Имя
    },
    {
       "type": "FILE",
       "list": ["mods/Waila_1.5.10_1.7.10.jar"],
       "info": "Мод, показывающий дополнительную информацию при наведении на блок",
       "name": "Walia",
       "permissions": 0,
       "visible": true,
       "dependenciesFile": [{"name":"NotEnoughItems"/* Имя зависимого мода */, "type": "FILE" /* Тип зависимого мода */}],
       "conflictFile": [{"name":"ClientFixer"/* Имя конфликтующего мода */, "type": "FILE" /* Тип конфликтующего мода */}],
       "subTreeLevel": 2  //Смещение относительно первого мода. Используется для создания визуального отображения дерева зависимостей
    },
    {
       "type": "FILE",
       "list": ["mods/clientfixer-1.0.jar"],
       "info": "Мод, исправляющий шрифты",
       "permissions": 0,
       "visible": true,
       "name": "ClientFixer"
    },
    {
       "type": "FILE",
       "list": ["mods/1.7.10/OptiFine_1.7.10_HD_U_E7.jar"],
       "info": "Улучшение производительности",
       "permissions": 0,
       "visible": true,
       "name": "OptiFine HD"
    }
  ],
</pre>
<h3>Интеграция с systemd</h3>
<p>Systemd - стандарт в мире дистрибутивов Linux. Ниже привожу .service файлы для лаунчсервера и сервера Minecraft.<br>
    Для правильного порядка загрузки с systemd требуется установить модуль SystemdNotify</p>
<pre class="prettyprint">
[Unit]
Description=LaunchServer
After=network.target

[Service]
WorkingDirectory=/home/launchserver/
Type=notify
User=launchserver
Group=servers
NotifyAccess=all
Restart=always

ExecStart=/usr/bin/screen -DmS launchserver /usr/bin/java -Xmx128M -javaagent:LaunchServer.jar -jar LaunchServer.jar
ExecStop=/usr/bin/screen -p 0 -S launchserver -X eval 'stuff "stop"\015'
[Install]
WantedBy=multi-user.target
</pre>
<pre class="prettyprint">
[Unit]
Description=Minecraft HiTech Server
After=network.target
After=LaunchServer.service
[Service]
WorkingDirectory=/home/hitech/

User=hitech
Group=servers

Restart=always

ExecStart=/home/hitech/start.sh
ExecStop=/usr/bin/screen -p 0 -S hitech -X eval 'stuff "stop"\015'
[Install]
WantedBy=multi-user.target
</pre>
