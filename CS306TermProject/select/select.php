<!DOCTYPE html>
<html>
    <head>
        <title>Select Operation</title>
        <style>
            table, th, td {
            border:1px solid black;
            }
        </style>
    </head>
    <body>
        <h1>Selection Tool</h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject");
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
        <form action="select.php" method="post">
            <input type="text" name="sid" placeholder="sid" required>
            <input type="submit">
        </form>
        <table>
        <tr>
            <?php
            foreach($header_array as $header){
                echo "<th>$header</th>";
            }           
            ?>
            </tr>
            <?php
            if (isset($_POST["sid"])==true) {
                global $selection_query;
                $selection_query = sprintf("SELECT * FROM stadium WHERE (sid)=%s",$_POST["sid"]);

                if ($conn->query($selection_query) == TRUE) {
                    echo "Selection of WHERE sid = " . $_POST["sid"];
                
                    //header("Location:http://localhost:9090/CS306/CS_306_Tuto/index/index.php");
                }
            }
            ?>
            
            <?php
            if (isset($_POST["sid"])==true) {
                $selection_query = sprintf("SELECT * FROM stadium WHERE (sid)=%s",$_POST["sid"]);
                if ($result = $conn -> query($selection_query)) {
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
            }
            
        ?>

        
        </table>
        <form method="post">
            <input type="submit" name="test" id="test" value="Go back to index?" /><br/>
        </form>

        <?php

        function testfun()
        {
            header("Location:http://localhost/CS306TermProject/CS306TermProject/index/index.php");
        }

        if(array_key_exists('test',$_POST)){
        testfun();
        }

        ?>
    </body>
</html>