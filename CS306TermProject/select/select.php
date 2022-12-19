<!DOCTYPE html>
<html>
    <head>
        <title>Select Operation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="selectstyle.css">
        <script defer src="../Misc/redirect.js"></script>
    </head>
    <body>
        <h1><span><button id="redirectbtn" onclick="redirect_table_index('<?php echo $_GET['id']?>')"><i class="arrow left"></i></button></span>Selecting rows from <span id="tbl_name"><?php echo $_GET["id"];?></span></h1>
        <?php
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");
        include 'config.php';
        include 'datatable.php';
        $display_field = sprintf("SELECT COLUMN_NAME,DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = '%s'
        ORDER BY ORDINAL_POSITION",$_GET["id"]);

        $field_array = array();
        if ($result = $conn -> query($display_field)) {
            $counter = 0;
            while ($obj = $result -> fetch_object()) { //Because of autoincrement we don't take primary key as input
                    $field_array[$obj->COLUMN_NAME] = $obj->DATA_TYPE;
            }
            $result -> free_result();
        }
        ?>

        <div class="container form-container">
            <div class="row form-row" style="width: 100%;">
                <form action="select.php?id=<?php echo $_GET["id"]?>" method="post">
                    <?php
                    foreach ($field_array as $column_name => $data_type) {
                        echo '<div class="form-group row">';
                        echo "<label class="."col-sm-3 col-form-label"." for=".$column_name.">$column_name:</label>";
                        if ($data_type == "char" or $data_type == "int" or $data_type == "double") {
                            echo "<div class='col-sm-9'><input type='text' id='$column_name' name='$column_name' placeholder='$data_type' ></div>";
                        }
                        elseif($data_type == "date"){
                            echo "<div class='col-sm-9'><input type='text' id='$column_name' name='$column_name' placeholder='$data_type' ></div>";
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="form-group row">
                        <span class="col-sm-3"></span>
                        <div class="col-sm-9">
                            <input type="submit" value="Submit Specifications">
                        </div> 
                    </div>
                </form>
            </div>
        </div>

        <?php
        if(count($_POST)>0){
            $select_query = sprintf("SELECT *");
            $column_num = 0;
            foreach($field_array as $column_name => $data_type){
                $column_num = $column_num + 1;
            }
            $select_query = $select_query.sprintf(" FROM %s WHERE ",$_GET["id"]);
            foreach($field_array as $column_name => $data_type){
                if($_POST[$column_name] != ""){
                    $select_query = $select_query.$_POST[$column_name]." AND ";
                }
            }
            
            if($column_num != 0){
                $select_query=substr_replace($select_query," ",-4);
            }
            else{
                $select_query = sprintf("SELECT * FROM %s ",$_GET["id"]);
            }
        }
        ?>

        <table id="select_table" style="overflow-x:auto;">
            <tr>
            <?php
                if(count($_POST)>0){
                    foreach($field_array as $column_name => $data_type){
                        echo "<th>$column_name</th>";
                    }
                } 
            ?>
            </tr>
            <?php
            if(count($_POST)>0)if($result = $conn -> query($select_query)) {
                while ($obj = $result -> fetch_array()) {?>
                    <tr>
                    <?php
                    for ($i=0; $i < $column_num; $i++) {
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
    </body>
</html>