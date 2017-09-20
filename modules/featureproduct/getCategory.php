<?php

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once(dirname(__FILE__) . '/../../config/config.inc.php');
require_once(dirname(__FILE__) . '/../../init.php');
$allcategories = array();
include(dirname(__FILE__) . '/../../config/settings.inc.php');
include(dirname(__FILE__) . '/../../config/defines_uri.inc.php');

$categoryId = Tools::getValue('categoryId');

$sql = "SELECT jcl.id_category,jcl.name  "
        . "FROM "._DB_PREFIX_."category as jc "
        . "LEFT JOIN "._DB_PREFIX_."category_lang as jcl ON "
        . "jc.id_category=jcl.id_category WHERE jc.id_parent = " . trim($categoryId) . " "
        . "GROUP BY jc.id_category";
$con = mysql_connect(_DB_SERVER_, _DB_USER_, _DB_PASSWD_);
mysql_select_db(_DB_NAME_, $con);
$query = mysql_query($sql, $con);
while ($results = mysql_fetch_assoc($query)) {
    array_push($allcategories, $results['id_category']."->".$results['name']);
    $i++;
}

die(Tools::jsonEncode($allcategories));