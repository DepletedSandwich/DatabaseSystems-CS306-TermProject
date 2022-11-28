<!DOCTYPE html>
<html>
    <head>
        <title>Insert Operation!</title>
    </head>
    <body>
        <h1>Insert Operation Tool</h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject");        
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
        <form action="insert.php?id=<?php echo $_GET["id"]?>" method="post">
            <?php
            foreach ($field_array as $column_name => $data_type) {
                if ($data_type == "char" or $data_type == "int") {
                    echo "<input type='text' placeholder='$column_name' name='$column_name' required>";
                }
                elseif($data_type == "date"){
                    echo "<input type='date'name='$column_name' required>";
                }
            }
            ?>
            <input type="submit">
        </form>
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