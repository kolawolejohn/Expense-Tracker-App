<?php

class ExpenseGroup {
    public $expenseCategory;

    public function __construct($expenseCategory){
        $this->expenseCategory = $expenseCategory;
    }

    public function setExpenseCategory(){
        $expenseCategory = readline("Enter category name: ");
    }

    public function getExpenseCategory(){
        return $this->expenseCategory;
    }
}



