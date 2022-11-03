<!DOCTYPE html>
<html>
    <head>
        <title>Selection Operation</title>
    </head>
    <body>
        <h1>Selection Tool</h1>
        <label for="fields">Choose filter column:</label>
        <form action="select.php" method="post" name="taskOption">
            <select name="taskOption">
                <?php
                set_include_path('D:\XAMPP\htdocs\CS306\CS306TermProject');
                include 'config.php';
                $display_field = "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = 'stadium'
                ORDER BY ORDINAL_POSITION";
                $header_array = array();
                if ($result = $conn -> query($display_field)) {
                    while($obj = $result -> fetch_object()) {
                        array_push($header_array, $obj->COLUMN_NAME);
                    }
                    $result -> free_result();
                }
                foreach($header_array as $item){
                    $select_item= sprintf('<option value="%s">%s</option>',$item,ucfirst($item));
                    echo $select_item;
                }
                ?>

            </select>
            <input type="submit">
        </form>
        <?php
        if(empty($_POST["taskOption"])==false){
            if ($_POST["taskOption"]=="sid"){
                $query_key = $_POST["taskOption"];
                echo '<label for="range">Give range for sid:</label><form name="range" action="select.php" method="post"><input type="text" placeholder="greater than"><input type="text" placeholder="lesser than"><input type="submit"></form>';
            }else{
                echo "sid else";
            }
        }?>
    </body>
</html>