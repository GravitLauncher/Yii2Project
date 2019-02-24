<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 24.02.19
 * Time: 14:54
 */
$this->title = 'Модули - Wiki - GravitLauncher';
$this->params['breadcrumbs'][] = "Модули";
?>
<h2>Модули</h2>
<p>Этот раздел посвящен разработке модулей на Java</p>
<p>Загрузка модулей происходит из папки modules. Менеджер модулей открывает по очереди все jar и смотрит на параметр Main-Class в манифесте JAR файла.</p>
<p>Main-Class - точка входа в модуль. Он обязан расширять интерфейс Module. Требуется, что бы методы getVersion/getName возвращали корректные значения. <span class="codes">null</span> не допускается</p>
<p><span class="codes">preInit</span> - вызывается максимально рано, когда конфигурация еще не инициализирована</p>
<p><span class="codes">init</span> - вызывается после основного этапа инициализации, но до старта прослушки сокета</p>
<p><span class="codes">postInit</span> - вызывается после старта прослушки сокета</p>
<h3>ModuleContext</h3>
<p>Во все методы инициализации передается контекст модуля. ModuleContext - это интерфейс всех возможных контекстов модуля. Можно создавать свои контексты модуля и свои загрузчики модулей</p>
<p>Существует ServerModuleContext, LaunchServerModuleContext и ClientModuleContext. Во всех контекстах содержатся самые необходимые объекты для работы модуля.</p>
<h3>Пример модуля</h3>
<p>В качестве примера возьмем модуль AutoSaveSessions. Этот модуль сохраняет сессии в файл при остановке лаунчсервера и загружает их обратно при старте</p>
<pre class="prettyprint">
package ru.gravit.launchermodules.autosavesessions;

import com.google.gson.reflect.TypeToken;
import ru.gravit.launcher.modules.Module;
import ru.gravit.launcher.modules.ModuleContext;
import ru.gravit.launchserver.LaunchServer;
import ru.gravit.launchserver.modules.LaunchServerModuleContext;
import ru.gravit.launchserver.socket.Client;
import ru.gravit.utils.Version;
import ru.gravit.utils.helper.IOHelper;
import ru.gravit.utils.helper.LogHelper;

import java.io.IOException;
import java.io.Reader;
import java.io.Writer;
import java.lang.reflect.Type;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.HashSet;
import java.util.Set;

public class AutoSaveSessionsModule implements Module {
    public static Version version = new Version(1, 0, 0);
    public static String FILENAME = "sessions.json";
    public static boolean isClearSessionsBeforeSave = true;
    public Path file;

    @Override
    public String getName() {
        return "AutoSaveSessions"; //Имя модуля, будет отображаться в списках и сообщении о загрузке
    }

    @Override
    public Version getVersion() {
        return version; //Версия модуля
    }

    @Override
    public int getPriority() {
        return 0; //Не используется
    }

    @Override
    public void init(ModuleContext context) {

    }

    @Override
    public void postInit(ModuleContext context1) {
        LaunchServerModuleContext context = (LaunchServerModuleContext) context1; //Получаем контекст
        Path configDir = context.modulesConfigManager.getModuleConfigDir(getName()); //Получаем папку с конфигурацией нашего модуля. По умолчанию config/modulename
        if (!IOHelper.isDir(configDir)) {
            try {
                Files.createDirectories(configDir);
            } catch (IOException e) {
                LogHelper.error(e);
            }
        }
        file = configDir.resolve(FILENAME);
        if (IOHelper.exists(file)) {
            LogHelper.info("Load sessions from %s", FILENAME); //Загрузка сессий
            Type setType = new TypeToken&lt;HashSet&lt;Client&gt;&gt;() {
            }.getType();
            try (Reader reader = IOHelper.newReader(file)) {
                Set&lt;Client> clientSet = LaunchServer.gson.fromJson(reader, setType);
                context.launchServer.sessionManager.loadSessions(clientSet); //Обращаемся к sessionsManager для загрузки сессий
                LogHelper.info("Loaded %d sessions", clientSet.size());
            } catch (IOException e) {
                LogHelper.error(e);
            }
        }
    }

    @Override
    public void preInit(ModuleContext context) {

    }

    @Override
    public void close() {
        if (isClearSessionsBeforeSave) {
            LaunchServer.server.sessionManager.garbageCollection();
        }
        Set&lt;Client&gt; clientSet = LaunchServer.server.sessionManager.getSessions(); //Обращаемся к sessionsManager для получения сессий
        try (Writer writer = IOHelper.newWriter(file)) {
            LogHelper.info("Write sessions to %s", FILENAME);
            LaunchServer.gson.toJson(clientSet, writer);
            LogHelper.info("%d sessions writed", clientSet.size());
        } catch (IOException e) {
            LogHelper.error(e);
        }
    }
}
</pre>
<p>Что бы узнать полный список API используйте подсказки IDEA и исходный код на GitHub</p>
<p>Прочие примеры модулей можно найти <a href="https://github.com/GravitLauncher/LauncherModules">тут</a></p>