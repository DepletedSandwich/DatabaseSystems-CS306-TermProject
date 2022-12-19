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
            #league_name span{
                color: red;
                font-style: italic;
            }
            #league_stats{
                font-style: italic;
            }
            #lgtbtn{
                border:none;
                background-color:transparent;
                color:white;
                transition: all 0.5s;
                cursor: pointer;
            }
            #lgtspan{
                cursor: pointer;
                display: inline-block;
                position: relative;
                transition: 0.5s;
            }
            #lgtbtn #lgtspan:after {
              content: '\00bb';
              position: absolute;
              opacity: 0;
              top: 0;
              right: -20px;
              transition: 0.5s;
            }
            #lgtbtn:hover #lgtspan {
              padding-right: 25px;
            }
            #lgtbtn:hover #lgtspan:after {
              opacity: 1;
              right: 0;
            }
        </style>
        <script defer src="../Misc/redirect.js"></script>
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
                    <a class="nav-link" href="http://localhost/CS306TermProject/CS306TermProject/user/user.php?option=leagues">Leagues</a>
                </li>
              </ul>
            </div>
            <button id="lgtbtn" onclick="redirect_logout()"><span id="lgtspan">Log out</span></button>
          </nav>
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
            $team_names_query = "SELECT teamname FROM teams";
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
        if (empty($_POST) !== TRUE) {
            $team_name = $_POST["teams"];
            $val=mysqli_real_escape_string($conn,$team_name);

            $team_info_query = 'SELECT teams.founddate, stadiums.sname, technic_directors.tname,leagues.lgname
            FROM teams
            INNER JOIN stadiums
            INNER JOIN technic_directors
            INNER JOIN leagues
            WHERE stadiums.sid = teams.teamstadiumid AND technic_directors.tid=teams.teamtechnicdirectorid AND leagues.lgid=teams.teamleagueid AND teams.teamname="'.$val.'"';
            if ($result = $conn->query($team_info_query)) {
                if($obj = $result->fetch_object()) {?>
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
            INNER JOIN teams ON players.pteamid = teams.teamid
            WHERE teams.teamname="'.$_POST["teams"].'"';?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Birthplace</th>
                    <th>Birthdate</th>
                    <th>Position</th>
                    <th>Height(cm)</th>
                    <th>Weight(kg)</th>
                    <th>Contract Start</th>
                    <th>Contract End</th>
                    <th>Wage(€)</th>
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
    }elseif ($_GET["option"] == "leagues") {?>
        <form action="user.php?option=leagues" method="post">
            <select class ="form-select" name="leagues" id="leagues">
                <?php
                $team_names_query = "SELECT lgname FROM leagues ORDER BY lgid";
                if ($result = $conn->query($team_names_query)) {
                    while($obj = $result->fetch_object()){ 
                        echo "<option>".$obj->lgname."</option>";
                    }
                }
                ?>
            </select>
        <button>Fetch Result</button>
        </form>
    <?php
        if (empty($_POST) !== TRUE) {
            $league_name = $_POST["leagues"];
            $val=mysqli_real_escape_string($conn,$league_name);

            $league_info_query = "SELECT leagues.lgname,tff_managers.mname,leagues.managed_since
            FROM leagues
            INNER JOIN tff_managers
            WHERE leagues.manager_id = tff_managers.mtffid AND leagues.lgname = '".$val."'";
            if ($result = $conn->query($league_info_query)) {
                if($obj = $result->fetch_object()) {?>
                    <h1 id="league_name">League Name: <span><?php echo $_POST["leagues"];?></span></h1>
                    <div id="teaminfo">
                        <h4>Manager: <span><?php echo $obj->mname;?></span></h4>
                        <h4>Manager Since: <span><?php $fdate= getDate(strtotime($obj->managed_since)); echo $fdate["mday"]." ".$fdate["month"]." ".$fdate["year"];?></span></h4>
                    </div>
            <?php
                }
            }

            $player_stats_query = "SELECT teams.teamname,players.pposition,players.pname,player_stats.pmatchattended,player_stats.pgoal,player_stats.passist,player_stats.ppasspercentage,player_stats.predcard,player_stats.pyellowcard
            FROM (((leagues INNER JOIN teams ON teams.teamleagueid = leagues.lgid) INNER JOIN players ON players.pteamid=teams.teamid) INNER JOIN player_stats ON player_stats.statid = players.pstatid)
            WHERE leagues.lgname = '".$val."' ORDER BY player_stats.pmatchattended DESC";?>
            <h3 id="league_stats">League Player Stats: </h3>
            <table>
                <tr>
                    <th>Team Name</th>
                    <th>Player Position</th>
                    <th>Player Name</th>
                    <th>Attended Matches</th>
                    <th>Goals</th>
                    <th>Assists</th>
                    <th>Pass Percentage(%)</th>
                    <th>Red Cards</th>
                    <th>Yellow Cards</th>
                </tr>
            <?php
            if ($result = $conn->query($player_stats_query)) {
                while ($obj = $result->fetch_object()) {
                    echo "<tr>";
                    foreach ($obj as $key => $value) {
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                }
            }
            ?>
        </table>
    <?php
    }
}
    ?>
    </body>
</html>