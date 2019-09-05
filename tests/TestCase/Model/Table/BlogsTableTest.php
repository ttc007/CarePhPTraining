<?php 
	namespace App\Test\TestCase\Model\Table;

	use App\Model\Table\BlogsTable;
	use Cake\ORM\TableRegistry;
	use Cake\TestSuite\TestCase;

	class ArticlesTableTest extends TestCase
	{
	    public $fixtures = ['app.Blogs'];

	    public function setUp()
	    {
	        parent::setUp();
	        $this->Blogs = TableRegistry::getTableLocator()->get('Blogs');
	    }

	    public function testFindPublished()
	    {
	        $query = $this->Blogs->findById(1);
	        $this->assertInstanceOf('Cake\ORM\Query', $query);
	        $result = $query->enableHydration(false)->toArray();
	        $expected = ['id' => 1, 'title' => 'First Article'];

	        $this->assertEquals($expected, $result);
	    }
	}