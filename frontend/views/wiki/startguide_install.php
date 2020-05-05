<?php

$this->title = 'Начало работы: Установка лаунчсервера';
$this->params['breadcrumbs'][] = "Install";
?>

<h2>Базовая установка лаунчсервера</h2>
<h3>Вариант 1: Скрипт установки <div class="gtag gtag-easy">Самый простой вариант</div> <div class="gtag gtag-info">Рекомендуется</div></h3>
<p>Для установки лаунчера версии 5.1.3+ можно воспользоваться скриптом. Доступные на данный момент скрипты находятся <a href="https://mirror.gravit.pro/scripts">тут</a>.</p>
<ol>
<li><b>dev</b> - самая последняя версия, менее или более стабильная чем master. Доступны новейшие возможности, возможны проблемы</li>
<li><b>master</b> - последний доступный релиз. Wiki всегда основана именно на этой ветке</li>
</ol>
<p>Для установки лаунчсервера на Linux перейдите в папку, в которой у вас будет находиться лаунчсервер и выполните следующие команды:</p>
<ol>
<li> <span class="codes">curl -o setup.sh https://mirror.gravit.pro/scripts/setup-ВЕРСИЯ.sh</span>.</li>
<li>(ОПЦИОНАЛЬНО) Выполните <span class="codes">cat setup.sh</span> и убедитесь, что скрипт скачан без ошибок.</li>
<li>Выполните <span class="codes">chmod +x setup.sh</span> что бы выдать права на выполнение</li>
<li>И наконец запустите скрипт <span class="codes">./setup.sh</span></li>
<li>Если всё прошло успешно последним сообщением будет: <span class="codes">NOT DELETE DIRECTORIES src AND srcRuntime</span></li>
<li>Если что то пошло не так на фазе проверки(фаза 0) - исправьте проблему и запустите скрипт снова.<br>
Если что то пошло не так на другой фазе - вам нужно будет исправить проблему, удалить созданные скриптом файлы и папки и заного запустить скрипт</li>
</ol>
<p>При установке на Windows можно воспользоваться Cygwin или другим методом установки</p>
<h4>Требования для успешной установки лаунчсервера скриптом <div class="gtag gtag-important">Важно</div></h4>
<ul>
<li>При выборе ОС выбирайте самые последние версии дистрибутивов: Debian 10, Ubuntu 18.04, ArchLinux и другие</li>
<li>У вас должно быть достаточно оперативной памяти для сборки(хотя бы 600-700Мб свободно), сам лаунчсервер при этом может работать с 300Мб или даже 128Мб. Если у вас машина с малым объемом ОЗУ и скрипт сборки падает из за нехватки памяти можете попробывать включить swap или воспользоваться другими вариантами установки</li>
<li>У вас должен быть установлен OpenJDK 11(и запускаться по умолчанию, т.е. вывод <span class="codes">java -version</span> должен выдать OpenJDK 11)</li>
<li>Для работы ProGuard уже после установки лаунчсервера вам понадобится OpenJFX той же версии, что и ваша OpenJDK(11). Иначе собранный лаунчер не запустится с ошибкой AbstractMethodError на JavaFXApplication при включеном ProGuard</li>
<li>У вас должен быть установлен Git и Curl</li>
<li>При возникновении проблем с launch4j:</li>
<ul>
<li>Убедитесь что у вас нет файла favicon.ico в корне лаунчсервера или он является достоверно валидным</li>
<li>Убедитесь что вы не меняли конфиг launch4j. Неправильное изменение некоторых параметров может привести к такому эффекту</li>
<li>Если у вас 32бит Linux или у вас какие то проблемы с запуском windres попробуйте скачать <a href="https://repo1.maven.org/maven2/net/sf/launch4j/launch4j/3.12/launch4j-3.12-workdir-linux.jar">этот архив с 32битными исполняемыми файлами</a> и распаковать в папку libraries/launch4j. При этом для 64бит систем вам нужно будет установить 32битные библиотеки(Debian: lib32z1 | CentOS: glibc.i686 | ArchLinux: lib32-glibc lib32-zlib)</li>
</ul>
</ul>
<h4>Как пользоваться скриптом после успешной установки лаунчсервера <div class="gtag gtag-important">Важно</div></h4>
<p>Скрипт экономит много времени и делает за вас большую часть работы. Вам <b>не нужно</b> следовать инструкции по установке модуля рантайма - скрипт установил его за вас</p>
<p><i>update.sh</i> - обновляет лаунчсервер и рантайм до последней версии. При этом перед обновлением ваши изменения скрываются, а после обновления - восстанавливаются. Это позволяет вам обновится без конфликтов с сохранением ваших изменений в дизайне<br>
Этот метод не заменит полноценной разработке рантайма с использованием Git, но тем не менее является отличным решением для начинающих</p>
<p><i>client.sh ClientName</i> - после скачки клиента через downloadClient вы можете воспользоваться этим скриптом что бы скопировать authlib и launchwrapper в папку с клиентом. ClientName - имя папки клиента в updates</p>
<p><i>start.sh</i> - Запуск лаунчсервера без использования screen. Рекомендуется для тестирования и начальной настройки</p>
<p><i>startscreen.sh</i> - Запуск лаунчсервера с использованием screen. Рекомендуется для постоянной работы. <span class="codes">Ctrl + A + D</span> - выйти из консоли лаунчсервере не убивая процесс. <span class="codes">screen -x</span> - подключится к консоли лаунчсервера.<b>Следите за тем что бы не запустить случайно два лаунчсервера. Если вы запустите два лаунчсервера одновременно - вы можете получить странные баги на гране здравого смысла и долго искать решение</b></p>
<p><b>Так как при установке лаунчсервера скриптом вы используете JDK 11, а майнкрафт(и сервера в том числе) 1.12.2 и ниже используют Java 8 вам необходимо поставить еще и Java 8 себе на VDS, при этом изменив прямой вызов java в ваших скриптах старта сервера на путь к java 8-ой версии</b></p>
<p></p>
<h3>Вариант 2: Скачивание релиза с GitHub Actions <div class="gtag gtag-easy">Это просто</div></h3>
<p>Открываем по ссылке <a class="link-animated" href="https://github.com/GravitLauncher/Launcher/actions">GitHub Actions</a><br>
    Выбираем ветку нажав на <span class="codes">Branch</span> и выбрав в открывшемся меню нужную ветку<br>
    Открываем самый последний билд и в разделе Artifacts вы увидите архив с готовыми .jar. Скачиваем его, распаковываем LaunchServer.jar и librzries.zip<br>
    <b>Ни в коем случае не распаковывайте всю папку modules сразу! Модули требуют дополнительной конфигурации и ставятся в разные папки. При необходимости берите из архива модули по одному и следуйте инструкции по их установке</b><br>
    Распакуйте архив libraries.zip в папку с лаунчсервером</p>
<b>Если вы не можете скачать файлы с GitHub Actions войдите/зарегистрируйтесь на GitHub либо скачайте из раздела релизов</b>
<p>Следуем дальнейшем инструкциям на Wiki по настройке. Используя этот способ вам нужно устанавливать модуль рантайма самостоятельно</p>
<h3>Вариант 3: Сборка из исходников <div class="gtag gtag-medium">Средний уровень</div></h3>
    <p>Для сборки вам потребуется: JDK, JavaFX библиотеки той же версии что и JDK, Git или wget/curl + unzip</p>
    <h4>Способ с Git</h4>
    <b>    Необходимо установить <a class="link-animated" href="https://git-scm.com/downloads">Git</a></b><br>
    <ol>
      <li>Открываем <b>cmd</b> или <b>терминал</b></li>
      <li>Выполняем <span class="codes">git clone https://github.com/GravitLauncher/Launcher.git</span></li>
      <b>Обязательно выполните <span class="codes">git submodule update --init</span><br></b>
      Если у вас не настроены SSH ключи для доступа к GitHub вам нужно изменить в файле .gitmodules <span>git@github.com:</span> на <span>https://github.com/</span>
      <li>Устанавливаем <a class="link-animated" href="https://www.oracle.com/technetwork/java/javase/downloads/2133151">JDK</a></li> 
      <li>Открываем в консоли папку с исходниками и выполняем <span class="codes">gradlew.bat build</span> (Windows) <span class="codes">sh gradlew build</span> (Linux)</li>
      <li>Готовый результат появится в <span class="codes">LaunchServer/build/libs</span>. Туда же будут скопированы все необходимые библиотеки</li>
      <li>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></li>
    </ol>
    <h4>Cкачивание вручную</h4>
    <ol>
      <li>Открываем репозиторий на <a class="link-animated" href="https://github.com/GravitLauncher/Launcher">GitHub</a>, жмем Clone or Download,
      и по желанию скачиваем <a class="link-animated" href="https://github.com/GravitLauncher/Launcher">модули</a></li>
      <li>Распаковываем <b>Launcher-master.zip</b>, заходим в распакованную папку. Распаковываем тут, по желанию, <b>модули</b></li>
      <li>Открываем в <b>cmd</b> или <b>терминале</b> папку с исходными кодами, пользуясь командами <b>cd (папка)</b> и <b>ls</b> (Linux) <b>dir</b> (Windows)</li>
      <li>Устанавливаем <a class="link-animated" href="https://www.oracle.com/technetwork/java/javase/downloads/2133151">JDK</a></li>
      <li>Открываем в консоли папку с исходниками и выполняем <span class="codes">gradlew.bat build</span> (Windows) <span class="codes">sh gradlew build</span> (Linux)</li>
      <li>Готовый результат появится в <span class="codes">LaunchServer/build/libs</span>. Туда же будут скопированы все необходимые библиотеки</li>
    </ol>
<p>Следуем дальнейшем инструкциям на Wiki по настройке. Используя этот способ вам нужно устанавливать модуль рантайма самостоятельно</p>
<h3>Вариант 4: Скачивание релиза с GitLab Pipelines <div class="gtag gtag-deprecated">Только для 5.1.2 и ниже</div></h3>
<p>Скачиваем последний релиз с <a class="link-animated" href="https://gitlab.com/gravitlauncherteam/Launcher/pipelines">GitLab</a><br>
    Он выглядит так: <br>
    <img src="https://cdn.discordapp.com/attachments/612736409677070338/635566914189393940/v.png"><br>
    (С пометкой latest, а так же ветка должна быть <b>master</b>)<br>
    Так же встречаются ветки hotfix/X.X.X, если они первее master'а - используйте их<br>
    Распаковываем в нужную папку</p>
<p>Запускаем лаунчсервер командой <span class="codes">java -javaagent:LaunchServer.jar -jar LaunchServer.jar</span></p>
