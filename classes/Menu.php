<?php

require_once "require/readline.php";
class Menu {

     public $user;
     public function __construct(){
         $this->user = new User();
     }

    public function displayMenu($response){

        echo(@ "\n\e[0;32m  Welcome to Mr John's Expense Tracker \e[0m\n
        \e[1;31m1  - Create an Expense Group\e[0m\n
        \e[1;31m2  - Update an Expense Group\e[0m\n
        \e[1;31m3  - Show Expense Groups\e[0m\n
        \e[1;31m4  - Delete an Expense group\e[0m\n
        \e[1;32m5  - Create an Expense\e[0m\n 
        \e[1;32m6  - Update an Expense\e[0m\n 
        \e[1;32m7  - Delete an Expense\e[0m\n 
        \e[1;32m8  - Show all Expenses\e[0m\n
        \e[1;35m9  - Create Beneficiary\e[0m\n
        \e[1;35m10 - Remove beneficiary\e[0m\n
        \e[1;35m11 - List beneficiaries\e[0m\n
        \e[1;36m12 - Show Percentage Amount Spent\e[0m\n 
        \e[1;36m13 - Show Amount Saved\e[0m\n
        \e[1;31m14 - Quit!\n\e[0m\n
        \e[1;34mEnter an option between 1 and 14:\e[0m ");

        $option = intval(readline($response));
        switch ($option)
        {
        case 1:
            echo $this->user->createExpenseGroup();
            break;
        case 2:
            echo $this->user->updateExpenseGroup();
            break;
        case 3:
            echo $this->user->showExpenseGroup();
            break;
        case 4:
            echo $this->user->deleteExpenseGroup();
            break;
        case 5:
            echo $this->user->createExpense();
            break;
        case 6:
            echo $this->user->updateExpense();
            break;
        case 7:
            echo $this->user->deleteExpense();
            break;
        case 8:
            $this->user->showAllExpenses();
            break;
        case 9:
            echo $this->user->createBeneficiary();
            break;
        case 10:
            echo $this->user->removeBeneficiary();
            break;
        case 11:
            echo $this->user->showBeneficiaries();
            break;
        case 12:
            echo $this->user->showPercentAmountSpent();
            break;
        case 13:
            echo $this->user->showPercentAmountSaved();
            break;
        case 14:
            $this->quit();
            break;
        default:
            echo ("Input not understood, Please retry again...");
            break;
        }
    }

    public function quit(){
        exit();
    }

}