<!DOCTYPE html>
<html lang="en">
<?php 
    require_once 'inc/functions.php';
    $info = "";
    $task = $_GET['task']??'report';
    if('seed'==$task){
        seed();
        $info = "Seeding is complete";
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD Project</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container main-container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <header class="app-header">
                    <h1>Students Info</h1>
                    <p>Your Students Management Dashboard, You can change your all students information hare</p>
                    <hr>
                    <?php include_once ('templates/nav.php'); ?>
                    <hr>
                </header>
            </div>
        </div>

        <div class="row">
            <div class="column column-60 column-offset-20">
                <p><?php echo "{$info}";?></p>
            </div>
        </div>

        <?php if('report'==$task):?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <h2>All Students Repor</h2>
                    <?php generateReport(); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>