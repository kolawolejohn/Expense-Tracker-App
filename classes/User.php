<?php
require_once "require/readline.php";
class User
{
    private $monthlyIncome;
    private $minimumPercentageToSave;
    private $minimumAmountToSave;
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
        return $minimumAmountToSave;
    }

    public function getMinimumPercentageToSave(){
        $this->$minimumPercentageToSave = ($this->minimumAmountToSave * 100)/($this->getMonthlyIncome()); 
        return $this->$minimumPercentageToSave;
    }

    public function createExpenseGroup(){
        $newExpenseCategory = readline("Enter new category: ");
        $this->expenseGroupList[] = $newExpenseCategory;
        return 'Expense group created successfully' . PHP_EOL;
    }

    public function updateExpenseGroup(){
        $newExpenseCategory = readline("Enter new category: ");
        $this->expenseGroupList[] = $newExpenseCategory;
        print_r(array_unique($this->expenseGroupList));
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
            $this->percentageOfIncomeSpent = ($this->expense->amountSpent * 100)/($this->monthlyIncome);
            $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
            if($this->showPercentAmountSpent() < $this->getMinimumPercentageToSave() && $this->showPercentAmountSpent() < $this->monthlyIncome){
                $this->expenseList[] = $this->getExpense();
                echo 'New expense created successfully' . PHP_EOL;
                if(!array_key_exists($this->expense->expenseCategory, $this->expenseGroupList)){
                    $this->expenseGroupList[] = $this->expense->expenseCategory;
                }
            }
             else{
                    echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
                    $delete[] = $this->getExpense();
                    unset($delete);
                    return 'This expense was not created as you exceeded the savings Limit!!!' . PHP_EOL;
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
        $this->expense->expenseCategory= readline("Enter expense category: ");
        $this->expense->title =  readline("Enter the title of your expense: ");
        $this->expense->benefactor = readline("Enter where the expense was made: ");
        $this->expense->amountSpent = intval(readline("Enter amount of income spent: "));
        $this->percentageOfIncomeSpent = ($this->expense->amountSpent * 100)/($this->monthlyIncome);
        $this->totalPersonalExpensePercent += $this->percentageOfIncomeSpent;
        $this->expenseList[] = $this->getExpense();
        if($this->showPercentAmountSpent() < $this->getMinimumPercentageToSave() && $this->showPercentAmountSpent() < $this->monthlyIncome){
            $this->expenseGroupList[] = $this->expense->expenseCategory;
            print_r($this->expenseList); 
        }
         else{
            echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
            $delete[] = $this->getExpense();
            unset($delete);
            return 'This expense was not updated as you exceeded the savings Limit!!!' . PHP_EOL;
        }
    }

    public function deleteExpense(){
        echo "\n\e[0;32mPlease delete the expense by the array Index, it must be a number\e[0m\n";
        $expenseIndex= readline("Please index of expense category to remove: ");
        if (array_key_exists($expenseIndex, $this->expenseList))
        {
            $this->expenseList = array_diff_key($this->expenseList,  array_flip((array) [$expenseIndex]));
            print_r($this->expenseList);
            return 'Expense Deleted Sussessfully' . PHP_EOL;
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
        $this->totalBeneficiaryExpensePercent +=  $this->percentageOfIncomeGiven;
        if($this->showPercentAmountSpent() < $this->getMinimumPercentageToSave() && $this->showPercentAmountSpent() < $this->monthlyIncome){
            $this->beneficiaryList[] = $this->getBeneficiary();
            print_r($this->beneficiaryList); 
        }
        else{
            echo "\n\e[0;32mYou have exceeded savings Limit!!!\e[0m" .PHP_EOL;
            $delete[] = $this->getBeneficiary();
            unset($delete);
            return 'This beneficiary was not updated as you exceeded the savings Limit!!!' . PHP_EOL;
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
        $nameIndex = readline("Please enter name of beneficiary to remove: ");
        if (array_key_exists( $nameIndex, $this->beneficiaryList))
        {
            $this->beneficiaryList = array_diff_key($this->beneficiaryList,  array_flip((array) [$nameIndex]));
            print_r($this->beneficiaryList);
            return $this->beneficiaryList;
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

    public function showPercentAmountSpent(){
        $totalPersonalExpensePercent = $this->getTotalPersonalExpensePercent();
        $totalBeneficiaryExpensePercent = $this->getTotalBeneficiaryExpensePercent();
        $result = $totalPersonalExpensePercent + $totalBeneficiaryExpensePercent;
        echo "\n\e[0;32mTotal Percentage of Income spent is: \e[0m" . $result . '%' .PHP_EOL;
        return $result;

    }

    public function showPercentAmountSaved(){
        $percentSaved = (100 - $this->showPercentAmountSpent());
        echo  "\n\e[0;32mTotal Percentage of Income saved is: \e[0m" . $percentSaved . '%' . PHP_EOL;
        return $percentSaved;
    }

}