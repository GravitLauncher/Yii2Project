<?php

/* @var $this yii\web\View */

$this->title = 'AuthProvider - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "AuthProvider";
?>

<h2>Настройка AuthProvider</h2>
<h3>Способ accept</h3>
<p>Принимает любые пары логин-пароль</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "accept"
    }
  }
]
</pre>
<h3>Способ reject</h3>
<p>Отклоняет любые пары логин-пароль<br>
message - сообщение при авторизации</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "reject",
      "message": "Ведутся технические работы, приходите позже"
    }
  }
]
</pre>
<h3>Способ mysql</h3>
<p>Для проверки логина и пароля лаунчсервер обращается к базе данных mysql<br>
Этот способ НЕ подходит для сайтов с нестандартными алгоритмами хеширования<br>
mySQLHolder<br>
  address - адрес mysql сервера<br>
  port - порт mysql сервера<br>
  username - имя пользователя на сервере mysql<br>
  password - пароль пользователя<br>
  database - база данных (до ?), после находится установка серверной таймзоны<br>
  timezone - установка клиентской таймзоны<br>
query - sql запрос, ? по порядку заменяются параметрами из queryParams (перевод: "ВЫБРАТЬ логин ИЗ ТАБЛИЦЫ users ГДЕ ЛОГИН=? И пароль=MD5(?) МАКСИМУМ 1")<br>
queryParams - параметры sql запроса<br>
message - сообщение при неверном пароле</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "mysql",
      "mySQLHolder": {
        "address": "localhost",
        "port": 3306,
        "username": "launchserver",
        "password": "password",
        "database": "db?serverTimezone=UTC",
        "timezone": "UTC"
      },
      "query": "SELECT login FROM users WHERE login=? AND password=MD5(?) LIMIT 1",
      "queryParams": [ "%login%", "%password%" ],
      "message": "Пароль неверный!"
    }
  }
]
</pre>
<p>Настройка permnissions этим спосбом</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "mysql",
      "mySQLHolder": {
        "address": "localhost",
        "port": 3306,
        "username": "launchserver",
        "password": "password",
        "database": "db?serverTimezone=UTC",
        "timezone": "UTC"
      },
      "query": "SELECT login, <b>permission</b> FROM users WHERE login=? AND password=MD5(?) LIMIT 1",
      "queryParams": [ "%login%", "%password%" ],
      "usePermission": true,
      "message": "Пароль неверный!"
    }
  }
]
</pre>
<h3>Способ request</h3>
<p>Для проверки логина и пароля лаунчсервер обращается к сайту по протоколу HTTP/HTTPS<br>
url - ссылка до скрипта<br>
response - маска ответа, если не соответствует, будет выведено сообщение с возвращенным текстом</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "request",
      "url": "http://gravit.pro/auth.php?username=%login%&password=%password%&ip=%ip%",
      "response": "OK:(?&lt;username&gt;.+)"
    }
  }
]
</pre>
<p>Настройка permissions этим способом</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "request",
      "usePermission": true,
      "url": "http://gravit.pro/auth.php?username=%login%&password=%password%&ip=%ip%",
      "response": "OK:(?&lt;username&gt;.+):(?&lt;permissions&gt;.+)"
    }
  }
]
</pre>
<h3>Способ json</h3>
<p>Для проверки логина и пароля лаунчсервер обращается к сайту по протоколу HTTP/HTTPS, но в отличии от request делает POST запрос с json данными внутри<br>
url - ссылка до скрипта<br>
apiKey - секретный ключ, который может проверятся в скрипте, для безопасности</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "json",
      "url": "http://gravit.pro/auth.php",
      "apiKey": "none"
    }
  }
]
</pre>
<p>При этом способе настройка permissions не выполняется, так как по умолчанию сервер обязан передавать permissions<br>
Запрос:</p>
<pre class="prettyprint">
{
  "username": "admin",
  "password": "password",
  "ip": "127.0.0.1",
  "apiKey": "none"
}
</pre>
<p>Ответ:</p>
<pre class="prettyprint">
{
  "username": "admin",
  "permissions": 0
}
</pre>
<p>Ошибка:</p>
<pre class="prettyprint">
{
  "error": "Неверный логин или пароль"
}
</pre>
<h3>Способ hibernate</h3>
<p>Hibernate — самая популярная реализация спецификации JPA, предназначенная для решения задач объектно-реляционного отображения (ORM)<br>
Для проверки логина и пароля лаунчсервер обращается к любой базе данных<br>
Для подключения к базам данных, в libraries необходимо положить библиотеку для поддержки соответствующей базы данных<br>
Этот способ НЕ подходит для сайтов с нестандартными алгоритмами хеширования<br>
driver - класс библиотеки поддержки типа базы данных<br>
url - url вида jdbc:типбд://хост/база<br>
username - имя пользователя на сервере баз данных<br>
password - пароль пользователя</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "hibernate",
      "driver": "org.postgresql.Driver",
      "url": "jdbc:postgresql://localhost/db",
      "username": "launchserver",
      "password": "password"
    }
  }
]
</pre>