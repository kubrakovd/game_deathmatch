<html>
<head>
<title>START GAME</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

    <div class="container">
      <div class="row">
          <h2 class="text-center">Rest in peace
          <?php


          if(isset($_GET['name'])){
            echo '<h2 class="text-center">' . $_GET['name'] . '</h2>';
          }

          ?>
          </h2>
          <div class="col-md-12 text-center">
            <img src="img/rip.jpeg">
            <br>

          </div>
      </div>
    </div>
</body>
</html>
