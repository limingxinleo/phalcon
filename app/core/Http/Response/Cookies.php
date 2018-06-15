<?php
// +----------------------------------------------------------------------
// | Cookies.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Http\Response;

use Phalcon\DiInterface;
use Phalcon\Http\Response\Cookies as BaseCookies;
use App\Core\Http\Cookie\SwooleCookie;

class Cookies extends BaseCookies
{
    protected $cookies;

    public function setSwooleCookies($cookies)
    {
        $this->cookies = $cookies;
        $this->_cookies = [];
    }

    /**
     * Gets all cookies from the bag
     */
    public function getCookies()
    {
        return $this->_cookies;
    }

    /**
     * Gets a cookie from the bag
     */
    public function get($name)
    {
        /**
         * Gets cookie from the cookies service. They will be sent with response.
         */
        if (isset($this->_cookies[$name])) {
            return $this->_cookies[$name];
        }

        $value = isset($this->cookies[$name]) ? $this->cookies[$name] : null;

        /**
         * Create the cookie if the it does not exist.
         * It's value come from $_COOKIE with request, so it shouldn't be saved
         * to _cookies property, otherwise it will always be resent after get.
         */
        $cookie = $this->_dependencyInjector->get(SwooleCookie::class, [$name, $value]);
        $dependencyInjector = $this->_dependencyInjector;

        if ($dependencyInjector instanceof DiInterface) {

            /**
             * Pass the DI to created cookies
             */
            $cookie->setDi($dependencyInjector);

            $encryption = $this->_useEncryption;

            /**
             * Enable encryption in the cookie
             */
            if ($encryption) {
                $cookie->useEncryption($encryption);
                $cookie->setSignKey($this->signKey);
            }
        }

        return $cookie;
    }
}