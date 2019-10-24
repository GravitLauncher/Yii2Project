<?php

$this->title = 'Download Java - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Download Java";
?>

<h2>Cкачивание своей java</h2>
<p>Для скачивания своей java надо выполнить следующие действия:<br>
1. runtime/config.js
<pre class="prettyprint">
jvm: {
    enable: true,                        // Включение загрузки своей JVM
    jvmMustdie32Dir: "jre-8u231-win32",  // Название папки JVM для Windows x32
    jvmMustdie64Dir: "jre-8u231-win64",  // Название папки JVM для Windows x64
},
</pre>
2. LaunchServer.json
<pre class="prettyprint">
"launcher": {
    "guardType": "no"
}
</pre>
меняем на
<pre class="prettyprint">
"launcher": {
    "guardType": "java"
}
</pre>
3. Распаковываем <a href="https://mirror.gravit.pro/jre8u231-win.zip">этот архив</a> в папку updates<br>
4. Выполняем команды в лаунчсервере: syncUpdates и build
</p>