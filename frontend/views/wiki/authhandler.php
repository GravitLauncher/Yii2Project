<?php

$this->title = 'AuthHandler - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "AuthHandler";
?>
<h2>Настройка AuthHandler</h2>
<h3>Способ memory</h3>
<p>UUID получается путем преобразования бинарного представления ника<br>
Каждому нику будет соответствовать ровно один UUID</p>
<pre class="prettyprint">
"auth": [
  "handler": {
    "type": "memory"
  }
]
</pre>
<h3>Способ mysql</h3>
<p>Для получения UUID лаунчсервер обращается к базе данных mysql<br>
mySQLHolder<br>
  address - адрес mysql сервера<br>
  port - порт mysql сервера<br>
  username - имя пользователя на сервере mysql<br>
  password - пароль пользователя<br>
  database - база данных (до ?), после находится установка серверной таймзоны<br>
  timezone - установка клиентской таймзоны<br>
table - таблица в базе данных<br>
uuidColumn - название столбца с uuid<br>
usernameColumn - название столбца с именами пользователей<br>
accessTokenColumn - название столбца с accessToken<br>
serverIDColumn - название столбца с serverID</p>
<pre class="prettyprint">
"auth": [
  "handler": {
    "type": "mysql",
    "mySQLHolder": {
      "address": "localhost",
      "port": 3306,
      "username": "launchserver",
      "password": "password",
      "database": "db?serverTimezone=UTC",
      "timezone": "UTC"
    },
    "table": "users",
    "uuidColumn": "uuid",
    "usernameColumn": "username",
    "accessTokenColumn": "accessToken",
    "serverIDColumn": "serverID"
  }
]
</pre>
<p>Для автоматического создания нужных полей в таблице и созданию UUID можно воспользоватся следующими SQL запросами:</p>
<pre class="prettyprint">
-- Добавляет недостающие поля в таблицу
-- Замените table на название таблицы
 ALTER TABLE `table`
 ADD COLUMN `uuid` CHAR(36) UNIQUE DEFAULT NULL,
 ADD COLUMN `accessToken` CHAR(32) DEFAULT NULL,
 ADD COLUMN `serverID` VARCHAR(41) DEFAULT NULL;

-- Создаёт триггер на генерацию UUID для новых пользователей
-- Замените table на название таблицы
DELIMITER //
CREATE TRIGGER setUUID BEFORE INSERT ON `table`
FOR EACH ROW BEGIN
IF NEW.uuid IS NULL THEN
SET NEW.uuid = UUID();
END IF;
END; //
DELIMITER;

-- Генерирует UUID для уже существующих пользователей
-- Замените table на название таблицы
UPDATE `table` SET uuid=(SELECT UUID()) WHERE uuid IS NULL;
</pre>
<h3>Способ request</h3>
<!-- TODO -->
<h3>Способ json</h3>
<!-- TODO -->
<h3>Способ hibernate</h3>
<!-- TODO -->