<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        <script defer src="index_red.js"></script>
        <link rel="stylesheet" href="index.css">
    </head>
    <body>
    <?php echo '<h1>Editing the <span id="tbl">'.ucfirst($_GET["id"]).'</span> table</h1>';?>
    <div class = "btnedt">
        <button class="idxbutton" id ="insert" onclick="rname('insert')">Insert</button>
        <button class="idxbutton" id ="delete" onclick="rname('delete')">Delete</button>
        <button class="idxbutton" id ="select" onclick="rname('select')">Select</button>
    </div>
    </body>
</html>