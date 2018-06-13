<?php
// +----------------------------------------------------------------------
// | SwooleRequest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Http\Request;

use limx\Support\Str;
use Phalcon\Http\RequestInterface;
use Phalcon\Di\InjectionAwareInterface;
use swoole_http_request;

class SwooleRequest implements RequestInterface, InjectionAwareInterface
{
    protected $_dependencyInjector;

    protected $_httpMethodParameterOverride = false;

    protected $headers;

    protected $server;

    protected $get;

    protected $post;

    protected $cookies;

    protected $files;

    protected $swooleRequest;

    public function init(swoole_http_request $request)
    {
        $this->swooleRequest = $request;
        foreach ($request->header as $key => $val) {
            $key = strtoupper(str_replace(['-'], '_', $key));
            $this->headers[$key] = $val;
        }
        foreach ($request->server as $key => $val) {
            $key = strtoupper(str_replace(['-'], '_', $key));
            $this->server[$key] = $val;
        }
        $this->get = $request->get;
        $this->post = $request->post;
        $this->cookies = $request->cookie;
        $this->files = $request->files;
    }

    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getDI()
    {
        return $this->_dependencyInjector;
    }

    public function get($name = null, $filters = null, $defaultValue = null)
    {
        if (isset($this->get[$name])) {
            return $this->get[$name];
        }
        return $defaultValue;
    }

    public function getPost($name = null, $filters = null, $defaultValue = null)
    {
        // TODO: Implement getPost() method.
    }

    public function getRequest($name = null, $filters = null, $defaultValue = null)
    {
        $value = $this->get($name, $filters, null);
        if (null !== $value) {
            return $value;
        }

        $value = $this->getPost($name, $filters, null);
        if (null !== $value) {
            return $value;
        }

        return $defaultValue;
    }

    public function getQuery($name = null, $filters = null, $defaultValue = null)
    {
        // TODO: Implement getQuery() method.
    }

    public function getServer($name)
    {
        if (isset($this->server[$name])) {
            return $this->server[$name];
        }
        return null;
    }

    public function has($name)
    {
        // TODO: Implement has() method.
    }

    public function hasPost($name)
    {
        // TODO: Implement hasPost() method.
    }

    public function hasPut($name)
    {
        // TODO: Implement hasPut() method.
    }

    public function hasQuery($name)
    {
        // TODO: Implement hasQuery() method.
    }

    public function hasServer($name)
    {
        // TODO: Implement hasServer() method.
    }

    public function getHeader($header)
    {
        // TODO: Implement getHeader() method.
    }

    public function getScheme()
    {
        // TODO: Implement getScheme() method.
    }

    public function isAjax()
    {
        // TODO: Implement isAjax() method.
    }

    public function isSoapRequested()
    {
        // TODO: Implement isSoapRequested() method.
    }

    public function isSecureRequest()
    {
        // TODO: Implement isSecureRequest() method.
    }

    public function getRawBody()
    {
        // TODO: Implement getRawBody() method.
    }

    public function getServerAddress()
    {
        // TODO: Implement getServerAddress() method.
    }

    public function getServerName()
    {
        // TODO: Implement getServerName() method.
    }

    public function getHttpHost()
    {
        // TODO: Implement getHttpHost() method.
    }

    public function getPort()
    {
        // TODO: Implement getPort() method.
    }

    public function getClientAddress($trustForwardedHeader = false)
    {
        // TODO: Implement getClientAddress() method.
    }

    public function getMethod()
    {
        $returnMethod = $this->getServer('REQUEST_METHOD');
        if (!isset($returnMethod)) {
            return 'GET';
        }

        $returnMethod = strtoupper($returnMethod);
        if ($returnMethod === 'POST') {
            $overridedMethod = $this->getHeader('X-HTTP-METHOD-OVERRIDE');
            if (!empty($overridedMethod)) {
                $returnMethod = strtoupper($overridedMethod);
            } elseif ($this->_httpMethodParameterOverride) {
                if ($spoofedMethod = $this->getRequest('_method')) {
                    $returnMethod = strtoupper($spoofedMethod);
                }
            }
        }

        if (!$this->isValidHttpMethod($returnMethod)) {
            return "GET";
        }

        return $returnMethod;
    }

    public function getUserAgent()
    {
        // TODO: Implement getUserAgent() method.
    }

    public function isMethod($methods, $strict = false)
    {
        // TODO: Implement isMethod() method.
    }

    public function isPost()
    {
        return $this->getMethod() === "POST";
    }

    public function isGet()
    {
        // TODO: Implement isGet() method.
    }

    public function isPut()
    {
        // TODO: Implement isPut() method.
    }

    public function isHead()
    {
        // TODO: Implement isHead() method.
    }

    public function isDelete()
    {
        // TODO: Implement isDelete() method.
    }

    public function isOptions()
    {
        // TODO: Implement isOptions() method.
    }

    public function isPurge()
    {
        // TODO: Implement isPurge() method.
    }

    public function isTrace()
    {
        // TODO: Implement isTrace() method.
    }

    public function isConnect()
    {
        // TODO: Implement isConnect() method.
    }

    public function hasFiles($onlySuccessful = false)
    {
        // TODO: Implement hasFiles() method.
    }

    public function getUploadedFiles($onlySuccessful = false)
    {
        // TODO: Implement getUploadedFiles() method.
    }

    public function getHTTPReferer()
    {
        // TODO: Implement getHTTPReferer() method.
    }

    public function getAcceptableContent()
    {
        // TODO: Implement getAcceptableContent() method.
    }

    public function getBestAccept()
    {
        // TODO: Implement getBestAccept() method.
    }

    public function getClientCharsets()
    {
        // TODO: Implement getClientCharsets() method.
    }

    public function getBestCharset()
    {
        // TODO: Implement getBestCharset() method.
    }

    public function getLanguages()
    {
        // TODO: Implement getLanguages() method.
    }

    public function getBestLanguage()
    {
        // TODO: Implement getBestLanguage() method.
    }

    public function getBasicAuth()
    {
        // TODO: Implement getBasicAuth() method.
    }

    public function getDigestAuth()
    {
        // TODO: Implement getDigestAuth() method.
    }

    /**
     * Checks if a method is a valid HTTP method
     */
    public function isValidHttpMethod($method)
    {
        switch (strtoupper($method)) {
            case "GET":
            case "POST":
            case "PUT":
            case "DELETE":
            case "HEAD":
            case "OPTIONS":
            case "PATCH":
            case "PURGE": // Squid and Varnish support
            case "TRACE":
            case "CONNECT":
                return true;
        }

        return false;
    }
}