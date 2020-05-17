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
        $this->percentageOfIncomeSpent = ($this->expense->amountSpent * 100)/($this->getMonthlyIncome());
        $this->totalPersonalAmountSpent += $this->expense->amountSpent;
        if($this->getTotalAmountSpent() < $this->getMinimumAmountToSave()){
            $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
            $this->expenseList[] = $this->getExpense();
            print_r($this->expenseList);
            $this->showPercentAmountSpent();
            echo 'New expense created successfully' . PHP_EOL;
            if(!array_key_exists($this->expense->expenseCategory, $this->expenseGroupList)){
                $this->expenseGroupList[] = $this->expense->expenseCategory;
            }
        }
        else if($this->getTotalAmountSpent() > $this->getMinimumAmountToSave()){
             echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
             $this->$totalPersonalExpensePercent -= $this->percentageOfIncomeSpent;
             $delete[] = $this->getExpense();
             unset($delete);
             $this->showPercentAmountSpent();
             echo 'This expense is not created as you have exceeded the savings limit!!!'. PHP_EOL;
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
        $oldPercentSpent = $this->getTotalPersonalExpensePercent();
        if (array_key_exists($expenseIndex, $this->expenseList))
        {
            $expenseToUpdate = $this->expenseList[$expenseIndex];
            $getPercent = $expenseToUpdate[$expenseCategory]['Percent'];
            if(array_key_exists($expenseIndex, $this->expenseList)){
                $this->totalPersonalExpensePercent = ($oldPercentSpent -  $getPercent);
                $this->expense->expenseCategory= readline("Enter expense category: ");
                $this->expense->title =  readline("Enter the title of your expense: ");
                $this->expense->benefactor = readline("Enter where the expense was made: ");
                $this->expense->amountSpent = intval(readline("Enter amount of income spent: "));
                $this->percentageOfIncomeSpent = ($this->expense->amountSpent * 100)/($this->getMonthlyIncome());
                $this->totalPersonalAmountSpent += $this->expense->amountSpent;
                if($this->getTotalAmountSpent() < $this->getMinimumAmountToSave()){
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
                    $this->showPercentAmountSpent();
                }
                else{
                    echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
                    $this->$totalPersonalExpensePercent -= $this->percentageOfIncomeSpent;
                    $delete[] = $this->getExpense();
                    unset($delete);
                    $this->showPercentAmountSpent();
                    echo 'This expense is not updated as you have exceeded the savings limit!!!'. PHP_EOL;
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
            unset($this->expenseList[$expenseIndex]);
            $this->expenseList = array_values($this->expenseList);
            print_r($this->expenseList);
            echo 'Expense Deleted Successfully'. PHP_EOL;
            $this->showPercentAmountSpent();
        }
        else
        {
          return 'This expense does not exist...' . PHP_EOL;
        }
    }

    public function showAllExpenses(){
        print_r($this->expenseList);
        $this->showPercentAmountSpent();
    }

    public function createBeneficiary(){
        $this->beneficiary->name = readline("Enter beneficiary name: ");
        $this->beneficiary->relationship = readline("Enter relationship with beneficiary: ");
        $this->beneficiary->amountGiven = intval(readline("Enter amount given to beneficiary: "));
        $this->percentageOfIncomeGiven = ($this->beneficiary->amountGiven * 100)/($this->getMonthlyIncome());
        $this->totalBeneficiaryAmountGiven +=$this->beneficiary->amountGiven;
        if($this->getTotalAmountSpent() < $this->getMinimumAmountToSave()){
            $this->totalBeneficiaryExpensePercent +=  $this->percentageOfIncomeGiven;
            $this->beneficiaryList[] = $this->getBeneficiary();
            print_r($this->beneficiaryList); 
            $this->showPercentAmountSpent();
        }
        else{
            echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
            $this->totalBeneficiaryExpensePercent -= $this->percentageOfIncomeGiven;
            $delete[] = $this->getBeneficiary();
            unset($delete);
            $this->showPercentAmountSpent();
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
            unset($this->beneficiaryList[$nameIndex]);
            $this->beneficiaryList = array_values($this->beneficiaryList);
            print_r($this->beneficiaryList);
            echo 'Beneficiary Deleted Successfully'. PHP_EOL;
            $this->showPercentAmountSpent();
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
        echo "\n\e[0;32mTotal Percentage of Income spent is: \e[0m" . $result. '%' .PHP_EOL;
    }

    public function showPercentAmountSaved(){
        $percentSaved = (100 - $this->getTotalPercentSpent());
        echo "\n\e[0;32mTotal Percentage of Income saved is: \e[0m" . $percentSaved . '%' . PHP_EOL;
    }

}