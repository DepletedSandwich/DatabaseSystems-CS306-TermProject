<!DOCTYPE html>
<html>
    <head>
        <title>Selection Operation</title>
        <script defer src="select_form.js"></script>
        <?php
        set_include_path('D:\XAMPP\htdocs\CS306\CS306TermProject');
        include 'config.php';
        $display_field = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = 'stadium'
        ORDER BY ORDINAL_POSITION";
        $header_array = array();
        ?>
    </head>
    <body id="anchor">
        <h1>Selection Tool</h1>
        <label for="fields">Choose filter column:</label>
            <select id="taskOption" onchange="select_hover()">
                <?php
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
            <?php
            vardump($_POST);
            
            ?>
    </body>
</html>