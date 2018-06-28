<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Core\Users;


/**
 * Class UserTest
 * @package App\Tests
 * @example php phpunit.phar --bootstrap ./vendor/autoload.php ./tests/UserTest
 */
class UserTest extends TestCase
{
    /** @var string */
    protected $app;

    protected function setUp()
    {
        $this->users = new Users();
    }

    public function testCanInstatiateUsers()
    {
        $this->assertInstanceOf(
            Users::class,
            $this->users
        );
    }

    /**
     *
     */
    public function testGetAllUsers()
    {
        $data = $this->users->getUserData();
        $this->assertArrayHasKey(154, $data);
        $this->assertTrue(count($data) === 0);
    }

}