<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monitus Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Oleo+Script:400,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="Favicon.ico">
	<link rel="icon" type="image/vnd.microsoft.icon" href="Favicon.ico">

  </head>

  <body>

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
          <a class="navbar-brand logofont" href="index.php"><img src="monitus.png" width="28px" border="0"> Monitus Dashboard</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
            <li class="active"><a href="assets.php"><img src="images/computer.png"> Assets</a></li>
            <li><a href="alertlog.php"><img src="images/book_open.png"> Alert Log</a></li>
            <li><a href="settings.php"><img src="images/cog.png"> Settings</a></li>
           </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/bell.png"> Alerts <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php
					$file="log.csv";
					readlog("$file");
				?>
				</ul>
            </li>
			<li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/brick.png"> Tasks <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="add-device.php"><img src="images/computer_add.png"> Add Asset</a></li>
                <li><a href="remove-log.php"><img src="images/page_white_delete.png"> Clear Alert Log</a></li>
				<li class="divider"></li>
                <!--<li><a href="#"><i class="icon-power-off"></i> Log Out</a></li>-->
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">

        <div class="row">
			<div class="col-lg-12">
            <h1><small>Assets Page</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
              <li class="active"><img src="images/computer.png"> Assets</li>
            </ol>
			<a href="add-device.php" class="btn btn-primary"><img src="images/add.png"> Asset</a>&nbsp;
			</div>
			</br>
			<div class="col-lg-6">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped table-condensed">
						<thead>
							<tr>
								<th class="header"></th>
								<th class="header">Server Name </th>
								<th class="header">IP Address </th>
								<th class="header">Port </th>
								<th class="header">Alerts </th>
								<th class="header"></th>
							</tr>
						</thead>
						<tbody>
                	<?php
					$file="servers.csv";
					$c = 0;
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
					?>
						<tr>
							<td><?php echo $c; ?></td>
							<td><?php echo $line[0]; ?></td>
							<td><?php echo $line[1]; ?></td>
							<td><?php echo $line[2]; ?></td>
							<td><?php if ($line[3] != "Quiet") { echo $line[3]; } else { ?><span class="label label-danger"><?php echo $line[3]; ?></span><?php } ?></td>
							<td><a href="remove-device.php?t=servers&s=<?php echo $line[0];?>" title="Remove <?php echo $line[0];?>"><img src="images/computer_delete.png"></a> | <a href="edit-device.php?t=servers&n=<?php echo $line[0]; ?>&i=<?php echo $line[1]; ?>&p=<?php echo $line[2]; ?>&a=<?php echo $line[3]; ?>" title="Edit <?php echo $line[0]; ?>"><img src="images/computer_edit.png"></a></td>
						</tr>
					<?php
					$c++;
					}
					}		
					fclose($handle);
					?>
						</tbody>
				</table>
				</div>
			</div>
			
			<div class="col-lg-6">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped table-condensed">
						<thead>
							<tr>
								<th class="header"></th>
								<th class="header">Website Name </th>
								<th class="header">IP Address </th>
								<th class="header">Port </th>
								<th class="header">Alerts </th>
								<th class="header"></th>
							</tr>
						</thead>
						<tbody>
                	<?php
					$file="websites.csv";
					$c = 0;
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
					?>
						<tr>
							<td><?php echo $c; ?></td>
							<td><?php echo $line[0]; ?></td>
							<td><?php echo $line[1]; ?></td>
							<td><?php echo $line[2]; ?></td>
							<td><?php if ($line[3] != "Quiet") { echo $line[3]; } else { ?><span class="label label-danger"><?php echo $line[3]; ?></span><?php } ?></td>
							<td><a href="remove-device.php?t=websites&s=<?php echo $line[0];?>" title="Remove <?php echo $line[0];?>"><img src="images/world_delete.png"></a> | <a href="edit-device.php?t=websites&n=<?php echo $line[0]; ?>&i=<?php echo $line[1]; ?>&p=<?php echo $line[2]; ?>&a=<?php echo $line[3]; ?>" title="Edit <?php echo $line[0]; ?>"><img src="images/world_edit.png"></a></td>
						</tr>
					<?php
					$c++;
					}
					}		
					fclose($handle);
					?>
						</tbody>
				</table>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped table-condensed">
						<thead>
							<tr>
								<th class="header"></th>
								<th class="header">Storage Name </th>
								<th class="header">IP Address </th>
								<th class="header">Port </th>
								<th class="header">Alerts </th>
								<th class="header"></th>
							</tr>
						</thead>
						<tbody>
                	<?php
					$file="storage.csv";
					$c = 0;
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
					?>
						<tr>
							<td><?php echo $c; ?></td>
							<td><?php echo $line[0]; ?></td>
							<td><?php echo $line[1]; ?></td>
							<td><?php echo $line[2]; ?></td>
							<td><?php if ($line[3] != "Quiet") { echo $line[3]; } else { ?><span class="label label-danger"><?php echo $line[3]; ?></span><?php } ?></td>
							<td><a href="remove-device.php?t=storage&s=<?php echo $line[0];?>" title="Remove <?php echo $line[0];?>"><img src="images/drive_delete.png"></a> | <a href="edit-device.php?t=storage&n=<?php echo $line[0]; ?>&i=<?php echo $line[1]; ?>&p=<?php echo $line[2]; ?>&a=<?php echo $line[3]; ?>" title="Edit <?php echo $line[0]; ?>"><img src="images/drive_edit.png"></a></td>
						</tr>
					<?php
					$c++;
					}
					}		
					fclose($handle);
					?>
						</tbody>
				</table>
				</div>
			</div>

			
			
			</div>
			
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
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
	<?php
	if ($linecount > $offset) {
		while($c<=($offset-1)){
			$line = fgetcsv($handle, 0, ",");
			if ($line[0] != "") {
			?>	
			<li class="message-preview">
                  <a href="#">
                    <span class="name"><img src="images/error.png"><font color="red"> <?php echo $line[1]; ?></font></span>
                    <span class="message"><?php echo $line[2]; ?></span>
                    <span class="time"><img src="images/clock.png"><small> <?php echo $line[0]; ?> </small></span>
                  </a>
                </li>
            <li class="divider"></li>
			<?php		
			$c++;
			}
		}
		?>
		<li class="panel-title"><a href="#"><img src="images/new.png"> <small>Alerts</small> <span class="badge"><?php echo $c; ?></span> of <span class="badge"><?php echo $linecount; ?></span></a></li>
		<?php
	} else {
		while(!feof($handle)){
			$line = fgetcsv($handle, 0, ",");
			if ($line[0] != "") {
			?>	
			<li class="message-preview">
                  <a href="#">
                    <span class="name"><img src="images/error.png"><font color="red"> <?php echo $line[1]; ?></font></span>
                    <span class="message"><?php echo $line[2]; ?></span>
                    <span class="time"><img src="images/clock.png"><small> <?php echo $line[0]; ?> </small></span>
                  </a>
                </li>
            <li class="divider"></li>
			<?php		
			$c++;
			}
		}
		?>
		<li class="panel-title"><a href="#"><img src="images/new.png"> <small>Alerts</small> <span class="badge"><?php echo $c; ?></span> of <span class="badge"><?php echo $linecount; ?></span></a></li>
		<?php

	}
	fclose($handle);
}

?>
 </body>
</html>