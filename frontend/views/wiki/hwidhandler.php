<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:49
 */
$this->title = 'HWIDHandler - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "HWIDHandler";
?>

<h2>Настройка HWIDHandler</h2>
<h3>Способ accept</h3>
<p>Принимает любые hwid. Баны недоступны</p>
<pre class="prettyprint">
"hwidHandler": {
     "type": "accept"
}
</pre>
<h3>Способ mysql</h3>
<p>Для проверки hwid лаунчсервер обращается к mysql</p>
<pre class="prettyprint">
"hwidHandler": {
     "type": "mysql",

     "mySQLHolder": {
       "address": "localhost",
       "port": 3306,
       "username": "launchserver",
       "password": "password",
       "database": "db"
     },

     "queryHwids": "SELECT * FROM `users_hwids` WHERE `totalMemory` = ? and `serialNumber` = ? and `HWDiskSerial` = ? and `processorID` = ?",
     "paramsHwids": [ "%totalMemory%", "%serialNumber%", "%HWDiskSerial%", "%processorID%" ],

     "queryBan": "UPDATE `users_hwids` SET `isBanned` = ? WHERE `totalMemory` = ? and `serialNumber` = ? and `HWDiskSerial` = ? and `processorID` = ?",
     "paramsBan": [ "%isBanned%", "%totalMemory%", "%serialNumber%", "%HWDiskSerial%", "%processorID%" ],

     "tableUsers": "users",
     "tableHwids": "users_hwids",

     "userFieldHwid": "hwid",
     "userFieldLogin": "username",

     "hwidFieldBanned": "isBanned",
     "hwidFieldTotalMemory": "totalMemory",
     "hwidFieldSerialNumber": "serialNumber",
     "hwidFieldHWDiskSerial": "HWDiskSerial",
     "hwidFieldProcessorID": "processorID",

     "banMessage": "Ваш аккаунт заблокирован!"
}
</pre>
<p>Есть 2 таблицы - users и users_hwids. В первой таблице в поле hwid хранится id записи в 2 таблице, во второй таблице - характеристики машины пользователя</p>
<p>Создать необходимые поля и таблицы можно запросом</p>
<pre class="prettyprint">
ALTER TABLE `users` ADD `hwid` BIGINT NOT NULL;
CREATE TABLE users_hwids (
 id BIGINT(20) NOT NULL AUTO_INCREMENT,
 isBanned tinyint(1) NOT NULL DEFAULT '0',
 totalMemory text NOT NULL,
 serialNumber text NOT NULL,
 HWDiskSerial text NOT NULL,
 processorID text NOT NULL,
 PRIMARY KEY (id)
)
</pre>
