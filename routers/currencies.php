<?php

function route($method, $urlData, $formData, $mysqli) {

	if ($method === 'GET' && count($urlData) === 0) {
        
		$query = "SELECT COUNT(*) FROM `currency`";
		$count = $mysqli->query($query) or die('Ошибка записи: '.mysqli_error($mysqli));
		$max = $count->fetch_row();
		
		//Пагинация
		$limit = $_GET['maxResult'] ?? "$max[0]";
		$offSet = $_GET['startAt'] ?? '0';
				
		// Получаем список валют из базы
        $query = "SELECT * FROM `currency` LIMIT $limit  OFFSET $offSet ";
		$res = $mysqli->query($query) or die('Ошибка записи: '.mysqli_error($mysqli));
		
		//Ставим заголовок JSON
        header('Content-Type: application/json; charset=utf-8');
               
        $rows = array();
		
		while($result = $res->fetch_assoc()) {
			$rows[] = $result;
		}
		
			
		echo json_encode($rows, JSON_UNESCAPED_UNICODE);
		
         
        return TRUE;
    }
 
    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));
 
}