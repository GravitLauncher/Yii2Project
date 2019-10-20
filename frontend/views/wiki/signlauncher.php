<?php

$this->title = 'Signing launcher - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Signing launcher";
?>

<h2>Где взять сертификат</h2>
Вариантов несколько:
<ul>
<li>Можно сгенерировать самому себе самоподписанный сертификат</li>
<li>Можно купить сертификат для подписи лаунчера у официальных СА (очень дорого)</li>
<li>Можно попросить сертификат у того, кто уже настроил грамотно свой СА и может подписывать другие сертификаты</li>
</ul>
<h2>Подпись jar</h2>
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
</span>
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
<h2>Подпись exe</h2>
<b>Инструкция и скрипты написаны под Linux</b>
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
<b>При каждом билде шаги 3-4 нужно будет повторять заново</b>
<b>При появлении ошибки <span class="codes">Corrupt jar file</span> (размер подписи изменился) заново выполните шаги 1-4</b>
</p>