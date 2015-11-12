<?php
//INCLUDE THE FILES NEEDED...
require_once('model/LayoutView.php');
require_once('model/Compiler.php');



//Starts new session
//session_start();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


$layoutView = new \view\LayoutView();
$layoutView->setLayout();





/*
$compile = false;

//CREATE OBJECTS OF THE MODEL
$compileModel = new \model\Compiler();
$dinner = new \model\Dinner();
$cinema = new \model\Cinema();
$calendar = new \model\Calendar();

//CREATE OBJECTS OF THE VIEWS

$formView = new \view\FormView();
$compView = new \view\CompilationView();

//CREATE OBJECT OF THE CONTROLLER - SEND OBJECTS OF THE CORRESPONDING VIEWS AND MODELS AS PARAMETERS
$controller = new \controller\Controller();

//CALL CONTROLLER METHOD doCalculate IN ORDER TO DETERMINE IF USER WANTS TO CALCULATE A SKIRT PATTERN
$compile = $controller->doCompile();
$compileModel->fetchPage();

//PICK WHICH VIEW TO DISPLAY
$layoutView->setLayout($compile, $compView, $formView);

*/

