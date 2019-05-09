<?php

/* @var $this yii\web\View */

$this->title = 'Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Wiki";
?>
<p><b>GravitLauncher - профессиональный лаунчер с лучшей защитой</b></p>
<h2>Начало работы</h2>
<h3>Вариант 1: Скачивание релиза</h3>
<p>Скачиваем последний релиз с <a class="link-animated" href="https://mirror.gravit.pro/build">зеркала</a> вместе с библиотеками<br>
    Распаковываем в нужную папку</p>
<p>Версии до 5.0.0b6 можно скачать на <a class="link-animated" href="https://github.com/GravitLauncher/Launcher/releases">GitHub</a></p>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
<h3>Вариант 2: Скрипт установки</h3>
<p>Выполните в консоли <span class="codes">curl -s http://mirror.gravitlauncher.ml/setup.sh | sh</span></p>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
<p>Некоторые shell некорреткно обрабатывают ввод при использовании этой команды. Если такое произошло с вами - скачайте setup.sh самостоятельно и запустите его</p>
<p>Перед установкой проверьте наличие <b>unzip</b> и <b>curl</b> в вашей системе</p>
<h3>Вариант 3: Сборка из исходников</h3>
<p>Открываем репозиторий на <a class="link-animated" href="https://github.com/GravitLauncher/Launcher">GitHub</a>, жмем <span class="codes">Clone or Download</span><br>
    Выполняем <span class="codes">git clone https://github.com/GravitLauncher/Launcher.git</span> или скачиваем zip архив с исходниками<br>
    <b>Если у вас не настроены SSH ключи для доступа к GitHub вам нужно изменить в файле .gitmodules <span>git@github.com:</span> на <span>https://github.com/</span></b><br>
    Обязательно выполните <span>git submodule update --init</span><br>
    Устанавливаем <a class="link-animated" href="https://www.oracle.com/technetwork/java/javase/downloads/2133151">JDK</a><br>
    Открываем в консоли папку с исходниками и выполняем <span class="codes">gradlew.bat build</span>(Windows) <span class="codes">./gradlew build</span>(Linux)</p>
<p>Готовый результат появится в <span class="codes">LaunchServer/build/libs</span>. Туда же будут скопированы все необходимые библиотеки</p>
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
  "legacyPort": 7240,
  "legacyAddress": "localhost",
  "legacyBindAddress": "0.0.0.0",
  "projectName": "TestProjectName", //Имя вашего проекта
  "mirrors": [
    "http://mirror.gravitlauncher.ml/", //Зеркало, с которого будет скачиваться assets и client командами downloadAsset/downloadClient
    "https://mirror.gravit.pro/"
  ],
  "binaryName": "Launcher", //Имя jar и exe файла
  "env": "STD", //Окружение лаунчсервера
  //DEV - на текущий момент аналогичен DEBUG, но в дальнейшем в этом режиме можно будет видеть особые отладочные сообщения
  //DEBUG - по умолчанию включен режим отладки
  //STD - стандартная полтитка. Дебаг включается -Dlauncher.debug=true, stacktrace -Dlauncher.stacktrace=true
  //PROD - Запрет установки флагов debug и stacktrace. Никакого отладочного вывода вы не получите
  "auth": [
    {
      "provider": { //AuthProvider, отвечает за проверку логина и пароля
        "message": "Настройте authProvider",
        "type": "accept"
      },
      "handler": { //AuthHandler, отвечает за UUID, checkServer и joinServer
        "type": "memory"
      },
      "textureProvider": { //textureProvider, отвечает за сикны и плащи
        "skinURL": "http://example.com/skins/%username%.png",
        "cloakURL": "http://example.com/cloaks/%username%.png",
        "type": "request"
      },
      "name": "std", //Имя конфигурации.
      "isDefault": true //Конфигурация по умолчанию
    }
  ],
  "protectHandler": { //Защита, отвечает за генерацию токена к нативной библиотеке защиты
    "type": "none"
  },
  "permissionsHandler": { //PermissionsHandler, отвечает за права аккаунтов: canServer/canAdmin/canBot
    "filename": "permissions.json",
    "type": "json"
  },
  "hwidHandler": { //HWIDHandler, отвечает за бан по HWID
    "type": "accept"
  },
  "components": { //Компоненты, которые можно включить или выключить. Так же здесь настраиваются некоторые модули
    "authLimiter": { //Лимит запросов на авторизацию
      "rateLimit": 3,
      "rateLimitMilis": 8000,
      "message": "Превышен лимит авторизаций",
      "excludeIps": [],
      "component": "authLimiter"
    }
  },
  "threadCount": 4,
  "threadCoreCount": 0,
  "launch4j": {
    "enabled": false, //Включение Launch4J
    "productName": "GravitLauncher",
    "productVer": "5.0.0.0",
    "fileDesc": "GravitLauncher 5.0.0",
    "fileVer": "5.0.0.0",
    "internalName": "Launcher",
    "copyright": "© GravitLauncher Team",
    "trademarks": "This product is licensed under GPLv3",
    "txtFileVersion": "%s, build %d",
    "txtProductVersion": "%s, build %d"
  },
  "netty": {
    "clientEnabled": true, //Не используется в 5.0, всегда true
    "launcherURL": "http://localhost:9274/Launcher.jar", //URL для скачивания jar версии лаунчера
    "downloadURL": "http://localhost:9274/%dirname%/", //URL для скачивания диреткории dirname
    "launcherEXEURL": "http://localhost:9274/Launcher.exe", //URL для скачивания exe версии лаунчера
    "address": "ws://localhost:9274/api", //Адрес API, по которому будет происходить авторизация и весь оставшийся обмен данными
    "performance": {
      "bossThread": 2, //Колличество потоков, принимающих соеденение
      "workerThread": 8 //Колличество потоков, обрабатывающих запросы
    },
    "binds": [ //Список адресов для bind
      {
        "address": "0.0.0.0",
        "port": 9274
      }
    ]
  },
  "compress": false, //Сжатие файлов при передаче(LEGACY)
  "whitelistRejectString": "Вас нет в белом списке",
  "genMappings": false, //Генерация маппингов ProGuard. Помогает понять что пошло не так
  "isUsingWrapper": false, //Активация врапперов. Необходима для новой нативной защиты
  "isDownloadJava": false, //Скачивание своей JVM (требуется правка рантайма)
  "isWarningMissArchJava": true, //Предупреждения о неверной разрядности Java
  "enabledProGuard": true, //Активировать ProGuard
  "stripLineNumbers": true, //С помощью ASM убирать номера строк
  "enableRadon": true, //Включение обфускатора Radon
  "deleteTempFiles": true, //Удаление временных файлов
  "enableRcon": false, //Включение удаленного доступа
  "startScript": "./start.sh" //Скрипт, выполняющийся при команде restart
}

</pre>
<p>P.S. В json нет коментариев. <b>Не пытайтесь копировать этот конфиг себе</b></p>
<h2>Команды LaunchServer</h2>
<p>Существует много команд лаунчсервера, которые можно выполнять из консоли</p>
<pre class="prettyprint">
2019.05.09 18:52:16 [INFO] Command 'help'
2019.05.09 18:52:16 [INFO] Category: basic - Base LaunchServer commands
2019.05.09 18:52:16 [INFO]  proguarddictregen [nothing] - Regenerates proguard dictonary
2019.05.09 18:52:16 [INFO]  gc [nothing] - null
2019.05.09 18:52:16 [INFO]  debug [true/false] [true/false] - null
2019.05.09 18:52:16 [INFO]  test [nothing] - Test command. Only developer!
2019.05.09 18:52:16 [INFO]  restart [nothing] - Restart LaunchServer
2019.05.09 18:52:16 [INFO]  loadmodule [jar] - Module jar file
2019.05.09 18:52:16 [INFO]  clear [nothing] - Clear terminal
2019.05.09 18:52:16 [INFO]  version [nothing] - Print LaunchServer version
2019.05.09 18:52:16 [INFO]  modules [nothing] - get all modules
2019.05.09 18:52:16 [INFO]  help [command name] - Print command usage
2019.05.09 18:52:16 [INFO]  stop [nothing] - Stop LaunchServer
2019.05.09 18:52:16 [INFO]  logconnections [true/false] - Enable or disable logging connections
2019.05.09 18:52:16 [INFO]  build [nothing] - Build launcher binaries
2019.05.09 18:52:16 [INFO]  rebind [nothing] - Rebind server socket
2019.05.09 18:52:16 [INFO]  proguardclean [nothing] - Resets proguard config
2019.05.09 18:52:16 [INFO]  proguardmappingsremove [nothing] - Removes proguard mappings (if you want to gen new mappings).
2019.05.09 18:52:16 [INFO] Category: updates - Update and Sync Management
2019.05.09 18:52:16 [INFO]  downloadclient [version] [dir] - Download client dir
2019.05.09 18:52:16 [INFO]  syncprofiles [nothing] - Resync profiles dir
2019.05.09 18:52:16 [INFO]  downloadasset [version] [dir] - Download asset dir
2019.05.09 18:52:16 [INFO]  unindexasset [dir] [index] [output-dir] - Unindex asset dir (1.7.10+)
2019.05.09 18:52:16 [INFO]  syncbinaries [nothing] - Resync launcher binaries
2019.05.09 18:52:16 [INFO]  indexasset [dir] [index] [output-dir] - Index asset dir (1.7.10+)
2019.05.09 18:52:16 [INFO]  syncupdates [subdirs...] - Resync updates dir
2019.05.09 18:52:16 [INFO] Category: auth - User Management
2019.05.09 18:52:16 [INFO]  uuidtousername [uuid] [auth_id] - Convert player UUID to username
2019.05.09 18:52:16 [INFO]  auth [login] [password] [auth_id] - Try to auth with specified login and password
2019.05.09 18:52:16 [INFO]  ban [username] - Ban username for HWID
2019.05.09 18:52:16 [INFO]  gethwid [username] - get HWID from username
2019.05.09 18:52:16 [INFO]  usernametouuid [username] [auth_id] - Convert player username to UUID
2019.05.09 18:52:16 [INFO]  unban [username] - Unban username for HWID
2019.05.09 18:52:16 [INFO] Category: dump - Dump runtime data
2019.05.09 18:52:16 [INFO]  dumpentrycache [load/unload] [auth_id] [filename] - Load or unload AuthHandler Entry cache
2019.05.09 18:52:16 [INFO]  dumpsessions [load/unload] [filename] - Load or unload sessions
2019.05.09 18:52:16 [INFO] Category: service - Managing LaunchServer Components
2019.05.09 18:52:16 [INFO]  serverstatus [nothing] - Check server status
2019.05.09 18:52:16 [INFO]  reloadall  - Reload all provider/handler/module config
2019.05.09 18:52:16 [INFO]  checkinstall [nothing] - null
2019.05.09 18:52:16 [INFO]  multi [nothing] - null
2019.05.09 18:52:16 [INFO]  getpermissions [username] - print username permissions
2019.05.09 18:52:16 [INFO]  reload [name] - Reload provider/handler/module config
2019.05.09 18:52:16 [INFO]  confighelp [name] - print help for config command
2019.05.09 18:52:16 [INFO]  getmodulus [nothing] - null
2019.05.09 18:52:16 [INFO]  givepermission [username] [permission] [true/false] - give permissions
2019.05.09 18:52:16 [INFO]  component [action] [component name] [more args] - component manager
2019.05.09 18:52:16 [INFO]  reloadlist  - print reloadable configs
2019.05.09 18:52:16 [INFO]  configlist [name] - print help for config command
2019.05.09 18:52:16 [INFO]  config [name] [action] [more args] - call reconfigurable action
2019.05.09 18:52:16 [INFO] Category: Base
2019.05.09 18:52:16 [INFO]  scriptmappings [nothing] - null
2019.05.09 18:52:16 [INFO]  eval [line] - Eval javascript in server script engine
</pre>
<h3>Команды Launcher. Разблокировка консоли. Удаленное управление</h3>
<p>Начиная с 5.0.0 в лаунчере появилась консоль, которую можно открыть после авторизации при клике справа на значек консоли.<br>
В этой консоли можно выполнять команды, недоступные из GUI. По умолчанию консоль заблокирована. Для её разблокировки используется команда <span>unlock [key]</span><br>
На момент выхода <span>5.0.0b6</span> разблокировать консоль можно любой строкой, например <span>unlock 1</span>. В дальнейшем процедура разблокировки усложнится<br>
Разблокировав консоль вы получите команды, недоступные ранее, в том числе возможность удаленно управлять лаунчсервером(при наличии прав)<br>
Что бы удаленно управлять лаунчсервером ваш аккаунт должен обладать правом canAdmin.<br>
<span>loglisten</span> - связывает вывод логов лаунчсервера с выводом логов лаунчера. Позволяет удалённо просматривать лог<br>
<span>exec</span> - выполняет команду на стороне лаунчсервера. Если у вас не включен <span>loglisten</span> вывод команды вы не увидите</p>
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
