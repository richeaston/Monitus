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
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
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
          <a class="navbar-brand" href="dashboard.php"><img src="monitus.png" width="28px" border="0"> Monitus Dashboard</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="index.php"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="settings.php"><i class="icon-gear"></i> Settings</a></li>
           </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-bell-alt"></i> Alerts <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php
					$alertcount = 0;
					$file="log.csv";
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "") {
					?>	
				<li class="message-preview">
                  <a href="#">
                    <span class="name"><i class="icon-warning-sign"></i> <?php echo $line[1]; ?></span>
                    <span class="message"><?php echo $line[2]; ?></span>
                    <span class="time"><i class="icon-time"></i> <?php echo $line[0]; ?></span>
                  </a>
                </li>
                <li class="divider"></li>
                <?php
					$alertcount++;
					}
					}
					fclose($handle);
				?>
				<li class="panel-title"><a href="#">New Alerts <span class="badge badge-important"><?php echo $alertcount; ?></span></a></li>
              </ul>
            </li>
			<li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tasks"></i> Tasks <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="add-device.php"><i class="icon-desktop"></i> Add Device</a></li>
                <li><a href="remove-log.php"><i class="icon-trash"></i> Delete Error Log</a></li>
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
            <h1><small>Settings Page</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="icon-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="icon-cog"></i> Settings</li>
            </ol>
			<a href="add-device.php" class="btn btn-primary"><i class="icon-plus"></i> Add new device</a>&nbsp;
			<a href="remove-log.php" class="btn btn-danger"><i class="icon-trash"></i> Clear Alert Log</a>
			</div>
			</br>
			<div class="col-lg-6">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped table-condensed">
						<thead>
							<tr>
								<th class="header"></th>
								<th class="header"><i class="icon-desktop"></i> Server Name </th>
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
							<td><?php if ($line[3] != "Quiet") { echo $line[3]; } else { ?><span class="label label-danger"><i class="icon-microphone-off"></i> <?php echo $line[3]; ?></span><?php } ?></td>
							<td><a href="remove-server.php?s=<?php echo $line[0];?>" title="Remove <?php echo $line[0];?>"><i class="icon-trash"></i></a> | <?php if ($line[3] != "Quiet") { ?><a href="#" title="Mute Alerts"><i class="icon-microphone-off"></i></a><?php } else { ?><a href="#" title="Enable Alerts"><i class="icon-microphone"></i></a><?php } ?></td>
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
								<th class="header"><i class="icon-desktop"></i> Website Name </th>
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
							<td><?php if ($line[3] != "Quiet") { echo $line[3]; } else { ?><span class="label label-danger"><i class="icon-microphone-off"></i> <?php echo $line[3]; ?></span><?php } ?></td>
							<td><a href="remove-website.php?s=<?php echo $line[0];?>" title="Remove <?php echo $line[0];?>"><i class="icon-trash"></i></a> | <?php if ($line[3] != "Quiet") { ?><a href="#" title="Mute Alerts"><i class="icon-microphone-off"></i></a><?php } else { ?><a href="#" title="Enable Alerts"><i class="icon-microphone"></i></a><?php } ?></td>
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
								<th class="header"><i class="icon-desktop"></i> Storage Name </th>
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
							<td><?php if ($line[3] != "Quiet") { echo $line[3]; } else { ?><span class="label label-danger"><i class="icon-microphone-off"></i> <?php echo $line[3]; ?></span><?php } ?></td>
							<td><a href="remove-storage.php?s=<?php echo $line[0];?>" title="Remove <?php echo $line[0];?>"><i class="icon-trash"></i></a> | <?php if ($line[3] != "Quiet") { ?><a href="#" title="Mute Alerts"><i class="icon-microphone-off"></i></a><?php } else { ?><a href="#" title="Enable Alerts"><i class="icon-microphone"></i></a><?php } ?></td>
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
  </body>
</html>