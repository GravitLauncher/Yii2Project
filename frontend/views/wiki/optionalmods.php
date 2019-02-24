<?php

$this->title = 'Опциональные моды - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Опциональные моды";
?>
<h2>Опциональные моды</h2>
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