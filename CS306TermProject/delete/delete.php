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
        set_include_path('D:\XAMPP\htdocs\CS306\CS306TermProject');
        include 'config.php';
        $display_field = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = 'stadium'
        ORDER BY ORDINAL_POSITION";
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
            $table_query = "SELECT * FROM stadium";
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
        <form action="delete.php" method="post">
            <input type="text" name="sid" placeholder="sid" required>
            <input type="submit">
        </form>
        <?php
        if (empty($_POST["sid"])==false) {
            $deletion_query= sprintf("DELETE FROM stadium WHERE sid=%s",$_POST["sid"]);
            if ($conn->query($deletion_query) === TRUE) {
                echo "New record created successfully";
                $conn->close();
                header("Location:http://localhost/CS306/CS306TermProject/index/index.php");
            }
        }
        ?>
    </body>
</html>