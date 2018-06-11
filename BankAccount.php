<?php

interface Account
{
    public function saveCash($amount);
}

abstract class BankAccount implements Account
{
    protected $balance; //encapsulation

    public function __construct($name, $balance)
    {
        $this->balance = $balance;
        $this->name = $name;
    }

    public abstract function getBalance();

    function withdrawCash($amount) 
    {
        if ($this->balance > $amount) {
            $this->balance -= $amount;
            return $amount;
        }
        return 'You do not have enough balance';
    }
    
    //polymorphism
    public function saveCash($amount) 
    {
         $this->balance = $amount + $this->balance; 
         return $this->balance;
    }

}

//Inheritance
class SavingsAccount extends BankAccount
{
    public function getBalance() {
        return $this->balance;
    }

    function __call($method_name, $parameter) 
    {
        $count = count($parameter);
        if ($method_name === 'takeLoan') {
            switch($count) {
            case 0:
                return "You are not eligble for loan.\n";
            case 1: 
                return 'You have '.$parameter[0]. ' cash loan';
            default:
                throw new exception('Bad argument');
            }
        };
        throw new exception("Function $method_name doesn't exists");
    }
}

$savings = new SavingsAccount('hamdalah', 10000);
echo $savings->getBalance();
echo "\n";
echo $savings->WithdrawCash(500);
echo "\n";
try {
     echo $savings->takeLoan(1000)."\n";
} catch (Exception $e) { 
    echo $e->getMessage();
}
echo "\n";
