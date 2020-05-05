<?php

/* @var $this yii\web\View */

$this->title = 'Начало работы: Конфигурация лаунчсервера';
$this->params['breadcrumbs'][] = "Runtime";
?>
<h2>Настройка лаунчсервера <div class="gtag gtag-info">Знать всем</div></h2>
<h3>Базовые параметры</h3>
<p>Это конфигурация для 5.1.0. Ваш конфиг может отличаться. Все пояснения ниже приведены для ознакомления, не пытайтесь копировать конфиг или его часть себе</p>
<pre class="prettyprint">
{
  "projectName": "GravitTestProject", // Название вашего проекта. Влияет на названия классов в .jar(proguard mapping), папку вашего сервера в AppData, название окна и многое другое
  "mirrors": [ //Один или несколько зеркал, с которых будут скачиваться клиенты командами downloadClient/downloadAsset
    "https://mirror.gravit.pro/"
  ],
  "binaryName": "Launcher", //Имя бинарника в папке updates. Меняя его не забывайте менять URL скачки
  "copyBinaries": true, //Копировать ли бинарники в updates
  "env": "STD", //Окружение, влияет на уровень отладочных сообщений
                //DEV - наибольший объем отладочных сообщений(launcher.dev/launcher.debug/launcher.stacktrace)
                //DEBUG - обычные отладочные сообщения(launcher.debug/launcher.stacktrace)
                //STD - отладка отключена по умолчанию, можно включить параметром
                //PROD - запрет установки флагов launcher.debug/launcher.stacktrace. Никаких отладочных сообщений
  "auth": { //Способы авторизации
    "std": {
      "provider": { //Auth Provider, отвечает за проверку пары логин-пароль
        "type": "accept"
      },
      "handler": { //Auth Handler, отвечает за UUID, вход на сервера
        "type": "memory"
      },
      "textureProvider": { //Texture Provider, отвечает за скины и плащи
        "skinURL": "http://example.com/skins/%username%.png",
        "cloakURL": "http://example.com/cloaks/%username%.png",
        "type": "request"
      },
      "hwid": { //HWID Handler, отвечает за бан по HWID
        "type": "accept"
      },
      "links": { //Позволяет использовать нескольким способам авторизации один handler/provider
        "provider": "myauth" //В качестве AuthProvider для этого способа авторизации использовать AuthProvider способа авторизации "myauth" 
      }
      "displayName": "Default", //Отобращаемое имя на экране логина лаунчера. Можно менять
      "isDefault": true //Способ авторизации по умолчанию
    }
  },
  "protectHandler": { //Protect Handler, отвечает за токены, выдачу accessToken
    "checkSecure": true,
    "type": "std"
  },
  "components": { //Опциональные компоненты
    "regLimiter": { //Лимит регистраций(через Hibernate/DAO)
      "message": "Превышен лимит регистраций",
      "excludeIps": [],
      "rateLimit": 3,
      "rateLimitMillis": 36000000,
      "exclude": [],
      "type": "regLimiter"
    },
    "authLimiter": { //Лимит авторизаций
      "message": "Превышен лимит авторизаций",
      "rateLimit": 3,
      "rateLimitMillis": 8000,
      "exclude": [],
      "type": "authLimiter"
    }
  },
  "launch4j": { //Создание EXE из JAR
    "enabled": true,
    "setMaxVersion": false, //Используется если вы хотите ограничить максимальную версию Java, к примеру что бы EXE файл launch4j выбрал Java 8 если установлена Java 9/11/13
    "maxVersion": "1.8.999",
    "minVersion": "1.8.0",
    "downloadUrl": "http://www.oracle.com/technetwork/java/javase/downloads/jre8-downloads-2133155.html",
    "productName": "GravitLauncher",
    "productVer": "5.1.0.0",
    "fileDesc": "GravitLauncher 5.1.0",
    "fileVer": "5.1.0.0",
    "internalName": "Launcher",
    "copyright": "© GravitLauncher Team",
    "trademarks": "This product is licensed under GPLv3",
    "txtFileVersion": "%s, build %d",
    "txtProductVersion": "%s, build %d"
  },
  "netty": {
    "fileServerEnabled": true, //Включить раздачу файлов из updates по http
    "sendExceptionEnabled": true, //Разрешить отправку сообщений об ошибке лаунчсервера на клиент. Рекомендуется false для прода
    "ipForwarding": false, //Разрешить проксирование реального IP через HTTP заголовки. Включить если используется проксирование nginx/apache2/cloudflare
    "showHiddenFiles": false, //Разрешает раздачу файлов, начинающихся с точки(.)
    "launcherURL": "http://localhost:9274/Launcher.jar", //URL скачки лаунчера(JAR)
    "downloadURL": "http://localhost:9274/%dirname%/", //URL скачки клиентов и ассетов
    "launcherEXEURL": "http://localhost:9274/Launcher.exe", //URL скачки лаунчера(EXE)
    "address": "ws://localhost:9274/api", //Адрес WebSocket API, по которому лаунчер будет подключаться
    "bindings": {}, //Настройка особых URL для скачки ассетов/клиентов
    "performance": { //Настройки производительности
      "usingEpoll": true, //Epoll, технология доступная только в Linux, ускоряет работу с множеством соеденений
      "bossThread": 2, //Начальное число потоков на прием соеденений
      "workerThread": 8 //Начальное число потоков на обработку запросов
    },
    "binds": [ //Адреса прослушивания сокета(bind)
      {
        "address": "0.0.0.0",
        "port": 9274
      }
    ],
    "logLevel": "DEBUG" //Уровень сообщений Netty в логгере slf4j
  },
  "whitelistRejectString": "Вас нет в белом списке",
  "launcher": { //Конфигурация лаунчера и его сборки
    "guardType": "no", //Тип нативной защиты AntiInject(см инструкцию к вашей нативной защите)
    "attachLibraryBeforeProGuard": false, //Добавление библиотек до proguard. Включать если это требуется по инструкции к кастомному конфигу proguard
    "compress": true, //Сжатие итогового файла
    "warningMissArchJava": true, //Предупреждение о несоответствии разрядности b/или версии Java. Отключите елси используется скачивание своей JRE
    "enabledProGuard": false, //Включить обфускацию(ProGuard)
    "stripLineNumbers": false, //Включить вырезание отладочной информации
    "deleteTempFiles": true, //Удалять временные файлы в папке build
    "proguardGenMappings": true //Включить генерацию маппингов proguard
  },
  "certificate": { //Не включать
    "enabled": false
  },
  "sign": { //Подпись лаунчера. См отдельный раздел
    "enabled": true,
    "keyStore": "GravitCodeSignEC_Java.p12",
    "keyStoreType": "PKCS12",
    "keyStorePass": "password",
    "metaInfKeyName": "SIGNUMO.EC",
    "metaInfSfName": "SIGNUMO.SF",
    "keyAlias": "1",
    "keyPass": "password",
    "signAlgo": "SHA256withECDSA"
  },
  "dao": { //Нстройка DAO/Hibernate. См отдельный раздел
    "type": "hibernate",
    "driver": "org.postgresql.Driver",
    "url": "jdbc:postgresql://localhost/launcher",
    "username": "launcher",
    "password": "password",
    "pool_size": "4"
   },
  "startScript": "./start.sh" //Скрипт запуска лаунчсервера(используется только в команде restart)
}
</pre>
