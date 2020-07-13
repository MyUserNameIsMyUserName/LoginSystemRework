<?php 

function getCurrentModuleName(){
    $moduleName = explode('?',$_SERVER['REQUEST_URI']);
    $moduleName = explode('/',$moduleName[0]);
    $moduleName = end($moduleName);
    return $moduleName;
}