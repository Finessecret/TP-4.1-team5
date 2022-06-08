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
$role_value = $params[2];
$id_lesson = $params[2];

if($method === 'GET'){
    print_r($type);
    if ($type === 'lessons'){
        if (isset($id)) {
            getLesson($connect);
        }
    }
    elseif ($type === 'discipline'){
        if (isset($id)) {
            getDiscipline($connect);
        }
    }
    elseif ($type === 'auditorium'){
        if (isset($id)) {
            getAuditorium($connect);
        }
    }
    elseif ($type === 'faculty'){
        if (isset($id)) {
            getFaculty($connect);
        }
    }
    elseif ($type === 'group'){
        if (isset($id)) {
            getGroup($connect);
        }
    }
    elseif ($type === 'lesson_Group'){
        if (isset($id)) {
            getLesson_Group($connect);
        }
    }
    elseif ($type === 'timeslot'){
        if (isset($id)) {
            getTimeslot($connect);
        }
    }
    elseif ($type === 'user'){
        if (isset($id)) {
            getUser($connect);
        }
    }
    if ($type === 'UserRole'){
        if (isset($id)) {
            getUser_Role($connect);
        }
    }
    elseif ($type === 'UserRole'){
        if (isset($id)) {
            getUser_Role($connect);
        }
    }
    elseif ($type === 'UserDiscipline'){
        if (isset($id)) {
            getUser_discipline($connect, $id);
        }
    }
    elseif($type === 'disciplines') {
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
    } elseif ($type === 'addAuditorium'){
        addAuditorium($connect, $_POST);
    } elseif ($type === 'addFaculty'){
        addFaculty($connect, $_POST);
    } elseif ($type === 'addGroup'){
        addGroup($connect, $_POST);
    } elseif ($type === 'addTimeslot'){
        addTimeslot($connect, $_POST);
    } elseif ($type === 'addLesson'){
        addLesson($connect, $_POST);
    } elseif ($type === 'addLessonGroup'){
        addLesson_group($connect, $_POST);
    }  elseif ($type === 'addUser'){
        addUser($connect, $_POST);
    } elseif ($type === 'addUserDiscipline'){
        addUser_discipline($connect, $_POST);
    } elseif ($type === 'addUserRole'){
        addUser_role($connect, $_POST);
    }
} elseif($method === 'PATCH') {
    if ($type === 'disciplines') {
        if (isset($id)) {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            updateDisciplines($connect, $id, $data);
        }
    } elseif ($type === 'faculty') {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        updateFaculty($connect, $id, $data);
    } elseif ($type === 'auditorium') {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        updateAuditorium($connect, $id, $data);
    } elseif ($type === 'group') {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        updateGroup($connect, $id, $data);
    } elseif ($type === 'user') {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        updateUser($connect, $id, $data);
    } elseif ($type === 'timeslot') {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        updateTimeslot($connect, $id, $data);
    } elseif ($type === 'lesson') {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        updateLesson($connect, $id, $data);
    }
} elseif($method === 'DELETE') {
    if ($type === 'disciplines') {
        if (isset($id)) {
            deleteDiscipline($connect, $id);
        } elseif ($type === 'auditorium'){
            deleteAuditorium($connect, $id);
        } elseif ($type === 'faculty'){
            deleteFaculty($connect, $id);
        } elseif ($type === 'group'){
            deleteGroup($connect, $id);
        } elseif ($type === 'timeslot'){
            deleteTimeslot($connect, $id);
        } elseif ($type === 'role'){
            deleteRole($connect, $id);
        } elseif ($type === 'user'){
            deleteUser($connect, $id);
        } elseif ($type === 'UserRole'){
            deleteUser_role($connect, $id, $role_value);
        } elseif ($type === 'userDiscipline'){
            deleteUser_discipline($connect, $id, $role_value);
        } elseif ($type === 'lesson'){
            deleteLesson($connect, $id);
        } elseif ($type === 'lessonGroup'){
            deleteLesson_group($connect, $id);
        }
    }
}



?>
