<?php


			include('/scripts/function.php');
            include('config.php');
  			$conn = mysql_connect($config['host'], $config['user'], $config['pass']);

			if (!$conn) {
			    echo "Unable to connect to DB: " . mysql_error();
  				exit;
			}
			
			
			if (!mysql_select_db($config['db'])) {
			    echo "Unable to select mydbname: " . mysql_error();
			    exit;
			}
			
			
       		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
        	$limit = 15;
        	$startpoint = ($page * $limit) - $limit;
			
			$statement = "";
			
			if(isset($_GET['username'])){
				$statement = "SELECT * FROM ".$config['tbl_prefix']."players WHERE username  LIKE  '%".$_GET['username']."%' ORDER BY id DESC LIMIT {$startpoint} , {$limit}";	
			}else{
				$statement = "SELECT * FROM ".$config['tbl_prefix']."players ORDER BY id DESC LIMIT {$startpoint} , {$limit}";	
			}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>LegendaryMessages Interface</title>
    <meta name="description" content="A new bootstrap theme">
    <meta name="author" content="Damian Sowers">
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600' rel='stylesheet' type='text/css'>
    <link href='css/corgi.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/elusive-webfont.css">
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/corgi.js" type="text/javascript"></script>
    <!-- elusive icons ie7 support -->
    <!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
    <style>
      body {
        padding-top: 80px; /* Only include this for the fixed top bar */
      }
    </style>
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php">LegendaryMessages</a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li class="active"><a href="index.php">Home</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row"><!-- end span8 -->
        <div class="span12">
        
        <button type="button" class="btn btn-inverse" data-toggle="collapse" data-parent="#accordion2" data-target="#collapseOne">
  Global Stats
</button>
<button type="button" class="btn btn-inverse" data-toggle="collapse" data-parent="#accordion2" data-target="#collapseTwo">
  Search
</button>
        
          <div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
      
      
                <div class="corgi_feed_well">
            <div class="sidebar_header">
              <div class="sidebar_title">
                <h4>Global Stats</h4>
              </div>
            </div>
            <hr class="feed_hr" />
            <div class="sidebar_interior">
<table width="100%" border="0" cellspacing="5" cellpadding="5" class="table table-bordered table-striped">
  <tr>
    <th>Total Players</th>
    <th>Newest Player</th>
  </tr>
  <tr>
    <td><?php
    $sql = mysql_query("SELECT total_players from ".$config['tbl_prefix']."information WHERE id = '1'");
	echo mysql_result($sql,0);
	
	?></td>
    <td><?php
    $sql = mysql_query("SELECT newest_player from ".$config['tbl_prefix']."information WHERE id = '1'");
	echo mysql_result($sql,0);?></td>
  </tr>
  <tr>
  <th colspan=2>
  Online Players (<?php
  $x = mysql_query("SELECT online_players from ".$config['tbl_prefix']."information WHERE id = '1'");

  $y = mysql_query("SELECT max_players from ".$config['tbl_prefix']."information WHERE id = '1'");

	echo mysql_result($x,0)."/".mysql_result($y,0);
  ?>)
  </th>
  </tr>
  <tr>
  <td colspan=2><?php


$z = mysql_result($x,0)/mysql_result($y,0);

$a = $z*100;

echo "<div class='progress progress-striped active'>

  <div class='bar' style='width: ".$a."%;'></div>
</div>";?></td>
  </tr>
</table>

            </div>
          </div>
      
      
      
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
      
          <div class="corgi_feed_well">
            <div class="sidebar_header">
              <div class="sidebar_title">
                <h4>Search</h4>
              </div>
            </div>
            <hr class="feed_hr" />
            <div class="sidebar_interior">
              <form name="form1" method="post" action="scripts/search.php">
                <table width="100%" border="0" cellspacing="5" cellpadding="5" class="table table-bordered table-striped">
                  <tr>
                    <th>Search</th>
                    </tr>
                  <tr>
                    <td>
                    
                    <div class="input-append">
  <input class="span3" id="appendedInputButton" type="text" placeholder="username..." name="username" id="username">
  <button class="btn btn-inverse" type="submit">Search...</button>
</div>
                    
                    </td>
                    </tr>
                </table>
              </form>
            </div>
          </div>



      </div>
    </div>
  </div>
</div>


 

        </div>
      </div>
      <div class="row">
        <div class="span12">
          <div class="corgi_feed_well">
            <div class="sidebar_header">
              <div class="sidebar_title">
                <h4>Player Information</h4>
              </div>
            </div>
            <hr class="title_hr" />
            <div class="well_padding">
            <font size="2">
              <table width="100%" border="0" cellspacing="5" cellpadding="5" class="table table-striped table-bordered">
  <tr>
    <th>Username</th>
    <th>First Seen</th>
    <th>Last Seen</th>
    <th>Time Played</th>
    <th>Health</th>
    <th>Hunger</th>
    <th>Location</th>
    <th>Item In Hand</th>
    <th>IP Address</th>
    <th>Player #</th>
  </tr>
      <?php			
			
			
			
			$result = mysql_query($statement);

			if (!$result) {
  			  echo "Could not successfully run query ($statement) from DB: " . mysql_error();
  			  exit;
			}
            
            while ($row = mysql_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['date_joined']." at ".$row['time_joined']."</td>";
				echo "<td>".$row['last_seen_date']." at ".$row['last_seen_time']."</td>";
				echo "<td>".$row['played_days']."d ".$row['played_hours']."h ".$row['played_minutes']."m ".$row['played_seconds']."s</td>";
				echo "<td>".$row['health']."</td>";
                echo "<td>".$row['hunger']."</td>";
                echo "<td>X: ".$row['location_x'].", Y: ".$row['location_y'].", Z: ".$row['location_z']."</td>";
                echo "<td>".$row['item_in_hand']."</td>";
                echo "<td>".$row['ip_address']."</td>";
                echo "<td>".$row['player_number']."</td>";
                echo "</tr>";
				
			}
  
  ?>
              </table></font>
              
              <?php
			  
			  if(isset($_GET['username'])){
				echo pagination($config['tbl_prefix']."players WHERE username LIKE '%".$_GET['username']."%'",$limit,$page,"?username=".$_GET['username']."&");
			  }else{
				echo pagination($config['tbl_prefix']."players",$limit,$page,"?");  
			  }
			  
			  
			  ?>
              <p>&nbsp;</p>
</div>
          </div>
        </div>
      </div>
    </div>
    <br/><br/>
    <div class="corgi_footer">
      <div class="container">
        <div class="row">
          <div class="span12">
            <ul>
              <li><a href="http://dev.bukkit.org/server-mods/joinmessages">BukkitDev Page</a></li>
              <li>LegendaryMessages-UI v2.0</li>
            </ul>
            <div class="corgi_copyright">Created By IcyRelic</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Le javascript
    ================================================== -->
   <script src="js/bootstrap.js"></script>
  </body>
</html>
