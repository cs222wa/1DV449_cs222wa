<?php
//INCLUDE THE FILES NEEDED...
require_once('Model/Radio.php');
require_once('View/HtmlView.php');
require_once('Controller/Controller.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'Off');
libxml_use_internal_errors(TRUE);

$c = new Controller();
$v = new HtmlView();


$c->getTraffic();
$v->render();

