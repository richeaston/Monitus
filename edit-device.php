<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Services Dashboard</title>

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
            <li><a href="index.php"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="settings.php"><i class="icon-gear"></i> Settings</a></li>
           </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-bell-alt"></i> Alerts <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php
					$alertcount = 0;
					$file="./log.csv";
					$handle = fopen($file, "r");
					while(!feof($handle)){
					$line = fgetcsv($handle, 0, ",");
					if ($line[0] != "No Entries." || $line[0] != "") {
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
                <li><a href="add-server.php"><i class="icon-desktop"></i> Add Server</a></li>
                <li><a href="#"><i class="icon-globe"></i> Add Website</a></li>
                <li><a href="#"><i class="icon-hdd"></i> Add Storage</a></li>
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
            <h1><small>Add New Device / Website / Storage</small></h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="icon-dashboard"></i> Dashboard</a></li>
			  <li><a href="settings.php"><i class="icon-cog"></i> Settings</a></li>
			  <li class="active"><i class="icon-plus"></i> <i class="icon-desktop"></i> Add New Device</li>
            </ol>
          </div>
        <!-- end of breadcrumbs -->
		
		<form class="" action="write-edit.php" method="post">
			<div class="col-lg-4">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="icon-pencil"></i> Edit Device Details</h3>
              </div>
              <div class="panel-body">
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="icon-magic"></i> Device Type</span>
                <select type="text" class="form-control" id="type" name="type" placeholder="Type">
                  <option><?php echo $type; ?></option>
                  <option>servers</option>
                  <option>websites</option>
                  <option>storage</option>
                </select>
              </div><div class="form-group input-group">
                <span class="input-group-addon"><i class="icon-desktop"></i> Name</span>
                <input type="text" class="form-control" id="servername" name="servername" placeholder="Name" value="<?php echo $name; ?>">
              </div>
			  <div class="form-group input-group">
                <span class="input-group-addon"><i class="icon-sitemap"></i> Address</span>
                <input type="text" class="form-control" id="ipaddress" name="ipaddress" placeholder="Address" value="<?php echo $ipaddress; ?>">
              </div>
			  <div class="form-group input-group">
                <span class="input-group-addon"><i class="icon-bolt"></i> Port</span>
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
                <span class="input-group-addon"><i class="icon-bell-alt"></i> Alerts</span>
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
  </body>
</html>