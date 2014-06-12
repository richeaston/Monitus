<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Richard Easton 2014">
	<meta http-equiv="refresh" content="120">

    <title>Monitus Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="Favicon.ico">
	<link rel="icon" type="image/vnd.microsoft.icon" href="Favicon.ico">

    <!-- Add custom CSS here -->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  </head>

  <body>
<?php 
	$servers = "servers.csv";
	$websites = "websites.csv";
	$storage = "storage.csv";
	if (file_exists($servers)) {
	} else {
	file_put_contents($servers, "google.co.uk,google.co.uk,80,Normal\n");
	}
	if (file_exists($websites)) {
	} else {
	file_put_contents($websites, "SelloString.co.uk,SelloString.co.uk,80,Normal\n");
	}
	if (file_exists($storage)) {
	} else {
	file_put_contents($storage, "Sellostring.com,Sellostring.com,80,Normal\n");
	}
?>
  
<?php 
	$file = "log.csv";
	if (file_exists($file)) {
	$lines = count(file($file));
		if ($lines > 50){
		$fh = fopen($file, 'w');
		fclose($fh);
		}
	} else {
	$date = date('d-m-Y H:i:s');
	file_put_contents($file, $date . ",information.png,Alert Log Created,Alert Log not found! Created one.\n");
	}
?>


    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top shadow" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand logofont" href="index.php"><img src="monitus.png" width="28px" border="0"> Monitus Dashboard</a>
		  
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav nav-shadow">
            <li class="active"><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
            <li><a href="assets.php"><img src="images/computer.png"> Assets</a></li>
            <li><a href="alertlog.php"><img src="images/book_open.png"> Alert Log</a></li>
            <li><a href="settings.php"><img src="images/cog.png"> Settings</a></li>
		 </ul>
		 
          <ul class="nav navbar-nav navbar-right navbar-user">
           <li><a href="#"><img src="images/clock.png"> Refresh in: <span id="countdown"></span></a></li>
		   <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/brick.png"> Menu <b class="caret"></b></a>
              <ul class="dropdown-menu">
                 <li><a href="assets.php"><img src="images/computer.png"> Assets</a></li>
                 <li><a href="alertlog.php"><img src="images/book_open.png"> Alert Log</a></li>
            	 <li><a href="settings.php"><img src="images/cog.png"> Settings</a></li>
              </ul>
            </li>
          </ul>

		</div><!-- /.navbar-collapse -->
     </nav>

      <div id="page-wrapper">
		<div class="row row-valign">
			<div class="col-lg-4">
			<div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Servers</h3>
              </div>
              <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th class="header">Server Name </th>
							<th class="header">Status </th>
						</tr>	
					</thead>
					<tbody>
						<?php
					$file="servers.csv";
					$sonline = 0;
					$soffline = 0;
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
						$result = getStatus("$line[1]", "$line[2]");
						if ($result != "online") {
					?>	
						<tr>
							<td><strong><img src="images/server.png"> <a href="#" title="<?php echo $line[1]; ?>"><?php echo $line[0];?></a></strong></td>
							<?php
							if ($line[3] != "Quiet") {
							?>
							<td><span class="label label-danger"><img src="images/bullet_error.png"> <?php echo $result; ?></span>
							<?php
							} else {
							?>
							<td><span class="label label-danger"><img src="images/bullet_error.png"> <?php echo $result; ?> </span> <img src="images/sound_mute.png">
							<?php
							}
							?>
							</td>
						</tr>
					<?php
					if ($line[3] != "Quiet") {
						writelog("$line[0]");
					}
					$soffline++;
					} else {
					?>
						<tr>
							<td><strong><img src="images/server.png"> <a href="#" title="<?php echo $line[1]; ?>"> <?php echo $line[0]; ?></a></strong></td>
							<td><span class="label label-success"><img src="images/accept.png"> <?php echo $result; ?></span></td>
						</tr>
					<?php
					$sonline++;
					}
					}		
					}
					$total = ($sonline + $soffline);
					$smeh = round(($soffline / ($sonline+$soffline) * 100) , 0);
					$p = (100 - $smeh);
					?>
						<tr><td colspan="2"><h4>Servers Online: <span class="label label-default"><?php echo $sonline; ?></span> of <span class="label label-default"><?php echo $total; ?></span></h4></td></tr>
					<?php
					
					fclose($handle);
					?>
					</tbody> 
					</table>
				</div>
              </div>
            </div>
			
			</div>
			<div class="col-lg-4">
			<div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Websites</h3>
              </div>
              <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th class="header">Website Name </th>
							<th class="header">Status </th>
						</tr>	
					</thead>
					<tbody>
						<?php
					$file="websites.csv";
					$wonline = 0;
					$woffline = 0;
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
						$result = getStatus("$line[1]", "$line[2]");
						if ($result != "online") {
					?>	
						<tr>
							<td><strong><img src="images/world.png"> <a href="#" title="<?php echo $line[1]; ?>"><?php echo $line[0];?></a></strong></td>
							<?php
							if ($line[3] != "Quiet") {
							?>
							<td><span class="label label-danger"><img src="images/bullet_error.png"> <?php echo $result; ?></span>
							<?php
							} else {
							?>
							<td><span class="label label-danger"><img src="images/bullet_error.png"> <?php echo $result; ?> </span> <img src="images/sound_mute.png">
							<?php
							}
							?>
							</td>
						</tr>
					<?php
					if ($line[3] != "Quiet") {
						writelog("$line[0]");
					}
					$woffline++;
					} else {
					?>
						<tr>
							<td><strong><img src="images/world.png"> <a href="http://<?php echo $line[1]; ?>:<?php echo $line[2]; ?>" target="_blank" title="<?php echo $line[1]; ?>"><?php echo $line[0]; ?></a></strong></td>
							<td><span class="label label-success"><img src="images/accept.png"> <?php echo $result; ?></span></td>
						</tr>
					<?php
					$wonline++;
					}
					}		
					}
					$wmeh = round(($woffline / ($wonline+$woffline) * 100 ) , 0);
					$w = (100 - $wmeh);
					
					fclose($handle);
					?>
					</tbody> 
					</table>
				</div>
              </div>
			</div>
			
			<div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Storage</h3>
              </div>
              <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th class="header">Storage Name </th>
							<th class="header">Status </th>
						</tr>	
					</thead>
					<tbody>
						<?php
					$file="storage.csv";
					$qonline = 0;
					$qoffline = 0;
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
						$result = getStatus("$line[1]", "$line[2]");
						if ($result != "online") {
					?>	
						<tr>
							<td><strong><img src="images/drive.png"> <a href="#" title="<?php echo $line[1]; ?>"><?php echo $line[0];?></a></strong></td>
							<?php
							if ($line[3] != "Quiet") {
							?>
							<td><span class="label label-danger"><img src="images/bullet_error.png"> <?php echo $result; ?></span>
							<?php
							} else {
							?>
							<td><span class="label label-danger"><img src="images/bullet_error.png"> <?php echo $result; ?> </span> <img src="images/sound_mute.png">
							<?php
							}
							?>
							</td>
						</tr>
					<?php
					if ($line[3] != "Quiet") {
						writelog("$line[0]");
					}
					$qoffline++;
					} else {
					?>
						<tr>
							<td><strong><img src="images/drive.png"> <a href="http://<?php echo $line[1]; ?>:<?php echo $line[2]; ?>" target="_blank" title="<?php echo $line[1]; ?>"><?php echo $line[0]; ?></a></strong></td>
							<td><span class="label label-success"><img src="images/accept.png"> <?php echo $result; ?></span></td>
						</tr>
					<?php
					$qonline++;
					}
					}		
					}
					$qmeh = round(($qoffline / ($qonline+$qoffline) * 100) , 0);
					$q = (100 - $qmeh);
					
					fclose($handle);
					?>
					</tbody> 
					</table>
				</div>
              </div>
			</div>
		</div>
		
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Service Status</h3>
				</div>
				<div class="panel-body">
						<div class="progress progress-striped active">
						<?php if ($p > 99) { ?>	
							<div class="progress-bar progress-bar-success" style="width: <?php echo $p;?>%"><img src="images/emoticon_happy.png"><strong>Servers <?php echo $p;?>%</strong></div>
						<?php } elseif ($p >= 80) { ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $p;?>%"><img src="images/emoticon_unhappy.png"><strong>Servers <?php echo $p;?>%</strong></div>
						<?php } else { ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $p;?>%"><img src="images/bullet_error.png"><strong>Servers <?php echo $p;?>%</strong></div>
						<?php } ?>
						</div>
						<div class="progress progress-striped active">
						<?php if ($w > 99) { ?>	
							<div class="progress-bar progress-bar-success" style="width: <?php echo $w;?>%"><img src="images/emoticon_happy.png"><strong>Websites <?php echo $w;?>%</strong></div>
						<?php } elseif ($w >= 80) { ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $w;?>%"><img src="images/emoticon_unhappy.png"><strong>Websites <?php echo $w;?>%</strong></div>
						<?php } else { ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $w;?>%"><img src="images/bullet_error.png"><strong>Websites <?php echo $w;?>%</strong></div>
						<?php } ?>
						</div>
						<div class="progress progress-striped active">
						<?php if ($q > 99) { ?>	
							<div class="progress-bar progress-bar-success" style="width: <?php echo $q;?>%"><img src="images/emoticon_happy.png"><strong>Storage <?php echo $q;?>%</strong></div>
						<?php } elseif ($q >= 80) { ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $q;?>%"><img src="images/emoticon_unhappy.png"><strong>Storage <?php echo $q;?>%</strong></div>
						<?php } else { ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $q;?>%"><img src="images/bullet_error.png"><strong>Storage <?php echo $q;?>%</strong></div>
						<?php } ?>
						</div>
				</div>
			</div>
			
			<div class="panel panel-danger">
              <div class="panel-heading">
                <h3 class="panel-title"><img src="images/new.png"> <small>Alerts</small></h3>
              </div>
                <?php
				$file="log.csv";
				readlog("$file");
				?>
              </div>
       		<FORM><INPUT class="btn btn-warning" TYPE="button" onClick="history.go(0)" VALUE="Force Refresh"></FORM>

			</div>
			
			
			
			
		</div>
		
      </div><!-- /#page-wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
	
<?php 

function writelog($name) {
		$logfile = "log.csv";
		$date = date('d-m-Y H:i:s');
		$content = file_get_contents($logfile);
		file_put_contents($logfile, $date  . ",error.png," . $name . ",Failed to respond to a ping request.\n" . $content, LOCK_EX);
	}	
?>		

<?php 

function readlog($file) {
	#count lines in log file
	$offset = 5;
	$handle = fopen($file, "r");
	$linecount = 0;
	while(!feof($handle)){
		$line = fgets($handle, 4096);
		$linecount++;
	}
	fclose($handle);
	
	
	#read log file and create webpage entries.
	$handle = fopen($file, "r");
	$c = 0;
	?>
	<div class="panel-body">
    <?php
	if ($linecount > $offset) {
		while($c<=($offset-1)){
			$line = fgetcsv($handle, 0, ",");
			if ($line[0] != "") {
			?>	
			<a href="#" class="list-group-item">
				<h4 class="list-group-item-heading"><img src="images/<?php echo $line[1]; ?>"><font color="red"> <?php echo $line[2]; ?></font></h4>
				<p class="list-group-item-text"><?php echo $line[3]; ?><br/><img src="images/clock.png"><small> <?php echo $line[0]; ?></small></p>
			</a>
			<?php		
			$c++;
			}
		}
		?>
		</div>
		<?php
		echo '<div class="panel-footer">Showing ' . $offset . ' of ' . $linecount . ' Total Alerts</div>';
	} else {
		while(!feof($handle)){
			$line = fgetcsv($handle, 0, ",");
			if ($line[0] != "") {
			?>	
			<a href="#" class="list-group-item">
				<h4 class="list-group-item-heading"><img src="images/<?php echo $line[1]; ?>"><font color="red"> <?php echo $line[2]; ?></font></h4>
				<p class="list-group-item-text"><?php echo $line[3]; ?><br/><img src="images/clock.png"><small> <?php echo $line[0]; ?></small></p>
			</a>
			<?php		
			$c++;
			}
		}
		?>
		</div>
		<?php
		echo '<div class="panel-footer">Showing ' . ($c) . ' of ' . $linecount . ' Total Alerts <a href="alertlog.php" class="pull-right btn btn-primary btn-xs"><img src="images/page_find.png"> See More</a></div>';

	}
	fclose($handle);
}

?>

<?php
 
function getStatus($ip,$port){
   $socket = @fsockopen($ip, $port, $errorNo, $errorStr, 2);
   if(!$socket) return "offline";
     else return "online";
}
 
?>			
<script>
var seconds = 119;
function secondPassed() {
    var minutes = Math.round((seconds - 30)/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;  
    }
    document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "<img src='images/arrow_refresh.png'>";
    } else {
        seconds--;
    }
}
 
var countdownTimer = setInterval('secondPassed()', 1000);
</script>

	</body>
	
</html>