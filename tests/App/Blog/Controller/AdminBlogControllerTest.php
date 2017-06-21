<?php
class AdminBlogControllerTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var \App\Blog\Controller\AdminBlogController
     */
    private $controller;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->uploader = $this->getMockBuilder(\App\Blog\PostUpload::class)
            ->disableOriginalConstructor()
            ->setMethods(['upload', 'delete'])
            ->getMock();

        $this->controller = $this->getMockBuilder(\App\Blog\Controller\AdminBlogController::class)
            ->disableOriginalConstructor()
            ->setMethods(['render', 'redirect', 'flash'])
            ->getMock();

        $this->table = $this->getMockBuilder(\App\Blog\PostTable::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();

        $this->entity = new \App\Blog\PostEntity();
        $this->entity->id = 2;
        $this->table->method('find')->willReturn($this->entity);

        parent::__construct($name, $data, $dataName);
    }

    public function makeRequest (array $params = [], array $files = []): \Psr\Http\Message\ServerRequestInterface {
        $mock = $this->getMockBuilder(\Slim\Http\Request::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();
        $mock
            ->expects($this->any())
            ->method('getParsedBody')
            ->willReturn($params);
        $mock
            ->expects($this->any())
            ->method('getUploadedFiles')
            ->willReturn($files);
        $mock
            ->expects($this->any())
            ->method('getMethod')
            ->willReturn('POST');
        return $mock;
    }

    public function makeFile () {
        return $this->getMockBuilder(\Slim\Http\UploadedFile::class)
            ->setConstructorArgs(['/tmp/demo.jpg', 'demo.jpg', 'image/jpeg', 2000])
            ->setMethodsExcept([])
            ->getMock();
    }

    public function testEditWithBadParams () {
        $this->controller->expects($this->once())
            ->method('render')
            ->with('@blog/admin/edit');

        $this->controller->edit(3, $this->table, $this->makeRequest(), $this->uploader);
    }

    public function testEditWithGoodParams () {
        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('blog.admin.index');

        $file = $this->makeFile();

        // Le fichier doit être uploadé
        $this->uploader
            ->expects($this->once())
            ->method('upload')
            ->with($file);

        // LA talbe doit être mis à jour
        $this->table->expects($this->once())
            ->method('update');

        $params = [
            'name' => 'Post title',
            'content' => 'Some fake content for test here it is it is a demonstration',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->controller->edit(3, $this->table, $this->makeRequest($params, ['image' => $file]), $this->uploader);
    }

}