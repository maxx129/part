<?php

function route($method, $urlData, $formData, $mysqli) {
    
        
    if ($method === 'GET' && count($urlData) === 1) {
        // Получаем id валюты
        $id = $urlData[0];
                 
        //Получаем валюту из базы...
        $query = "SELECT * FROM `currency` WHERE `id` = '$id'";
        $res = $mysqli->query($query) or die('Ошибка записи: '.mysqli_error($mysqli));
          
        //Ставим заголовок JSON
        header('Content-Type: application/json; charset=utf-8');
                
        while($result = $res->fetch_assoc()) {
            // Выводим ответ клиенту
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
       
        return TRUE;
    }
 
    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));
 
}