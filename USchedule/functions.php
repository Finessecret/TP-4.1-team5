<?php

/*
 * отобразить список  строк таблицы
*/
 function getDisciplines($connect){   //таблица дисциплин
     $disciplines = mysqli_query($connect,"SELECT * FROM `discipline`");

     $tablelist = [];

     while ($tableRow = mysqli_fetch_assoc($disciplines)){
         $tablelist[] = $tableRow;
     }
     echo json_encode($tablelist);
 }

function getLessons($connect){    //таблица уроков
    $lessons = mysqli_query($connect,"SELECT * FROM `lesson`");

    $tableList = [];

    while ($tableRow = mysqli_fetch_assoc($lessons)){
        $tableList[] = $tableRow;
    }
    echo json_encode($tableList);
}


/*
 * отобразить одну строку из таблицы
*/
function getDiscipline($connect, $id){ // отобразить одну дисциплину
    $dis= mysqli_query($connect,"SELECT * FROM `discipline` WHERE `id_discipline` = '$id'");

    if(mysqli_num_rows($dis) === 0){
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Discipline not found"
        ];
        echo json_encode($res);
    }else {
        $dis = mysqli_fetch_assoc($dis);
        echo json_encode($dis);
    }
}


/*
 * добавить запись в одну из таблиц
*/
function addDisciplines($connect,$data){ // добавить дисциплину
    $id = $data['id'];
    $name = $data['name'];
    mysqli_query($connect, "INSERT INTO `discipline`(`id_discipline`, `name_discipline`) VALUES ('$id' ,'$name') ");

    http_response_code(201);

    $res = [
        "status" => true,
        "message" => "Discipline is created"
    ];
    echo json_encode($res);
}


/*
 * обновить запись в одной из таблиц
*/
function updateDisciplines($connect,$id, $data){ // обновить дисциплину
    $name = $data['name_discipline'];
    mysqli_query($connect,"UPDATE `discipline` SET `name_discipline`='$name' WHERE `id_discipline`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Discipline is updated"
    ];
    echo json_encode($res);
}


/*
 * удалить одну запись из таблицы
*/
function deleteDiscipline($connect, $id){ // удалить дисциплину
    mysqli_query($connect,"DELETE FROM `discipline` WHERE `id_discipline`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Discipline is deleted"
    ];
    echo json_encode($res);

}

function deleteLesson($connect, $id){ // удалить урок
    mysqli_query($connect,"DELETE FROM `discipline` WHERE `id_discipline`='$id'");

    http_response_code(200);

    $res = [
        "status" => true,
        "message" => "Lesson is deleted"
    ];
    echo json_encode($res);

}


/*
 * поиск по таблицам
*/
function findFromTables($connect, $findPart){
    $tables = ['auditorium', 'discipline', 'faculty', 'groupp'];
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

        }else {
            $dis = mysqli_fetch_all($dis);
            echo $dis;
            echo '{
                table:',$table, ',
                row:',$map[$table], ',
                val:',json_encode($dis), '
            }';
        }
    }
}