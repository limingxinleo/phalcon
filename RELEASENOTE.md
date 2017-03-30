# Release Note For 1.6.*

## [Unreleased]
### Added
* 增加Logics逻辑层
* 增加用于json返回的error控制器方法

### Changed
* 扩展Response返回，自定义错误码

### Fixed

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