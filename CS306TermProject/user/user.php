<!DOCTYPE html>
<html>
    <head>
        <title>User Panel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style>
            table {
              font-family: Arial, Helvetica, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }

            table td, table th {
              border: 1px solid #ddd;
              padding: 8px;
            }

            table tr:nth-child(even){background-color: #f2f2f2;}

            table tr:hover {background-color: #ddd;}

            table th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              color: white;
              background-color: purple;
              font-size: small;
            }
            #teaminfo span{
                font-style: italic;
                color:purple;
            }
            #teaminfo{
                width: 50%;
                border: 2px solid;
                border-radius: 10px;
            }
            #team_name span{
                color: red;
                font-style: italic;
            }
            #team_roster_label{
                font-weight: bold;
                font-style: italic;
            }
            #teamroster{
                font-style: italic;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <h1 class="navbar-brand">Welcome, user!</h1>
            <div class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/CS306TermProject/CS306TermProject/user/user.php?option=matches">Matches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/CS306TermProject/CS306TermProject/user/user.php?option=refrankings">Referee Rankings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/CS306TermProject/CS306TermProject/user/user.php?option=teams">Teams</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/CS306TermProject/CS306TermProject/user/user.php?option=players">Players</a>
                </li>
              </ul>
            </div>
          </nav>
    </body>
    <?php
    set_include_path("/xampp/htdocs/CS306TermProject/CS306TermProject/Misc");
    include 'config.php';
    if ($_GET["option"] == "matches") {
        $header_view_query="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'user_matches'";
        $header_array = array();
        if ($result = $conn -> query($header_view_query)) {
            while($obj = $result -> fetch_object()) {
                array_push($header_array,$obj->COLUMN_NAME);
            }
            $result -> free_result();
        }
        ?>
        <table>
            <tr>
                <?php
                foreach ($header_array as $header) {
                    $header=str_replace("_"," ",$header);
                    echo "<th>$header</th>";
                }
                ?>
            </tr>
            <?php
            $user_match_data_query = "SELECT * FROM user_matches ORDER BY Date_of_Match";
            if ($result = $conn -> query($user_match_data_query)) {
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
    <?php
    } elseif ($_GET["option"] == "refrankings") {
        $header_view_query="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'user_referee_rankings'";
        $header_array = array();
        if ($result = $conn -> query($header_view_query)) {
            while($obj = $result -> fetch_object()) {
                array_push($header_array,$obj->COLUMN_NAME);
            }
            $result -> free_result();
        }
        ?>
        <table>
            <tr>
                <?php
                foreach ($header_array as $header) {
                    $header=str_replace("_"," ",$header);
                    echo "<th>$header</th>";
                }
                ?>
            </tr>
            <?php
            $user_match_data_query = "SELECT * FROM user_referee_rankings";
            if ($result = $conn -> query($user_match_data_query)) {
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
    <?php
    } elseif ($_GET["option"] == "teams") {?>
    <form action="user.php?option=teams" method="post">
        <select class ="form-select" name="teams" id="teams">
            <?php
            $team_names_query = "SELECT teamname FROM team";
            if ($result = $conn->query($team_names_query)) {
                while($obj = $result->fetch_object()){ 
                    echo "<option>".$obj->teamname."</option>";
                }
            }
            ?>
        </select>
        <button>Fetch Result</button>
    </form>
    <?php
        if (!empty($_POST)) {
            $team_info_query = 'SELECT team.founddate, stadium.sname, technicdirector.tname,leagues.lgname
            FROM team
            INNER JOIN stadium
            INNER JOIN technicdirector
            INNER JOIN leagues
            WHERE stadium.sid = team.teamstadiumid AND technicdirector.tid=team.teamtechnicdirectorid AND leagues.lgid=team.teamleagueid AND team.teamname="'.$_POST["teams"].'"';
            if ($result = $conn->query($team_info_query)) {
                while ($obj = $result->fetch_object()) {?>
                    <h1 id="team_name">Team Name: <span><?php echo $_POST["teams"];?></span></h1>
                    <div id="teaminfo">
                        <h4>Found in: <span><?php $fdate= getDate(strtotime($obj->founddate)); echo $fdate["mday"]." ".$fdate["month"]." ".$fdate["year"];?></span></h4>
                        <h4>Stadium: <span><?php echo $obj->sname;?></span> </h4>
                        <h4>Technic Director/Manager: <span><?php echo $obj->tname;?></span></h4>
                        <h4>League: <span><?php echo $obj->lgname;?></span></h4>
                    </div>
                <?php
                }
            }?>
            <h3 id="teamroster">Team Roster: </h3>
            <table>
            <?php
            $team_roster_query = 'SELECT players.pname,players.pbirthplace,players.pbirthdate,players.pposition,players.pheight,players.pweight,players.pcontractstart,players.pcontractend,players.pwage
            FROM players
            INNER JOIN team ON players.pteamid = team.teamid
            WHERE team.teamname="'.$_POST["teams"].'"';?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Birthplace</th>
                    <th>Birthdate</th>
                    <th>Position</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>Contract Start</th>
                    <th>Contract End</th>
                    <th>Wage</th>
                </tr>
            <?php
            if ($result = $conn->query($team_roster_query)) {
                while ($obj = $result->fetch_object()) {
                    echo "<tr>";
                    foreach ($obj as $key => $value) {
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                }
            }?>
            </table>
    <?php
    }
    }elseif ($_GET["option"] == "players") {
        echo "teams";
    }
    ?>
</html>