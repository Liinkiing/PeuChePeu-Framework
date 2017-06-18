<?php
class PostValidatorTest extends \PHPUnit\Framework\TestCase {

    public function testWithoutData () {
        $validator = new \App\Blog\Validator\PostValidator([]);
        $this->assertFalse($validator->validates());
    }

    public function testWithSmallData () {
        $validator = new \App\Blog\Validator\PostValidator([
            'name' => 'fake content',
            'content' => 'fake',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $this->assertFalse($validator->validates());
    }

    public function testWithInvalidDate () {
        $validator = new \App\Blog\Validator\PostValidator([
            'name' => 'fake content',
            'content' => 'another fake content but long enought',
            'created_at' => 'Helllo'
        ]);
        $this->assertFalse($validator->validates());
    }

    public function testWithGoodData () {
        $validator = new \App\Blog\Validator\PostValidator([
            'name' => 'fake content',
            'content' => 'another fake content but long enought',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $this->assertTrue($validator->validates(), print_r($validator->errors, true));
    }

}