<?php

$this->title = 'Download Java - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Download Java";
?>

<h2>Cкачивание своей java</h2>
<p>Для скачивания своей java надо выполнить следующие действия:<br>
1. runtime/config.js
<pre class="prettyprint">
jvm: {
        enable: false,
		jvmMustdie32Dir: "jre-8u202-win32",
        jvmMustdie64Dir: "jre-8u202-win64",
}
</pre>
меняем на
<pre class="prettyprint">
jvm: {
        enable: true,
		jvmMustdie32Dir: "jre-8u211-win32",
        jvmMustdie64Dir: "jre-8u211-win64"
}
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
3. Распаковываем <a href="https://yadi.sk/d/B7FMKOP6AEtCrA">этот архив</a> в папку updates<br>
4. Выполняем команды в лаунчсервере: syncUpdates и build
</p>