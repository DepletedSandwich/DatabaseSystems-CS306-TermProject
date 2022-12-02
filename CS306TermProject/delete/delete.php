<!DOCTYPE html>
<html>
    <head>
        <title>Delete Operation</title>
        <link rel="stylesheet" href="deletestyle.css">
    </head>
    <body>
        <h1>Deleting tuple from <span id="tbl_name"><?php echo $_GET["id"];?></span></h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");
        include 'config.php';
        include 'datatable.php';
        ?>
        <form action="delete.php?id=<?php echo $_GET["id"]?>" method="post">
            <div id="adj_id">
                <label for="lbl_id">Select primary key:</label>
                    <div id="Loc_id">
                    <select id="lbl_id" name="primary_key">
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
                    <input type="submit" value="Delete">
                </div>
            </div>
        </form>
        <?php
        /*Assuming primary key is the first column*/
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