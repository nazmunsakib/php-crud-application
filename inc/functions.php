<?php 
define("DB_NAME", "C:/xampp/htdocs/PHP-projects/php-crud/DB/db.txt");

function seed(){
    $data = [
        [
            "id" => 1,
            "name" => "Nazmun Sakib",
            "class" => 12,
            "roll" => "1",
        ],
        [
            "id" => 2,
            "name" => "Bill Grets",
            "class" => 12,
            "roll" => "2",
        ],
        [
            "id" => 3,
            "name" => "Mark Jukerbarg",
            "class" => 12,
            "roll" => "3",
        ],
        [
            "id" => 4,
            "name" => "Elon Maks",
            "class" => 12,
            "roll" => "4",
        ],
        [
            "id" => 5,
            "name" => "Einnstine",
            "class" => 12,
            "roll" => "5",
        ],
    ];
    $serializeData = serialize($data);
    file_put_contents(DB_NAME, $serializeData, LOCK_EX );
}

function generateReport(){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Class</th>
            <th>Roll</th>
            <?php if(hasPrivilege()):  ?>
                <th style="width:20%">Action</th>
            <?php endif;  ?>
        </tr>
        <?php foreach($students as $student): ?>
            <tr>
                <td><?php printf("%s", $student['id'] ); ?> :</td>
                <td><?php printf("%s", $student['name'] ); ?></td>
                <td><?php printf("%s", $student['class'] ); ?></td>
                <td><?php printf("%s", $student['roll'] ); ?></td>
                <?php if(isAdmin()):  ?>
                    <td><?php printf("<a href='index.php?task=edit&id=%s'>Edit</a> | <a href='index.php?task=delete&id=%s' class='delete' >Delete</a>", $student['id'], $student['id']); ?></th>
                <?php elseif(isEditor()):  ?>
                    <td><?php printf("<a href='index.php?task=edit&id=%s'>Edit</a>", $student['id']); ?></th>
                <?php endif;  ?>
                
            </tr>
        <?php endforeach; ?> 
    </table>
    <?php
}

function addStudent($name, $class, $roll){
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $_student){
        if($_student['roll'] == $roll){
            $found = true;
            break;
        }
    }
    if(!$found){
        $student = [
            "id" => getNewId($students),
            "name" => $name,
            "class" => $class,
            "roll" => $roll,
        ];
        array_push($students, $student);
        $addSerializeData = serialize($students);
        file_put_contents(DB_NAME, $addSerializeData, LOCK_EX );
        return true;
    }
    return false;
}

function getStudent($id){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $student){
        if( $student['id'] == $id ){
            return $student;
        }
    }
    return false;
}

function updateStudent($id, $name, $class, $roll){
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $student){
        if($student['roll'] == $roll && $student['id'] != $id){
            $found = true;
        }
    }
    if(!$found){
        $students[$id -1]['name'] = $name;
        $students[$id -1]['class'] = $class;
        $students[$id -1]['roll'] = $roll;
        $updateSerializeData = serialize($students);
        file_put_contents(DB_NAME, $updateSerializeData, LOCK_EX );
        return true;
    }
    return false;

}
function test(){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    print_r($students);
}

function deleteStudent($id){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $offset=>$student){
        if( $student['id'] == $id ){
            unset($students[$offset]);
        }
    }
    $serializedData               = serialize( $students );
	file_put_contents( DB_NAME, $serializedData, LOCK_EX );
}

function getNewId($studemts){
    $maxId = max(array_column($studemts, 'id'));
    return $maxId+1;
}

function isAdmin(){
    if(isset( $_SESSION['role'])):
        return ('admin' == $_SESSION['role']) ;
    endif;
}
function isEditor(){
    if(isset( $_SESSION['role'])):
        return ('editor' == $_SESSION['role'] );
    endif;
}
function hasPrivilege(){
    return (isAdmin() || isEditor() );
}
