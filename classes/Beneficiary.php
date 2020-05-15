<?php

class Beneficiary {
    public $name;
    public $relationship;
    public $amountGiven;

    public function __construct($name, $relationship, $amountGiven){
        $this->name = $name;
        $this->relationship = $relationship;
        $this->amountGiven = $amountGiven;
    }

    public function getName(){
        return $this->name;
    }

    public function getRelationship(){
        return $this->relationship;
    }

    public function getAmountGiven(){
        return $this->$amountGiven;
    }

}