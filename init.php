<?php
/*
 * Basic config file
 *
*/
error_reporting(E_ALL);
if($_SERVER['SERVER_NAME'] == 'localhost'){
    ini_set('display_errors', 0);
} else{
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', '/logs/error.log');
}

require_once __DIR__.'/vendor/autoload.php';

$users = new \App\Core\Users();
$transaction = new \App\Core\Data();
$display = [];
if(isset($_GET['m'])){
    try{
        $data = $users->getUserData();
        $month = htmlspecialchars($_GET['m'], ENT_QUOTES);
        $list = $transaction->getTransactions($month);
        foreach ($data as $mdaKey => $mdaData) {
            $display[$mdaKey] = [
                'id'            => $mdaKey,
                'initial'       => $mdaData["amount"],
                'program'       => $mdaData["program"],
                'transactions'  => $transaction->getUserActivity($list, $mdaKey),
                'deposits'      => $transaction->getUserDeposits($list, $mdaKey),
                'balance'       => $transaction->userBalance($mdaData["amount"], $list, $mdaKey),
                'fees'          => [
                    'fee_balance'   => $transaction->userBalanceOk($transaction->userBalance($mdaData["amount"], $list, $mdaKey), $mdaData["program"]),
                    'fee_trans'     => $transaction->userTransactionOk($transaction->getUserActivity($list, $mdaKey), $mdaData["program"]),
                    'fee_deposits'  => $transaction->userDespositsOk($transaction->getUserDeposits($list, $mdaKey), $mdaData["program"]),
                ],
            ];
        }
    }catch(\Throwable $e){
        error_log($e->getMessage());
    }
}





