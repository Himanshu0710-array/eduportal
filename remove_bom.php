<?php
$str = file_get_contents('database.sql');
$bom = pack('H*','EFBBBF');
$str = preg_replace("/^$bom/", '', $str);
file_put_contents('database.sql', $str);
echo "BOM Removed";
?>
