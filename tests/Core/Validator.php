<?php

namespace Core;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UploadedFileInterface;

class ValidatorTest extends TestCase {

    public function makeValidator(array $params) {
        return new Validator($params);
    }

    public function testRequired () {
        $errors = $this
            ->makeValidator(['a' => 1, 'b' => ''])
            ->required('a', 'b', 'c')
            ->getErrors();
        $this->assertCount(2, $errors);
    }

    public function testValidDateTime () {
        $errors = $this
            ->makeValidator(['date' => '2012-12-12 00:00:00'])
            ->dateTime('date')
            ->getErrors();
        $this->assertCount(0, $errors);

        $errors = $this
            ->makeValidator(['date' => '2012-12-12 11:12:13'])
            ->dateTime('date')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    public function testInvalidDateTime () {
        $errors = $this
            ->makeValidator(['a' => '2014-21-31'])
            ->dateTime('a')
            ->getErrors();
        $this->assertCount(1, $errors);

        $errors = $this
            ->makeValidator(['a' => '2013-02-29 11:12:13'])
            ->dateTime('a')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    public function testMinLength () {
        $errors = $this
            ->makeValidator(['a' => '12'])
            ->minLength('a', 3)
            ->getErrors();
        $this->assertCount(1, $errors);
        $errors = $this
            ->makeValidator(['a' => '123'])
            ->minLength('a', 3)
            ->getErrors();
        $this->assertCount(0, $errors);
        $errors = $this
            ->makeValidator(['a' => '12☺'])
            ->minLength('a', 3)
            ->getErrors();
        $this->assertCount(0, $errors, 'Attention aux caractères unicode :)');
    }

    public function testSlug () {
        $errors = $this
            ->makeValidator(['a' => 'azezea-812-aezaez'])
            ->slug('a')
            ->getErrors();
        $this->assertCount(0, $errors);
        $errors = $this
            ->makeValidator(['a' => 'aze'])
            ->slug('a')
            ->getErrors();
        $this->assertCount(0, $errors);
        $errors = $this
            ->makeValidator([])
            ->slug('a')
            ->getErrors();
        $this->assertCount(1, $errors);
        $errors = $this
            ->makeValidator([
                'a' => 'Ajae',
                'b' => 'aze--azeeza',
                'c' => 'ée-azze'
            ])
            ->slug('a')
            ->slug('b')
            ->slug('c')
            ->getErrors();
        $this->assertCount(3, $errors);
    }

    public function testUploadedFileWithError () {
        $file = $this->getMockBuilder(UploadedFileInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();
        $file->method('getError')
            ->willReturn(UPLOAD_ERR_CANT_WRITE);

        $errors = $this->makeValidator(['a' => $file])
            ->uploaded('a')
            ->getErrors();
        $this->assertCount(1, $errors, 'Un fichier avec une erreur devrait déclencher une erreur');

        $errors = $this->makeValidator([])
            ->uploaded('a')
            ->getErrors();
        $this->assertCount(1, $errors, 'Un fichier non existant devrait déclencher une erreur');
    }

    public function testUploadedFile () {
        $file = $this->getMockBuilder(UploadedFileInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();
        $file->method('getError')
            ->willReturn(UPLOAD_ERR_OK);

        $errors = $this->makeValidator(['a' => $file])
            ->uploaded('a')
            ->getErrors();
        $this->assertCount(0, $errors, 'Un fichier valide devrait être accepté');
    }

    public function testFileExtensionWithErrors () {
        $file = $this->getMockBuilder(UploadedFileInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientFilename')->willReturn('demo.exe');
        $file->method('getClientMediaType')->willReturn('image/jpeg');

        $errors = $this->makeValidator(['a' => $file])
            ->extension('a', ['jpg'])
            ->getErrors();
        $this->assertCount(1, $errors, "L'extension devrait être vérifiée");

        $file->method('getClientFilename')->willReturn('demo.jpg');
        $file->method('getClientMediaType')->willReturn('executable/exe');

        $errors = $this->makeValidator(['a' => $file])
            ->extension('a', ['jpg'])
            ->getErrors();
        $this->assertCount(1, $errors, "L'extension devrait être vérifiée");
    }

    public function testFileExtension () {
        $file = $this->getMockBuilder(UploadedFileInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();
        $file->method('getError')->willReturn(UPLOAD_ERR_OK);
        $file->method('getClientFilename')->willReturn('DEMO.JPG');
        $file->method('getClientMediaType')->willReturn('image/jpeg');

        $errors = $this->makeValidator(['a' => $file])
            ->extension('a', ['jpg'])
            ->getErrors();
        $this->assertCount(0, $errors, "Un fichier valide devrait pouvoir être uploadé");
    }

}