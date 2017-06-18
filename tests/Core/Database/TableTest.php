<?php
use Core\Database\Table;

class FakeTableTest extends Table {
    protected $table = "fake";
}

class TableTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var Mockable
     */
    private $database;

    public function setUp()
    {
        $this->database = $this->getMockBuilder(\Core\Database\Database::class)
            ->disableOriginalConstructor()
            ->setMethods(['query', 'fetch', 'lastInsertId'])
            ->getMock();

        $this->table = new FakeTableTest($this->database);
    }

    public function testUpdate () {
        $this->database
            ->expects($this->once())
            ->method('query')
            ->with(
                $this->equalTo('UPDATE fake SET a = :a, b = :b WHERE id = :id'),
                $this->equalTo(['a' => 'a', 'b' => 2, 'id' => 1])
            );

        $this->table->update(1, ['a' => 'a', 'b' => 2]);
    }

    public function testDelete () {
        $this->database
            ->expects($this->once())
            ->method('query')
            ->with(
                $this->equalTo('DELETE FROM fake WHERE id = ?'),
                $this->equalTo([2])
            );

        $this->table->delete(2);
    }

    public function testFind () {
        $this->database
            ->expects($this->once())
            ->method('fetch')
            ->with(
                $this->equalTo('SELECT * FROM fake WHERE id = ?'),
                $this->equalTo([2])
            )
            ->willReturn([]);

        $this->table->find(2);
    }

    public function testCreate () {
        $this->database
            ->expects($this->once())
            ->method('query')
            ->with(
                $this->equalTo('INSERT INTO fake SET a = :a, b = :b'),
                $this->equalTo(['a' => 'a', 'b' => 2])
            );

        $this->database
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(3);

        $id = $this->table->create(['a' => 'a', 'b' => 2]);
        $this->assertEquals(3, $id);
    }

}