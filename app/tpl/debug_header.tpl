<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DebugPager</title>
</head>
<style>
table {margin:0px; padding:0px;}
table.tbfix {width:100%; table-layout:fixed; background:#bbb}
table.tbcom {width:100%; background:#bbb}
td {padding:3px; background:#fff}
td.title {background:#eee}
td.left {width:200px}
input.button {width:100px}
textarea#result {width:100%; height:300px; background:#ffffe0}
</style>
<script type='text/javascript' src='/js/jquery.js'></script>
<script type='text/javascript' src='/js/app.util.js'></script>
<?php
echo "<h2>" . ucfirst(__APP_NAME) . " Debug Server - v" . __APP_VERSION . "</h2>\n";
?>
<hr/>
<body>
