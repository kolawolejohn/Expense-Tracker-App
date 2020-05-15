<?php

require_once "require/autoloader.php";
echo "\e[1;31m $$$ ************* Welcome To The Expense Tracker App ************** $$$ \e[0m\n";

$expense = new Menu();

while(true){

    $expense->displayMenu($response);

    if($response === 13){
        $this->quit();
    }

}




