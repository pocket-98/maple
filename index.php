<html>
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>Maple</title>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <script type="text/javascript"><?php
$spaces = "\n      ";
echo $spaces . "var scripts = {";

$names = explode(" ", exec("echo $(ls examples/*txt | cut -d '.' -f 2)"));


for ($i = 1; $i <= count($names); $i++) {
  $file = "examples/";
  if ($i < 10) {
    $file .= "0";
  }
  $file .= "$i." . $names[$i-1] . ".txt";

  echo $spaces . "  $i: { name:" . '"' . $names[$i-1];
  echo '", ' . 'script:"';
  $old = array("\n",'"');
  $new = array('\n','\"');
  echo str_replace($old, $new, file_get_contents("$file"));
  echo '" },';
}

echo $spaces . "}";
?>

      var loadExample = function(i) {
        document.getElementById("input").value = scripts[i]["script"];
      }
    </script>
    <div id="examples-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Examples">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Example Scripts</h4>
          </div>
          <div class="modal-body container-fluid"><?php

$spaces = "\n            ";
echo $spaces . '<div class="col-xs-0"></div>';
echo $spaces . '<div class="col-xs-12">';
echo "$spaces";
echo '  <div class="container-fluid">';
echo "$spaces";
for ($i = 1; $i <= count($names); $i++) {
	echo '    <div class="col-sm-6 col-md-4">' . $spaces;
	echo '      <div class="button" data-dismiss="modal" onclick="loadExample(';
	echo  $i . ')"><div>' . $names[$i-1];
	echo "</div></div>$spaces";
  echo "    </div>$spaces";
}
echo "  </div>$spaces</div>$spaces";
echo '<div class="col-xs-0"></div>' . "\n";
?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Dismiss</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container" style="margin: 0 auto">
      <div class="col-xs-0 col-sm-1 col-md-2"></div>
      <div id="page" class="col-xs-12 col-sm-10 col-md-8">
        <h1 id="title">Maple</h1>
        <form id="form" action="output/" method="post">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12">
                <textarea id="input" name="input" placeholder="Enter Maple Commands"><?php
if (isset($_GET['input']) && strlen($_GET['input']) > 0) {
  echo $_GET['input'];
} else {
  echo $_POST['input'];
}
              ?></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="button" data-toggle="modal" data-target="#examples-modal">
                  <div>Load Example</div>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="button" onclick="document.getElementById('form').submit()">
                  <div>Run Script</div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-xs-0 col-sm-1 col-md-2"></div>
    </div>

  </body>
</html>
