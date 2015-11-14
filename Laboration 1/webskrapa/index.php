<?php
//INCLUDE THE FILES NEEDED...
require_once('model/LayoutView.php');
require_once('model/Compiler.php');
require_once('model/Scraper.php');

//Starts new session
//session_start();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


$layoutView = new \view\LayoutView();
$layoutView->setLayout();


