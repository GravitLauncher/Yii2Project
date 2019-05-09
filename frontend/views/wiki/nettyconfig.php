<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:45
 */

$this->title = 'NettyConfig - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "NettyConfig";
?>
<h2>О вебсокетах</h2>
<p>WebSocket — протокол связи поверх TCP-соединения, предназначенный для обмена сообщениями между браузером и веб-сервером в режиме реального времени. (с) Википедия</p>
<p>Этот протокол позворяет лаунчсерверу педедавать события(events) подключенным клиентам вне зависимости от того, посылали они запрос или нет.</p>
<p>Скачивание ассетов и клиента проходит по протоколу http/https. Это позволяет подключить CDN и значительно ускоить загрузку файлов на машинах ваших пользователей</p>
<p>Благоря переходу на этот протокол лаунчсервер может находиться как за nginx, так и за cloudflare, или за обоими сразу. Так же это позволяет установить лаунчер на бесплатный сервис <a href="https://www.openshift.com/">OpenShift</a>(UPD: уже 60 дней trial период).</p>
<p>Благодаря возможностям проксирвоания DDoS атаки на лаунчсервер значительно усложняются, а то и становятся невозможными</p>
<h2>Проксирование лаунчсервера через Nginx и CloudFlare</h2>
<p>Для проксирования можно воспроьзоваться следующим конфигом nginx</p>
<p>Подходит если у вас нет SSL сертификата или его предоставляет вам CloudFlare</p>
<pre class="prettyprint">
server {
        listen 80;
        server_name projectname.ru;
        location / {
                root /путь/до/updates;
        }
        location /api {
                proxy_pass http://localhost:9274/api;
                proxy_set_header Host $host;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header X-Real-IP $remote_addr;
        }
}
</pre>
<p>Подходит если у вас есть SSL сертификат(в том числе от Let's Encrypt)</p>
<pre class="prettyprint">
    server {
        listen 80;
        listen 443 ssl;
        server_name projectname.ru;
        ssl_certificate /путь/до/сертификата.crt;
        ssl_certificate_key /путь_до/ключа/сертификата.key;
        location / {
                root /путь/до/updates;
        }
        location /api {
                proxy_pass http://localhost:9274/api;
                proxy_set_header Host $host;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header X-Real-IP $remote_addr;
        }
}
</pre>