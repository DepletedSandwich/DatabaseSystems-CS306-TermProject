<!DOCTYPE html>
<html>
    <head>
        <title>Select Operation</title>
        <link rel="stylesheet" href="selectstyle.css">
        <style>
            
        </style>
    </head>
    <body>
        <h1>Selecting rows from <span id="tbl_name"><?php echo $_GET["id"];?></span></h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");
        include 'config.php';
        include 'datatable.php';
        ?>
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
                
                    header("Location:http://localhost/CS306/CS_306_Tuto/index/index.php?id=stadium");
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
            header("Location:http://localhost/CS306TermProject/CS306TermProject/admin/admin.php");
        }

        if(array_key_exists('test',$_POST)){
        testfun();
        }

        ?>
    </body>
</html>