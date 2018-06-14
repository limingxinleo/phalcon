<?php
// +----------------------------------------------------------------------
// | SwooleRequest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Http\Request;

use Phalcon\DiInterface;
use Phalcon\FilterInterface;
use Phalcon\Http\RequestInterface;
use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Http\Request\File;
use swoole_http_request;
use Exception;

class SwooleRequest implements RequestInterface, InjectionAwareInterface
{
    protected $_dependencyInjector;

    protected $_httpMethodParameterOverride = false;

    protected $_filter;

    protected $_putCache;

    protected $_strictHostCheck = false;

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
        $this->headers = [];
        $this->server = [];
        $this->get = isset($request->get) ? $request->get : [];
        $this->post = isset($request->post) ? $request->post : [];
        $this->cookies = isset($request->cookie) ? $request->cookie : [];
        $this->files = isset($request->files) ? $request->files : [];
        $this->_rawBody = $request->rawContent();

        foreach ($request->header as $key => $val) {
            $key = strtoupper(str_replace(['-'], '_', $key));
            $this->headers[$key] = $val;
        }
        foreach ($request->server as $key => $val) {
            $key = strtoupper(str_replace(['-'], '_', $key));
            $this->server[$key] = $val;
        }
    }

    public function setDI(DiInterface $dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getDI()
    {
        return $this->_dependencyInjector;
    }

    public function get($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        $source = array_merge($this->get, $this->post);
        return $this->getHelper($source, $name, $filters, $defaultValue, $notAllowEmpty, $noRecursive);
    }

    public function getPost($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        $source = $this->post;
        return $this->getHelper($source, $name, $filters, $defaultValue, $notAllowEmpty, $noRecursive);
    }

    public function getQuery($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        $source = $this->get;
        return $this->getHelper($source, $name, $filters, $defaultValue, $notAllowEmpty, $noRecursive);
    }

    public function getServer($name)
    {
        $name = strtoupper(str_replace(['-'], '_', $name));
        if (isset($this->server[$name])) {
            return $this->server[$name];
        }
        return null;
    }

    public function getPut($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        $put = $this->_putCache;

        if (empty($put)) {
            parse_str($this->getRawBody(), $put);
            $this->_putCache = $put;
        }

        return $this->getHelper($put, $name, $filters, $defaultValue, $notAllowEmpty, $noRecursive);
    }

    public function has($name)
    {
        $source = array_merge($this->get, $this->post);
        return isset($source[$name]);
    }

    public function hasPost($name)
    {
        return isset($this->post[$name]);
    }

    public function hasPut($name)
    {
        $put = $this->getPut();

        return isset ($put[$name]);
    }

    public function hasQuery($name)
    {
        return isset($this->get[$name]);
    }

    public function hasServer($name)
    {
        $name = strtoupper(str_replace(['-'], '_', $name));

        return isset($this->server[$name]);
    }

    public function hasHeader($header)
    {
        if ($this->hasServer($header)) {
            return true;
        }
        if ($this->hasServer('HTTP_' . $header)) {
            return true;
        }
        return false;
    }

    public function getHeader($header)
    {
        $header = $this->getServer($header);
        if (isset($header)) {
            return $header;
        }

        $header = $this->getServer('HTTP_' . $header);
        if (isset($header)) {
            return $header;
        }

        return '';
    }

    public function getScheme()
    {
        $https = $this->getServer('HTTPS');
        if ($https && $https != 'off') {
            return 'https';
        }

        return 'http';
    }

    public function isAjax()
    {
        return $this->getServer('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }

    public function isSoap()
    {
        if ($this->hasServer('HTTP_SOAPACTION')) {
            return true;
        }

        $contentType = $this->getContentType();
        if (!empty($contentType)) {
            return memstr($contentType, 'application/soap+xml');
        }

        return false;
    }

    public function isSoapRequested()
    {
        return $this->isSoap();
    }

    public function isSecure()
    {
        return $this->getScheme() === 'https';
    }

    public function isSecureRequest()
    {
        return $this->isSecure();
    }

    public function getRawBody()
    {
        return $this->_rawBody;
    }

    public function getServerAddress()
    {
        $serverAddr = $this->getServer('SERVER_ADDR');
        if ($serverAddr) {
            return $serverAddr;
        }

        return gethostbyname("localhost");
    }

    public function getServerName()
    {
        $serverName = $this->getServer('SERVER_NAME');
        if ($serverName) {
            return $serverName;
        }

        return "localhost";
    }

    public function getHttpHost()
    {
        $strict = $this->_strictHostCheck;

        /**
         * Get the server name from $_SERVER["HTTP_HOST"]
         */
        $host = $this->getServer("HTTP_HOST");
        if (!$host) {
            /**
             * Get the server name from $_SERVER["SERVER_NAME"]
             */
            $host = $this->getServer("SERVER_NAME");
            if (!host) {
                /**
                 * Get the server address from $_SERVER["SERVER_ADDR"]
                 */
                $host = $this->getServer("SERVER_ADDR");
            }
        }

        if ($host && $strict) {
            /**
             * Cleanup. Force lowercase as per RFC 952/2181
             */
            $host = strtolower(trim($host));
            if (memstr(host, ":")) {
                $host = preg_replace("/:[[:digit:]]+$/", "", $host);
            }

            /**
             * Host may contain only the ASCII letters 'a' through 'z' (in a case-insensitive manner),
             * the digits '0' through '9', and the hyphen ('-') as per RFC 952/2181
             */
            if ("" !== preg_replace("/[a-z0-9-]+\.?/", "", $host)) {
                throw new \UnexpectedValueException("Invalid host " . host);
            }
        }

        return (string)host;
    }

    /**
     * Sets if the `Request::getHttpHost` method must be use strict validation of host name or not
     */
    public function setStrictHostCheck($flag = true)
    {
        $this->_strictHostCheck = $flag;

        return $this;
    }

    /**
     * Checks if the `Request::getHttpHost` method will be use strict validation of host name or not
     */
    public function isStrictHostCheck()
    {
        return $this->_strictHostCheck;
    }

    public function getPort()
    {
        /**
         * Get the server name from $_SERVER["HTTP_HOST"]
         */
        $host = $this->getServer("HTTP_HOST");
        if ($host) {
            if (memstr($host, ":")) {
                $pos = strrpos($host, ":");

                if (false !== $pos) {
                    return (int)substr($host, $pos + 1);
                }

                return "https" === $this->getScheme() ? 443 : 80;
            }
        }
        return (int)$this->getServer("SERVER_PORT");
    }

    /**
     * Gets HTTP URI which request has been made
     */
    public function getURI()
    {
        $requestURI = $this->getServer('REQUEST_URI');
        if ($requestURI) {
            return $requestURI;
        }

        return '';
    }

    public function getClientAddress($trustForwardedHeader = false)
    {
        $address = null;

        /**
         * Proxies uses this IP
         */
        if ($trustForwardedHeader) {
            $address = $this->getServer('HTTP_X_FORWARDED_FOR');
            if ($address === null) {
                $address = $this->getServer('HTTP_CLIENT_IP');
            }
        }

        if (address === null) {
            $address = $this->getServer('REMOTE_ADDR');
        }

        if (is_string($address)) {
            if (memstr($address, ",")) {
                /**
                 * The client address has multiples parts, only return the first part
                 */
                return explode(",", address)[0];
            }
            return $address;
        }

        return false;
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
                if ($spoofedMethod = $this->get('_method')) {
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
        $userAgent = $this->getServer('HTTP_USER_AGENT');
        if ($userAgent) {
            return $userAgent;
        }
        return '';
    }

    public function isMethod($methods, $strict = false)
    {
        $httpMethod = $this->getMethod();

        if (is_string($methods)) {

            if ($strict && !$this->isValidHttpMethod(methods)) {
                throw new Exception("Invalid HTTP method: " . methods);
            }
            return $methods == $httpMethod;
        }

        if (is_array($methods)) {
            foreach ($methods as $method) {
                if ($this->isMethod($method, $strict)) {
                    return true;
                }
            }

            return false;
        }

        if ($strict) {
            throw new Exception("Invalid HTTP method: non-string");
        }

        return false;
    }

    public function isPost()
    {
        return $this->getMethod() === "POST";
    }

    public function isGet()
    {
        return $this->getMethod() === 'GET';
    }

    public function isPut()
    {
        return $this->getMethod() === 'PUT';
    }

    public function isPatch()
    {
        return $this->getMethod() === "PATCH";
    }

    public function isHead()
    {
        return $this->getMethod() === 'HEAD';
    }

    public function isDelete()
    {
        return $this->getMethod() === "DELETE";
    }

    public function isOptions()
    {
        return $this->getMethod() === "OPTIONS";
    }

    public function isPurge()
    {
        return $this->getMethod() === "PURGE";
    }

    public function isTrace()
    {
        return $this->getMethod() === "TRACE";
    }

    public function isConnect()
    {
        return $this->getMethod() === "CONNECT";
    }

    public function hasFiles($onlySuccessful = false)
    {
        $numberFiles = 0;

        $files = $this->files;

        if (empty($files)) {
            return $numberFiles;
        }

        foreach ($files as $file) {
            $error = $file['error'];
            if ($error) {
                if (!is_array($error)) {
                    if (!$error || !$onlySuccessful) {
                        $numberFiles++;
                    }
                } else {
                    $numberFiles += $this->hasFileHelper($error, $onlySuccessful);
                }
            }
        }

        return $numberFiles;
    }

    /**
     * Recursively counts file in an array of files
     */
    protected function hasFileHelper($data, $onlySuccessful)
    {
        $numberFiles = 0;

        if (!is_array($data)) {
            return 1;
        }

        foreach ($data as $value) {
            if (!is_array($value)) {
                if (!$value || !$onlySuccessful) {
                    $numberFiles++;
                }
            } else {
                $numberFiles += $this->hasFileHelper($value, $onlySuccessful);
            }
        }

        return numberFiles;
    }

    public function getUploadedFiles($onlySuccessful = false)
    {
        $files = [];

        $superFiles = $this->files;

        if (count($superFiles) > 0) {

            foreach ($superFiles as $prefix => $input) {
                if (is_array(!input["name"])) {
                    $smoothInput = $this->smoothFiles(
                        $input["name"],
                        $input["type"],
                        $input["tmp_name"],
                        $input["size"],
                        $input["error"],
                        $prefix
                    );

                    foreach ($smoothInput as $file) {
                        if ($onlySuccessful == false || $file["error"] == UPLOAD_ERR_OK) {
                            $dataFile = [
                                "name" => $file["name"],
                                "type" => $file["type"],
                                "tmp_name" => $file["tmp_name"],
                                "size" => $file["size"],
                                "error" => $file["error"]
                            ];

                            $files[] = new File($dataFile, $file["key"]);
                        }
                    }
                } else {
                    if ($onlySuccessful == false || $input["error"] == UPLOAD_ERR_OK) {
                        $files[] = new File($input, $prefix);
                    }
                }
            }
        }

        return $files;
    }

    /**
     * Smooth out $_FILES to have plain array with all files uploaded
     */
    protected function smoothFiles($names, $types, $tmp_names, $sizes, $errors, $prefix)
    {
        $files = [];

        foreach ($names as $idx => $name) {
            $p = $prefix . "." . $idx;

            if (is_string($name)) {

                $files[] = [
                    "name" => $name,
                    "type" => $types[$idx],
                    "tmp_name" => $tmp_names[$idx],
                    "size" => $sizes[$idx],
                    "error" => $errors[$idx],
                    "key" => $p
                ];
            }

            if (is_array($name)) {
                $parentFiles = $this->smoothFiles(
                    $names[$idx],
                    $types[$idx],
                    $tmp_names[$idx],
                    $sizes[$idx],
                    $errors[$idx],
                    $p
                );

                foreach ($parentFiles as $file) {
                    $files[] = $file;
                }
            }
        }

        return files;
    }

    public function getServers()
    {
        return $this->server;
    }

    public function getHeaders()
    {

        $headers = [];
        $contentHeaders = ["CONTENT_TYPE" => true, "CONTENT_LENGTH" => true, "CONTENT_MD5" => true];

        $servers = $this->getServers();
        foreach ($servers as $name => $value) {
            if (starts_with($name, 'HTTP_')) {
                $name = ucwords(strtolower(str_replace("_", " ", substr($name, 5))));
                $name = str_replace(" ", "-", $name);
                $headers[$name] = $value;
            }

            $name = strtoupper($name);
            if (isset($contentHeaders[$name])) {
                $name = ucwords(strtolower(str_replace("_", " ", $name)));
                $name = str_replace(" ", "-", $name);
                $headers[$name] = $value;
            }
        }

        $authHeaders = $this->resolveAuthorizationHeaders();

        // Protect for future (child classes) changes
        if (is_array($authHeaders)) {
            $headers = array_merge($headers, $authHeaders);
        }

        return $headers;
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

    /**
     * Helper to get data from superglobals, applying filters if needed.
     * If no parameters are given the superglobal is returned.
     */
    protected function getHelper($source, $name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        if ($name === null) {
            return $source;
        }

        if (!isset($source[$name])) {
            return $defaultValue;
        }

        $value = $source[$name];

        if ($filters !== null) {
            $filter = $this->_filter;
            if (!$filter instanceof FilterInterface) {
                $dependencyInjector = $this->_dependencyInjector;
                if (!$dependencyInjector instanceof DiInterface) {
                    throw new  Exception("A dependency injection object is required to access the 'filter' service");
                }

                $filter = $dependencyInjector->getShared('filter');
                $this->_filter = $filter;
            }

            $value = $filter->sanitize($value, $filters, $noRecursive);
        }

        if (empty($value) && $notAllowEmpty === true) {
            return $defaultValue;
        }

        return $value;
    }

    /**
     * Gets content type which request has been made
     */
    public function getContentType()
    {
        $contentType = $this->getHeader('CONTENT_TYPE');
        if ($contentType) {
            return $contentType;
        }

        return null;
    }
}