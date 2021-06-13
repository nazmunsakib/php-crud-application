<?php 
define("DB_NAME", "C:/xampp/htdocs/PHP-projects/php-crud/DB/db.txt");

function seed(){
    $data = [
        [
            "name" => "Nazmun Sakib",
            "class" => 12,
            "roll" => "01",
        ],
        [
            "name" => "Bill Grets",
            "class" => 12,
            "roll" => "02",
        ],
        [
            "name" => "Mark Jukerbarg",
            "class" => 12,
            "roll" => "03",
        ],
        [
            "name" => "Elon Maks",
            "class" => 12,
            "roll" => "04",
        ],
        [
            "name" => "Einnstine",
            "class" => 12,
            "roll" => "05",
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
            <th>Name</th>
            <th>Class</th>
            <th>Roll</th>
            <th style="width:20%">Action</th>
        </tr>
        <?php foreach($students as $student): ?>
            <tr>
                <td><?php printf("%s", $student['name'] ); ?></td>
                <td><?php printf("%s", $student['class'] ); ?></td>
                <td><?php printf("%s", $student['roll'] ); ?></td>
                <td><?php printf("<a href='index.php?task=edit&id=%s'>Edit</a> | <a href='index.php?task=delete&id=%s'>Delete</a>", $student['roll'], $student['roll']); ?></th>
            </tr>
        <?php endforeach; ?> 
    </table>
    <?php
}