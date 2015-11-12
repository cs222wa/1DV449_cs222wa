<?php
//CompilationView class
namespace view;

class CompilationView
{
    public function renderResult($compile){
        if($compile){
            return "result";
        }

        return false;
    }

}
