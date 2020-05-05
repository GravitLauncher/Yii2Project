<?php

/* @var $this yii\web\View */

$this->title = 'Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Wiki";
?>
<p><b>GravitLauncher - профессиональный лаунчер Minecraft с лучшей защитой</b></p>
<h2>Начало работы</h2>
<b>Ставьте только те модули, что вам действительно необходимы. Большинство модулей требует дополнительной конфигурации</b><br>
Модули, заканчивающиеся на <span class="codes">_module</span> - для лаунчсервера, на <span class="codes">_lmodule</span> - для лаунчера(требутется LauncherModuleLoader), на <span class="codes">_swmodule</span> для ServerWrapper'а<br>
<ol style="font-size: 24px;">
<li><a href="?r=wiki%2Fpage&page=startguide_install">Устанавливаем лаунчсервер</a> (выберите один из способов)</li>
<li><a href="?r=wiki%2Fpage&page=startguide_runtime">Устанавливаем рантайм</a> (если это требуется выбранным способом установки)</li>
<li><a href="?r=wiki%2Fpage&page=startguide_config">Настраиваем конфигурацию лаунчсервера</a></li>
<li>Настраиваем <a href="?r=wiki%2Fpage&page=authprovider">AuthProvider</a> и <a href="?r=wiki%2Fpage&page=authhandler">AuthHandler</a></li>
<li>Собираем <a href="?r=wiki%2Fpage&page=clientbuild">клиент</a></li>
<li>Подключаем ваш майнкрафт сервер с помощью <a href="?r=wiki%2Fpage&page=serverwrapper">ServerWrapper</a></li>
</ol>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
<hr>
<h2>Рекомендуемые настройки безопасности для проектов <div class="gtag gtag-important">Важно</div> <div class="gtag gtag-info">Знать всем</div></h2>
<ul>
    <li>Рекомендуется выделить лаунчсерверу отдельного пользователя и папку в <span class="codes">/home</span></li>
    <li>Права на папку должны быть <b>755</b>, на private.key, LaunchServer.json и прочие конфигурации <b>640</b> или <b>600</b></li>
    <li>Рекомендуется использовать <span class="codes">screen</span> для удобного контроля за работой лаунчсервера</li>
    <li>Рекомендуется использовать systemd для автоматического рестарта, контроля за потреблением памяти и автозапуска при перезапуске VDS</li>
    <li>Прописывать какому либо из файлов лаунчера или библиотек права 777 строго запрещается</li>
    <li>Крайне аккуратно пользуйтесь параметром <b>updateExclusions</b>. Если вы пишите что то вида <span class="codes">"mods/railcraft"</span> то это означает "игнорировать всё что начинается с railcraft в папке mods, в том числе railcraft_SuperMegaCheat.jar". Для игнорирования папки railcraft в mods вы должны прописать "mods/railcraft/"(при этом событие создания папки всё равно будет "mods/railcraft", следовательно вам нужно на сервере в папке вашего клиента самим создать папку railcraft).<b>Единственное оправданное приминение updateExclusions - это если в папке находятся динамично изменяющиеся <u>неисполняемые</u> данные, так к примеру поступает VoxelMap</b>. Наличие в игнорируемых папках любых .jar файлов недопустимо с точки зрения безопастности</li>
    <li>Крайне рекомендуется использовать проксирование nginx с SSL сертификатом(можно от CloudFlare, можно от Let's Encrypt или любой другой валидный сертификат) и правильно настроить iptables, закрыв порты, которые не должны быть открыты в сеть</li>
</ul>

<h2>Команды LaunchServer</h2>
<p>Простейшие команды, которые понядобятся в первую очередь:</p>
<pre class="prettyprint">
help [command name] - Вывести справку по команде или по всем командам
stop [nothing] - Остановить LaunchServer
build [nothing] - Собрать Launcher.jar
downloadclient [version] [dir] - скачать клиент с зеркала
downloadasset [version] [dir] - скачать ассеты с зеркала
syncupdates [subdirs...] - синхронизировать хеши в памяти с файлами в updates на диске
syncprofiles [nothing] - синхронизировать профили в памяти с файлами в profiles на диске
debug [true/false] [true/false] - включает или отключает режим отладки в лаунчсервере
version [nothing] - версия лаунчсервера если вдруг забыли
</pre>
<p>Еще команды:</p>
<pre class="prettyprint">
uuidtousername (uuid) (auth_id) - получить ник пользователя по его UUID
auth (login) (password) (auth_id) - попробывать войти с указанным логином и паролем
usernametouuid (username) (auth_id) - получить UUID пользователя по нику
serverstatus [nothing] - информация о лаунчсервере
config [name] [action] [more args] - мультикоманда по управлению компонентами(provider/handler), жмите TAB что бы узнать о доступных компонентах и их командах
unindexasset [dir] [index] [output-dir] - преобразовать индексированные ассеты(с хешами в имени) в обычные для удобства редактирования (1.7.10+)
indexasset [dir] [index] [output-dir] - соответственно обратная операция (1.7.10+)
clients [nothing] - список всех подключенных клиентов
dumpsessions [load/unload] [filename] - создать или загрузить дамп сессий. Используется при отсутствии модуля AutoSaveSessions для раучного сохранения и загрузки сессий
clear [nothing] - почистить терминал
gc [nothing] - запустить Java Garbare Collector
modules [nothing] - список всех загруженных модулей
notify [head] [message] - послать уведомление, которое увидят все у кого открыт ваш лаунчер
</pre>
<p>Команды DAO(работают только с настроеным Hibernate):</p>
<pre class="prettyprint">
setuserpassword [username] [new password] - сменить пароль пользователю
getuser [username] - информация о пользователе
getallusers  - информация о всех пользователях
register [login] [password] - зарегистрировать нового пользователя
</pre>
<p>Экспертные команды из стандартной поставки:</p>
<pre class="prettyprint">
proguarddictregen [nothing] - перегенерировать маппинги proguard
loadmodule [jar] - загрузить модуль не из папки modules в runtime
proguardclean [nothing] - сброс конфига proguard
proguardmappingsremove [nothing] - удалить маппинги proguard
signjar [path to file] (path to signed file) - подписать JAR файл используя настроеный в sign сертификат(enable в true)
signdir [path to dir] - подписать все файлы в папке используя настроеный в sign сертификат(enable в true)
component [action] [component name] [more args] - управление компонентами
</pre>
<p>Команды ниже настолько же круты, насколько и опасны. Если вы понимаете что делаете, эти команды будут крайне полезны:</p>
<pre class="prettyprint">
setsecuritymanager [allow, logger, system] - Вызов System.setSecurityManager для тестирования(UnsafeCommandsPack)
sendauth [connectUUID] [username] [auth_id] [client type] (permissions) (client uuid) - ручная отправка события AuthEvent соеденению в обход AuthProvider(UnsafeCommandsPack)
newdownloadasset [version] [dir] - скачать ассеты прямо с Mojang сайта, любой версии(UnsafeCommandsPack)
newdownloadclient [version] [dir] - скачать клиент прямо с Mojang сайта, любой версии. Профиль придется создать самостоятельно(UnsafeCommandsPack)
patcher [patcher name or class] [path] [test mode(true/false)] (other args) - Запутсить патчер на основе ASM. Позволяет искать пакетхаки в модах(findPacketHack), RAT(findRemote/findDefineClass), UnsafeSunAPI(findSun), поиск и замена любых вызовов по опкоду INVOKESTATIC (pro.gravit.launchermodules.unsafecommands.patcher.StaticReplacerPatcher) (UnsafeCommandsPack)
loadjar [jarfile] - добавить в SystemClassLoader любой JAR(используя javaagent)(UnsafeCommandsPack)
registercomponent [name] [classname] - зарегистрировать компонент по классу(UnsafeCommandsPack)
scriptmappings [nothing] - посмотреть все маппинги классов лаунчсервера в javascript(ServerScriptEngine)
synclaunchermodules [] - синхронизировать модули лаунчера(LauncherModuleLoader)
eval [line] - выполнить JavaScript код на стороне лаунчсервера(ServerScriptEngine)
</pre>
<h3>Команды лаунчера. Разблокировка консоли. Удаленное управление</h3>
<p>Начиная с версии 5.0.0 в лаунчере появилась консоль, которую можно открыть после авторизации, нажав справа на значок консоли.<br>
В этой консоли можно выполнять команды, недоступные из GUI. По умолчанию консоль заблокирована. Для её разблокировки используется команда <span>unlock [key]</span><br>
Ключ находится в RuntimeLaunchServerConfig.json, поле oemUnlockKey<br>
После разблокировки консоли, вы получите доступ к командам, недоступным ранее, в том числе возможность удаленно управлять лаунчсервером (при наличии прав)<br>
Что бы удаленно управлять лаунчсервером, ваш аккаунт должен иметь право canAdmin<br>
<!-- TODO commands list -->
<h2>Интеграция с systemd <div class="gtag gtag-medium">Средний уровень</div></h2>
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
