<?php

$this->title = 'Hibernate - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Hibernate";
?>

<p>Hibernate — самая популярная реализация спецификации JPA, предназначенная для решения задач объектно-реляционного отображения (ORM)<br>
Для работы, лаунчсервер подключается к любой базе данных, будь то SQLite, postgreSQL, или другие, у которых есть библиотеки под java.<br>
Библиотеки (драйвера) необходимо скачать из интернета, и положить в папку libraries.<br>
<b>Эта секция должна быть в LaunchServer.json, прям в корне, до последней }</b>
<pre class="prettyprint">
    "stripLineNumbers": true,
    "deleteTempFiles": true,
    "startScript": "./start.sh",                            // тут нужна ,
    "dao": {
        "type": "hibernate",
        "driver": "org.postgresql.Driver",                  // класс драйвера
        "url": "jdbc:postgresql://localhost/launchserver",  // URL базы данных
        "username": "launchserver",                         // имя пользователя
        "password": "xxxxx",                                // пароль
        "pool_size": "4"
    }
}
</pre>
</p>