<?php

/**
*
*/
class RequestTest extends PHPUnit_Framework_TestCase
{

    public function testGetRootSimple()
    {
        $server = array(
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('/', $request->getRoot());
    }

    public function testGetRootInsideFolder()
    {
        $server = array(
            'SCRIPT_NAME' => '/folder/index.php',
            'REQUEST_URI' => '/'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('/folder', $request->getRoot());
    }

    public function testGetPathSimple()
    {
        $server = array(
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('', $request->getPath());
    }

    public function testGetPathSimpleWithPath()
    {
        $server = array(
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/admin/'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('/admin', $request->getPath());
    }

    public function testGetPathSimpleWithPathWithoutSlash()
    {
        $server = array(
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/admin'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('/admin', $request->getPath());
    }

    public function testGetPathInsideFolder()
    {
        $server = array(
            'SCRIPT_NAME' => '/folder/index.php',
            'REQUEST_URI' => '/folder/'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('', $request->getPath());
    }

    public function testGetPathInsideFolderWithoutSlash()
    {
        $server = array(
            'SCRIPT_NAME' => '/folder/index.php',
            'REQUEST_URI' => '/folder'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('', $request->getPath());
    }

    public function testGetPathInsideFolderWithPath()
    {
        $server = array(
            'SCRIPT_NAME' => '/folder/index.php',
            'REQUEST_URI' => '/folder/admin/'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('/admin', $request->getPath());
    }

    public function testGetPathInsideFolderWithPathWithoutSlash()
    {
        $server = array(
            'SCRIPT_NAME' => '/folder/index.php',
            'REQUEST_URI' => '/folder/admin'
        );

        $request = new \Drumon\Request($server);

        $this->assertEquals('/admin', $request->getPath());
    }

    public function testGetMethodDelete()
    {
        $server = array(
            'REQUEST_METHOD' => 'POST'
        );

        $request = new \Drumon\Request($server, array(), array('_method'=>'DELETE'));

        $this->assertEquals('DELETE', $request->getMethod());
    }

    public function testGetMethodPut()
    {
        $server = array(
            'REQUEST_METHOD' => 'POST'
        );

        $request = new \Drumon\Request($server, array(), array('_method'=>'PUT'));

        $this->assertEquals('PUT', $request->getMethod());
    }

    public function testGetMethodRequestGetAndPutReturnGet()
    {
        $server = array(
            'REQUEST_METHOD' => 'GET'
        );

        $request = new \Drumon\Request($server, array(), array('_method'=>'PUT'));

        $this->assertEquals('GET', $request->getMethod());
    }

    public function testGetMethodRequestPost()
    {
        $server = array(
            'REQUEST_METHOD' => 'POST'
        );

        $request = new \Drumon\Request($server, array(), array());

        $this->assertEquals('POST', $request->getMethod());
    }

    public function testAddParams()
    {
        $request = new \Drumon\Request(array(), array('post' => 1), array());

        $request->addParams(array('category' => 'car'));

        $this->assertEquals(array('post'=>1, 'category' => 'car'), $request->params);
    }
}
