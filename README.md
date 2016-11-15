# simple-subcontrollers.phalcon
[![Total Downloads](https://poser.pugx.org/limingxinleo/phalcon-project-ss/downloads)](https://packagist.org/packages/limingxinleo/phalcon-project-ss)
[![Latest Stable Version](https://poser.pugx.org/limingxinleo/phalcon-project-ss/v/stable)](https://packagist.org/packages/limingxinleo/phalcon-project-ss)
[![Latest Unstable Version](https://poser.pugx.org/limingxinleo/phalcon-project-ss/v/unstable)](https://packagist.org/packages/limingxinleo/phalcon-project-ss)
[![License](https://poser.pugx.org/limingxinleo/phalcon-project-ss/license)](https://packagist.org/packages/limingxinleo/phalcon-project-ss)
simple-subcontrollers 多级控制器的phalcon项目结构

[Phalcon 官网](https://docs.phalconphp.com/zh/latest/index.html)

## 安装方法 ##
~~~
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install

vim etc/php.ini 
extension=phalcon.so

composer create-project limingxinleo/phalcon-project-ss demo
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
│ └─migrations          数据库迁移目录
├─vendor                第三方类库目录（Composer依赖库）
├─.env                  env支持配置文件
├─composer.json         composer定义文件
├─README.md             README文件
├─LICENSE               授权说明文件
├─run                   命令行入口文件
~~~

## 注意事项 ##
* 利用phalcon脚本新建model时，使用phalcon model name --namespace=MyApp\Models
* 利用phalcon脚本新建controller时，使用phalcon controller name --namespace=MyApp\Controllers\SubNamespace


