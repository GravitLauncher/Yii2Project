<?php

/* @var $this yii\web\View */

$this->title = 'HWIDHandler - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "HWIDHandler";
?>

<h2>Настройка HWIDHandler</h2>
<h3>Способ accept</h3>
<p>Принимает любые hwid и никуда их не записывает. Банить не получится</p>
<pre class="prettyprint">
"hwidHandler": {
    "type": "accept"
}
</pre>
<h3>Способ memory</h3>
<p>Сохраняет и проверяет hwid в ОЗУ<br>
<b>При остановке лаунчсервера hwid теряются</b></p>
"hwidHandler": {
    "type": "memory"
}
</pre>
<h3>Способ jsonfile</h3>
<!-- TODO -->
<h3>Способ json</h3>
<!-- TODO -->
<h3>Способ mysql</h3>
<p>Для проверки hwid лаунчсервер обращается к mysql</p>
<pre class="prettyprint">
"hwidHandler": {
     "type": "mysql",

     "mySQLHolder": {
        "address": "localhost",              // адрес mysql сервера
        "port": 3306,                        // порт mysql сервера
        "username": "launchserver",          // имя пользователя
        "password": "password",              // пароль пользователя
        "database": "db?serverTimezone=UTC", // база данных (до ?), после находится установка серверной таймзоны
        "timezone": "UTC"                    // установка клиентской таймзоны
      },

     "queryHwids": "SELECT * FROM `users_hwids` WHERE `totalMemory` = ? and `serialNumber` = ? and `HWDiskSerial` = ? and `processorID` = ? and `macAddr` = ?",           // sql запрос, ? по порядку заменяются параметрами из paramsHwids
     "paramsHwids": [ "%totalMemory%", "%serialNumber%", "%HWDiskSerial%", "%processorID%", "%MAC%" ],                                                                    // параметры sql запроса

     "queryBan": "UPDATE `users_hwids` SET `isBanned` = ? WHERE `totalMemory` = ? and `serialNumber` = ? and `HWDiskSerial` = ? and `processorID` = ? and `macAddr` = ?", // sql запрос, ? по порядку заменяются параметрами из paramsBan
     "paramsBan": [ "%isBanned%", "%totalMemory%", "%serialNumber%", "%HWDiskSerial%", "%processorID%", "%MAC%" ],                                                        // параметры sql запроса

     "tableUsers": "users",                    // таблица с пользователями

     "userFieldHwid": "hwid",                  // название столбца с ID пользователя в таблице с HWIDами
     "userFieldLogin": "username",             // название столбца с именами пользователей

     "tableHwids": "users_hwids",              // таблица с hwid

     "hwidFieldBanned": "isBanned",            // название столбца с значением, забанен ли пользователь
     "hwidFieldTotalMemory": "totalMemory",    // название столбца с количеством ОЗУ пользователя (в байтах)
     "hwidFieldSerialNumber": "serialNumber",  // название столбца с серийным номером компьютера пользователя
     "hwidFieldHWDiskSerial": "HWDiskSerial",  // название столбца с серийным номером жесткого диска пользователя
     "hwidFieldProcessorID": "processorID",    // название столбца с ID процессора пользователя
     "hwidFieldMAC": "macAddr",                // название столбца с MAC адресом сетевой карты пользователя

     "banMessage": "Ваш аккаунт заблокирован!" // сообщение, когда забаненный пользователь пытается войти
}
</pre>

<p>В таблице users хранятся данные о пользователях (минимум: ник), в столбце "hwid" хранится id записи в таблице users_hwids<br>
В users_hwids хранятся характеристики компьютеров пользователей</p>
<p>Создать необходимый столбец и таблицу можно запросом</p>
<pre class="prettyprint">
-- Добавляет столбец "hwid", для связи таблицы с users_hwids
-- Замените users на название таблицы
ALTER TABLE `users` ADD `hwid` BIGINT NOT NULL;

-- Создаёт таблицу для хранения характеристик компьютеров пользователей
CREATE TABLE users_hwids (
 id BIGINT(20) NOT NULL AUTO_INCREMENT,
 isBanned tinyint(1) NOT NULL DEFAULT '0',
 totalMemory text NOT NULL,
 serialNumber text NOT NULL,
 HWDiskSerial text NOT NULL,
 processorID text NOT NULL,
 macAddr text NOT NULL,
 PRIMARY KEY (id)
)
</pre>
