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
  </head>

  <body>
<?php
$type = $_GET['t'];
$name = $_GET['n'];
$ipaddress = $_GET['i'];
$port = $_GET['p'];
$alert = $_GET['a'];
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
          <a class="navbar-brand" href="index.php"><img src="monitus.png" width="28px" border="0"> Monitus Dashboard</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
            <li class="active"><a href="assets.php"><img src="images/Computer.png"> Assets</a></li>
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
            <h1><small>Edit Asset</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><img src="images/monitor.png"> Dashboard</a></li>
			  <li><a href="assets.php"><img src="images/computer.png"> Assets</a></li>
			  <li class="active"><img src="images/computer_edit.png"> Edit Asset</li>
            </ol>
          </div>
        <!-- end of breadcrumbs -->
		
		<form class="" action="write-edit.php" method="post">
			<div class="col-lg-4">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="icon-pencil"></i> Edit Asset Details</h3>
              </div>
              <div class="panel-body">
              <div class="form-group input-group">
                <span class="input-group-addon"><img src="images/wand.png"> Asset Type</span>
                <select type="text" class="form-control" id="type" name="type" placeholder="Type">
                  <option><?php echo $type; ?></option>
                  <option>servers</option>
                  <option>websites</option>
                  <option>storage</option>
                </select>
              </div><div class="form-group input-group">
                <span class="input-group-addon"><img src="images/computer.png">  Name</span>
                <input type="text" class="form-control" id="servername" name="servername" placeholder="Name" value="<?php echo $name; ?>">
              </div>
			  <div class="form-group input-group">
                <span class="input-group-addon"><i class="icon-sitemap"></i> Address</span>
                <input type="text" class="form-control" id="ipaddress" name="ipaddress" placeholder="Address" value="<?php echo $ipaddress; ?>">
              </div>
			  <div class="form-group input-group">
                <span class="input-group-addon"><img src="images/lightning.png">  Port</span>
                <select type="text" class="form-control" id="port" name="port" placeholder="Port">
                  <option><?php echo $port; ?></option>
                  <option>139</option>
                  <option>1080</option>
                  <option>21</option>
                  <option>22</option>
                  <option>3389</option>
                  <option>80</option>
                  <option>8080</option>
                </select>
              </div>
			  <div class="form-group input-group">
                <span class="input-group-addon"><img src="images/bell.png">  Alerts</span>
                <select type="text" class="form-control" id="alerts" name="alerts" placeholder="Alerts">
                <?php 
				if ($alert != "Quiet") {
				?>
				  <option>Normal</option>
                  <option>Quiet</option>
                <?php } else { ?>
				  <option>Quiet</option>
                  <option>Normal</option>
                <?php }	?>
				</select>
              </div>
			  
			  <button type="submit" class="btn btn-primary">Update Details</button>
			  <button type="cancel" class="btn btn-default">cancel</button>
			  </div>
            </div>
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