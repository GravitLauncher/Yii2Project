<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:45
 */

$this->title = 'AuthHandler - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "AuthHandler";
?>
<h2>Настройка AuthHandler</h2>
<h3>Способ memory</h3>
<p>UUID получается путем преобразования бинарного представления ника<br>
    Каждому нику будет соответствовать ровноо один uuid<br>
    Возможны вылеты исключений, если гдето в модах/плагинах для фейк игрока прописан неподходящий uuid</p>
<pre class="prettyprint">
"authHandler": {
     "type": "memory"
}
</pre>
<h3>Способ mysql</h3>
<p>Для получения UUID лаунчсервер обращается к базе данных mysql</p>
<pre class="prettyprint">
"authHandler": {
     "type": "mysql",
     "mySQLHolder": {
       "address": "localhost",
       "port": 3306,
       "username": "launchserver",
       "password": "password",
       "database": "db"
     },

     "table": "users",
     "uuidColumn": "uuid",
     "usernameColumn": "username",
     "accessTokenColumn": "access_token",
     "serverIDColumn": "server_id"
}
</pre>
<p>Для автоматического создания нужных полей в таблице можно воспрользоваться SQL запросом</p>
<pre class="prettyprint">
-- Добавляет недостающие поля в таблицу
 ALTER TABLE `users`
 ADD COLUMN `uuid` CHAR(36) UNIQUE DEFAULT NULL,
 ADD COLUMN `access_token` CHAR(32) DEFAULT NULL,
 ADD COLUMN `server_id` VARCHAR(41) DEFAULT NULL;

 -- Создаёт триггер на генерацию UUID для новых пользователей
 DELIMITER //
 CREATE TRIGGER setUUID BEFORE INSERT ON `users`
 FOR EACH ROW BEGIN
 IF NEW.uuid IS NULL THEN
 SET NEW.uuid = UUID();
 END IF;
 END; //
 DELIMITER ;

 -- Генерирует UUID для уже существующих пользователей
 UPDATE users SET uuid=(SELECT UUID()) WHERE uuid IS NULL;
</pre>
<h3>Способ mojang</h3>
<p><b>Начиная с 5.0 этот способ вынесен в модуль LegacySupport</b></p>
<p>Обратите внимание: при использовании этого способа НЕ РЕКОМЕНДУЕТСЯ привязывать ваш сервер к лаунчеру.</p>
<p>Выполняет запрос к веб серверам mojang для получения UUID</p>
<pre class="prettyprint">
"authHandler": [
 {
     "type": "mojang"
 }
]
</pre>