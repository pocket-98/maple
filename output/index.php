<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Maple Script Executed</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
  </head>
  <body>
    <div class="container" style="margin: 0 auto">
      <div class="col-xs-0 col-md-1 col-lg-2"></div>
      <div id="page" class="col-xs-12 col-md-10 col-lg-8">
        <h1 id="title">Maple Script Executed</h1>
        <hr/>
        <div class="container-fluid">
          <div class="col-xs-1 col-sm-2 col-md-3"></div>
          <div class="col-xs-10 col-sm-8 col-md-6">
            <form id="form" action="../" method="post">
              <input type="hidden" name="input" value=<?php
if (isset($_GET['input']) && strlen($_GET['input']) > 0) {
  $input = $_GET['input'];
} else {
  $input = $_POST['input'];
}
echo "'" . $input . "'";
            ?>/>
            </form>
            <div class="button" onclick="document.getElementById('form').submit()">
              <div>Edit Script</div>
            </div>
          </div>
          <div class="col-xs-1 col-sm-2 col-md-6"></div>
        </div>
        <hr/>

<?php

$inputs = explode(";", $input);
$inputs2 = array();
$inputstring = "";
foreach($inputs as $line){
  $line = str_replace(' ','',trim($line));
//  $inputstring = $inputstring ."\"$line;\" ";
  $inputstring .= "'$line;' ";
  array_push($inputs2, $line);
}

$output = shell_exec("./shell.sh $inputstring");
$output2 = explode("\n", $output);
$output3 = array();
for($i = 0; $i < count($output2); $i++){
  $item = $output2[$i];
  $next = $output2[$i+1];
  if (strpos($item,"startstartstartstartstart") !== false) {
    $part = array();
  }
  if (strpos($next,"endendendendend") !== false) {
    if (count($part) > 0) {
      array_push($output3, $part);
    }
    $part = array();
  } else {
    if ((strpos($next,"fixme:") === false) and (strpos($next,"err:") === false)) {
      array_push($part, $next);
    }
  }
}

for ($i = 0; $i < count($inputs2); $i++) {
  $in = $inputs2[$i];
  $out = $output3[$i];

  if (strpos($in, "exportplot(") !== false) {
    foreach (explode("xportplot", $in) as $inline) {
      if (strpos($inline, '"') !== false) {
        $inlineparts = explode('"', $inline);
        for ($j = 0; $j < count($inlineparts); $j++) {
          if ($j % 2 == 1) {
            $plot = $inlineparts[$j];
            $plotlink = '<a class="plot" target="_blank" ' . "href='$plot'>$plot</a>";
            $in = str_replace("\"$plot\"", "\"$plotlink\"", $in);
          }
        }
      }
    }
  }

  if (strcmp(trim($in),"") != 0) {
    echo '<pre class="input">>> ' . $in . ";</pre>\n";
    echo '<pre class="output">';
    foreach ($out as $outline) {
      echo $outline;
    }
    echo "</pre>\n";
  }
}

?>

      </div>
      <div class="col-xs-0 col-md-1 col-lg-2"></div>
    </div>
  </body>
</html>
