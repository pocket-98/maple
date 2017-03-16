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
              <textarea name="input" style="display: none;"><?php
if (isset($_GET['input']) && strlen($_GET['input']) > 0) {
  $input = $_GET['input'];
} else {
  $input = $_POST['input'];
}
echo "" . $input . "";
            ?></textarea>
            </form>
            <div class="button" onclick="document.getElementById('form').submit()">
              <div>Edit Script</div>
            </div>
          </div>
          <div class="col-xs-1 col-sm-2 col-md-6"></div>
        </div>
        <hr/>

<?php

$inputs = explode(";",$input);
$inputs2 = array();

$inputstring = "";
$s = "startstartstartstartstart";
$e = "endendendendend";

$loopLevel = 0;
$loopContent = "";

foreach($inputs as $line){
  if (strpos($line, " do") !== false) {
    $loopLevel -= substr_count($line, "end do");
    $loopLevel += substr_count(str_replace("end do","",$line), " do");

    if (loopLevel == 0) {
      $line = "$loopContent$line";
      $loopContent = "";
    }
  }

  if ($loopLevel == 0) {
    $inputstring .= "$s;$line;$e;";
    array_push($inputs2, $line);
  } else {
    $loopContent .= "$line;";
  }
}

$cmd = "export HOME=/srv/http; echo '$inputstring' | ";
$cmd .= "/usr/local/bin/cmaple -q -T 15,200000 -t";
$output = shell_exec($cmd);
$output2 = explode("\n", $output);
$output3 = array();
for($i = 0; $i < count($output2); $i++){
  $item = $output2[$i];
  $next = $output2[$i+1];
  if (strpos($item,$s) !== false) {
    $part = array();
  }
  if (strpos($next,$e) !== false) {
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
