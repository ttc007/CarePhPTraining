<?php 
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BlogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BlogsTableTest extends TestCase
{
    public $fixtures = ['app.Blogs'];

    public function setUp()
    {
        parent::setUp();
     	$config = TableRegistry::exists('Blogs') ? [] : ['className' => 'App\Model\Table\BlogsTable'];
        $this->Blogs = TableRegistry::get('Blogs', $config);
    }

    public function testFindPublished()
    {
        $blog = $this->Blogs->findById(1)->firstOrFail()->toArray();
        $expected = [
          'id' => 1,
          'title' => 'First Article',
          'content' => 'First Article Body',
          'user_id' => 1,
          'image' => null
        ];

        $this->assertEquals($expected, $blog);
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);
        parent::tearDown();
    }
}