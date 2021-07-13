<?php
?>
<nav class="overflow-hidden">
    <div class="float-left">
            <a href="index.php?task=report">All Student</a>
            <?php if(hasPrivilege()): ?> 
                | <a href="index.php?task=add">Add New Student</a> 
            <?php endif; ?>
            <?php if(isAdmin()): ?>
                | <a href="index.php?task=seed">Seed</a>
            <?php endif; ?>
    </div>
    <div class="float-right">
        <?php if(!isset($_SESSION['loggedin']) ): ?>
            <a href="auth.php">Log In</a>
            <?php elseif($_SESSION['loggedin']): ?>
            <a href="auth.php?logout=true">Log Out > <?php echo $_SESSION['role'] ?></a>
        <?php endif; ?>
    </div>
</nav>


