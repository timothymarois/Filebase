<?php 
namespace Filebase\Test;

use org\bovigo\vfs\vfsStream;
use Filebase\{Database,Table,Query};
use Filebase\Test\TestCase;
class QueryTest extends TestCase
{
    public $db;
    public $query;

    public function setUp()
    {
        parent::setUp();

        $this->db=new Database([
            'path' => $this->path
            ]);
        $this->query=new Query(new Table($this->db,'tbl_one'));
    }
    /**
     * @test
     */
    public function testMustReturnTable()
    {
        $tbl=$this->query->getTable();
        $this->assertInstanceOf(Table::class,$tbl);
    }
    /**
     * @test
     */
    public function testMustReturnInstanceOfDatabase()
    {
        $db=$this->query->getDatabase();
        $this->assertInstanceOf(Database::class,$db);
    }
    /**
     * @test
     */
    public function testMustInsertNewRecordOnTable()
    {

        // check create
        $this->query->create(['name'=>'John','last_name'=>'Doe']);
        $this->assertFileExists($this->path."/tbl_one/0.json");

        $this->query->create(['name'=>'John','last_name'=>'Doe']);
        $this->assertFileExists($this->path."/tbl_one/1.json");

        // check file have data
        $this->assertJsonStringEqualsJsonFile(
            $this->path."/tbl_one/1.json", json_encode(['name'=>'John','last_name'=>'Doe'])
        );
    }
    /** @test */
    public function testMustReturnDbRecordWithId()
    {
        $this->query->create(['name'=>'John','last_name'=>'Doe']);
        $record=$this->query->find(0);

        $this->assertEquals(['name'=>'John','last_name'=>'Doe'],$record);
    }
    /** @test */
    public function testMustReturnInstanceOfCollection()
    {
        // Test
    }
    
    
}