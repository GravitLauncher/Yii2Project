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
<p>Иногда Hibernate просит указать SQL диалект для некоторых драйверов. Список стандартных диалектов можно посмотреть <a href="https://docs.jboss.org/hibernate/orm/3.5/api/org/hibernate/dialect/package-summary.html">тут</a>. Некоторый неполный список драйверов, с которыми работает Hibernate:</p>
<ul>
<li>org.hsqldb.jdbcDriver(URL jdbc:hsqldb:hsql://localhost, Dialect org.hibernate.dialect.HSQLDialect) - HSQL - встроеная база данных в оперативной памяти. Только для тестирования</li>
<li>org.postgresql.Driver(URL jdbc:postgresql://localhost/launchserver, Dialect org.hibernate.dialect.PostgreSQLDialect) - PostgreSQL - конфигурация по умолчанию</li>
<li>com.mysql.jdbc.Driver (URL jdbc:mysql://localhost/launchserver, Dialect org.hibernate.dialect.MySQLDialect) - MySQL(MariaDB/PersonaServer)</li>
</ul>
<h3>Автосоздание таблиц</h3>
<p>У Hibernate есть возможность автоматически создать необходимые таблицы для своей работы для любой поддерживаемой БД. После настройки параметров подключения запустите лаунчсервер с опцией JVM <span class="codes">-Dhibernate.hbm2ddl.auto=ЗНАЧЕНИЕ</span>, где выберите одно из следующих значений:</p>
<ul>
<li>validate - только проверка, никаких изменений в базу не будет внесено</li>
<li>update - обновление структуры таблиц без потери данных</li>
<li>create - удаление всех данных из БД и повторное создание таблиц</li>
</ul>
