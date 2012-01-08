<?
    include('config.php');
    $db = new mysqliDB();
    // Получаем текущие курсы валют в rss-формате с сайта www.cbr.ru 
    $content = get_content(); 
    // Разбираем содержимое, при помощи регулярных выражений 
    $pattern = "#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i"; 
    preg_match_all($pattern, $content, $out, PREG_SET_ORDER); 
    $value = "";
    $time = time();
    $db->insert("INSERT INTO ExchangeRates (Code, Value, Date) VALUES (?,?,?)", "643", "1", $time);
    foreach($out as $cur) 
    { 
        if($cur[2] == 840){
            $value = str_replace(",",".",$cur[4]);
            $db->insert("INSERT INTO ExchangeRates (Code, Value, Date) VALUES (?,?,?)", "840", $value, $time);
            $value = "";
        }
        if($cur[2] == 978) {
            $value = str_replace(",",".",$cur[4]);
            $db->insert("INSERT INTO ExchangeRates (Code, Value, Date) VALUES (?,?,?)", "978", $value, $time);
            $value = "";
        }
        if($cur[2] == 980) {
            $value = str_replace(",",".",$cur[4]);
            $db->insert("INSERT INTO ExchangeRates (Code, Value, Date) VALUES (?,?,?)", "980", $value, $time);
            $value = "";
        }
        if($cur[2] == 826) {
            $value = str_replace(",",".",$cur[4]);
            $db->insert("INSERT INTO ExchangeRates (Code, Value, Date) VALUES (?,?,?)", "826", $value, $time);
            $value = "";
        }
    }
    
    function get_content() 
    { 
        // Формируем сегодняшнюю дату 
        $date = date("d/m/Y"); 
        // Формируем ссылку 
        $link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date"; 
        // Загружаем HTML-страницу 
        $fd = fopen($link, "r"); 
        $text=""; 
        if (!$fd) echo "Запрашиваемая страница не найдена"; 
        else 
        { 
          // Чтение содержимого файла в переменную $text 
          while (!feof ($fd)) $text .= fgets($fd, 4096); 
        } 
        // Закрыть открытый файловый дескриптор 
        fclose ($fd); 
        return $text;
    }
?>