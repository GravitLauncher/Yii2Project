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
<h3>Вариант 2: Сборка из исходников</h3>
    <h4>Способ с Git</h4>
    <b>    Необходимо установить <a class="link-animated" href="https://git-scm.com/downloads">Git</a></b><br>
    <ol>
      <li>Открываем <b>cmd</b> или <b>терминал</b></li>
      <li>Выполняем <span class="codes">git clone https://github.com/GravitLauncher/Launcher.git</span></li>
      <b>Обязательно выполните <span>git submodule update --init</span><br></b>
      Если у вас не настроены SSH ключи для доступа к GitHub вам нужно изменить в файле .gitmodules <span>git@github.com:</span> на <span>https://github.com/</span>
      <li>Устанавливаем <a class="link-animated" href="https://www.oracle.com/technetwork/java/javase/downloads/2133151">JDK</a></li> 
      <li>Открываем в консоли папку с исходниками и выполняем <span class="codes">gradlew.bat build</span> (Windows) <span class="codes">sh gradlew build</span> (Linux)</li>
      <li>Готовый результат появится в <span class="codes">LaunchServer/build/libs</span>. Туда же будут скопированы все необходимые библиотеки</li>
      <li>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></li>
    </ol>
    <h4>Cкачивание вручную</h4>
    <ol>
      <li>Открываем репозиторий на <a class="link-animated" href="https://github.com/GravitLauncher/Launcher">GitHub</a>, жмем Clone or Download,
      так же скачиваем <a class="link-animated" href="https://github.com/GravitLauncher/Radon">Radon</a>, и по желанию
      <a class="link-animated" href="https://github.com/GravitLauncher/Launcher">модули</a></li>
      <li>Распаковываем <b>Launcher-master.zip</b>, заходим в распакованную папку. Распаковываем тут <b>Radon</b>, и по желанию <b>модули</b></li>
      <li>Открываем в <b>cmd</b> или <b>терминале</b> папку с исходными кодами, пользуясь командами <b>cd (папка)</b> и <b>ls</b> (Linux) <b>dir</b> (Windows)</li>
      <li>Устанавливаем <a class="link-animated" href="https://www.oracle.com/technetwork/java/javase/downloads/2133151">JDK</a></li>
      <li>Открываем в консоли папку с исходниками и выполняем <span class="codes">gradlew.bat build</span> (Windows) <span class="codes">sh gradlew build</span> (Linux)</li>
      <li>Готовый результат появится в <span class="codes">LaunchServer/build/libs</span>. Туда же будут скопированы все необходимые библиотеки</li>
      <li>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></li>
    </ol>
<hr>
<h2>Рекомендуемые настройки безопасности для проектов</h2>
<p>Рекомендуется выделить лаунчсерверу отдельного пользователя и папку в <span class="codes">/home</span><br>
    Права на папку должны быть <b>755</b>, на private.key <b>640</b><br>
    Рекомендуется использовать <span class="codes">screen</span> для удобного контроля за работой лаунчсервера<br>
    Рекомендуется использовать systemd для автоматического рестарта, контроля за потреблением памяти и автозапуска при перезапуске VDS<br>
    Скрипты для systemd будут приведены ниже</p>
<h2>Настройка лаунчсервера</h2>
<h3>Базовые параметры</h3>
<p>В json нет коментариев. <b>Не пытайтесь копировать этот конфиг себе</b></p>
<pre class="prettyprint">
{
  "projectName": "MineCraft",      // Название проекта
  "mirrors": [                     // Зеркала для скачивания шаблонов клиента
    "https://mirror.gravit.pro/"
  ],
  "binaryName": "Launcher",        // Название выходных jar и exe
  "copyBinaries": true,            // Копировать jar и exe в updates?
  "env": "STD",                    // Окружение лаунчсервера
                                     // DEV - на текущий момент аналогичен DEBUG, но в дальнейшем в этом режиме можно будет видеть особые отладочные сообщения
                                     // DEBUG - по умолчанию включен режим отладки
                                     // STD - стандартная полтитка. Дебаг включается -Dlauncher.debug=true, stacktrace -Dlauncher.stacktrace=true
                                     // PROD - Запрет установки флагов debug и stacktrace. Никакого отладочного вывода вы не получите
  "auth": [
    {
      "provider": {                // AuthProvider, проверка правильности логина и пароля
        "message": "Настройте authProvider",
        "type": "reject"
      },
      "handler": {                 // AuthHandler, хранение сессий и uuid
        "type": "memory"
      },
      "textureProvider": {         // textureProvider, выдача скинов/плащей
        "type": "request",
        "skinURL": "http://example.com/skins/%username%.png",
        "cloakURL": "http://example.com/cloaks/%username%.png"
      },
      "name": "std",               // Название данной конфигурации auth
      "displayName": "Default",    // Отображаемое название конфигурации auth
      "isDefault": true            // Конфигурация по умолчанию?
    }
  ],
  "protectHandler": {
    "type": "std"                  // protectHandler, защита, отвечающая за генерацию токена к нативной библиотеке защиты
  },
  "permissionsHandler": {          // permissionsHandler, проверка разрешений администраторов, серверов
    "type": "json",
    "filename": "permissions.json"
  },
  "hwidHandler": {                 // hwidHandler, отвечает за бан по HWID
    "type": "accept"
  },
  "components": {                  // Компоненты, которые можно включить или выключить. Так же здесь настраиваются некоторые модули
    "regLimiter": {                            // Ограничение регистраций
      "type": "regLimiter",                    // Тип
      "rateLimit": 3,                          // Максимальное количество
      "rateLimitMilis": 36000000,              // На какое время, в миллисекундах (10 часов)
      "message": "Превышен лимит регистраций", // Сообщение
      "excludeIps": []                         // IP адреса, на которые ограничение не действует.
    },
    "authLimiter": {                           // Ограничение попыток авторизации
      "type": "authLimiter",                   // Тип
      "rateLimit": 3,                          // Максимальное количество
      "rateLimitMilis": 8000,                  // На какое время, в миллисекундах (8 секунд)
      "message": "Превышен лимит авторизаций", // Сообщение
      "excludeIps": []                         // IP адреса, на которые ограничение не действует.
    }
  },
  "threadCount": 2,                                        // Не используется
  "threadCoreCount": 0,                                    // Не используется
  "launch4j": {                                            // Launch4J (Создание EXE файла)
    "enabled": true,                                        // Включен?
    "setMaxVersion": false,                                 // Установить максимальную версию java?
    "maxVersion": "1.8.999",                                // Максимальная версия java
    "productName": "GravitLauncher",                        // Название продукта
    "productVer": "5.0.4.4",                                // Версия продукта
    "fileDesc": "GravitLauncher 5.0.4",                     // Описание файла
    "fileVer": "5.0.4.4",                                   // Версия файла
    "internalName": "Launcher",                             // Внутреннее имя
    "copyright": "© GravitLauncher Team",                   // Копирайты
    "trademarks": "This product is licensed under GPLv3",   // Торговые марки
    "txtFileVersion": "%s, build %d",                       // Как будет выглядеть версия файла
    "txtProductVersion": "%s, build %d"                     // Как будет выглядеть версия продукта
  },
  "netty": {
    "fileServerEnabled": true,                              // Включен ли встроенный файловый сервер?
    "sendExceptionEnabled": true,                           // При возникновении ошибки в лаунчсервере отправлять текст ошибки лаунчеру для отображения
    "ipForwarding": false,                                  // Получение IP из заголовка (при использовании nginx/cloudflare)
    "launcherURL": "http://localhost:9274/Launcher.jar",    // Ссылка на лаунчер JAR
    "downloadURL": "http://localhost:9274/%dirname%/",      // Ссылка на папки клиента
    "launcherEXEURL": "http://localhost:9274/Launcher.exe", // Ссылка на лаунчер EXE
    "address": "ws://localhost:9274/api",                   // Адрес лаунчсервера
    "bindings": {},                                         // Настройка URL конкретных папок updates. Настройка скачивания zip архивами
    "performance": {
      "usingEpoll": false,                                  // Оптимизации netty для использования epoll. Повышает производительность. Только Linux
      "bossThread": 2,                                      // Количество потоков, принимающих соеденение
      "workerThread": 8                                     // Количество потоков, обрабатывающих запросы
    },
    "binds": [                                              // Привязки к определенным IP адресам/портам
      {
        "address": "0.0.0.0",                               // Адрес
        "port": 9274                                        // Порт
      }
    ],
    "logLevel": "DEBUG",                                    // Уровень отладочных сообщений netty. Тут можно убрать "Connection reset by peer", ...
    "proxy": {                                              // Подключение к другому лаунчсерверу
      "enabled": false,                                     // Включено?
      "address": "ws://localhost:9275/api",                 // Адрес
      "login": "login",                                     // Логин
      "password": "password",                               // Пароль
      "auth_id": "std",                                     // Тип аутентификации
      "requests": []                                        // Cписок типов запросов, которые будут проксироваться
    }
  },
  "launcher": {
    "guardType": "no",                                      // Защита
    "attachLibraryBeforeProGuard": false                    // Присоеденять библиотеки до обработки ProGuard, а не после
  },
  "whitelistRejectString": "Вас нет в белом списке", // Ошибка, когда человека нет в белом списке
  "genMappings": true,                               // Генерация маппингов ProGuard
  "isWarningMissArchJava": true,                     // Предупреждения о неверной разрядности Java
  "enabledProGuard": true,                           // Включение обфускатора ProGuard
  "enabledRadon": true,                              // Включение обфускатора Radon
  "stripLineNumbers": true,                          // С помощью ASM убирать номера строк
  "deleteTempFiles": true,                           // Удаление временных файлов
  "startScript": "./start.sh"                        // Скрипт, выполняющийся при команде restart
}
</pre>
<h2>Команды LaunchServer</h2>
<p>Существует много команд лаунчсервера, которые можно выполнять из консоли</p>
<pre class="prettyprint">
Category: basic - Base LaunchServer commands
 proguarddictregen [nothing] - Regenerates proguard dictonary
 gc [nothing] - null
 debug [true/false] [true/false] - null
 test [nothing] - Test command. Only developer!
 restart [nothing] - Restart LaunchServer
 loadmodule [jar] - Module jar file
 clear [nothing] - Clear terminal
 version [nothing] - Print LaunchServer version
 modules [nothing] - get all modules
 help [command name] - Print command usage
 stop [nothing] - Stop LaunchServer
 build [nothing] - Build launcher binaries
 proguardclean [nothing] - Resets proguard config
 proguardmappingsremove [nothing] - Removes proguard mappings (if you want to gen new mappings).
Category: updates - Update and Sync Management
 downloadclient [version] [dir] - Download client dir
 syncprofiles [nothing] - Resync profiles dir
 downloadasset [version] [dir] - Download asset dir
 unindexasset [dir] [index] [output-dir] - Unindex asset dir (1.7.10+)
 syncbinaries [nothing] - Resync launcher binaries
 indexasset [dir] [index] [output-dir] - Index asset dir (1.7.10+)
 syncupdates [subdirs...] - Resync updates dir
Category: DAO - Data Management
 setuserpassword [username] [new password] - Set user password
 getuser [username] - get user information
 getallusers  - get all users information
 register [login] [password] - Register new user
Category: auth - User Management
 uuidtousername <uuid> <auth_id> - Convert player UUID to username
 auth <login> <password> <auth_id> - Try to auth with specified login and password
 ban [username] - Ban username for HWID
 gethwid [username] - get HWID from username
 usernametouuid <username> <auth_id> - Convert player username to UUID
 unban [username] - Unban username for HWID
Category: dump - Dump runtime data
 dumpentrycache [load/unload] [auth_id] [filename] - Load or unload AuthHandler Entry cache
 dumpsessions [load/unload] [filename] - Load or unload sessions
Category: service - Managing LaunchServer Components
 clients [nothing] - Show all connected clients
 serverstatus [nothing] - Check server status
 reloadall  - Reload all provider/handler/module config
 checkinstall [nothing] - null
 multi [nothing] - null
 getpermissions [username] - print username permissions
 reload [name] - Reload provider/handler/module config
 confighelp [name] - print help for config command
 getmodulus [nothing] - null
 givepermission [username] [permission] [true/false] - give permissions
 component [action] [component name] [more args] - component manager
 reloadlist  - print reloadable configs
 configlist [name] - print help for config command
 config [name] [action] [more args] - call reconfigurable action
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