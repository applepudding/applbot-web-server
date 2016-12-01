<?php
$inputChannel = 0;
if (isset($_REQUEST["c"]))
{
   $inputChannel = $_REQUEST["c"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>ffxiv.act.applbot plugin server</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/ico" href="favicon.ico">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <div class="container">
    <div class="header clearfix">
      <nav>
        <ul class="nav nav-pills float-xs-right">
          <li class="nav-item">
            <span class="nav-link"><button id="btn_home">Home</a></button>
          </li>
          <li class="nav-item">
            <span class="nav-link" id="webspeech_status">Channel <span id="current_channel"><?php print $inputChannel; ?></span><span class="sr-only">(current)</span></span>
          </li>
        </ul>
      </nav>
      <h3 class="text-muted">ffxiv.act.applbot</h3>    
      <a href="https://github.com/applepudding">Github</a>
      <a href="https://github.com/applepudding/ffxiv.act.applbot/releases">1.5</a>
    </div>
    <div id="main_channel" style="display:none;">
      <div class="jumbotron">
        <p>
          <label for="input_channel">Channel#</label>
          <input type="number" class="form-control" id="input_channel" value="0" min="1" style="text-align:center;"> 
        </p>
        <button id="btn_join">Join</button>
      </div>
    </div>
    <main id="main_display" style="display:none;">
      <div class="jumbotron">
        <p id="debug_outputArea" style="color:blue;">Ready</p>
        <hr>
        <h1 class="display-4" id="display_eventMain">--</h1><h2 id="display_eventTimer">0</h2>
        <hr>
        <p class="lead" id="display_eventSub">--</p>        
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Voice</h4>
          <div class="form-group">
            <select class="form-control" id="input_voice">
            </select>
          </div>
          <div class="form-group form-inline">
            <label for="input_volume" class="col-form-label">Volume:</label>
            <input type="range" class="form-control" id="input_volume" min="0" max="1" step="0.1" value="0.7">
          </div>
        </div>

        <div class="col-lg-6">
          <h4>Misc</h4>
          <div class="form-group">
            <input type="text" class="form-control" id="input_myName" placeholder="My Name">
          </div>
          <div class="form-group form-inline">
            <label for="input_delay" class="col-form-label">Delay (ms):</label>
            <input type="number" class="form-control" id="input_delay" value="200" min="100">
          </div>
          <div class="form-group">
            <label class="form-check-label">
              <input type="checkbox" class="form-check-input" id="chk_reverseDirection">
              Reverse Left and Right
            </label>
          </div>
        </div>
      </div>
    </main>
    <footer class="footer">
      <p>&copy; Apple Pudding 2016</p>
    </footer>

  </div> <!-- /container -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
  <script src="scripts.js"></script>
</body>

</html>