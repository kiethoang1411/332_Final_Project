<?php
    include_once 'mysql_connector.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Database Interface</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <div class="center">
            <h1>CPSC 332 File Structures and Database Systems</h1>

            <form method="post">
                <button type="submit" name="professors" value="Professors">Professors</button>
                <button type="submit" name="students" value="Students">Students</button>
            </form>
        </div>
    </body>
</html>


<?php
    // Controller for professors/students options
    if(isset($_POST['students'])){
        header("Location: student.php");
    }

    if(isset($_POST['professors'])){
        header("Location: professor.php");
    }
?>
