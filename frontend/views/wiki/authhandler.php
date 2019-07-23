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
<p>Для получения UUID лаунчсервер обращается к базе данных mysql</p>
<pre class="prettyprint">
"auth": [
  "handler": {
    "type": "mysql",
    "mySQLHolder": {
      "address": "localhost",              // адрес mysql сервера
      "port": 3306,                        // порт mysql сервера
      "username": "launchserver",          // имя пользователя
      "password": "password",              // пароль пользователя
      "database": "db?serverTimezone=UTC", // база данных (до ?), после находится установка серверной таймзоны
      "timezone": "UTC"                    // установка клиентской таймзоны
    },
    "table": "users",                      // таблица
    "uuidColumn": "uuid",                  // название столбца с uuid
    "usernameColumn": "username",          // название столбца с именами пользователей
    "accessTokenColumn": "accessToken",    // название столбца с accessToken
    "serverIDColumn": "serverID"           // название столбца с serverID
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
DELIMITER ;

-- Генерирует UUID для уже существующих пользователей
-- Замените table на название таблицы
UPDATE `table` SET uuid=(SELECT UUID()) WHERE uuid IS NULL;
</pre>
<h3>Способ request</h3>
<p>Для получения и обновления uuid, accessToken, serverID лаунчсервер обращается к сайту по протоколу HTTP/HTTPS<br>
В скобках указаны параметры запроса</p>
<pre class="prettyprint">
"auth": [
  {
    "handler": {
      "type": "request",
      "usernameFetch": "http://gravit.pro/usernameFetch.php",   // получение uuid:accessToken:serverID по имени пользователя (user)
      "uuidFetch": "http://gravit.pro/uuidFetch.php",           // получение username:accessToken:serverID по uuid (uuid)
      "updateAuth": "http://gravit.pro/updateAuth.php",         // скрипт обновления accessToken и uuid по имени пользователя (user, uuid, token)
      "updateServerID": "http://gravit.pro/updateserverID.php", // скрипт обновления serverID по uuid (serverid, uuid)
      "splitSymbol": ":",     // символ разделения в uuidFetch и usernameFetch (например: "username:accessToken:serverID") 
      "goodResponse": "OK"    // ответ updateAuth и updateServerID, когда все прошло успешно
    }
  }
]
</pre>
<h3>Способ json</h3>
<!-- TODO -->
<h3>Способ hibernate</h3>
<p>Hibernate — самая популярная реализация спецификации JPA, предназначенная для решения задач объектно-реляционного отображения (ORM)<br>
Для проверки логина и пароля лаунчсервер обращается к любой базе данных<br>
<b>Для подключения к базам данных, в libraries необходимо положить библиотеку для поддержки соответствующей базы данных</b><br>
<a href="index.php?r=wiki/page&page=hibernate">Инструкция по настройке Hibernate</a></p>
<pre class="prettyprint">
"auth": [
  {
    "handler": {
      "type": "hibernate"
    }
  }
]
</pre>