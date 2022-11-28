<!DOCTYPE html>
<html>
    <head>
        <title>Delete Operation</title>
        <style>
            table, th, td {
            border:1px solid black;
            }
        </style>
    </head>
    <body>
        <h1>Deletion Tool</h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject");
        include 'config.php';
        $display_field = sprintf("SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '%s'
        ORDER BY ORDINAL_POSITION",$_GET["id"]);
        $header_array = array();
        if ($result = $conn -> query($display_field)) {
            while ($obj = $result -> fetch_object()) {
                array_push($header_array, $obj->COLUMN_NAME);
            }
            $result -> free_result();
        }
        ?>
        <table>
            <tr>
            <?php
            foreach($header_array as $header){
                echo "<th>$header</th>";
            }           
            ?>
            </tr>
            <?php
            $table_query = sprintf("SELECT * FROM %s",$_GET["id"]);
            if ($result = $conn -> query($table_query)) {
                while ($obj = $result -> fetch_array()) {?>
                    <tr>
                    <?php
                    for ($i=0; $i < count($header_array); $i++) {
                        $item=$obj[$i];
                        echo "<td>$item</td>";
                    }?>
                    </tr>
                <?php
                }
                $result -> free_result();
            }
        ?>
        </table>
        <form action="delete.php?id=<?php echo $_GET["id"]?>" method="post">
            <select name="primary_key">
                <?php
                $sid_table_query = sprintf("SELECT $header_array[0] FROM %s",$_GET["id"]);
                if ($result = $conn -> query($sid_table_query)){
                    while ($obj = $result -> fetch_array()) {   
                        for ($i=0; $i < sizeof($obj)-1; $i++) { 
                            $item = $obj[$i];
                            echo "<option>$item</option>";
                        }
                    }  
                }
                ?>
            </select>
            <input type="submit">
        </form>
        <?php
        if (empty($_POST["primary_key"])==false) {
            $deletion_query= sprintf("DELETE FROM %s WHERE $header_array[0]=%s",$_GET["id"],$_POST["primary_key"]);
            if ($conn->query($deletion_query) === TRUE) {
                $conn->close();
                header("Location:http://localhost/CS306TermProject/CS306TermProject/admin/admin.php");
            }
        }
        ?>
    </body>
</html>