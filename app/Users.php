<?php
namespace App\Core;

use SplFileObject;

/**
 * Class Users
 * @package App\Core
 * @uses DataTrait for additional properties
 */
class Users
{
    use DataTrait;

    /**
     * @var string $userFile Path to user data
     */
    protected $userFile = __DIR__."/../files/StartingData.csv";

    /**
     * Class constructor
     */
    public function _construct(){}

    /**
     * Get all user data
     *
     * @return array Initial user data array
     */
    public function getUserData():array
    {
        try{
            $file = new SplFileObject($this->userFile);
            $file->setFlags(SplFileObject::READ_CSV);
            $file = new \LimitIterator($file, 1);
            $allUsers = [];
            foreach ($file as $row) {
                list($id, $amount, $program) = $row;
                $allUsers[(int)$id] = [$this->amount_column => $amount, $this->program_column => $program];
            }
            array_pop($allUsers);
            return $allUsers;
        }catch(\Throwable $e){
            error_log($e->getMessage());
            return [];
        }
    }

}