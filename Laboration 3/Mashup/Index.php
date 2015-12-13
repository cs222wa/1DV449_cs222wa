<?php
//INCLUDE THE FILES NEEDED...
require_once('Model/Radio.php');
require_once("view/HtmlView.php");
require_once("controller/Controller.php");

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');
libxml_use_internal_errors(TRUE);

$c = new Controller();
$v = new HtmlView();


$c->mashup();
$v->render();

