<style>
#tbl {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#tbl td, #tbl th {
  border: 1px solid #ddd;
  padding: 8px;
}

#tbl tr:nth-child(even){background-color: #f2f2f2;}

#tbl tr:hover {background-color: #ddd;}

#tbl th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: red;
  color: white;
  font-size: small;
}
</style>

<?php
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
<table id="tbl" style="overflow-x:auto;">
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