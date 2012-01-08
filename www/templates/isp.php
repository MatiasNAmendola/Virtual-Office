<?
class isp {
    # HID_USER HID_PASS
    #show_databases("hid_user1", "hid_user1_pass");
    public function show_databases($hid_user, $hid_pass){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=db";
        # echo $url;
        # exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # ROOT ROOT_PASS DB_NAME HID_USER DB_USERNAME DB_UNAME_PASS
    # add_databases("root", "root_pass", "hiduser_db1","hid_user" ,"db_uname", "db_upass");
    public function add_databases($root, $rootpass, $db_name, $hid_user, $db_uname, $db_upass){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=db.edit";

        $add_db["sok"] = "yes";
        $add_db["elid"] = "";

        $add_db["name"] =  $db_name; #- Имя базы..
        $add_db["dbtype"] =  "MySQL"; #- Тип базы данных..
        $add_db["owner"] =  $hid_user; #- Владелец..
        $add_db["dbencoding"] = "utf8"; #- Кодировка..
        #$add_db["dbuser"] =  ""; #- Пользователь..
        $add_db["dbusername"] =  $db_uname; #- Новый пользователь..
        $add_db["dbpassword"] =  $db_upass; #- Пароль..
        $add_db["dbconfirm"] =  $db_upass; #- Подтверждение..
        #$add_db["dbuserhost"] =  ""; #- Удалённый доступ.

        foreach( $add_db as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        # echo $url;
        # exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # HID_USER HID_PASS DATABASES
    #delete_databases("hid_user", "hid_pass" , "databases");
    public function delete_databases($hid_user, $hid_pass, $databases){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=db.delete";
        # echo $url;
        # exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $delete_databases["elid"] = $databases;

        foreach( $delete_databases as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # ROOT ROOT_PASS HID_USER DOMAIN_WWW EMAIL
    # add_domain("root", "root_pass", "hid_user", "domain1.ru", "webmaster@yandex.ru");
    public function add_domain($root, $rootpass, $hid_user, $domainwww, $email){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=wwwdomain.edit";

        $add_domain["sok"] = "yes";
        $add_domain["elid"] = "";

        $add_domain["domain"] = $domainwww;
        $add_domain["alias"] = "www.".$domainwww;
        $add_domain["docroot"] = "/www/".$domainwww;
        $add_domain["owner"] = $hid_user;
        #add_domain["version"].

        $add_domain["ip"] = $_SERVER['SERVER_ADDR'];
        #ip6 - IPv6-адрес. Параметр зависим от возможности ipv6..
        #pool - Пул приложений. Параметр зависим от возможности windows..
        $add_domain["admin"] = $email;
        $add_domain["charset"] = "UTF-8";
        $add_domain["index"] = "index.php";
        #autosubdomain - Авто поддомены. Параметр зависим от возможности asd..

        #Возможные значения :.
        $add_domain["asdnone"] = "on";
        #asddir = "/var/www/".$hid_user."/data/www/".$domainwww;
        #asdsubdir - В поддиректории WWW домена.
        $add_domain["php"] = "phpfcgi";

        #Возможные значения :.
        #phpnone - Нет поддержки PHP.
        #phpmod - PHP как модуль Apache.
        #phpcgi - PHP как CGI.
        $add_domain["phpfcgi"] = "on";
        #- PHP как FastCGI.
        $add_domain["cgi"] = "on" ;
        #Cgi-bin. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности cgi..
        #wsgi - wsgi-scripts. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности wsgi..
        #ssi - SSI. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности ssi..

        #ssiext - Расширения файлов SSI. Параметр зависим от возможности ssi..
        #frp - FrontPage. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности frp..

        #fppasswd - Пароль для FrontPage. Параметр зависим от возможности frp..
        #ror - Ruby on rails. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности ror..

        #ssl - SSL. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности ssl..

        #sslport - SSL порт. Параметр зависим от возможности ssl..
        #cert - SSL сертификат. Параметр зависим от возможности ssl..
        #switchispmgr - Отключить ISPmanager. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".).
        $add_domain["logrequests"] = "on";

         foreach( $add_domain as $k => $v )
            {
             $url .= '&'.$k.'='.urlencode($v);
            }
        # echo $url;
        # exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # ROOT ROOT_PASS USER PASS EMAIL 
    # add_user_hid("root", "root_pass", "hid_user", "hid_pass", "webmaster@yandex.ru");
    public function add_user_hid($root, $rootpass, $hid_user, $hid_password, $hid_email){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.edit";

        $add_user["sok"] = "yes";
        $add_user["elid"] = "";
        $add_user["name"] = $hid_user;
        $add_user["passwd"] = $hid_password;
        $add_user["confirm"] = $hid_password;
        $add_user["owner"] = $hid_user;
        $add_user["ip"] = $_SERVER['SERVER_ADDR'];
        #$add_user["ip6"] = "";
        #$add_user["domain"] = $domain;
        $add_user["preset"] = "Hosting"; // Shablon user hosting
        $add_user["email"] = $hid_email;
        $add_user["welcome"] = "on"  ;
        #$add_user["shell"] = ;
        #$add_user["ssl"] = ;
        $add_user["cgi"] = "on";
        #$add_user["wsgi"] = WSGI. ;
        #$add_user["ssi"] = SSI.;
        #$add_user["phpmod"] =;
        #$add_user["phpcgi"] =;
        $add_user["phpfcgi"] =  "on";
        #$add_user["safemode"] =  ;
        $add_user["disklimit"] = "1024"; # в Мегабайтах
        #$add_user["ftplimit"] ="10000";
        #$add_user["maillimit"] = "10000";
        #$add_user["domainlimit"] = "10000";
        #$add_user["webdomainlimit"] = "10000";
        #$add_user["maildomainlimit"] = "10000";
        #$add_user["baselimit"] = "10000";
        #$add_user["baseuserlimit"] = "10000";
        #$add_user["bandwidthlimit"] = "100000000";
        #$add_user["cpulimit"] = "100000";
        #$add_user["memlimit"] = "100000";
        #$add_user["proclimit"] = "100000";
        #$add_user["mysqlquerieslimit"] = "100000000";
        #$add_user["mysqlupdateslimit"] = "100000000";
        #$add_user["mysqlconnectlimit"] = "100000000";
        #$add_user["mysqluserconnectlimit"] = "100000000";
        #$add_user["maxclientsvhost"] = "100000000";
        #$add_user["mailrate"] = "100000000";
        $add_user["note"] = "";

        foreach( $add_user as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        // echo $url;
        // exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # ROOT ROOT_PASS HID_USER
    # add_user_hid("root", "root_pass", "hid_user");
    public function delete_user_hid($root, $rootpass, $hid_user){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.delete";
        $delete_user_hid["elid"] = $hid_user;

        foreach( $delete_user_hid as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        // echo $url;
        // exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # ROOT ROOT_PASS HID_USER
    # deactivate_user_hid("root", "root_pass", "hid_user");
    public function deactivate_user_hid($root, $rootpass, $hid_user){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.disable";
        $delete_user_hid["elid"] = $hid_user;

        foreach( $delete_user_hid as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        // echo $url;
        // exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # ROOT ROOT_PASS HID_USER
    # activate_user_hid("root", "root_pass", "hid_user");
    public function activate_user_hid($root, $rootpass, $hid_user){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$root.":".$rootpass."&out=xml&func=user.enable";
        $delete_user_hid["elid"] = $hid_user;

        foreach( $delete_user_hid as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        // echo $url;
        // exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # $hid_user, $hid_pass, $domain, $blog_pass, $blog_email, $blog_title, $db_name, $db_user, $db_pass
    # add_wordpress("hid_user", "hid_pass", "domainwww1.ru", "123","him@him.ru","Blog_TITLE","wordpress10","wp_user10","wp_pass10" );
    public function add_wordpress($hid_user, $hid_pass, $domainwww, $blog_pass, $blog_email, $blog_title, $db_name, $db_user, $db_pass){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr";
        $post = "accept=on";
        #$add_wordpress["accept"] = "on";
        $add_wordpress["authinfo"] = $hid_user.":".$hid_pass;
        $add_wordpress["db_satisf_obj"] = "MySQL";
        $add_wordpress["domain"] = $domainwww;
        $add_wordpress["path"] = "";
        $add_wordpress["pkg"] = "WordPress";
        $add_wordpress["setting_admin_name"] = "admin";
        $add_wordpress["setting_admin_passwordgen"] = "";
        $add_wordpress["setting_admin_password"] = $blog_pass;
        $add_wordpress["setting_admin_password_confirmgen"] = "";
        $add_wordpress["setting_admin_password_confirm"] = $blog_pass;
        $add_wordpress["setting_admin_email"] = $blog_email;
        $add_wordpress["setting_title"] = urlencode($blog_title);
        $add_wordpress["setting_locale"] = "en-US";
        $add_wordpress["req_main_dbtype"] = "MySQL";
        $add_wordpress["req_main_dbname"] = $db_name;
        $add_wordpress["req_main_dbuser"] = $db_user;
        $add_wordpress["req_main_dbpassgen"] = "";
        $add_wordpress["req_main_dbpass"] = $db_pass;
        $add_wordpress["req_main_dbpass_confirmgen"] = "";
        $add_wordpress["req_main_dbpass_confirm"] = $db_pass;
        $add_wordpress["func"] = "webaps.setting";
        $add_wordpress["elid"] = "";
        $add_wordpress["sback"] = "";
        $add_wordpress["sok"] = "ok";

        foreach( $add_wordpress as $k => $v ) {
            $post .= '&'.$k.'='.urlencode($v);
        }

        # echo $post;
        # exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; ru)");
        curl_setopt($ch , CURLOPT_REFERER , "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&func=webaps.setting&accept=on&db_satisf_obj=MySQL&domain=".urlencode($domain)."&path=&pkg=WordPress" );

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = curl_exec($ch);
        curl_close($ch);

        # Sparsit na slovo "error" esli netu to TRUE!!!
        echo $response;
    }
    # HID_USER HID_PASS
    # show_domaindns("hid_user","hid_pass");
    public function show_domaindns($hid_user, $hid_pass){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=domain";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    # HID_USER HID_PASS DOMAIN_DNS
    # delete_domaindns("hid_user", "hid_pass", "domain1.ru");
    public function delete_domaindns($hid_user, $hid_pass, $domaindns){

    $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=domain.sublist.delete";

    #func=domain.delete&extop=on&elid=domaindns4.ru&sok=ok

    $delete_domain["sok"] = "ok";
    $delete_domain["elid"] = $domaindns;
    $delete_domain["extop"] = "on";

    foreach( $delete_domain as $k => $v )
        {
         $url .= '&'.$k.'='.urlencode($v);
        }
    # echo $url;
    # exit();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Get the response and close the channel.
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    }


    # HID_USER HID_PASS DOMAIN_DNS
    # add_domaindns("hid_user1", "hid_pass", "domaindns.ru");
    public function add_domaindns($hid_user, $hid_pass, $domaindns){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=domain.edit";

        $add_domaindns["elid"] = "";
        $add_domaindns["sok"] = "yes";

        $add_domaindns["name"] = $domaindns; #- Доменное имя. 
        $add_domaindns["ip"] = $_SERVER['SERVER_ADDR']; #- IP-адрес. 
        $add_domaindns["ns"] = "ns1.fastvps.ru ns2.fastvps.ru"; #- Серверы имён. (Одно или несколько значений, разделенных пробелом) 
        #$add_domaindns["mx"] = ""; #- Почтовые серверы. (Одно или несколько значений, разделенных пробелом) 
        #$add_domaindns["owner"] = $hid_user; #- Владелец. 

        #$add_domaindns["webdomain"] = ""; #- Создать WWW домен. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности www. 
        #$add_domaindns["maildomain"] = "";  #- Создать почтовый домен. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности email. 
        #$add_domaindns["buy"] = "";  #- Купить домен. (Необязательный параметр. Чтобы включить данную опцию используйте значение "on".) Параметр зависим от возможности domainmarket.

        foreach( $add_domaindns as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }
        # echo $url;
        # exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Get the response and close the channel.
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    /*
    $hid_user - логин пользователя
    $hid_pass - пароль пользователя

    имя функции - cron
     поля: 
     period - "custom"
     min - минуты
     hour - часы
     mday - день месяца
     month - месяц
     wday - день недели
     name - сама команда
     hideout - [on | off] не посылать отчет по email

     пример добавления задания cron на добавление задания вида
     * * * * * /sbin/command > /dev/null 2>&1


            func=cron.edit&out=xml&name=[команда]&min=[минуты]&hour=[часы]&mday=[дни]&month=[месяцы]&wday=[дни недели]&hideout=on&period=custom&sok=ok
    out=xml&func=cron.edit&elid=&period=custom&min=*&hour=*&mday=*&month=*&wday=*&name=/sbin/command&hideout=on&sok=ok


    Рабочая ссылка: укажите логин и пароль

    https://78.46.34.77/manager/ispmgr?authinfo= : &out=xml&min=*&hour=*%2F02&mday=*&month=*&wday=*&name=wget+http%3A%2F%2Fyandex2.ru&period=custom&crmin=all&evmin=02&semin=&crhour=every&evhour=02&sehour=&crmday=all&evmday=02&semday=&crmonth=all&evmonth=02&semonth=&crwday=all&evwday=02&sewday=&hideout=on&func=cron.edit&elid=&sok=ok
    */

    public function add_cron($hid_user, $hid_pass, $min, $hour, $mday, $month, $wday, $name, $hideout){
        $url = "https://".$_SERVER['SERVER_ADDR']."/manager/ispmgr?authinfo=".$hid_user.":".$hid_pass."&out=xml&func=cron.edit&elid=".$hid_user."&period=custom&min=".$min."&hour=".$hour."&mday=".$mday."&month=".$month."&wday=".$wday."&name=".$name."&hideout=on&sok=ok";
        foreach( $add_cron as $k => $v ) {
            $url .= '&'.$k.'='.urlencode($v);
        }

        # echo $url;
        # exit();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
}
?>