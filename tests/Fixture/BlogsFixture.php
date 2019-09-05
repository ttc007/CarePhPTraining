<?php 
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogsFixture extends TestFixture
{
    public $import = ['table' => 'blogs'];
    public $records = [
        [
          'title' => 'First Article',
          'content' => 'First Article Body',
          'user_id' => '1',
          'image' => null
        ],
        [
          'title' => 'Second Article',
          'content' => 'Second Article Body',
          'user_id' => '1',
          'image' => null
        ],
        [
          'title' => 'Third Article',
          'content' => 'Third Article Body',
          'user_id' => '1',
          'image' => null
        ]
    ];
}