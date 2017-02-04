# phalcon-project
[![Total Downloads](https://poser.pugx.org/limingxinleo/phalcon-project/downloads)](https://packagist.org/packages/limingxinleo/phalcon-project)
[![Latest Stable Version](https://poser.pugx.org/limingxinleo/phalcon-project/v/stable)](https://packagist.org/packages/limingxinleo/phalcon-project)
[![Latest Unstable Version](https://poser.pugx.org/limingxinleo/phalcon-project/v/unstable)](https://packagist.org/packages/limingxinleo/phalcon-project)
[![License](https://poser.pugx.org/limingxinleo/phalcon-project/license)](https://packagist.org/packages/limingxinleo/phalcon-project)


[Phalcon 官网](https://docs.phalconphp.com/zh/latest/index.html)

## 安装方法 ##
~~~
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install

vim etc/php.ini 
extension=phalcon.so

composer create-project limingxinleo/phalcon-project demo
~~~

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─app                   项目文件
│ ├─config              配置文件
│ ├─controllers         控制器目录
│ ├─library             第三方库目录
│ ├─models              模型目录
│ ├─services            自定义服务目录
│ ├─tasks               任务目录
│ ├─traits              Trait目录
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
├─run                   命令行入口文件
~~~
## 定时脚本 ##
* crontab -e 
* 编辑增加 * * * * * /path/to/php /path/to/run System\\\\Cron >> /dev/null 2>&1
* 启动crond 服务
* 在config/app.php 中维护cron-tasks数组

## 注意事项 ##
* 利用phalcon脚本新建model时，使用phalcon model name --namespace=MyApp\Models
* 利用phalcon脚本新建controller时，使用phalcon controller name --namespace=MyApp\Controllers\SubNamespace

* 使用模型进行信息存储时，因为模型元数据的问题，非空字段会匹配非空、非空字符串两个条件，致使一些空字符串字段不赋默认非空字符串值的情况下，保存失败！
* 框架默认以文件的方式缓存元数据，一旦表结构被修改，请执行php run system\clear meta yes 清理元数据
* 在使用Model的Relation时，因为命名空间的问题，需要使用别名，例如 $this->hasMany("id", "MyApp\\Models\\Book", "uid", ['alias' => 'book']);
* 控制器中 $this->request->url函数 (url助手函数) 生成的地址 会拼接config中的baseUri 故url('index') 会生成 /index。
* 控制器中 $this->response->redirect() 会根据当前模块跳转 故redirect('/index') 才会生成 /index。
* 默认的调度params是按照数组顺序进行对应的。
* 使用Cli时，因为Windows对大小写不敏感 可以用php run system\clear 但在Linux下 需要使用php run System\\\\Clear
* 使用Phalcon 开发工具的时候，需要维护config/config.ini配置文件
* 初始化脚本因为Windows和Linux使用Cli的区别，没办法同时兼容，暂时兼容Windows，Linux需要手动执行命令。
* 项目没有设置时区，所以对于8小时的误差，要么在项目中增加date_default_timezone_set(Asia/Shanghai)，要么在php.ini中修改date.timezone = Asia/Shanghai
* 使用dispatch forward调度的时候，必须使用return截断控制器。要不然他会走后面的dispatch forward调度。如果使用exit截断，调度则不会执行。
* 使用任务php run test_test 会转化为 TestTestTask 但是使用php run Test\\test_test 会转化为Test\test_testTask
