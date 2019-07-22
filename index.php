<?php

require_once ('properties.php');
require_once ('classes/BdConnect.php');


if(!isset($_GET['token']) || $_GET['token'] !== $token) {
    // Возвращаем ошибку
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(array(
        'error' => 'Unauthorized'
    ));die;
}


// Определяем метод запроса
$method = $_SERVER['REQUEST_METHOD'];

// Получаем данные из тела запроса
$formData = getFormData($method);

// Получение данных из тела запроса
function getFormData($method) {
 
    // GET или POST: данные возвращаем как есть
    if ($method === 'GET') {return $_GET;}
    if ($method === 'POST') {return $_POST;}
 
    // PUT, PATCH или DELETE
    $data = array();
    $exploded = explode('&', file_get_contents('php://input'));
 
    foreach($exploded as $pair) {
        $item = explode('=', $pair);
        if (count($item) == 2) {
            $data[urldecode($item[0])] = urldecode($item[1]);
        }
    }
    return $data;
}

// Разбираем url
$url = (isset($_GET['q'])) ? $_GET['q'] : '';
//$url = $_GET['q'] ?? ''; //для php7
$url = rtrim($url, '/');
$urls = explode('/', $url);


//Определяем роутер и url data
$router = $urls[0];
$urlData = array_slice($urls, 1);

//Открываем соединение к БД
$mysqli = BdConnect::getInstance();

//Подключаем файл-роутер и запускаем функцию route
include_once 'routers/' . $router . '.php';

route($method, $urlData, $formData, $mysqli);




