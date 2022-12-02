<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <title>Insert Operation!</title>
        <link rel="stylesheet" href="insertstyle.css">
    </head>
    <body>
        <h1>Inserting row into <span id="tbl"><?php echo $_GET["id"];?></span></h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");        
        include 'config.php';
        $display_field = sprintf("SELECT COLUMN_NAME,DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '%s'
        ORDER BY ORDINAL_POSITION",$_GET["id"]);

        $field_array = array();
        if ($result = $conn -> query($display_field)) {
            $counter = 0;
            while ($obj = $result -> fetch_object()) { //Because of autoincrement we don't take primary key as input
                if ($counter == 0) {
                    $counter++;
                }else{
                    $field_array[$obj->COLUMN_NAME] = $obj->DATA_TYPE;
                }
            }
            $result -> free_result();
        }
        ?>
        <div class="container form-container">
            <div class="row form-row" style="width: 100%;">
                <form action="insert.php?id=<?php echo $_GET["id"]?>" method="post">
                    <?php
                    foreach ($field_array as $column_name => $data_type) {
                        echo '<div class="form-group row">';
                        echo "<label class="."col-sm-3 col-form-label"." for=".$column_name.">$column_name:</label>";
                        if ($data_type == "char" or $data_type == "int") {
                            echo "<div class='col-sm-9'><input type='text' id='$column_name' name='$column_name' placeholder='$column_name' required></div>";
                        }
                        elseif($data_type == "date"){
                            echo "<div class='col-sm-9'><input type='date' id='$column_name' name='$column_name' required></div>";
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group row">
                        <span class="col-sm-3"></span>
                        <div class="col-sm-9">
                            <input type="submit" value="Insert">
                        </div> 
                    </div>
                </form>
            </div>
        </div>
        <?php
        if(count($_POST)>0){
            $insert_query = sprintf("INSERT INTO %s(",$_GET["id"]);
            foreach($field_array as $column_name => $data_type){
                $insert_query = $insert_query.$column_name.",";
            }
            $insert_query=substr_replace($insert_query,"",-1);
            $insert_query = $insert_query.") VALUES(";
            foreach ($field_array as $column_name => $data_type) {
                if ($data_type == "char" or $data_type == "date") {
                    $insert_query = $insert_query."'".$_POST[$column_name]."',";
                }
                else if($data_type == "int"){
                    $insert_query = $insert_query.$_POST[$column_name].",";
                }
            }
            $insert_query=substr_replace($insert_query,"",-1);
            $insert_query=$insert_query.")";
            if ($conn->query($insert_query) === TRUE) {
                $conn->close();
                header("Location:http://localhost/CS306TermProject/CS306TermProject/admin/admin.php");
            }
        }
        ?>
    </body>
</html>