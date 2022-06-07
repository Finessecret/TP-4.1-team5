<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

require 'C:/openserver/domains/USchedule/config/connect.php';
require 'C:/openserver/domains/USchedule/functions.php';



$method = $_SERVER['REQUEST_METHOD'];





$q = $_GET['q'];
$params = explode('/', $q);
$type = $params[0];
$id = $params[1];

if($method === 'GET'){


    if ($type === 'getUserSchedule'){
        if (isset($id)) {
            //echo $id;
            getUserSchedule($connect, $id);
        }
    }
    if($type === 'disciplines') {

        if (isset($id)) {
            getDiscipline($connect, $id);
        } else {
            getDisciplines($connect);
        }
    }
} elseif($method === 'POST') {
    if($type === 'disciplines'){
        addDisciplines($connect,$_POST);
    } elseif ($type === 'find'){
        findFromTables($connect, $POST['findPart']);
    } elseif ($type === 'register'){
        register($connect, new User($_POST['name'], $_POST['login'], $_POST['password'], $_POST['facutyCode'],
            $_POST['userCode'], $_POST['groupCode']) );
    } elseif ($type === 'login'){
        login($connect, new Login($_POST['login'], $_POST['password']) );
    }
} elseif($method === 'PATCH') {
    if ($type === 'disciplines') {
        if (isset($id)) {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            updateDisciplines($connect, $id, $data);
        }
    }
} elseif($method === 'DELETE') {
    if ($type === 'disciplines') {
        if (isset($id)) {
            deleteDiscipline($connect, $id);
        }
    }
}



?>
