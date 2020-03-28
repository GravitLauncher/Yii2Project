<?php

/* @var $this yii\web\View */

$this->title = 'AuthProvider - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "AuthProvider";
?>

<h2>Настройка AuthProvider</h2>
<h3>Способ accept <div class="gtag gtag-easy">Только для ознакомления</div></h3>
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
<h3>Способ reject <div class="gtag gtag-easy">Это просто</div></h3>
<p>Отклоняет любые пары логин-пароль</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "reject",
      "message": "Ведутся технические работы, приходите позже" // cообщение при авторизации
    }
  }
]
</pre>
<h3>Способ mysql <div class="gtag gtag-easy">Это просто</div></h3>
<p>Для проверки логина и пароля лаунчсервер обращается к базе данных mysql<br>
<b>Этот способ НЕ подходит для сайтов с нестандартными алгоритмами хеширования</b></p>
<b>В базе данных создайте поле permissions типа BIGINT(значение по умолчанию 0)</b></p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "mysql",
      "mySQLHolder": {
        "address": "localhost",               // адрес mysql сервера
        "port": 3306,                         // порт mysql сервера
        "username": "launchserver",           // имя пользователя
        "password": "password",               // пароль пользователя
        "database": "db",                     // база данных, при проблемах с timezone используйте "database": "db?serverTimezone=UTC"
        "timezone": "UTC"                     // установка клиентской таймзоны
      },
      "query": "SELECT login, permission FROM users WHERE login=? AND password=MD5(?) LIMIT 1", // sql запрос
      "queryParams": [ "%login%", "%password%" ],                                               // параметры sql запроса
      "usePermission": true,
      "message": "Пароль неверный!"                                                             // сообщение при неверном пароле
    }
  }
]
</pre>
<h3>Способ postgresql <div class="gtag gtag-medium">Средний уровень</div></h3>
<p>Для проверки логина и пароля лаунчсервер обращается к базе данных postgresql<br>
<b>Этот способ НЕ подходит для сайтов с нестандартными алгоритмами хеширования</b></p>
<b>В базе данных создайте поле permissions типа bigint(значение по умолчанию 0)</b></p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "postgresql",
      "postgreSQLHolder": {
        "address": "localhost",               // адрес postgresql сервера
        "port": 3306,                         // порт postgresql сервера
        "username": "launchserver",           // имя пользователя
        "password": "password",               // пароль пользователя
        "database": "db",                     // база данных, при проблемах с timezone используйте "database": "db?serverTimezone=UTC" (?)
        "timezone": "UTC"                     // установка клиентской таймзоны
      },
      "query": "SELECT login, permission FROM users WHERE login=? AND password=MD5(?) LIMIT 1", // sql запрос
      "queryParams": [ "%login%", "%password%" ],                                               // параметры sql запроса
      "usePermission": true,
      "message": "Пароль неверный!"                                                             // сообщение при неверном пароле
    }
  }
]
</pre>
<h3>Способ request <div class="gtag gtag-easy">Это просто</div></h3>
<p>Для проверки логина и пароля лаунчсервер обращается к сайту по протоколу HTTP/HTTPS</p>
<p>Ответ сервера должен выглядеть так: OK:Gravit:0, где Gravit - ваш никнейм, 0 - маска permissions</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "request",
      "usePermission": true,
      "url": "http://gravit.pro/auth.php?username=%login%&password=%password%&ip=%ip%",
      "response": "OK:(?&lt;username&gt;.+):(?&lt;permission&gt;.+)"
    }
  }
]
</pre>
<p>Некоторые скрипты авторизации не поддерживают передачу permissions и их ответ выглядит как OK:Gravit, где Gravit - ваш никнейм<br>
Вы можете использовать конфигурацию ниже на версиях до 5.1.0, однако <b>рекомендуется найти/написать/подправить скрипт, что бы он передавал permissions</b></p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "request",
      "url": "http://gravit.pro/auth.php?username=%login%&password=%password%&ip=%ip%", // ссылка до скрипта проверки логина-пароля
      "response": "OK:(?&lt;username&gt;.+)" // маска ответа, если не соответствует, будет выведено сообщение с возвращенным текстом
    }
  }
]
</pre>
<h3>Способ json <div class="gtag gtag-medium">Средний уровень</div></h3>
<p>Для проверки логина и пароля лаунчсервер обращается к сайту по протоколу HTTP/HTTPS, но в отличии от request делает POST запрос с json данными внутри</p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "json",
      "url": "http://gravit.pro/auth.php", // ссылка до скрипта проверки логина-пароля
      "apiKey": "none"                     // секретный ключ, который может проверятся в скрипте, для безопасности
    }
  }
]
</pre>
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
<h3>Способ hibernate <div class="gtag gtag-medium">Средний уровень</div></h3>
<p>Hibernate — самая популярная реализация спецификации JPA, предназначенная для решения задач объектно-реляционного отображения (ORM)<br>
Для проверки логина и пароля лаунчсервер обращается к любой базе данных<br>
<b>Для подключения к базам данных, в libraries необходимо положить библиотеку для поддержки соответствующей базы данных</b><br>
<a href="index.php?r=wiki/page&page=hibernate">Инструкция по настройке Hibernate</a></p>
<pre class="prettyprint">
"auth": [
  {
    "provider": {
      "type": "hibernate"
    }
  }
]
</pre>
<h2>Permissions. Маска <div class="gtag gtag-medium">Средний уровень</div></h2>
<p>Маска permissions представляет собой обычное 64-битное число(long в Java/BIGINT в mySQL), каждый бит которого отвечает за определенную привилегию.<br>
Что бы получить право ADMIN+SERVER вы должны сложить(выполнить побитовое ИЛИ если точнее, в простых случаях эквивалентно сложению) числа, соответствующие правам ADMIN и SERVER</p>
<ul>
<li>Ничего - 0</li>
<li>canAdmin - 1</li>
<li>canServer - 2 (устаревший)</li>
<li>canUSR1 - 4</li>
<li>canUSR2 - 8</li>
<li>canUSR3 - 16</li>
<li>canBot - 32 (устаревший)</li>
</ul>
<p>Проверка в лаунчере выполняется путем выполнения побитового И, например если для опционального мода требуется право 9(canUSR2+canAdmin) то подойдут 9, 11, 13, 15 и тд</p>
