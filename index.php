<!DOCTYPE html>
<html lang="en">
<?php 
 session_name("userLogin");
 session_start();
    require_once 'inc/functions.php';
    $info = "";
    $task = $_GET['task']??'report';
    $error = '0';
    if('seed'==$task){
        seed();
        $info = "Seeding is complete";
    }
    $name = '';
    $class = '';
    $roll = '';
    if(isset($_POST['submit'])){
        $name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
        $class = filter_input( INPUT_POST, 'class', FILTER_SANITIZE_STRING );
        $roll = filter_input( INPUT_POST, 'roll', FILTER_SANITIZE_STRING );
        $id = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_STRING );
        if($id){
            if($id !='' && $name !='' && $class !='' && $roll !=''){
                if(!hasPrivilege()){
                    header('location: index.php?task=report');
                    return;
                }
            $updateStudent = updateStudent($id, $name, $class, $roll);
            header('location: index.php?task=report');
            if($updateStudent){
                header('location: index.php?task=report');
               }else{
                    $error = '404'; 
               }
             }
        }else{
            if($name !='' && $class !='' && $roll !=''){
                if(!isAdmin()){
                    header('location: index.php?task=report');
                    return;
                }
                $studentSubmit = addStudent($name, $class, $roll);
                if($studentSubmit){
                 header('location: index.php?task=report');
                }else{
                     $error = '404'; 
                }
             }
        }
    }
    if('delete'==$task){
        if(!isAdmin()){
            header('location: index.php?task=report');
            return;
        }
        $id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
        if($id>0){
            deleteStudent($id);
            header('location: index.php?task=report');
        }
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
        <?php if('add'==$task):?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <h2>Add A New Student</h2>
                    <?php if('404'==$error): ?>
                        <blockquote>
                            The <?php echo $roll; ?> Roll numder is already exist to Another One
                        </blockquote>
                    <?php endif; ?>
                    <form action="index.php?task=add" method="POST">
                        <label for="name">Your Name</label>
                        <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                        <label for="class">Your Class</label>
                        <input type="number" name="class" id="" value="<?php echo $class; ?>" >
                        <label for="roll">Your Roll</label>
                        <input type="number" name="roll" id="" value="<?php echo $roll; ?>">
                        <button type="submit" name="submit" class="button button-primary">SUBMIT</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php 
            if('edit'==$task):
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
             $student = getStudent($id);
             if($student):
            ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <h2>Update Student</h2>
                    <?php if('404'==$error): ?>
                        <blockquote>
                            The <?php echo $roll; ?> Roll numder is already exist to Another One
                        </blockquote>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" >
                        <label for="name">Your Name</label>
                        <input type="text" name="name" id="name" value="<?php echo $student['name']; ?>">
                        <label for="class">Your Class</label>
                        <input type="number" name="class" id="" value="<?php echo $student['class']; ?>" >
                        <label for="roll">Your Roll</label>
                        <input type="number" name="roll" id="" value="<?php echo $student['roll']; ?>">
                        <button type="submit" name="submit" class="button button-primary">UPDATE</button>
                    </form>
                </div>
            </div>
        <?php 
            endif; 
        endif; 
        ?>

    </div>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>