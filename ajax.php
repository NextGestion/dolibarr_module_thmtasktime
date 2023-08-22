<?php
if (!defined('NOCSRFCHECK'))     define('NOCSRFCHECK', 1);
if (!defined('NOTOKENRENEWAL'))  define('NOTOKENRENEWAL', 1);

$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include("../main.inc.php");       // For root directory
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php"); // For "custom"

$results = array();

$action = GETPOST('action');
$userid = GETPOST('userid');

if($action == 'getthm'){
	$employee = new User($db);
	$employee->fetch($userid);
    $results['thm'] = price2num($employee->thm);
}

echo json_encode($results);
