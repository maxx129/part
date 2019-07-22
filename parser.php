<?php

require_once ('properties.php');
require_once ('classes/bdConnect.php');

try {
    $xml = simplexml_load_file($url);
       
    if(!$xml) {
        throw new Exception('Ошибка обновления курсов валют');
    }
}
 catch (Exception $e) {
    echo "Исключение: ", $e->getMessage();
    //Страховочный вариант с файлом скачанным CURL из консоли (по планировщику) 
    $xml = simplexml_load_file($file);
 }

//Открываем соединение к БД
$mysqli = BdConnect::getInstance();
//Очищаем таблицу 
$mysqli->query("TRUNCATE TABLE `$table`");

foreach($xml as $item) {
    
    $id = $item['ID'];
    $name = $item->Name;
    $value = $item->Value;
    $value = str_replace(",", ".", $value);
    $value = (float)$value;
    
    //echo $id." ";
    //echo $name." ";
    //var_dump($value); 
    //echo "<br>";
    
    //Заносим данные в БД
    $query = "INSERT INTO $table (`id`, `name`, `rate`) VALUES ('$id', '$name', '$value')";
    $mysqli->query("$query") or die('Ошибка записи: '.mysqli_error($mysqli));;
     
}

$today = date('d m y');
echo "Курсы на $today загружены";