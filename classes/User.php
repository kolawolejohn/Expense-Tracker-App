<?php
require_once "require/readline.php";

class User
{
    private $monthlyIncome;
    private $minimumPercentageToSave;
    private $minimumAmountToSave;
    private $totalPersonalAmountSpent= 0;
    private $totalBeneficiaryAmountGiven=0;
    private $percentageOfIncomeSpent;
    private $percentageOfIncomeGiven;
    private $totalPersonalExpensePercent = 0 ;
    private $totalBeneficiaryExpensePercent = 0;
    private $beneficiaryList = [];
    private $expenseList = [];
    private $expenseGroupList = [];

    public function __construct(){
        $this->setMonthlyIncome($monthlyIncome);
        $this->setMinimumAmountToSave($minimumAmountToSave);
        $this->beneficiary = new Beneficiary($name, $relationship, $amountGiven);
        $this->expenseGroup = new ExpenseGroup($expenseCategory);
        $this->expense = new Expense($title, $benefactor, $amountSpent, $expenseGroup);
    }

    public function setMonthlyIncome($monthlyIncome){
        $this->monthlyIncome  = intval(readline('Enter monthly income: '));
    }

    public function getMonthlyIncome(){
        return $this->monthlyIncome;
    }

    public function setMinimumAmountToSave($minimumAmountToSave){
        $this->minimumAmountToSave = intval(readline('Enter minimum amount to save: '));
    }

    public function getMinimumAmountToSave(){
        return $this->minimumAmountToSave;
    }

    public function getMinimumPercentageToSave(){
        $this->$minimumPercentageToSave = ($this->minimumAmountToSave * 100)/($this->getMonthlyIncome()); 
        return $this->$minimumPercentageToSave;
    }

    public function createExpenseGroup(){
        $newExpenseCategory = readline("Enter new category: ");
        if(!empty($newExpenseCategory)){
            $this->expenseGroupList[] = $newExpenseCategory;
            array_unique($this->expenseGroupList);
            print 'Expense group created successfully' . PHP_EOL;
        }
        else{
            print("Please specify expense group to create" .PHP_EOL);
            $this->createExpenseGroup();
        }
    }

    public function updateExpenseGroup(){
        echo "\n\e[0;32mPlease choose the expense group by the name of the expense group\e[0m\n";
        $expenseGroupToUpdate = readline("Please enter expense category to update: ");
        $updatedExpenseGroup = readline("Enter new category: ");
        if ((($key = array_search($expenseGroupToUpdate , $this->expenseGroupList)) !== false) &&  !empty($expenseGroupToUpdate)  && !empty($updatedExpenseGroup)) {
            unset($this->expenseGroupList[$key]);
            $this->expenseGroupList = array_values($this->expenseGroupList);
            $expenseGroupToUpdate = $updatedExpenseGroup;
            $this->expenseGroupList[] = $expenseGroupToUpdate;
            array_unique($this->expenseGroupList);
            return 'Expense group updated successfully' . PHP_EOL;
        }
        else{
            print("Please specify expense group to update" .PHP_EOL);
            $this->updateExpenseGroup();
        }
    }

    public function showExpenseGroup(){
        $groupList = $this->expenseGroupList;
        if(!empty($groupList)){
            foreach(array_unique($groupList) as $key => $expenseGroup){
                print $expenseGroup . PHP_EOL;
             }
        }
        else{
            return "There is now expensegroup list to show" . PHP_EOL;
        }
    }

    public function deleteExpenseGroup(){
       print("\n\e[0;32mPlease delete the expense group by the name of the expense group\e[0m\n");
        $expenseCategory = readline("Please enter expense category to remove: ");
        if (($key = array_search($expenseCategory, $this->expenseGroupList)) !== false && !empty($expenseCategory)) {
            unset($this->expenseGroupList[$key]);
            $this->expenseGroupList = array_values($this->expenseGroupList);
            return 'Expense group Deleted Successfully' .PHP_EOL;
        }
        else
        {
           return 'This expense category does not exist...' .PHP_EOL;
        }
    }

    public function createExpense(){
        $this->expense->setExpenseCategory($expenseCategory);
        $this->expense->setTitle($title);
        $this->expense->setBenefactor($benefactor);
        $expenseAmount = $this->expense->getAmountSpent();
        $expenseAmount = intval(readline("Enter amount of income spent: "));
        $this->percentageOfIncomeSpent = ($expenseAmount  * 100)/($this->getMonthlyIncome());
        $this->totalPersonalAmountSpent += $expenseAmount ;
        if($this->getTotalAmountSpent() < $this->getMinimumAmountToSave()){
            $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
            $this->expenseList[] = $this->getExpense();
            $array[] = $this->getExpense();
            foreach($array as $key => $expenseGroup){
                foreach($expenseGroup as $key => $expense){
                    foreach($expense as $key => $value){
                        print  $key . ': '. $value . PHP_EOL;
                    }
                }
                print "\n\e[1;33m============================================\e[0m\n";
            }
            $this->showPercentAmountSpent();
            print('New expense created successfully' . PHP_EOL);
            if(!array_key_exists($expenseCategory, $this->expenseGroupList)){
                $this->expenseGroupList[] = $this->expense->getExpenseCategory();
            }
        }
        else if($this->getTotalAmountSpent() > $this->getMinimumAmountToSave()){
             print("\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL);
             $this->$totalPersonalExpensePercent -= $this->percentageOfIncomeSpent;
             $delete[] = $this->getExpense();
             unset($delete);
             $this->showPercentAmountSpent();
             print('This expense is not created as you have exceeded the savings limit!!!'. PHP_EOL);
        }
    }

    public function getExpense(){
            return 
            [
                $this->expense->getExpenseCategory() =>
                    [
                        'Title'     => $this->expense->getTitle(),
                        'Benefactor'  => $this->expense->getBenefactor(),
                        'Percent'   => $this->percentageOfIncomeSpent
                    ]
            ];
    }

    public function updateExpense(){
        $expenseIndex= readline("Please enter index of expense category to update: ");
        $expenseCategory = readline("Please enter category to update: ");
        $oldPercentSpent = $this->getTotalPersonalExpensePercent();
        if (array_key_exists($expenseIndex, $this->expenseList))
        {
            $expenseToUpdate = $this->expenseList[$expenseIndex];
            $getPercent = $expenseToUpdate[$expenseCategory]['Percent'];
            if(array_key_exists($expenseIndex, $this->expenseList)){
                $this->totalPersonalExpensePercent = ($oldPercentSpent -  $getPercent);
                $this->expense->setExpenseCategory($expenseCategory);
                $this->expense->setTitle($title);
                $this->expense->setBenefactor($benefactor);
                $expenseAmount = $this->expense->getAmountSpent();
                $expenseAmount = intval(readline("Enter amount of income spent: "));
                $this->percentageOfIncomeSpent = ($expenseAmount  * 100)/($this->getMonthlyIncome());
                $this->totalPersonalAmountSpent += $expenseAmount ;
                if($this->getTotalAmountSpent() < $this->getMinimumAmountToSave()){
                    $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
                    $newExpenseUpdate = $this->getExpense();
                    $expenseToUpdate = $newExpenseUpdate;
                    $this->expenseList[] = $expenseToUpdate;
                    unset($this->expenseList[$expenseIndex]);
                    $this->expenseList = array_values($this->expenseList);
                    $updatedExpense[] = $expenseToUpdate;
                    foreach($updatedExpense as $key => $expenseGroup){
                        foreach($expenseGroup as $key => $expense){
                            foreach($expense as $key => $value){
                                print  $key . ': '. $value . PHP_EOL;
                            }
                        }
                        print "\n\e[1;33m============================================\e[0m\n";
                    }
                    print('New expense created successfully' . PHP_EOL);
                    if(!array_key_exists($expenseCategory, $this->expenseGroupList)){
                        $this->expenseGroupList[] = $this->expense->getExpenseCategory();
                    }
                    $this->showPercentAmountSpent();
                }
                else{
                    print("\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL);
                    $this->$totalPersonalExpensePercent -= $this->percentageOfIncomeSpent;
                    $delete[] = $this->getExpense();
                    unset($delete);
                    $this->showPercentAmountSpent();
                    print('This expense is not updated as you have exceeded the savings limit!!!'. PHP_EOL);
                }

            }
        }
    }

    public function deleteExpense(){
        print("\n\e[0;32mPlease delete the expense by the array Index, it must be a number\e[0m\n");
        $expenseIndex= readline("Please enter index of expense category to remove: ");
        $expenseCategory = readline("Please enter category to delete: ");
        $oldPercentSpent = $this->getTotalPersonalExpensePercent();
        if (array_key_exists($expenseIndex, $this->expenseList))
        {
            $expenseToDelete = $this->expenseList[$expenseIndex];
            $getPercent = $expenseToDelete[$expenseCategory]['Percent'];
            $this->totalPersonalExpensePercent = ($oldPercentSpent -  $getPercent);
            unset($this->expenseList[$expenseIndex]);
            $this->expenseList = array_values($this->expenseList);
            print('Expense Deleted Successfully'. PHP_EOL);
            $this->showPercentAmountSpent();
        }
        else
        {
          return 'This expense does not exist...' . PHP_EOL;
        }
    }

    public function showAllExpenses(){
        $expenses = $this->expenseList;
            foreach($expenses as $key => $expenseGroup){
                print 'Index' . ':' . $key . PHP_EOL;
                foreach($expenseGroup as $key => $expense){
                    print  $key .PHP_EOL;
                    foreach($expense as $key => $value){
                        print  $key . ': '. $value . PHP_EOL;
                    }
                }
                print "\n\e[1;33m============================================\e[0m\n";
            }
        $this->showPercentAmountSpent();
    }

    public function createBeneficiary(){
        $this->beneficiary->setName($name);
        $this->beneficiary->setRelationship($relationship);
        $amountGiven = $this->beneficiary->getAmountGiven();
        $amountGiven = intval(readline("Enter amount given to beneficiary: "));
        $this->percentageOfIncomeGiven = ($amountGiven * 100)/($this->getMonthlyIncome());
        $this->totalBeneficiaryAmountGiven +=$amountGiven;
        if($this->getTotalAmountSpent() < $this->getMinimumAmountToSave()){
            $this->totalBeneficiaryExpensePercent +=  $this->percentageOfIncomeGiven;
            $this->beneficiaryList[] = $this->getBeneficiary();
            $array[] = $this->getBeneficiary();
            foreach($array as $key => $beneficiary){
                foreach($beneficiary as $key => $value){
                    print $key . ': '. $value  . PHP_EOL;
                }
                print "\n\e[1;33m============================================\e[0m\n";
            }
            $this->showPercentAmountSpent();
        }
        else{
            print("\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL);
            $this->totalBeneficiaryExpensePercent -= $this->percentageOfIncomeGiven;
            $delete[] = $this->getBeneficiary();
            unset($delete);
            $this->showPercentAmountSpent();
        }
    }

    public function getBeneficiary(){
        return 
            [
                'Name'     => $this->beneficiary->getName(),
                'Relationship'  => $this->beneficiary->getRelationship(),
                'Percent'   => $this->percentageOfIncomeGiven
            ];
    }

    public function removeBeneficiary(){
        print("\n\e[0;32mPlease delete the beneficiary by the array Index, it must be the desired index(number)\e[0m\n");
        $nameIndex = readline("Please enter index of beneficiary to remove: ");
        $oldPercentGiven = $this->getTotalBeneficiaryExpensePercent();
        if (array_key_exists($nameIndex, $this->beneficiaryList))
        {
            $beneficiaryToDelete = $this->beneficiaryList[$nameIndex];
            $getPercent = $beneficiaryToDelete['Percent'];
            $this->totalBeneficiaryExpensePercent = ($oldPercentGiven -  $getPercent);
            unset($this->beneficiaryList[$nameIndex]);
            $this->beneficiaryList = array_values($this->beneficiaryList);
            //print_r($this->beneficiaryList);
            print('Beneficiary Deleted Successfully'. PHP_EOL);
            $this->showPercentAmountSpent();
        }
        {
           return 'This beneficiary does not exist...';
        }
    }

    public function showBeneficiaries(){
        //print_r($this->beneficiaryList);
        $beneficiaries = $this->beneficiaryList;
        foreach($beneficiaries as $key => $beneficiary){
            print 'Index' . ':' . $key . PHP_EOL;
            foreach($beneficiary as $key => $value){
                print $key . ': '. $value  . PHP_EOL;
            }
            print "\n\e[1;33m============================================\e[0m\n";
        }
        $this->showPercentAmountSpent();
    }

    public function getTotalPersonalExpensePercent(){
       return $this->totalPersonalExpensePercent;
    }

    public function getTotalBeneficiaryExpensePercent(){
        return $this->totalBeneficiaryExpensePercent;
    }

    public function getTotalPercentSpent(){
        return $this->getTotalPersonalExpensePercent() + $this->getTotalBeneficiaryExpensePercent();
    }

    public function getToTalPersonalExpense(){
        return $this->totalPersonalAmountSpent;
    }

    public function getToTalBeneficiaryExpense(){
        return $totalBeneficiaryAmountSpent;
    }

    public function getTotalAmountSpent(){
        return $this->getToTalPersonalExpense() + $this->getToTalBeneficiaryExpense();
    }

    public function showPercentAmountSpent(){
        $result = $this->getTotalPercentSpent();
        print "\n\e[0;32mTotal Percentage of Income spent is: \e[0m" . $result. '%' .PHP_EOL;
    }

    public function showPercentAmountSaved(){
        $percentSaved = (100 - $this->getTotalPercentSpent());
        print "\n\e[0;32mTotal Percentage of Income saved is: \e[0m" . $percentSaved . '%' . PHP_EOL;
    }

}