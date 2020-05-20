<?php

require_once "require/autoloader.php";
print "\e[1;31m $$$ ************* Welcome To The Expense Tracker App ************** $$$ \e[0m\n";
print "\e[1;31m $$$ ************* This app will not create your expenses if you exceed savings limit ************** $$$ \e[0m\n";
print "\e[1;31m $$$ ************* Plan to spend wisely ************** $$$ \e[0m\n";
print "\e[1;31m $$$ ************* Enjoy the app ************** $$$ \e[0m\n";

$expense = new Menu();

while(true){

    $expense->displayMenu($response);

    if($response === 13){
        $this->quit();
    }

}




