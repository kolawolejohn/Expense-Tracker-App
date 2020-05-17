<?php
require_once "require/readline.php";
class User
{
    private $monthlyIncome;
    private $minimumPercentageToSave;
    private $minimumAmountToSave;
    private $totalPersonalAmountSpent = 0;
    private $totalBeneficiaryAmountSpent = 0;
    private $percentageOfIncomeSpent;
    private $percentageOfIncomeGiven;
    private $totalPersonalExpensePercent = 0;
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
        $this->expenseGroupList[] = $newExpenseCategory;
        print_r(array_unique($this->expenseGroupList));
        return 'Expense group created successfully' . PHP_EOL;
    }

    public function updateExpenseGroup(){
        echo "\n\e[0;32mPlease choose the expense group by the name of the expense group\e[0m\n";
        $expenseCategory = readline("Please enter expense category to update: ");
        if (($key = array_search($expenseCategory, $this->expenseGroupList)) !== false) {
            unset($this->expenseGroupList[$key]);
            $this->expenseGroupList = array_values($this->expenseGroupList);
        }
        $expenseGroupToUpdate = readline("Enter new category: ");
        $this->expenseGroupList[] = $expenseGroupToUpdate;
        print_r(array_unique($this->expenseGroupList));
        return 'Expense group updated successfully' . PHP_EOL;

    }

    public function showExpenseGroup(){
        $groupList = $this->expenseGroupList;
        foreach(array_unique($groupList) as $key => $expenseGroup){
           print_r($expenseGroup . PHP_EOL);
        }
    }

    public function deleteExpenseGroup(){
        echo "\n\e[0;32mPlease delete the expense group by the name of the expense group\e[0m\n";
        $expenseCategory = readline("Please enter expense category to remove: ");
        if (($key = array_search($expenseCategory, $this->expenseGroupList)) !== false) {
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
        $this->expense->expenseCategory= readline("Enter expense category: ");
        $this->expense->title =  readline("Enter the title of your expense: ");
        $this->expense->benefactor = readline("Enter where the expense was made: ");
        $this->expense->amountSpent = intval(readline("Enter amount of income spent: "));
        $oldTotalPersonalExpensePercent = $this->getTotalPersonalExpensePercent();
        if(($this->showPercentAmountSpent() < $this->getMinimumPercentageToSave())){
            $this->percentageOfIncomeSpent = ($this->expense->amountSpent * 100)/($this->monthlyIncome);
            $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
            $this->expenseList[] = $this->getExpense();
            print_r($this->expenseList);
            echo 'New expense created successfully' . PHP_EOL;
            if(!array_key_exists($this->expense->expenseCategory, $this->expenseGroupList)){
                $this->expenseGroupList[] = $this->expense->expenseCategory;
            }
        }
        else{
            echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
             $this->totalPersonalExpensePercent = ($oldTotalPersonalExpensePercent - $this->percentageOfIncomeSpent + $this->percentageOfIncomeSpent);
             unset($oldTotalPersonalExpensePercent);
             $delete[] = $this->getExpense();
             unset($delete);
             echo 'This expense was not created as you exceeded the savings Limit!!!' . PHP_EOL;
        }
    }

    public function getExpense(){
            return 
            [
                $this->expense->expenseCategory =>
                    [
                        'Title'     => $this->expense->title,
                        'Benefactor'  => $this->expense->benefactor,
                        'Percent'   => $this->percentageOfIncomeSpent
                    ]
            ];
    }

    public function updateExpense(){
        $expenseIndex= readline("Please enter index of expense category to update: ");
        $expenseCategory = readline("Please enter category to update: ");
        $oldPersonalExpensePercentSpent = $this->getTotalPersonalExpensePercent();
        if (array_key_exists($expenseIndex, $this->expenseList))
        {
            $expenseToUpdate = $this->expenseList[$expenseIndex];
            $getPercent = $expenseToUpdate[$expenseCategory]['Percent'];
            if(array_key_exists($expenseIndex, $this->expenseList)){
                $this->totalPersonalExpensePercent = ($oldPersonalExpensePercentSpent -  $getPercent);
                unset($oldPercentSpent);
                $this->expense->expenseCategory= readline("Enter expense category: ");
                $this->expense->title =  readline("Enter the title of your expense: ");
                $this->expense->benefactor = readline("Enter where the expense was made: ");
                $this->expense->amountSpent = intval(readline("Enter amount of income spent: "));
                if($this->showPercentAmountSpent() < $this->getMinimumPercentageToSave()){
                    $this->percentageOfIncomeSpent = ($this->expense->amountSpent * 100)/($this->monthlyIncome);
                    $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
                    $newExpenseUpdate = $this->getExpense();
                    $expenseToUpdate = $newExpenseUpdate;
                    $this->expenseList[] = $expenseToUpdate;
                    unset($this->expenseList[$expenseIndex]);
                    $this->expenseList = array_values($this->expenseList);
                    print_r($this->expenseList);
                    echo 'New expense created successfully' . PHP_EOL;
                    if(!array_key_exists($this->expense->expenseCategory, $this->expenseGroupList)){
                        $this->expenseGroupList[] = $this->expense->expenseCategory;
                    }
                    var_dump($this->showPercentAmountSpent());
                    var_dump($this->getMinimumPercentageToSave());
                }
                }
                else{
                    echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
                    $this->totalPersonalExpensePercent = ($oldTotalPersonalExpensePercent - $this->percentageOfIncomeSpent + $this->percentageOfIncomeSpent);
                    unset($oldTotalPersonalExpensePercent);
                    $delete[] = $this->getExpense();
                    unset($delete);
                    echo 'This expense was not updated as you exceeded the savings Limit!!!' . PHP_EOL;
                }

            }
        }
         
    }

    public function deleteExpense(){
        echo "\n\e[0;32mPlease delete the expense by the array Index, it must be a number\e[0m\n";
        $expenseIndex= readline("Please enter index of expense category to remove: ");
        $expenseCategory = readline("Please enter category to delete: ");
        $oldPercentSpent = $this->getTotalPersonalExpensePercent();
        if (array_key_exists($expenseIndex, $this->expenseList))
        {
            $expenseToDelete = $this->expenseList[$expenseIndex];
            $getPercent = $expenseToDelete[$expenseCategory]['Percent'];
            $this->totalPersonalExpensePercent = ($oldPercentSpent -  $getPercent);
            unset($oldPercentSpent);
            unset($this->expenseList[$expenseIndex]);
            $this->expenseList = array_values($this->expenseList);
            print_r($this->expenseList);
            echo 'Expense Deleted Successfully'. PHP_EOL;
        }
        else
        {
          return 'This expense does not exist...' . PHP_EOL;
        }
    }

    public function showAllExpenses(){
        print_r($this->expenseList);
    }

    public function createBeneficiary(){
        $this->beneficiary->name = readline("Enter beneficiary name: ");
        $this->beneficiary->relationship = readline("Enter relationship with beneficiary: ");
        $this->beneficiary->amountGiven = intval(readline("Enter amount given to beneficiary: "));
        $this->percentageOfIncomeGiven = ($this->beneficiary->amountGiven * 100)/($this->getMonthlyIncome());
        if($this->showPercentAmountSpent() < $this->getMinimumPercentageToSave()){
            $this->totalBeneficiaryExpensePercent +=  $this->percentageOfIncomeGiven;
            $this->beneficiaryList[] = $this->getBeneficiary();
            print_r($this->beneficiaryList); 
        }
        else{
            echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
            $oldTotalBeneficiaryExpensePercent = $this->getTotalBeneficiaryExpensePercent();
            $this->totalBeneficiaryExpensePercent = ($oldTotalBeneficiaryExpensePercent - $this->percentageOfIncomeGiven + $this->percentageOfIncomeGiven);
            unset($oldTotalBeneficiaryPercent);
            $delete[] = $this->getBeneficiary();
            unset($delete);
        }
    }

    public function getBeneficiary(){
        return 
            [
                'Name'     => $this->beneficiary->name,
                'relationship'  => $thisbeneficiary->relationship,
                'Percent'   => $this->percentageOfIncomeGiven
            ];
    }

    public function removeBeneficiary(){
        echo "\n\e[0;32mPlease delete the beneficiary by the array Index, it must be the desired index(number)\e[0m\n";
        $nameIndex = readline("Please enter index of beneficiary to remove: ");
        $oldPercentGiven = $this->getTotalBeneficiaryExpensePercent();
        if (array_key_exists($nameIndex, $this->beneficiaryList))
        {
            $beneficiaryToDelete = $this->beneficiaryList[$nameIndex];
            $getPercent = $beneficiaryToDelete['Percent'];
            $this->totalBeneficiaryExpensePercent = ($oldPercentGiven -  $getPercent);
            unset($oldPercentGiven);
            unset($this->beneficiaryList[$nameIndex]);
            $this->beneficiaryList = array_values($this->beneficiaryList);
            print_r($this->beneficiaryList);
            echo 'Beneficiary Deleted Successfully'. PHP_EOL;
        }
        {
           return 'This beneficiary does not exist...';
        }
    }

    public function showBeneficiaries(){
        print_r($this->beneficiaryList);
    }

    public function getTotalPersonalExpensePercent(){
       return $this->totalPersonalExpensePercent;
    }

    public function getTotalBeneficiaryExpensePercent(){
        return $this->totalBeneficiaryExpensePercent;
    }

    public function getToTalPersonalExpense(){
        return $this->totalPersonalAmountSpent;
    }

    public function getToTalBeneficiaryExpense(){
        return $totalBeneficiaryAmountSpent;
    }

    public function getTotalAmountSpent(){
        return $this->totalPersonalAmountSpent + $this->totalBeneficiaryAmountSpent;
    }

    public function showPercentAmountSpent(){
        $totalPersonalExpensePercent = $this->getTotalPersonalExpensePercent();
        $totalBeneficiaryExpensePercent = $this->getTotalBeneficiaryExpensePercent();
        $result = $totalPersonalExpensePercent + $totalBeneficiaryExpensePercent;
        echo "\n\e[0;32mTotal Percentage of Income spent is: \e[0m" . $result. '%' .PHP_EOL;
        return $result;
    }

    public function showPercentAmountSaved(){
        $percentSaved = (100 - $this->showPercentAmountSpent());
        echo "\n\e[0;32mTotal Percentage of Income saved is: \e[0m" . $percentSaved . '%' . PHP_EOL;
        return $percentSaved;
    }

}