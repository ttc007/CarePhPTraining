<?php 
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class BlogsFixture extends TestFixture
{
    // Optional. Set this property to load fixtures to a different test datasource
    public $connection = 'test';

    public $import = ['model' => 'Blogs'];
    public $fields = [
          'id' => ['type' => 'integer'],
          'title' => ['type' => 'string', 'length' => 255, 'null' => false],
          'content' => 'text',
          '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
          ]
      ];
    public $records = [
        [
            'title' => 'First Article',
            'content' => 'First Article Body',
        ],
        [
            'title' => 'Second Article',
            'content' => 'Second Article Body',
        ],
        [
            'title' => 'Third Article',
            'content' => 'Third Article Body',
        ]
    ];
 

    public function init()
    {
        parent::init();
    }
}