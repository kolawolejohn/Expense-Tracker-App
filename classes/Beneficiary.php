<?php

class Beneficiary {
    private $name;
    private $relationship;
    private $amountGiven;

    public function __construct($name, $relationship, $amountGiven){
        $this->name = $name;
        $this->relationship = $relationship;
        $this->amountGiven = $amountGiven;
    }

    public function setName($name){
        $this->name = readline("Enter name of beneficiary: ");
    }

    public function getName(){
        return $this->name;
    }

    public function setRelationship($relationship){
        $this->relationship = readline("Enter the relationship with the beneficiary: ");
    }

    public function getRelationship(){
        return $this->relationship;
    }

    public function setAmountGiven($amountGiven){
        $this->$amountGiven = readline("Enter amount given: ");
    }

    public function getAmountGiven(){
        return $this->$amountGiven;
    }

}