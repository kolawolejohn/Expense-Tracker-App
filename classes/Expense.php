<?php

class Expense extends ExpenseGroup{

    private $title;
    private $benefactor;
    private $amountSpent;

    public function __construct($title, $benefactor, $amountSpent){
        $this->title = $title;
        $this->benefactor = $benefactor;
        $this->amountSpent = $amountSpent;
        $this->expenseCategory = $expenseGroup->expenseCategory;
    }

    public function setTitle($title){
        $this->title = readline("Enter title of expense: ");
    }

    public function getTitle(){
        return $this->title;
    }

    public function setBenefactor($benefactor){
        $this->benefactor = readline("Enter where expense was made: ");
    }

    public function getBenefactor(){
        return $this->benefactor;
    }

    public function setAmountSpent($amountSpent){
        $this->amountSpent = intval(readline("Enter amount spent: "));
     }

    public function getAmountSpent(){
       return $this->amountSpent;
    }

    public function setExpenseCategory(){
        $this->expenseCategory = readline("Enter expense category: ");
    }

    public function getExpenseCategory(){
        return $this->expenseCategory;
    }

}