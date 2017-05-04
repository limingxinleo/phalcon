# Release Note

## [Unreleased]
### Checked
- [ ] php单元测试

### Added
* 增加日志工具类
* 增加mongo工具类
* 增加Debug工具类
* 增加http接口访问的单元测试

### Changed
* 修改用于dispatcher转发 返回json错误的方法
* 修改入口文件

### Fixed

## [1.7.8]
### Checked
- [x] php单元测试

### Added
* 增加mongodb配置
* 增加mongodb缓存适配器【phalcon底层不支持php7 mongo扩展】
* 数据库SQL语句监听日志，增加绑定参数记录
* 增加缓存工具类
* 增加devtools控制器配置
* 增加devtools模型配置
* 增加Info系统脚本
* 增加控制器注释列表获取方法

## [1.7.3]
### Added
* 增加model层基类
* 增加工具目录
* 增加DB工具类
* 增加Redis工具类

### Changed
* 修改Controller基类为Controller.php
* 【严重】修改项目命名空间MyApp->App
* 去除修改命名空间的脚本
 
### Fixed
* 解决phalcon新建model指定继承类时出现BUG的问题
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