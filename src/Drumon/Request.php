<?php
namespace Drumon;

/**
* Router
*/
class Request
{
    private $server = NULL;
    private $method = NULL;
    public $params = array();

    public function __construct($server, $get_params = null, $post_params = null)
    {
        if (is_null($get_params) && isset($_GET)) {
            $get_params = $_GET;
        } else {
            $get_params = $get_params ? $get_params : array();
        }

        if (is_null($post_params) && isset($_POST)) {
            $post_params = $_POST;
        } else {
            $post_params = $post_params ? $post_params : array();
        }

        $this->server = $server;
        $this->params = array_merge($get_params, $post_params);
    }

    public function getRoot()
    {
        return dirname($this->server['SCRIPT_NAME']);
    }

    public function getPath()
    {
        $root = $this->getRoot();
        $path = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);

        if ($root !== '/') {
            $path = str_replace($root, '', $path);
        }

        return rtrim($path, '/');
    }

    public function getMethod()
    {
        $method = strtoupper($this->server['REQUEST_METHOD']);

        if ($method === 'POST' && isset($this->params['_method']) && in_array(strtoupper($this->params['_method']), array('PUT','DELETE','PACTH'))) {
            return strtoupper($this->params['_method']);
        }

        return strtoupper($this->server['REQUEST_METHOD']);
    }

    public function addParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }
}
