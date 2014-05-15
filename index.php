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
	file_put_contents($websites, "google.co.uk,google.co.uk,80,Normal\n");
	}
	if (file_exists($storage)) {
	} else {
	file_put_contents($storage, "google.co.uk,google.co.uk,80,Normal\n");
	}
?>
  
<?php 
	$file = "log.csv";
	if (file_exists($file)) {
	$lines = count(file($file));
		if ($lines > 5){
		$fh = fopen($file, 'w');
		fclose($fh);
		}
	} else {
	$date = date('d-m-Y H:i:s');
	file_put_contents($file, $date . ",Log File Created,New error log created.\n");
	}
?>
    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="dashboard.php"><img src="monitus.png" width="28px" border="0"> Monitus Dashboard</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li class="active"><a href="index.php"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li><a href="settings.php"><i class="icon-gear"></i> Settings</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
             <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tasks"></i> Menu <b class="caret"></b></a>
              <ul class="dropdown-menu">
                 <li><a href="settings.php"><i class="icon-gear"></i> Settings</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">
		</br>
        <div class="row row-valign">
			<div class="col-lg-4">
			<div class="panel panel-primary">
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
							<td><strong><i class="icon-desktop"></i> <a href="#" title="<?php echo $line[1]; ?>"><?php echo $line[0];?></a></strong></td>
							<?php
							if ($line[3] != "Quiet") {
							?>
							<td><span class="label label-danger"><i class="icon-warning-sign"></i> <?php echo $result; ?></span>
							<?php
							} else {
							?>
							<td><span class="label label-danger"><i class="icon-warning-sign"></i> <?php echo $result; ?> <i class="icon-microphone-off"></i></span>
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
							<td><strong><i class="icon-desktop"></i> <a href="#" title="<?php echo $line[1]; ?>"> <?php echo $line[0]; ?></a></strong></td>
							<td><span class="label label-success"><i class="icon-ok"> <?php echo $result; ?></span></td>
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
						<tr><td colspan="2"><h4>Servers Online: <span class="label label-primary"><?php echo $sonline; ?></span> of <span class="label label-primary"><?php echo $total; ?></span></h4></td></tr>
					<?php
					
					fclose($handle);
					?>
					</tbody> 
					</table>
				</div>
              </div>
            </div>
			
			</div>
			<div class="col-lg-5">
			<div class="panel panel-primary">
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
							<td><strong><i class="icon-globe"></i> <a href="http://<?php echo $line[1]; ?>:<?php echo $line[2]; ?>" target="_blank" title="<?php echo $line[1]; ?>"><?php echo $line[0]; ?></a></strong></td>
							<?php
							if ($line[3] != "Quiet") {
							?>
							<td><span class="label label-danger"><i class="icon-warning-sign"></i> <?php echo $result; ?></span>
							<?php
							} else {
							?>
							<td><span class="label label-danger"><i class="icon-warning-sign"></i> <?php echo $result; ?> <i class="icon-microphone-off"></i></span>
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
							<td><strong><i class="icon-globe"></i> <a href="http://<?php echo $line[1]; ?>:<?php echo $line[2]; ?>" target="_blank" title="<?php echo $line[1]; ?>"><?php echo $line[0]; ?></a></strong></td>
							<td><span class="label label-success"><i class="icon-ok"> <?php echo $result; ?></span></td>
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
			
			<div class="panel panel-primary">
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
							<td><strong><i class="icon-hdd"></i> <a href="http://<?php echo $line[1]; ?>:<?php echo $line[2]; ?>"  target="_blank" title="<?php echo $line[1]; ?>"><?php echo $line[0]; ?></a></strong></td>
							<?php
							if ($line[3] != "Quiet") {
							?>
							<td><span class="label label-danger"><i class="icon-warning-sign"></i> <?php echo $result; ?></span>
							<?php
							} else {
							?>
							<td><span class="label label-danger"><i class="icon-warning-sign"></i> <?php echo $result; ?> <i class="icon-microphone-off"></i></span>
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
							<td><strong><i class="icon-hdd"></i> <a href="http://<?php echo $line[1]; ?>:<?php echo $line[2]; ?>" target="_blank" title="<?php echo $line[1]; ?>"><?php echo $line[0]; ?></a></strong></td>
							<td><span class="label label-success"><i class="icon-ok"> <?php echo $result; ?></span></td>
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
		
		<div class="col-lg-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Service Status</h3>
				</div>
				<div class="panel-body">
						<div class="progress progress-striped active">
						<?php if ($p > 99) { ?>	
							<div class="progress-bar progress-bar-success" style="width: <?php echo $p;?>%"><strong>Servers <?php echo $p;?>%</strong></div>
						<?php } elseif ($p >= 90) { ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $p;?>%"><strong>Servers <?php echo $p;?>%</strong></div>
						<?php } else { ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $p;?>%"><strong>Servers <?php echo $p;?>%</strong></div>
						<?php } ?>
						</div>
						<div class="progress progress-striped active">
						<?php if ($w > 99) { ?>	
							<div class="progress-bar progress-bar-success" style="width: <?php echo $w;?>%"><strong>Websites <?php echo $w;?>%</strong></div>
						<?php } elseif ($w >= 90) { ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $w;?>%"><strong>Websites <?php echo $w;?>%</strong></div>
						<?php } else { ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $w;?>%"><strong>Websites <?php echo $w;?>%</strong></div>
						<?php } ?>
						</div>
						<div class="progress progress-striped active">
						<?php if ($q > 99) { ?>	
							<div class="progress-bar progress-bar-success" style="width: <?php echo $q;?>%"><strong>Storage <?php echo $q;?>%</strong></div>
						<?php } elseif ($q >= 90) { ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $q;?>%"><strong>Storage <?php echo $q;?>%</strong></div>
						<?php } else { ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $q;?>%"><strong>Storage <?php echo $q;?>%</strong></div>
						<?php } ?>
						</div>
				</div>
			</div>
			
			<div class="list-group">
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading"><U><B>Most Recent Alert!</b></u></h4>
                	<div class="list-group">
					<?php
					$file="log.csv";
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
					?>	
					<a href="#" class="list-group-item">
						<h4 class="list-group-item-heading"><i class="icon-warning-sign"></i> <?php echo $line[1]; ?></h4>
						<p class="list-group-item-text"><?php echo $line[2]; ?><br/><i class="icon-time"></i> <?php echo $line[0]; ?></p>
					</a>
					
					<?php
					}
					}
					fclose($handle);
					?>
					</div>
					
                </a>
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
		file_put_contents($logfile, $date . "," . $name . ",Failed to respond to a ping request.\n", FILE_APPEND | LOCK_EX);
	}	
?>		




<?php
 
function getStatus($ip,$port){
   $socket = @fsockopen($ip, $port, $errorNo, $errorStr, 2);
   if(!$socket) return "offline";
     else return "online";
}
 
?>			
	
	</body>
</html>