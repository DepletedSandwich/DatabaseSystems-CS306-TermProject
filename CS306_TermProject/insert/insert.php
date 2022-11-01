<!DOCTYPE html>
<html>
    <head>
        <title>Insert Operation!</title>
        <script defer src="insertop.js"></script>
    </head>
    <body>
        <h1>Completed Redirect!</h1>
        <?php


        $servername="localhost";
        $usrname="root";
        $dbname="cs306_projectdb";

        $conn= new mysqli($servername,$usrname,"",$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $display_field = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = 'stadium'
        ORDER BY ORDINAL_POSITION";
        $field_array = array();
        if ($result = $conn -> query($display_field)) {
            while ($obj = $result -> fetch_object()) {
                if ($obj->COLUMN_NAME != "sid") {
                    array_push($field_array, $obj->COLUMN_NAME);
                }
            }
            $result -> free_result();
        }
        ?>
        <form action="insert.php" method="post">
            <?php
            foreach ($field_array as $name) {
                echo "<input type='text' placeholder='$name' name='$name' required>";
            }
            ?>
            <input type="submit">
        </form>
        <?php
        if ((empty($_POST["sname"]) and empty($_POST["slocation"]) and empty($_POST["scapacity"]) and empty($_POST["ssize"]))==false) {
            $insert_query= sprintf("INSERT INTO stadium(sname,slocation,scapacity,ssize) VALUES('%s','%s',%d,%d)",$_POST['sname'],$_POST['slocation'],$_POST['scapacity'],$_POST['ssize']);
            if ($conn->query($insert_query) === TRUE) {
                echo "New record created successfully";
                $conn->close();
                header("Location:http://localhost/CS306/index/index.php");
            }
        }
        ?>
    </body>
</html>