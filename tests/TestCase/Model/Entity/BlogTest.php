<?php
namespace App\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use App\Model\Entity\Blog;

class BlogTest extends TestCase
{
    public $fixtures = ['app.Blogs'];
    public $autoFixtures = false;

    public function testMyFunction()
    {
        $this->loadFixtures('Blogs');
    }
}