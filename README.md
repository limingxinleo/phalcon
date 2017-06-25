# phalcon-project
[![Total Downloads](https://poser.pugx.org/limingxinleo/phalcon-project/downloads)](https://packagist.org/packages/limingxinleo/phalcon-project)
[![Latest Stable Version](https://poser.pugx.org/limingxinleo/phalcon-project/v/stable)](https://packagist.org/packages/limingxinleo/phalcon-project)
[![Latest Unstable Version](https://poser.pugx.org/limingxinleo/phalcon-project/v/unstable)](https://packagist.org/packages/limingxinleo/phalcon-project)
[![License](https://poser.pugx.org/limingxinleo/phalcon-project/license)](https://packagist.org/packages/limingxinleo/phalcon-project)


[Phalcon 官网](https://docs.phalconphp.com/zh/latest/index.html)

## 安装方法
### 编译phalcon安装扩展
~~~
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install

vim etc/php.ini 
extension=phalcon.so
~~~

### Linux下Yum安装扩展
~~~
yum --enablerepo=remi install php70-php-phalcon3
~~~

### Mac下Homebrew安装扩展
~~~
brew install php70-phalcon
~~~

### 安装项目
* 利用composer安装
~~~
composer create-project limingxinleo/phalcon-project demo
~~~

* git clone 安装
~~~
git clone https://github.com/limingxinleo/simple-subcontrollers.phalcon.git
cd simple-subcontrollers.phalcon
composer install
mkdir .phalcon
cp .env.example .env
php run
~~~

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─app                   项目文件
│ ├─config              配置文件
│ │ ├─cli               cli服务配置目录
│ │ ├─web               web路由与服务配置目录
│ │ ├─services          自定义服务目录
│ │ └─loader.php        自动加载文件
│ ├─controllers         控制器目录
│ ├─library             第三方库目录
│ ├─listeners           监听事件目录
│ ├─models              模型目录
│ ├─tasks               任务目录
│ ├─traits              Trait目录
│ ├─utils               工具类库
│ └─views               视图目录
├─public                资源目录
│ ├─app                 项目资源目录
│ ├─lib                 第三方资源目录
│ ├─.htaccess           apache重写文件
│ └─index.php           入口文件
├─storage               项目写入仓库
│ ├─cache               项目缓存目录
│ │ ├─data              数据缓存目录
│ │ └─view              视图缓存目录
│ ├─log                 日志目录
│ ├─meta                模型元数据目录
│ └─migrations          数据库迁移目录
├─tests                 单元测试目录
├─vendor                第三方类库目录（Composer依赖库）
├─.env                  env支持配置文件
├─composer.json         composer定义文件
├─README.md             README文件
├─LICENSE               授权说明文件
└─run                   命令行入口文件
~~~

## phalcon工具脚本
[devtools](https://github.com/limingxinleo/phalcon-devtools.git)
> 如果想使用更加定制化的功能，比如在app/config/config.ini维护控制器的默认信息，请使用修改后的[devtools](https://github.com/limingxinleo/phalcon-devtools.git) dev分支。

## Web开发规范
调用方式
~~~
controller -> logic -> model -> db
task -> logic -> model -> db
~~~

## 消息队列
编辑app/tasks/TestTask.php
~~~
namespace App\Tasks;

use limx\phalcon\Redis;
use limx\phalcon\Cli\Color;

class TestTask extends \App\Tasks\System\QueueTask
{
    // 最大进程数
    protected $maxProcesses = 10;
    // 当前进程数
    protected $process = 0;
    // 消息队列Redis键值
    protected $queueKey = 'phalcon:test:queue';
    // 等待时间
    protected $waittime = 1;

    protected function redisClient()
    {
        return Redis::getInstance('127.0.0.1', '910123');
    }

    protected function redisChildClient()
    {
        return Redis::getInstance('127.0.0.1', '910123', 0, 6379, uniqid());
    }

    /**
     * @desc   子进程也能监听消息队列
     *         3秒内没有消息自动回收
     * @author limx
     * @param $data
     */
    protected function run($data)
    {
        $this->handle($data);
        $redis = $this->redisChildClient();
        while (true) {
            // 无任务时,阻塞等待
            $data = $redis->brpop($this->queueKey, 3);
            if (!$data) {
                break;
            }
            if ($data[0] != $this->queueKey) {
                // 消息队列KEY值不匹配
                continue;
            }
            if (isset($data[1])) {
                $this->handle($data[1]);
            }
        }
    }

    /**
     * @desc   消息队列处理逻辑
     * @author limx
     * @param $data
     */
    protected function handle($data)
    {
        echo Color::success($data);
    }
}
~~~

运行php run test即可启动消息队列
~~~
php run test
~~~

## 定时脚本 ##
~~~
crontab -e 
编辑增加 * * * * * /path/to/php /path/to/run System\\\\Cron >> /dev/null 2>&1
启动crond 服务
在config/app.php 中维护cron-tasks数组
~~~

## 注意事项 ##
* 利用phalcon脚本新建model时，使用phalcon model name --namespace=App\Models --extends=Model --force
* 【BUG】如果你model里用use加载了其他类库，当你使用官方phalcon工具脚本建立model的时候，会被删除掉。这里可以使用我修改的[devtools](https://github.com/limingxinleo/phalcon-devtools.git)
* 利用phalcon脚本新建controller时，使用phalcon controller name --namespace=App\Controllers\SubNamespace

* 使用模型进行信息存储时，因为模型元数据的问题，非空字段会匹配非空、非空字符串两个条件，致使一些空字符串字段不赋默认非空字符串值的情况下，保存失败！[cphalcon v3.0.4 已修改此BUG]
* 框架默认以文件的方式缓存元数据，一旦表结构被修改，请执行php run system\clear meta yes 清理元数据
* 在使用Model的Relation时，因为命名空间的问题，需要使用别名，例如 $this->hasMany("id", "App\\Models\\Book", "uid", ['alias' => 'book']);
* 控制器中 $this->request->url函数 (url助手函数) 生成的地址 会拼接config中的baseUri 故url('index') 会生成 /index。
* 控制器中 $this->response->redirect() 会根据当前模块跳转 故redirect('/index') 才会生成 /index。
* 默认的调度params是按照数组顺序进行对应的。
* 使用Cli时，因为Windows对大小写不敏感 可以用php run system\clear 但在Linux下 需要使用php run System\\\\Clear
* 使用Phalcon 开发工具的时候，需要维护config/config.ini配置文件
* 使用dispatch forward调度的时候，必须使用return截断控制器。要不然他会走后面的dispatch forward调度。如果使用exit截断，调度则不会执行。
* 使用任务php run test_test 会转化为 TestTestTask 但是使用php run Test\\test_test 会转化为Test\test_testTask
* 由于Phalcon内部redis引擎的问题，当auth=null时也会调用redis->auth()，故连不上redis服务器。所以暂时redis服务器不支持无密码（个人认为无密码是不对的！！），除非手动修改逻辑。[#12736](https://github.com/phalcon/cphalcon/issues/12736) [cphalcon v3.2.0 已修改此BUG]

* 当增加新路由规则时需要修改app/config/web/routes.php文件
* 当增加新的命名空间时需要修改app/config/loader.php自动加载文件
* app下的一级目录为小写，需要注册命名空间。二级目录为首字母大写，不需要注册命名空间。但命名空间必须与其对应。
* 因为phalcon扩展框架暂不支持mongoDB扩展，所以如果想使用mongoCollection，需要require phalcon/incubator。