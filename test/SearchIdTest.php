<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Fuse\Fuse;

class SearchIdTest extends TestCase
{
    protected static $fuse;

    public static function setUpBeforeClass()
    {
        static::$fuse = new Fuse([[
            'ISBN' => 'A',
            'title' => "Old Man's War",
            'author' => 'John Scalzi'
        ], [
            'ISBN' => 'B',
            'title' => 'The Lock Artist',
            'author' => 'Steve Hamilton'
        ]], [
            'keys' => ['title', 'author'],
            'id' => 'ISBN',
        ]);
    }

    // When searching for the author tag "Stve"...
    public function testSearchStve()
    {
        $result = static::$fuse->search('Stve');

        // ...we get a list containing 1 item...
        $this->assertCount(1, $result);

        // ...whose value is the ISBN of the book.
        $this->assertInternalType('string', $result[0]);
        $this->assertEquals('B', $result[0]);
    }
}
