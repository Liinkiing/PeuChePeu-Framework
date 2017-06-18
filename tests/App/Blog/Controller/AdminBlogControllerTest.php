<?php
class AdminBlogControllerTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var \App\Blog\Controller\AdminBlogController
     */
    private $controller;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->controller = $this->getMockBuilder(\App\Blog\Controller\AdminBlogController::class)
            ->disableOriginalConstructor()
            ->setMethods(['render', 'redirect', 'flash'])
            ->getMock();

        $this->table = $this->getMockBuilder(\App\Blog\Table\PostTable::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept([])
            ->getMock();

        parent::__construct($name, $data, $dataName);
    }

    public function makeRequest (array $params = []): \Psr\Http\Message\ServerRequestInterface {
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
            ->method('getMethod')
            ->willReturn('POST');
        return $mock;
    }

    public function testEditWithBadParams () {
        $this->controller->expects($this->once())
            ->method('render')
            ->with('@blog/admin/edit');

        $this->controller->edit(3, $this->table, $this->makeRequest(), new \Slim\Http\Response());
    }

    public function testEditWithGoodParams () {
        $this->controller->expects($this->once())
            ->method('redirect')
            ->with('blog.admin.index');

        $params = [
            'name' => 'Post title',
            'content' => 'Some fake content for test here it is it is a demonstration',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->controller->edit(3, $this->table, $this->makeRequest($params), new \Slim\Http\Response());
    }

}