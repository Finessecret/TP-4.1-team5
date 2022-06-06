<?php

//поиск по таблицам

function findFromTables($connect, $findPart){
$tables = ['auditorium', 'discipline', 'faculty', 'group'];
$rows = ['number_auditorium', 'name_discipline', 'name_faculty', 'id_group'];
$i = 0;
$map = array();
foreach($tables as $table => $value) {
  $value = $rows[$i];
  $map[$tables[$i]]=$value;
  $i = $i+1;
}
$res = array();
foreach ($tables as $table){
    $dis = mysqli_query($connect, "SELECT * FROM $table WHERE $map[$table] LIKE '%$findPart%' ");
    echo "SELECT * FROM $table WHERE $map[$table] LIKE '%$findPart%' ";

    if(mysqli_num_rows($dis) === 0){
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Discipline not found"
        ];
        echo json_encode($res);
    }else {
        $dis = mysqli_fetch_assoc($dis);
        echo '{
                table:',$table, ',
                row:',$map[$table], ',            
                val:',$dis[1], '            
            }';
    }
}
}

// регистрация
function register($connect, User $user){
    mysqli_query($connect, "
    INSERT INTO 
    `user`(`name`, `login`, `password`, `код факультета`, `код пользователя`, `код группы`)
    VALUES ($user->getName(), $user->getLogin(), $user->getPassword(), $user->getFacutyCode(),
        $user->getUserCode(), $user->getGroupCode())) ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "User is created"
    ];
    echo json_encode($res);
}

//  вход
function login($connect, Login $login)
{
    $user = mysqli_query($connect, "
     SELECT * FROM `user`
     WHERE `login` = $login->getLogin() AND `password` = $login->getPassword()");

    http_response_code(201);

    if ($user) {
    $res = [
        "status" => true,
        "message" => "User logined"
    ];
    } else {
        $res = [
            "status" => true,
            "message" => "User not exist"
        ];
    }
    echo json_encode($res);
}

// хеширование пароля
function gen_password($length)
{
    $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
    $size = strlen($chars) - 1;
    $password = '';
    while($length--) {
        $password .= $chars[random_int(0, $size)];
    }
    return $password;
}

// восстановление пароля
function reset_password($connect, Reset_password $reset_password){
     $new_pass = gen_password(6);
    $to      = $reset_password->getMail();
    $subject = 'Reset password';
    $message = "Новый пароль '$new_pass'";

    mail($to, $subject, $message);
     mysqli_query($connect,"UPDATE `user` SET `password`='$new_pass' WHERE `id_user`='$reset_password->getIdUser()'");

}

// получение расписания пользователя
function getUserSchedule($connect, $user_id)
{

    $user_role = mysqli_query($connect, "SELECT `role_value` FROM `user_role` WHERE `id_user` = '$user_id'"); // получить роль пользователя
    $user_role = mysqli_fetch_row($user_role);

    if ($user_role[0] =="student") { // если роль = студент
        $group = mysqli_query($connect, "SELECT `id_group` FROM `user` WHERE `id_user` = $user_id"); // получаем код группы пользователя
        $group = mysqli_fetch_assoc($group);
        $group = $group['id_group'];

        $lessons = mysqli_query($connect, "SELECT `id_lesson` FROM `lesson_group` WHERE `id_group`= '$group'"); // получаем коды уроков этой группы
        $lessons = mysqli_fetch_all($lessons);


    }else{ // если роль = преподаватель
        $lessons = mysqli_fetch_all(mysqli_query($connect,"SELECT `id_lesson` FROM `lesson` WHERE `id_user` = '$user_id'"));


    }

    foreach ($lessons as $lesson_id) {

        $lesson = mysqli_query($connect, "SELECT * FROM `lesson` WHERE `id_lesson` = '$lesson_id[0]'"); // получаем данные по урокам
        $lesson = mysqli_fetch_assoc($lesson);

        $us_id_fio =  $lesson['id_user'];  // выписываем айди препода
        $audit_num_capacity =  $lesson['number_auditorium'];  // выписываем номер аудитории
        $time_id_value =  $lesson['id_time'];  // выписываем айди времени
        $dis_id_name =  $lesson['id_discipline'];  // выписываем айди дисциплины

        $us_id_fio = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `surname`, `name`  FROM `user` WHERE `id_user` = '$us_id_fio'")); //получаем имя и фамилию препода

        $audit_num_capacity = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `capacity` FROM `auditorium` WHERE `number_auditorium` = '$audit_num_capacity'")); // получаем вместительность аудитории

        $time_id_value = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `time_value`  FROM `timeslot` WHERE `id_time` = '$time_id_value'")); // получаем значение времени

        $dis_id_name = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name_discipline`  FROM `discipline` WHERE `id_discipline` = '$dis_id_name'")); // получаем названия дисциплины


        echo '{
        
                day_week: ', json_encode($lesson['day_week']), '
                week_value: ', json_encode($lesson['week_value']), '
                number_auditorium: ', json_encode($lesson['number_auditorium']), '                
                capacity: ', json_encode($audit_num_capacity['capacity']), '
                name: ', json_encode($us_id_fio['name']), '
                surname: ', json_encode($us_id_fio['surname']), '
                name discipline: ', json_encode($dis_id_name['name_discipline']), '
                time_value: ', json_encode($time_id_value['time_value']), '
    
        }';
    }

}


// отобразить информацию о пользователе (мой профиль)
function getMyProfile($connect, $id){
    $us_body= mysqli_query($connect,"SELECT * FROM `user` WHERE `id_user` = '$id'");
    $us_role= mysqli_fetch_assoc(mysqli_query($connect,"SELECT `role_value` FROM `user_role` WHERE `id_user` = '$id'"));

    if(mysqli_num_rows($us_body) === 0){
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Discipline not found"
        ];
        echo json_encode($res);
    }else {
        $us_body = mysqli_fetch_assoc($us_body);
        echo '{
        login: ', json_encode($us_body['login']),'
        password: ', json_encode($us_body['password']),'
        name: ', json_encode($us_body['name']),'
        patronymic: ', json_encode($us_body['patronymic']),'
        surname: ', json_encode($us_body['surname']),'
        id_group: ', json_encode($us_body['id_group']),'
        id_faculty: ', json_encode($us_body['id_faculty']),'

        role_value: ', json_encode($us_role['role_value']),'

         }';
    }
}



/*
 * отобразить список  строк таблицы
*/

//таблица УРОКОВ
function getLesson($connect){
    $lessons = mysqli_query($connect,"SELECT * FROM `lesson`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($lessons)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ДИСЦИПЛИН
function getDiscipline($connect){
    $discipline = mysqli_query($connect,"SELECT * FROM `discipline`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($discipline)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица АУДИТОРИЙ
function getAuditorium($connect){
    $auditoriums = mysqli_query($connect,"SELECT * FROM `auditorium`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($auditoriums)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ФАКУЛЬТЕТОВ
function getFaculty($connect){
    $faculty = mysqli_query($connect,"SELECT * FROM `faculty`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($faculty)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ГРУПП
function getGroup($connect){
    $group = mysqli_query($connect,"SELECT * FROM `groupp`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($group)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица УРОК+ГРУППА
function getLesson_Group($connect){
    $les_group = mysqli_query($connect,"SELECT * FROM `lesson_group`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($les_group)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ТАЙМСЛОТОВ
function getTimeslot($connect){
    $timeslot = mysqli_query($connect,"SELECT * FROM `timeslot`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($timeslot)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ПОЛЬЗОВАТЕЛЕЙ
function getUser($connect){
    $user = mysqli_query($connect,"SELECT * FROM `user`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($user)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ПОЛЬЗОВАТЕЛЬ+РОЛЬ
function getUser_Role($connect){
    $user_role = mysqli_query($connect,"SELECT * FROM `user_role`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($user_role)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}

//таблица ПОЛЬЗОВАТЕЛЬ+ДИСЦИПЛИНА
function getUser_discipline($connect){
    $user_dis = mysqli_query($connect,"SELECT * FROM `user_discipline`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($user_dis)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}







/*
 * добавить запись в одну из таблиц
*/


// добавить ДИСЦИЛПИНУ
function addDiscipline($connect,$data){
    $id = $data['id'];
    $name_discipline = $data['name_discipline'];
    mysqli_query($connect, "INSERT INTO `discipline`(`id_discipline`, `name_discipline`) VALUES ('$id' ,'$name_discipline') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Discipline is created"
    ];
    echo json_encode($res);
}

// добавить АУДИТОРИЮ
function addAuditorium($connect,$data){
    $id = $data['id'];
    $capacity = $data['capacity'];
    mysqli_query($connect, "INSERT INTO `auditorium`(`number_auditorium`, `capacity`) VALUES ('$id' ,'$capacity') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Auditorium is created"
    ];
    echo json_encode($res);
}

// добавить ФАКУЛЬТЕТ
function addFaculty($connect,$data){
    $id = $data['id'];
    $name_faculty = $data['name_faculty'];
    mysqli_query($connect, "INSERT INTO `faculty`(`id_faculty`, `name_faculty`) VALUES ('$id' ,'$name_faculty') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Faculty is created"
    ];
    echo json_encode($res);
}

// добавить ГРУППУ
function addGroup($connect,$data){
    $id = $data['id'];
    $number_of_students = $data['number_of_students'];
    mysqli_query($connect, "INSERT INTO `groupp`(`id_group`, `number_of_students`) VALUES ('$id' ,'$number_of_students') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Group is created"
    ];
    echo json_encode($res);
}

// добавить ТАЙМСЛОТ
function addTimeslot($connect,$data){
    $id = $data['id'];
    $time_value = $data['time_value'];
    mysqli_query($connect, "INSERT INTO `timeslot`(`id_time`, `time_value`) VALUES ('$id' ,'$time_value') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Discipline is created"
    ];
    echo json_encode($res);
}

// добавить УРОК
function addLesson($connect,$data){
    $id_lesson = $data['id_lesson'];
    $day_week = $data['day_week'];
    $week_value = $data['week_value'];
    $id_user = $data['id_user'];
    $id_discipline = $data['id_discipline'];
    $id_time = $data['id_time'];
    $number_auditorium = $data['number_auditorium'];

    $control = mysqli_query($connect,"SELECT * FROM `lesson` WHERE `day_week`='$day_week'AND `week_value`='$week_value'AND `id_user`='$id_user'AND`id_discipline`='$id_discipline'AND `id_time`='$id_time'AND`number_auditorium`='$number_auditorium' ");
    $control = mysqli_fetch_assoc($control);
    if($control['id_lesson'] == null) {
        mysqli_query($connect, "INSERT INTO `lesson`(`id_lesson`,`day_week`, `week_value`, `id_user`, `id_discipline`, `id_time`, `number_auditorium`) VALUES ('$id_lesson','$day_week' ,'$week_value' ,'$id_user' ,'$id_discipline' ,'$id_time' ,'$number_auditorium') ");

        http_response_code(201);

        $res = [
            "status" => true,
            "message" => "Lesson is created"
        ];
    }
    else{
        $res = [
            "status" => false,
            "message" => "Lesson is not created, such a unique key already exists"
        ];
    }
    echo json_encode($res);
}

// добавить УРОК+ГРУППА
function addLesson_group($connect,$data){
    $id_lesson = $data['id_lesson'];
    $id_group = $data['id_group'];

    mysqli_query($connect, "INSERT INTO `lesson_group`(`id_lesson`, `id_group`) VALUES ('$id_lesson','$id_group') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Lesson+group is created"
    ];
    echo json_encode($res);
}

// добавить ПОЛЬЗОВАТЕЛЬ
function addUser($connect,$data){
    $id_user = $data['id_user'];
    $login = $data['login'];
    $password = $data['password'];
    $name = $data['name'];
    $patronymic = $data['patronymic'];
    $surname = $data['surname'];
    $id_group = $data['id_group'];
    $id_faculty = $data['id_faculty'];

    mysqli_query($connect, "INSERT INTO `user`(`id_user`, `login`, `password`, `name`, `patronymic`, `surname`, `id_group`, `id_faculty`) VALUES ('$id_user' ,'$login' ,'$password' ,'$name' ,'$patronymic' ,'$surname' ,'$id_group' ,'$id_faculty') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "user is created"
    ];
    echo json_encode($res);
}


// добавить ПОЛЬЗОВАТЕЛЬ+ДИСЦИПЛИНА
function addUser_discipline($connect,$data){
    $id_user = $data['id_user'];
    $id_discipline = $data['id_discipline'];
    mysqli_query($connect, "INSERT INTO `user_discipline`(`id_user`, `id_discipline`)VALUES ('$id_user' ,'$id_discipline') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "user+discipline is created"
    ];
    echo json_encode($res);
}

// добавить ПОЛЬЗОВАТЕЛЬ+РОЛЬ
function addUser_role($connect,$data){
    $id_user = $data['id_user'];
    $role_value = $data['role_value'];
    mysqli_query($connect, "INSERT INTO `user_role`(`role_value`, `id_user`) VALUES ('$role_value', '$id_user') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "User+role is created"
    ];
    echo json_encode($res);
}








/*
 * обновить запись в одной из таблиц
*/

// обновить ДИСЦИПЛИНУ
function updateDiscipline($connect,$id, $data){
    $name = $data['name_discipline'];
    mysqli_query($connect,"UPDATE `discipline` SET `name_discipline`='$name' WHERE `id_discipline`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Discipline is updated"
    ];
    echo json_encode($res);
}

// обновить ФАКУЛЬТЕТ
function updateFaculty($connect,$id, $data){
    $name_faculty = $data['name_faculty'];
    mysqli_query($connect,"UPDATE `faculty` SET `name_faculty`='$name_faculty' WHERE `id_faculty`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Faculty is updated"
    ];
    echo json_encode($res);
}

// обновить АУДИТОРИЮ
function updateAuditorium($connect,$id, $data){
    $capacity = $data['capacity'];
    mysqli_query($connect,"UPDATE `auditorium` SET `capacity`='$capacity' WHERE `id_auditorium`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Auditorium is updated"
    ];
    echo json_encode($res);
}

// обновить ГРУППУ
function updateGroup($connect,$id, $data){
    $number_of_students = $data['number_of_students'];
    mysqli_query($connect,"UPDATE `groupp` SET `number_of_students`='$number_of_students' WHERE `id_group`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Group is updated"
    ];
    echo json_encode($res);
}

// обновить ПОЛЬЗОВАТЕЛЯ
function updateUser($connect,$id, $data){
    $login = $data['login'];
    $password = $data['password'];
    $name = $data['name'];
    $patronymic = $data['patronymic'];
    $surname = $data['surname'];
    $id_group = $data['id_group'];
    $id_faculty = $data['id_faculty'];
    mysqli_query($connect,"UPDATE `user` SET `login`='$login',`password`='$password',`name`='$name',`patronymic`='$patronymic',`surname`='$surname',`id_group`='$id_group',`id_faculty`='$id_faculty' WHERE `id_user`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "User is updated"
    ];
    echo json_encode($res);
}

// обновить ТАЙМСЛОТ
function updateTimeslot($connect,$id, $data){
    $time_value = $data['time_value'];
    mysqli_query($connect,"UPDATE `timeslot` SET `time_value`='$time_value' WHERE `id_time`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Timeslot is updated"
    ];
    echo json_encode($res);
}

// обновить УРОК
function updateLesson($connect,$id, $data){
    $day_week = $data['day_week'];
    $week_value = $data['week_value'];
    $id_user = $data['id_user'];
    $id_discipline = $data['id_discipline'];
    $id_time = $data['id_time'];
    $number_auditorium = $data['number_auditorium'];

    $control = mysqli_query($connect,"SELECT * FROM `lesson` WHERE `day_week`='$day_week'AND `week_value`='$week_value'AND `id_user`='$id_user'AND`id_discipline`='$id_discipline'AND `id_time`='$id_time'AND`number_auditorium`='$number_auditorium' ");
    $control = mysqli_fetch_assoc($control);
    if($control['id_lesson'] == null) {
        mysqli_query($connect, "UPDATE `lesson` SET `day_week`='$day_week',`week_value`='$week_value',`id_user`='$id_user',`id_discipline`='$id_discipline',`id_time`='$id_time',`number_auditorium`='$number_auditorium' WHERE `id_lesson`='$id'");

        http_response_code(200);

        $res = [
            "status" => true,
            "message" => "Lesson is updated"
        ];
    }
    else{
        $res = [
            "status" => false,
            "message" => "Lesson is not updated, such a unique key already exists"
        ];
    }
    echo json_encode($res);
}











/*
 * удалить одну запись из таблицы
*/

// удалить ДИСЦИПЛИНУ
function deleteDiscipline($connect, $id){
    mysqli_query($connect,"DELETE FROM `discipline` WHERE `id_discipline`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Discipline is deleted"
    ];
    echo json_encode($res);

}

// удалить АУДИТОРИЮ
function deleteAuditorium($connect, $id){
    mysqli_query($connect,"DELETE FROM `auditorium` WHERE `number_auditorium`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Auditorium is deleted"
    ];
    echo json_encode($res);

}

// удалить ФАКУЛЬТЕТ
function deleteFaculty($connect, $id){
    mysqli_query($connect,"DELETE FROM `faculty` WHERE `id_faculty`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Faculty is deleted"
    ];
    echo json_encode($res);

}

// удалить ГРУППУ
function deleteGroup($connect, $id){
    mysqli_query($connect,"DELETE FROM `groupp` WHERE `id_group`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Group is deleted"
    ];
    echo json_encode($res);

}

// удалить ТАЙМСЛОТ
function deleteTimeslot($connect, $id){
    mysqli_query($connect,"DELETE FROM `timeslot` WHERE `id_time`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Timeslot is deleted"
    ];
    echo json_encode($res);

}

// удалить РОЛЬ
function deleteRole($connect, $role_value){
    mysqli_query($connect,"DELETE FROM `role` WHERE `role_value`='$role_value'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Role is deleted"
    ];
    echo json_encode($res);

}

// удалить ПОЛЬЗОВАТЕЛЯ
function deleteUser($connect, $id){
    mysqli_query($connect,"DELETE FROM `user` WHERE `id_user`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "User is deleted"
    ];
    echo json_encode($res);

}

// удалить ПОЛЬЗОВАТЕЛь+РОЛЬ
function deleteUser_role($connect, $id, $role_value){
    mysqli_query($connect,"DELETE FROM `user_role` WHERE `id_user`='$id'AND `role_value`='$role_value'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "User+role is deleted"
    ];
    echo json_encode($res);

}

// удалить ПОЛЬЗОВАТЕЛь+ДИСЦИПЛИНА
function deleteUser_discipline($connect, $id_user, $id_dicsipline){
    mysqli_query($connect,"DELETE FROM `user_discipline` WHERE `id_user`='$id_user'AND `id_discipline`='$id_dicsipline'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "User is deleted"
    ];
    echo json_encode($res);

}

// удалить УРОК
function deleteLesson($connect, $id_lesson){
    mysqli_query($connect,"DELETE FROM `lesson` WHERE `id_lesson`='$id_lesson' ");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Lesson is deleted"
    ];
    echo json_encode($res);

}

// удалить УРОК+ГРУППА
function deleteLesson_group($connect, $id_group, $id_lesson){
    mysqli_query($connect,"DELETE FROM `lesson_group` WHERE `id_group`='$id_group' AND  `id_lesson`='$id_lesson'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Lesson+group is deleted"
    ];
    echo json_encode($res);

}