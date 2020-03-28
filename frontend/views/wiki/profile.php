<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:49
 */
$this->title = 'Profiles - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Profiles";
?>
<h2>Настройка профиля</h2>
<p>Профиль - инструкция по запуску и конфигурированию клиента</p>
<h3>Конфигурация <div class="gtag gtag-easy">Это просто</div></h3>
<pre class="prettyprint">
{
  "version": "1.12.2", //Версия клиента
  "assetIndex": "1.12.2",
  "dir": "HiTech", //Папка клиента в updates
  "assetDir": "asset1.12", //Папка ассетов в updates
  "sortIndex": 0, //Индекс сортировки. В версиях до 5.1.0 у всех профилей должен быть различный индекс для корреткной работы опциональных модов
  "uuid": "d893746b-21be-4aa4-b62f-20800d4786bc", //UUID клиента
  "title": "XXX", //Заголовок клиента, отображаемый пользователю
  "info": "Информация о сервере", //Информация о сервере, отображаемая пользователю
  "serverAddress": "localhost", //Адрес майнкрафт сервера, к которому лаунчер будет обращаться за текущим онлайном
  "serverPort": 25565, //Порт майнкрафт сервера, к которому лаунчер будет обращаться за текущим онлайном
  "update": [ //Файлы и папки, которые нужно обновлять при запуске клиента
    "servers.dat"
  ],
  "updateExclusions": [ //Исключения для update и updateVerify(см предупреждение на главной странице Wiki по использованию этого параметра)
  ],
  "updateShared": [], //Не используется
  "updateVerify": [ //Файлы и папки, которые не должны меняться при работе клиента(более строгая версия update)
    "libraries",
    "natives",
    "mods",
    "minecraft.jar",
    "forge.jar",
    "liteloader.jar"
  ],
  "updateOptional": [], //Опциональные моды, см ниже отдельный раздел
  "updateFastCheck": true, //Проверка только размеров, без сравнения хешей
  "mainClass": "net.minecraft.launchwrapper.Launch", //Main Class клиента
  "jvmArgs": [ //Аргументы JVM
    "-Dfml.ignorePatchDiscrepancies\u003dtrue",
    "-Dfml.ignoreInvalidMinecraftCertificates\u003dtrue",
    "-XX:+UseConcMarkSweepGC",
    "-XX:+CMSIncrementalMode",
    "-XX:-UseAdaptiveSizePolicy",
    "-Xmn128M",
    "-XX:+DisableAttachMechanism"
  ],
  "classPath": [ //Class Path клиента. Указание папки в этом разделе равносильно добавлению всех .jar файлов в этой папке
    "forge.jar",
    "liteloader.jar",
    "minecraft.jar",
    "libraries"
  ],
  "altClassPath": [], //альтернативный ClassPath. Указанные здесь файлы будут загружены другим, отличным от classLoaderConfig загрузчиком классов(как правило SystemClassLoader). Используется только некоторыми клиентами
  "clientArgs": [ //Аргументы клиента
    "--tweakClass",
    "net.minecraftforge.fml.common.launcher.FMLTweaker",
    "--tweakClass",
    "com.mumfrey.liteloader.launch.LiteLoaderTweaker"
  ],
  "securityManagerConfig": "CLIENT", //Используемый SecurityManager для клиента
  "classLoaderConfig": "LAUNCHER" //Используемый тип класслоадера для клиента
}
</pre>
<h3>Опциональные моды <div class="gtag gtag-easy">Это просто</div></h3>
<p>Опциональные моды позволяют игроку управлять загрузкой определенных модов/classpath/jvmargs</p>
<p>Настройка опциональных модов производится для каждого профиля отдельно</p>
<pre class="prettyprint">
"updateOptional": [
    {
       "type": "FILE", //Тип опционального мода. Может быть FILE, CLIENTARGS, JVMARGS, CLASSPATH
       "list": ["mods/1.7.10/NotEnoughItems-1.7.10-1.0.5.118-universal.jar"], //Список файлов или аргументов
       "info": "Мод, показывающий рецепты", //Описание
       "visible": true, //Видимость
       "mark": true, //Включен по умолчанию
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
       "type": "JVMARGS",
       "list": ["--add-modules", "jdk.unsupported"],
       "triggers": [{"type": "JAVA_VERSION", "compareMode": 1, "need": true, "value": 8}], //Триггеры, о них ниже
       "info": "Аргументы Java9+",
       "visible": false,
       "permissions": 0,
       "visible": true,
       "name": "Java9Args"
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
<h3>Триггеры в опциональных модах <div class="gtag gtag-medium">Средний уровень</div></h3>
<p>Триггеры - условия, при которых опциональный мод будет включен без участия пользователя автоматически.<br>Первый параметр - type:</p>
<ul>
<li>JAVA_VERSION - версия Java, с которой запущен лаунчер. Принимает значения 8,9,11 и т.д.</li>
<li>JAVA_BITS - разрядность Java, с которой запущен лаунчер. Принимает значения 32 и 64</li>
<li>OS_BITS - разрядность ОС, с которой запущен лаунчер. Принимает значения 32 и 64</li>
<li>OS_TYPE - тип ОС, с которой запущен лаунчер. Так как значение может быть только числом приняты следующие соответствия ОС-ЧИСЛО:<ul>
<li>0 - Windows(MUSTDIE)</li>
<li>1 - Linux</li>
<li>2 - MacOS</li>
</ul></li>
</ul>
<p>Второй параметр - compareMode. Он соответствует одному из трех знаков сравнения</p>
<ul>
<li>0 - знак равенства</li>
<li>Любое положительное число - знак больше(строгий)</li>
<li>Любое отрицательное число - знак меньше(строгий)</li>
</ul>
<p>Третий параметр - value. Это значение, с которым будет сравниваться параметр</p>
<p>Четвертый параметр - need. Это особый флаг, означающий "опциональный мод не может работать если этот триггер не сработал"</p>
<p>Если триггеров с need нет - опциональный мод включится если сработает ХОТЯ БЫ ОДИН триггер</p>
<p>Если есть ХОТЬ ОДИН триггер с NEED - опциональный мод включится только если ВСЕ ТРИГГЕРЫ С NEED сработают. При этом если хоть один триггер с need не сработает:<ol>
<li>Если опциональный мод был включен по умолчанию - он будет выключен</li>
<li>Если опциональный мод был видимым по умолчанию - он станет невидимым</li>
</ol></p>
<p>Примеры тригеров</p>
<ul>
<li>{"type": "JAVA_VERSION", "compareMode": 1, "need": true, "value": 8} - выполняется если версия Java > 8</li>
<li>{"type": "OS_TYPE", "compareMode": 0, "need": true, "value": 0} - выполняется если ОС Windows</li>
<li>{"type": "JAVA_BITS", "compareMode": 0, "need": true, "value": 64} - выполняется если Java, с которой запущен лаунчер 64 бит</li>
</ul>
