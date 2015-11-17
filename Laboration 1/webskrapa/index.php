<?php
//INCLUDE THE FILES NEEDED...
require_once('View/LayoutView.php');
require_once('Model/Compiler.php');
require_once('Model/Scraper.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'Off');
libxml_use_internal_errors(TRUE);

$layoutView = new \View\LayoutView();
$layoutView->setLayout();


