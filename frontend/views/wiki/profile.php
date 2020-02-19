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
<h3>Конфигурация</h3>
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
  "useWhitelist": false, //Использовать белый список
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
  "clientArgs": [ //Аргументы клиента
    "--tweakClass",
    "net.minecraftforge.fml.common.launcher.FMLTweaker",
    "--tweakClass",
    "com.mumfrey.liteloader.launch.LiteLoaderTweaker"
  ],
  "whitelist": [], //Белый список игроков, включается useWhitelist
  "securityManagerConfig": "CLIENT", //Используемый SecurityManager для клиента
  "classLoaderConfig": "LAUNCHER" //Используемый тип класслоадера для клиента
}
</pre>
<h3>Опциональные моды</h3>
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
