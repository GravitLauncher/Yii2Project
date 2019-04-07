<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:40
 */

/* @var $this yii\web\View */

$this->title = 'AuthProvider - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "AuthProvider";
?>

<h2>Настройка AuthProvider</h2>
<h3>Способ reject</h3>
<p>Отклоняет любые пары логин-пароль</p>
<pre class="prettyprint">
 "authProvider": [
     {
         "type": "reject",
         "message": "Ведутся технические работы, приходите позже."
     }
 ]
 </pre>
<h3>Способ accept</h3>
<p>Принимает любые пары логин-пароль</p>
<pre class="prettyprint">
 "authProvider": [
     {
         "type": "accept"
     }
 ]
</pre>
<h3>Способ request</h3>
<p>Для проверки логина и пароля лаунчсервер обращается к сайту по протоколу HTTP/HTTPS</p>
<pre class="prettyprint">
"authProvider": [
     {
       "url": "http://gravitlauncher.ml/auth.php?username=%login%&password=%password%",
       "response": "OK:(?&lt;username&gt;.+)", // Маска ответа
       "type": "request"
     }
]
</pre>
<p>Настройка permissions этим способом</p>
<pre class="prettyprint">
"authProvider": [
     {
       "url": "http://gravitlauncher.ml/auth.php?username=%login%&password=%password%",
       "usePermission": true,
       "response": "OK:(?&lt;username&gt;.+):(?&lt;permissions&gt;.+)", // Маска ответа
       "type": "request"
     }
]
</pre>
<h3>Способ mysql</h3>
<p>Для проверки логина-пароля лаунчсервер обращается к базе данных mysql<br>
    Этот способ НЕ подходит для сайтов с нестандартнми алгоритмами хеширования</p>
<pre class="prettyprint">
 "authProvider": [
 {
     "type": "mysql",
     "mySQLHolder": {
         "address": "localhost",
         "port": 3306,
         "username": "launchserver",
         "password": "password",
         "database": "db",
         "timezone": "UTC"
     },
     "query": "SELECT name FROM dle_users WHERE (email=? OR name=?) AND password=MD5(MD5(?)) LIMIT 1",
     "queryParams": [ "%login%", "%login%", "%password%" ],
     "message": "Пароль неверный!"
 }
]
</pre>
<p>Настройка permnissions этим спосбом</p>
<pre class="prettyprint">
 "authProvider": [
 {
     "type": "mysql",
     "mySQLHolder": {
         "address": "localhost",
         "port": 3306,
         "username": "launchserver",
         "password": "password",
         "database": "db",
         "timezone": "UTC"
     },
     "query": "SELECT name,permission FROM dle_users WHERE (email=? OR name=?) AND password=MD5(MD5(?)) LIMIT 1",
     "queryParams": [ "%login%", "%login%", "%password%" ],
     "usePermission": true,
     "message": "Пароль неверный!"
 }
]
</pre>
<h3>Способ json</h3>
<p>Для проверки логина-пароля лаунчсервер обращается к сайту по протоколу HTTP/HTTPS, но в отличии от request делает POST запрос с json данными внутри</p>
<pre class="prettyprint">
"authProvider": [
 {
     "type": "json",
     "url": "http://gravitlauncher.ml/auth.php",
     "apiKey": "none" //Любая строка, передается в каждом запросе
 }
]
</pre>
<p>При этом способе настройка permissions не выполняется, так как по умолчанию сервер обязан передавать permissions
    <br>Запрос:</p>
<pre class="prettyprint">
{
    "username": "Admin",
    "password": "password",
    "ip": "127.0.0.1",
    "apiKey": "none"
}
</pre>
<p>Ответ:</p>
<pre class="prettyprint">
{
    "username": "Admin",
    "permissions": 0 //Маска привилегий
}
</pre>
<p>Ошибка:</p>
<pre class="prettyprint">
{
    "error": "Неверный логин или пароль"
}
</pre>
<h3>Способ mojang</h3>
<p><b>Начиная с 5.0 этот способ вынесен в модуль LegacySupport</b></p>
<p>Выполняет запрос к веб серверам mojang для проверки логина-пароля</p>
<pre class="prettyprint">
"authProvider": [
 {
     "type": "mojang"
 }
]
</pre>
