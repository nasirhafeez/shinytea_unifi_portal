<?php
session_start();

include 'parameters.php';
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

# Facebook login parameters

$fb = new Facebook\Facebook([
  'app_id'                => $_SERVER['APP_ID'],
  'app_secret'            => $_SERVER['APP_SECRET'],
  'default_graph_version' => $_SERVER['DEFAULT_GRAPH_VERSION'],
]);

$helper      = $fb->getRedirectLoginHelper();
$scope       = array("email");
$loginUrl    = $helper->getLoginUrl($callBackUrl, $scope);

# Google login parameters

$client_id = $_SERVER['CLIENT_ID'];
$client_secret = $_SERVER['CLIENT_SECRET'];
$client_redirect_url = $_SERVER['CLIENT_REDIRECT_URL'];

$google_login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode($client_redirect_url) . '&response_type=code&client_id=' . $client_id . '&access_type=online';


if (!isset($_SESSION['id'])) {
  $_SESSION["id"] = $_GET['id'];
  $_SESSION["ap"] = $_GET['ap'];
}

$_SESSION["user_type"] = "new";
$_SESSION["method"] = "Form";

# Checking DB to see if user exists or not.

$host_ip = $_SERVER['HOST_IP'];
$db_user = $_SERVER['DB_USER'];
$db_pass = $_SERVER['DB_PASS'];
$db_name = $_SERVER['DB_NAME'];

$con = mysqli_connect($host_ip, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
  echo "Failed to connect to SQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT * FROM `$table_name` WHERE mac='$_SESSION[id]'");

if ($result->num_rows >= 1) {
  $row = mysqli_fetch_array($result);

  $_SESSION["fname"] = $row[1];
  $_SESSION["lname"] = $row[2];
  $_SESSION["email"] = $row[3];
  $_SESSION["mac"] = $row[4];
  $_SESSION["method"] = $row[5];

  mysqli_close($con);

  $_SESSION["user_type"] = "repeat";
  header("Location: welcome.php");
} else {
  mysqli_close($con);
}

?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>
    <?php echo htmlspecialchars($business_name); ?> WiFi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="stylesheet" href="bulma.min.css" />
  <link rel="stylesheet" href="vendor\fortawesome\font-awesome\css\all.css" />
  <link rel="icon" type="image/png" href="favicomatic\favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="favicomatic\favicon-16x16.png" sizes="16x16" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="page">

    <div class="head">
      <br>
      <figure id="logo">
        <img src="logo.png">
      </figure>
    </div>

    <div class="main">
      <seection class="section">
        <div class="container">
          <div id="login" class="content is-size-6 has-text-centered">Welcome to SHINY TEA.</div>
          <div id="login" class="content is-size-6 has-text-centered">Log on to our network and it</div>
          <div id="login" class="content is-size-6 has-text-centered">will automatically connect to</div>
          <div id="login" class="content is-size-6 has-text-centered">any SHINY TEA stores</div>
          <br>
          <form id="verify" method="post" action="connect.php">

            <div class="field">
              <div class="control has-icons-left">
                <input class="input" type="text" id="form_font" name="fname" placeholder="First Name" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>
            
            <div class="field">
              <div class="control has-icons-left">
                <input class="input" type="text" id="form_font" name="lname" placeholder="Last Name" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>

            <div class="field">
              <div class="control has-icons-left">
                <input class="input" type="email" id="form_font" name="email" placeholder="Email" required>
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
            </div>

            <br>
            <div class="columns is-centered is-mobile">
              <div class="control">
                <label class="checkbox">
                  <div class="checkbox_custom">
                    <input type="checkbox">
                    Yes, I would like to receive news, promotions, information and offers from SHINY TEA
                    <br>
                    <div id="login" class="content is-size-6 has-text-centered">You can unsubscribe at any time.</div>
                    <div id="login" class="content is-size-6 has-text-centered">Please read our <a href="policy.php">Terms of Use</a> or Contact Us</div>
                  </div>
                </label>
              </div>
            </div>

            <div class="buttons is-centered">
              <button class="button is-dark is-rounded">CONNECT</button>
            </div>

          </form>
        </div>
        <br>
        <div id="logintext" class="content has-text-centered is-size-5 has-text-weight-bold">Or Login Using</div>
        <br>
        <div class="container has-text-centered">
            <a href="<?php echo htmlspecialchars($loginUrl); ?>">
              <i class="fab fa-facebook fa-3x"></i>
            </a>
            <a href="<?php echo htmlspecialchars($google_login_url); ?>">
              <i class="fab fa-google fa-3x"></i>
            </a>
        </div>
      </seection>
    </div>

  </div>
</body>

</html>