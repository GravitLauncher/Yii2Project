<?php

$this->title = 'Signing launcher - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Signing launcher";
?>

<h2>Где взять сертификат <div class="gtag gtag-medium">Средний уровень</div></h2>
Вариантов несколько:
<ul>
<li>Можно сгенерировать самому себе самоподписанный сертификат</li>
<li>Можно попросить сертификат у того, кто уже настроил грамотно свой СА и может подписывать другие сертификаты (Например maintainer Gravit, активные участники sasha0552, radioegor146 за небольшую сумму (до 500 рублей))<br>
Для этого надо создать CSR, и передать его человеку, который его подпишет (см. инструкцию в конце)</li>
<li>Можно отдавать каждый билд лаунчера человеку, имеющему сертификат, но не являющийся СА, на подпись. (Например активный участник Xaver будет подписывать каждый билд в течении года за 3+ тысяч рублей)</li>
<li>Можно купить сертификат для подписи лаунчера у официальных СА (очень дорого)</li>
</ul>
<h2>Подпись jar <div class="gtag gtag-medium">Средний уровень</div></h2>
<p>Этот гайд необходим всем тем кто хочет настроить JarSigner module, а так же начиная с 5.0.10 подписывание будет обязательным.<br>
Перед началом работы, у вас уже должны быть:
<ol>
<li>Установлен модуль JarSigner</li>
<li>Сертификат</li>
</ol>
Конфигурация:
<h3>Для формата PKCS12 (рекомендуется)</h3>

<pre class="prettyprint">
{
  "key": "/home/myname/MyCert.p12",  // Путь к хранилищу ключей
  "storepass": "mypassword",         // Пароль от хранилища
  "algo": "PKCS12",                  // Тип хранилища
  "keyalias": "gravit code sign",    // Key Alias, см ниже как его узнать
  "pass": "mypassword",              // Пароль от хранилища, совпадает с storepass
  "signAlgo": "SHA256WITHRSA"        // При использовании ключей на эллиптический криптографии используйте SHA256withECDSA
}
</pre>
<h4>Как узнать key alias из PKCS12 хранилища</h4>
Выполните <span class="codes">keytool -storepass ПарольОтХранилища -keystore ПутьКХранилищу -list</span><br>
У вас будет такой вывод<br>
<span class="codes">Your keystore contains 1 entry
untrusted code sign, 20.10.2019, PrivateKeyEntry,
</span><br>
untrusted code sign - ваш key alias, его вы и должны будете указать<br>
<b>Утилита keystore поставляется вместе с JDK</b>
<h3>Для JKS(Java KeyStore)</h3>
<pre class="prettyprint">
{
  "key": "/home/myname/MyCert.jks",  // Путь к хранилищу ключей
  "storepass": "mypassword",         // Пароль от хранилища
  "algo": "JKS",                     // Тип хранилища
  "keyalias": "gravit code sign ec", // Key Alias, задается при создании
  "pass": "mypassword",              // Пароль от хранилища, может не совпадать с storepass
  "signAlgo": "SHA256WITHRSA"        // При использовании ключей на эллиптический криптографии используйте SHA256withECDSA
}
</pre>
<h2>Подпись exe  <div class="gtag gtag-hard">Сложный уровень</div></h2>
<b>Инструкция и скрипты написаны под Linux</b><br>
Перед началом работы с этими скриптами у вас уже должны быть:
<ol>
<li>Установлен osslsigncode<br>
Debian-подобные системы: sudo apt install osslsigncode</li>
<li>Сертификат</li>
<li><a class="link-animated" href="https://yadi.sk/d/PAt9gkJyBORXjA">Скрипты для подписи</a></li>
</ol>
Если ваш сертификат имеет расширение pfx просто переименуйте его в p12 (это одно и тоже)<br>
В другом случае конвертируйте свой сертификат в формат p12<br>
<ol>
<li>В папку с скриптами положите ваш Launcher.exe</li>
<li>Выполните <span class="codes">sh sign-update.sh Launcher.exe</span><br>
Будет создан файл signsize.txt, который понадобится на следующем этапе<br>
Эту процедуру достаточно провести один раз</li>
<li>Выполните <span class="codes">sh sign.sh Launcher.exe</span><br>
У вас в папке со скриптами должен присутствовать signsize.txt<br>
Если всё прошло успешно, вам покажет информацию о сертификатах внутри exe</li>
<li>Замените ваш Launcher.exe рядом с лаунчсервером подписанной версией, и пропишите <span class="codes">syncBinaries</span> в консоли лаунчсервера</li>
</ol>
<b>При каждом билде шаги 3-4 нужно будет повторять заново</b><br>
<b>При появлении ошибки <span class="codes">Corrupt jar file</span> (размер подписи изменился) заново выполните шаги 1-4</b>
<h2>Создание CSR (Certificate Signing Request) для 3 варианта получения сертификата <div class="gtag gtag-medium">Средний уровень</div></h2>
<b>CSR это не сертификат - это запрос на сертификат</b><br>
<b>Необходимо установить <a class="link-animated" href="https://www.openssl.org/source/">OpenSSL</a></b><br>
В терминале:<br>
<span class="codes">openssl genrsa -out private.key 4096</span><br>
4096 - это размер приватного ключа в битах. Можно использовать от 1024 бит (небезопасно) до 8192 (безопасно).<br>
<b>Приватный ключ не должен быть скомпрометирован никем, и не должен передаватся по незащищенным каналам связи</b><br><br>
<b>Если вы хотите использовать эллиптические кривые вместо RSA:</b><br>
<span class="codes">openssl ecparam -name secp256k1 -genkey -out private.key</span><br>
Где secp256k1 -  название эллиптической кривой<br>
Вы можете выбрать любую кривую на свое усмотрение, если понимаете что делаете<br>
В противом случае рекомендуется оставить всё как есть<br><br>
Далее:<br>
<span class="codes">openssl req -new -key private.key -out cert.csr</span><br>
И отвечаем на вопросы примерно так:
<pre class="prettyprint">
Country Name (2 letter code) [AU]:RU
State or Province Name (full name) [Some-State]:Russia
Locality Name (eg, city) []:Moscow
Organization Name (eg, company) [Internet Widgits Pty Ltd]:MyProjectName              
Organizational Unit Name (eg, section) []:IT
Common Name (e.g. server FQDN or YOUR name) []:MyProjectName Code Sign
Email Address []:admin@myproject.name
A challenge password []:
An optional company name []:
</pre>
После чего CSR вы должны отправить тому, кто подпишет вам сертификат своим СА<br>
После получения сертификата (.pem) соберите его с своим приватным ключем в формат pfx<br>
<span class="codes">openssl pkcs12 -export -in MyProjectName_Code_Sign.pem -inkey private.key -out cert.pfx</span><br>
У вас спросят пароль. Если вы хотите дополнительно защитить ваш ключ - можете поставить<br>
Готовый pfx вы можете использовать для подписи самостоятельно
</p>
