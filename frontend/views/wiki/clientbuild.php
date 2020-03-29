<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:46
 */
$this->title = 'Сборка клиента - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Сборка клиента";
?>
<h2>Сборка клиента на версиях до 5.1.0 <div class="gtag gtag-easy">Это просто</div></h2>
<p>Никаких специальных действий не требуется. Соблюдайте структуру папок и профиля, для этого за основу вы можете взять ближайший по версии, уже готовый профиль/клиент и подправить необходимые параметры. Некоторые клиенты(1.14/1.15) умельцы уже собрали и выложили на своё зеркало. Следите за доступными зеркалами на нашем Discord сервере, там же можно задать вопрос по сборке какой то нестандартной версии</p>
<h2>Сборка клиента на версии 5.1.0+ <div class="gtag gtag-important">Важно</div></h2>
<p>Для уже готового клиента, скачанного с зеркала выполните:</p>
<ul>
<li>Вам необходимо будет скопировать файл authlib-clean.jar отсюда ( <a href="https://github.com/GravitLauncher/Launcher/raw/master/compat/authlib/authlib-clean.jar">master</a> ) в папку libraries клиента</li>
<li>Скопируйте из артефактов сборки файл LauncherAuthlib.jar в папку libraries клиента</li>
</ul>
<p>Для сборки клиента с <b>Forge</b> также выполните следущее:</p>
<ul>
  <li>Скачайте клиентский лаунчвраппер и <b>замените</b> предыдущий лаунчвраппер в папке librares клиента.(<a href="https://mirror.gravit.pro/compat/launchwrapper-1.12-5.1.x-clientonly.jar">ссылка</a> на момент публикации)(<u>только клиент</u>) Так как launchwrapper может постоянно фиксится под 5.1.0 следите за discord сервером</li>
</ul>
<p>Для сборки клиента с <b>Fabric</b> выполните следущее:</p>
<ul>
  <li>Добавьте путь к библиотекам guava и jimfs в altClassPath. Например:
    <pre class="prettyprint">
"altClassPath": [
  "libraries/com/google/jimfs/jimfs/1.1/jimfs-1.1.jar",
  "libraries/com/google/guava/guava/21.0/guava-21.0.jar"
]</pre>
    <p>Объяснение: jimfs использует технологию сервисов(ServiceLoader) и требует, что бы он был загружен системным загрузчиком классов(SystemClassLoader), в противном случае JVM не сможет правильно зарегистрировать обработчик URL'ов jimfs</p>
  </li>
</ul>
<h3>Подпись всего клиента <div class="gtag gtag-hard">Сложный уровень</div></h3>
<p>Начиная с 5.1.0 появилась возможность подписывать не только лаунчер, а весь клиент целиком. Подпись всего клиента осуществляется командой signdir и доступна только если у вас настроен свой сертификат(автосгенерированный не подойдет). Перед началом подписи убедитесь что вы настроили раздел sign Лаунчсервера</p>
<ol>
<li>Сделайте бекап клиента</li>
<li>Подготовьте клиент к подписи. Удалите из forge.jar/minecraft.jar/liteloader.jar файлы подписи, которые находятся в META-INF и имеют разрешение .SF/.RSA/.EC при их наличии. Так же может понадобится удаление из манифеста всех хешей. Убедитесь, что ничего вы этим действием не сломали</li>
<li>Выполните <span class="codes">signdir updates/ВашКлиент</span></li>
<li>Выполните <span class="codes">syncUpdates</span></li>
</ol>
<p>После каждого обновления модов и любых других .jar файлов вам нужно будет их переподписать командой <span class="codes">signjar updates/ВашКлиент/ПутьКФайлу</span>. Команда signdir не умеет игнорировать уже подписанные файлы, имейте это ввиду</p>
<p>Подпись клиента - вспомогательное действие, нужное некоторым защитам от читов для нормальной работы</p>
<h3>Наложение патчей на клиент <div class="gtag gtag-hard">Сложный уровень</div></h3>
<p>Для работы некоторых возможностей лаунчера необходимо, что бы обращения к некоторым вызовам перенаправлялись в лаунчер. Это можно сделать с помощью мультикоманды patcher из UnsafeCommandsPack</p>
<style>
table {
border: 1px solid grey;
padding: 3px;
} 
/* границы ячеек первого ряда таблицы */
th {
border: 1px solid grey;
padding: 3px;
}
/* границы ячеек тела таблицы */
td {
border: 1px solid grey;
padding: 3px;
}
</style>
<table>
<tr><th>Исходный класс</th><th>Исходный метод</th><th>Прокси класс</th><th>Прокси метод</th></tr>
<tr><td>java.lang.System</td><td>setSecurityManager</td><td>pro.gravit.launcher.api.SystemService</td><td>setSecurityManager</td></tr>
<tr><td>java.lang.System</td><td>exit</td><td>pro.gravit.launcher.api.SystemService</td><td>exit</td></tr>
</table>
<p>Так как это статические функции то должен использоваться патчер, который работает с опкодом INVOKESTATIC. В данном случае это <span class="codes">pro.gravit.launchermodules.unsafecommands.patcher.StaticReplacerPatcher</span>. Этот патчер принимает 4 аргумента в том порядке, в котором они указаны в таблице.</p>
<p>Нет смысла пытаться пропатчить все .jar файлы(включая моды) этим патчером. Как правило достаточно патча forge.jar, так как в других файлах(и тем более модах) эти вызовы встречатся не должны. В выборе что патчить руководствуйтесь инструкцией к вашей защите</p>
