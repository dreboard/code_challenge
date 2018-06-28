<?php

namespace App\Core;


/**
 * Trait DataTrait
 * @package App\Core
 * @used-by Users::class
 * @used-by Data::class
 */
trait DataTrait
{
    /**
     * @var string $id_column The users id
     */
    protected $id_column = 'id';

    /**
     * @var string $amount_column Users initial amount
     */
    protected $amount_column = 'amount';

    /**
     * @var string $date_column
     */
    protected $date_column = 'date';

    /**
     * @var string $program_column Users program
     */
    protected $program_column = 'program';

}