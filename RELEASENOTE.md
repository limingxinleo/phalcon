# Release Note

## [Unreleased]
### Added
* 增加model层基类
* 解决phalcon新建model指定继承类时出现BUG的问题
* 增加工具目录
* 增加DB工具类
* 增加Redis工具类

### Changed
* 修改Controller基类为Controller.php
* 去除修改命名空间的脚本
 
### Fixed
* 解决phalcon新建model会删除文件上方use的类库 [devtools](https://github.com/limingxinleo/phalcon-devtools.git)

## [1.7.0]
### Added
* 增加Logics逻辑层
* 增加用于json返回的error控制器方法
* 增加cookies测试
* 默认开启cookies加密

### Changed
* 扩展Response返回，自定义错误码
* 修改系统服务为共享服务

## [1.6.14]
### Changed
* 修改部分语法规范
* 修改项目根目录BASE_PATH为ROOT_PATH
* 修改单元测试目录为TESTS_PATH
* 优化清除缓存数据脚本
* 修改文件注释规则

### Fixed
* 修改Redis缓存配置报错的BUG

## [1.6.10]
### Added
* 增加System\Init key 修改配置的数值
* 消息队列中，增加主线程操作数据的方法。但是不能实例化数据库类，会报mysql gone away错误。原因暂时不明。
* 增加WebSocket 抽象类
* System\Cron 脚本增加日志

### Changed
* 移动打包脚本配置到System\Package脚本中
* 删除limx\func 依赖
* 修改System\Clear 脚本为调用系统函数 Windows 为递归删除文件