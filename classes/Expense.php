<?php

class Expense extends ExpenseGroup{

    public $title;
    public $benefactor;
    public $amountSpent;

    public function __construct($title, $benefactor, $amountSpent){
        $this->title = $title;
        $this->benefactor = $benefactor;
        $this->amountSpent = $amountSpent;
        $this->expenseCategory = $expenseGroup->expenseCategory;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getBenefactor(){
        return $this->benefactor;
    }

    public function getAmountSpent(){
       return $this->amountSpent;
    }

    public function getExpenseCategory(){
        return $this->expenseCategory;
    }

}