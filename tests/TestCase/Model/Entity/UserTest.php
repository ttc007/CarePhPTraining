<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use App\Model\Entity\User;

class UserTest extends TestCase
{
    public function test_setPasswordNotNull()
    {
        $password = '123456';
        $passwordHash = User::_setPassword($password);
        
        $this->assertNotNull($passwordHash);
    }

    
}