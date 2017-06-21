<?php
use App\Blog\Validator\PostValidator;

class PostValidatorTest extends \PHPUnit\Framework\TestCase {

    public function testWithoutData () {
        $this->assertCount(3, PostValidator::validates([]));
    }

    public function testWithSmallData () {
        $this->assertCount(1, PostValidator::validates([
            'name' => 'fake content',
            'content' => 'fake',
            'created_at' => date('Y-m-d H:i:s')
        ]));
    }

    public function testWithInvalidDate () {
        $this->assertCount(1, PostValidator::validates([
            'name' => 'fake content',
            'content' => 'another fake content but long enought',
            'created_at' => 'Helllo'
        ]));
    }

    public function testWithGoodData () {
        $this->assertCount(0, PostValidator::validates([
            'name' => 'fake content',
            'content' => 'another fake content but long enought',
            'created_at' => date('Y-m-d H:i:s')
        ]));
    }

    public function testWithoutFile () {
        $this->assertCount(1, PostValidator::validates([
            'name' => 'fake content',
            'content' => 'another fake content but long enought',
            'created_at' => date('Y-m-d H:i:s'),
        ], true));
    }

    public function testWithFile () {
        $file = $this->getMockBuilder(\Slim\Http\UploadedFile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertCount(0, PostValidator::validates([
            'name' => 'fake content',
            'content' => 'another fake content but long enought',
            'created_at' => date('Y-m-d H:i:s'),
            'image' => $file
        ], true));
    }

}