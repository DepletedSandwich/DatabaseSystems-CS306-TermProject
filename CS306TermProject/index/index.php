<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        <script defer src="../Misc/redirect.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
        <h1><span><button id="redirectbtn" onclick="redirectadmin()"><i class="arrow left"></i></button></span>Editing the <span id="tblname"><?php echo $_GET["id"];?></span> table</h1>
    <?php
    set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");
    include 'config.php';
    include 'datatable.php';
    ?>
        <div class = "btnedt">
            <div id="btnpos">
                <button class="idxbutton" id ="insert" onclick="rname('insert')">Insert</button>
                <button class="idxbutton" id ="delete" onclick="rname('delete')">Delete</button>
                <button class="idxbutton" id ="select" onclick="rname('select')">Select</button>
            </div>
        </div>
    </body>
</html>