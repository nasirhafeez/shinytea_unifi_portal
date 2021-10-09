<?php
session_start();

include 'parameters.php';

?>

<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($business_name); ?> WiFi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="stylesheet" href="bulma.min.css" />
  <link rel="stylesheet" href="vendor\fortawesome\font-awesome\css\all.css" />
  <meta http-equiv="refresh" content="5;url=https://www.shinytea.ca/" />
  <link rel="icon" type="image/png" href="favicomatic\favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="favicomatic\favicon-16x16.png" sizes="16x16" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="page">

    <br>
    <img src="logo.png" class="center">

    <div class="main">
      <seection class="section">
        <div id="margin_zero" class="content has-text-centered is-size-6">Thanks, you are now </div>
        <div id="margin_zero" class="content has-text-centered is-size-6">authorized on <?php echo htmlspecialchars($business_name); ?> network</div>
      </seection>
    </div>

  </div>
</body>

</html>