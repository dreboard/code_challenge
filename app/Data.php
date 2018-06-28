<?php

namespace App\Core;

use SplFileObject;
use LimitIterator;

/**
 * Class Data
 *
 * Get all user data to include balances, transactions and fees assessed.
 * @package App\Core
 * @uses DataTrait for additional properties
 */
class Data
{
    use DataTrait;

    /**
     * int Users program number 1
     */
    const PROGRAM1 = 1;

    /**
     * int Users program number 2
     */
    const PROGRAM2 = 2;

    /**
     *
     */
    const DEFAULT_VALUE = 0;

    /**
     * @var array $dataFiles
     */
    protected $dataFiles = [
        'Jan' => __DIR__ . "/../data/Jan.csv",
        'Feb' => __DIR__ . "/../data/Feb.csv",
        'Mar' => __DIR__ . "/../data/Mar.csv"
    ];

    /**
     * @var array $transactions
     */
    protected $deposits = [
        self::PROGRAM1 => 300,
        self::PROGRAM2 => 800
    ];
    /**
     * @var array $transactions
     */
    protected $transactions = [
        self::PROGRAM1 => 5,
        self::PROGRAM2 => 1
    ];

    /**
     * @var array $balance The minimum balance.
     */
    protected $balance = [
        self::PROGRAM1 => 1200,
        self::PROGRAM2 => 5000
    ];

    /**
     * @var array $penalty The penalty dollar amount
     */
    protected $penalty = [
        self::PROGRAM1 => 8,
        self::PROGRAM2 => 4
    ];

    /**
     * Get users monthly activity
     *
     * @param string $month Month of year to get data for
     * @return array|int Summary of monthly activity
     */
    public function getTransactions(string $month):array
    {
        try {
            $summary = new SplFileObject($this->dataFiles[$month]);
            $summary->setFlags(SplFileObject::READ_CSV);
            $summary = new LimitIterator($summary, 1);
            $allData = [];
            foreach ($summary as $row) {
                list($date, $id, $amount) = $row;
                $allData[] = [$this->date_column => $date, $this->id_column => (int)$id, $this->amount_column => $amount];
            }
            return $allData;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /**
     * Number of user transactions
     *
     * @param array $data User data array
     * @param int $id users id
     * @return int Amount of activity
     */
    public function getUserActivity(array $data, int $id):int
    {
        try {
            $data = array_replace($data, array_fill_keys(array_keys($data, null), self::DEFAULT_VALUE));
            $ids = array_column($data, $this->id_column);
            $counts = array_count_values($ids);
            if (in_array($id, $ids)) {
                return $counts[$id];
            }
            return self::DEFAULT_VALUE;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }

    /**
     * Number of user deposits
     *
     * @param array $data User data array
     * @param int $id Users id
     * @return int Number of deposits
     */
    public function getUserDeposits(array $data, int $id): int
    {
        try {
            $total = self::DEFAULT_VALUE;
            foreach ($data as $row) {
                if ($row[$this->id_column] == $id) {
                    $total += $row[$this->amount_column] > self::DEFAULT_VALUE ? $row[$this->amount_column] : self::DEFAULT_VALUE;
                }
            }
            return $total;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }

    /**
     * Get users current balance
     *
     * @param int $initial Initial account balance
     * @param array $data User data array
     * @param int $id Users id
     * @return int Current balance
     * @todo correct month to month
     */
    public function userBalance(int $initial, array $data, int $id): int
    {
        try {
            foreach ($data as $row) {
                if ($row[$this->id_column] == $id) {
                    $initial += $row[$this->amount_column];
                }
            }
            return $initial;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }


    /**
     * Set fee charged if balance is under required amount
     *
     * @param int $balance Current dollar balance
     * @param int $program Users program number
     * @return int Fee based off of minimum
     */
    public function userBalanceOk(int $balance, int $program):int
    {
        try {
            if($balance >= $this->balance[$program]){
                return self::DEFAULT_VALUE;
            }
            return $this->penalty[$program];
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }

    /**
     * Check transactions for fee assessed
     *
     * @param int $transaction Total transactions
     * @param int $program Users program
     * @return int Fee based off of minimum
     */
    public function userTransactionOk(int $transaction, int $program): int
    {
        try {
            if($transaction >= $this->transactions[$program]){
                return self::DEFAULT_VALUE;
            }
            return $this->penalty[$program];

        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }

    /**
     * Check deposits for fee assessed
     *
     * @param int $deposits Total deposits
     * @param int $program Users program
     * @return int Fee based off of minimum
     */
    public function userDespositsOk(int $deposits, int $program): int
    {
        try {
            if($deposits >= $this->deposits[$program]){
                return self::DEFAULT_VALUE;
            }
            return $this->penalty[$program];

        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }
    /**
     * Get fees assessed for user
     *
     * @param int $program
     * @param int $id
     * @return int
     */
    public function userFee(int $program, int $id): int
    {
        try {
            return self::DEFAULT_VALUE;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            return self::DEFAULT_VALUE;
        }
    }
}