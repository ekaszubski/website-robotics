<?php

$ROOT = '../../';
chdir( $ROOT );
include_once 'php/global_settings.php';
include_once 'php/content/code_view.php';

$source_filename = 'motion_primitives.cpp';
$html_comp_file = content\code_view\make_code_html_compatible( file_get_contents( 'projects/seabee3/' . $source_filename ) );

echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>' . $source_filename . '</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="' . $SITE_ROOT . '/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="' . $SITE_ROOT . '/assets/css/code-prettify.css" rel="stylesheet">
    <style>
      body {
        padding-top: 20px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="span16">
<pre class="prettyprint linenums">
' . $html_comp_file . '</pre>
    </div>

    <script src="' . $SITE_ROOT . '/assets/js/code-prettify.js"></script>
    <script src="' . $SITE_ROOT . '/assets/js/jquery.js"></script>
    <script src="' . $SITE_ROOT . '/assets/js/bootstrap.js"></script>
    <script src="' . $SITE_ROOT . '/assets/js/code.js"></script>

  </body>
</html>';

?>
