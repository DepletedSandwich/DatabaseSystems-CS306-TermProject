<!DOCTYPE html>
<html>
    <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="adminstyle.css">
    </head>
    <body>
        <h1>Welcome, admin!</h1>
        <?php 
        set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");
        include 'config.php';
        $dbtable_query="SHOW TABLES";
        $querytableitem = array();
        if($result = $conn -> query($dbtable_query)){
            while ($obj = $result -> fetch_array()) {
                for ($i=0; $i<count($obj)-1 ; $i++) { 
                    array_push($querytableitem,$obj[$i]);
                }
            }
        }
        ?>
        <table>
            <tr><th>Tables of database</th></tr>
            <?php
            for ($i=0; $i < count($querytableitem); $i++) {
                ?><tr><td><a href="http://localhost/CS306TermProject/CS306TermProject/index/index.php?id=<?php echo $querytableitem[$i];?>" id="<?php echo $querytableitem[$i];?>"><?php echo ucfirst($querytableitem[$i]);?></a></td></tr> <?php
            }
            ?>
        </table>
    </body>
</html>