<html>
<head>
  <title>Aura|Settings</title>
  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon-16x16.png">
  <link rel="shortcut icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>../images/favicons/favicon.ico" type="image/x-icon">
  <link rel="icon" href="<?php echo str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['REQUEST_URI']); ?>i../mages/favicons/favicon.ico" type="image/x-icon">
  <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="print-list.js" type="text/javascript"></script>
</head>
<body>
  <div class="container">
      <div class="header">
          <a href="../"><img class="page-title" src="../images/AuraLogo.png"></a>
          <div class="action">
              <div class="links">
                  <a href="../new">New</a> <a href="../results">Search</a>
              </div>
          </div>
          <div class="footer">
              <a href="https://github.com/hschreck/Aura/issues">Support</a>
          </div>

      </div>
      <div class="wrapper">
        <div class="inner-wrapper">
          <div class="settings">
              <h1 class="page-title">Settings</h1>
              <form action="." method="post">
                Printer: <select id="printer" onchange="savePrinter(this.value);">

                  </select>
              </form>
          </div>
        </div>
        </div>
</body>
</html>
