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
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="Favicon.ico">
	<link rel="icon" type="image/vnd.microsoft.icon" href="Favicon.ico">

  </head>

  <body>

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
          <ul class="nav navbar-nav side-nav shadow">
            <li><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
            <li><a href="assets.php"><img src="images/Computer.png"> Assets</a></li>
            <li><a href="alertlog.php"><img src="images/book_open.png"> Alert Log</a></li>
            <li class="active"><a href="Wakeonlan.php"><img src="images/bell.png"> Wake On Lan</a></li>
		    <li ><a href="settings.php"><img src="images/cog.png"> Settings</a></li>
           </ul>
		</div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">
		<form method="post" action="write-settings.php">
        <div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
					<li class="active"><img src="images/bell.png">  Wake On Lan</li>
				</ol>
			</div>
			<div class="col-lg-4">		
					<div class="panel panel-default ">
						<div class="panel-heading">
							<h3 class="panel-title">Target</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label>Target Name</label>
								<input class="form-control" id="tname" name="tname" placeholder="120" value="NONE">
								<p class="help-block">Targets Name</p>
							</div>
							<div class="form-group">
								<label>Target IP</label>
								<input class="form-control" id="tip" name="tip" placeholder="" value="192.168.0.1">
								<p class="help-block">IP Address</p>
							</div>
							<div class="form-group">
								<label>Target IP</label>
								<input class="form-control" id="tmac" name="tmac" placeholder="00-00-00-00-00-00" value="00-00-00-00-00-00">
								<p class="help-block">MAC Address</p>
							</div>
							<a href="
						</div>
					</div>
			</div>		
			<div class="col-lg-4">		
			</div>
		  	</form>
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
                    <span class="name"><img src="images/<?php echo $line[1]; ?>"><font color="red"> <?php echo $line[2]; ?></font></span>
                    <span class="message"><?php echo $line[3]; ?></span>
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
                    <span class="name"><img src="images/<?php echo $line[1]; ?>"><font color="red"> <?php echo $line[2]; ?></font></span>
                    <span class="message"><?php echo $line[3]; ?></span>
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
<?php include 'footer.php'; ?>
