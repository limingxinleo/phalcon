# Release Note

## [Unreleased]
### Checked
- [ ] php单元测试

### Added

### Changed

### Fixed
* 修改InstanceBase getInstance不能返回一个实例的BUG

### Deleted
* 删除Logic目录

## [2.0.7]
### Checked
- [x] php单元测试

### Added
* 增加路由group方法
* 增加系统环境变量
* 增加单例基类

### Changed
* 不使用系统方法 system删除缓存
* 完善消息队列失败时逻辑处理
* 修改异常捕获时，错误信息的格式
* 修改缓存基类位置

### Fixed

## [2.0.5]
### Checked
- [x] php单元测试

### Added
* Swoole Socket增加用户组
* Socket基类增加beforeServerStart方法
* 增加中间件支持

### Changed
* 重写Debug工具类
* 重构Mongo工具类
* 重构Mongo服务注入
* 修改limx\Support\Str工具类为Phalcon\Text工具类

### Fixed
* 修改中间件在php7.1下报错的BUG

## [2.0.0]
### Checked
- [x] php单元测试

### Added
* 增加x-console-color依赖
* 增加limingxinleo\support-str 依赖

### Changed
* 移动Queue Socket WebSocket 基类
* 删除success & error 助手方法 ！！
* 移除limingxinleo/phalcon-utils 依赖 ！！

### Fixed
* 修改定时脚本日志BUG

## [1.11.4]
### Checked
- [x] php单元测试

### Added
* 增加脚本描述字段
* 错误捕获
* 增加Swoole Socket
* 增加x-phalcon-logger依赖
* 增加x-phalcon-db依赖
* 增加Validator基类

### Changed
* 修改部分命名
* 修改XConsole依赖版本
* 调整目录结构
* 更换limx\phalcon\Redis为Xin\Redis

## [1.10.9]
### Checked
- [x] php单元测试

### Added
* 增加通用消息队列异常捕获机制
* 增加重载、清除异常消息脚本
* 增加XConsole依赖

### Changed
* 默认启动Redis服务
* 修改通用消息队列的KEY键
* 修改Redis服务，设置uniqid
* 修改默认消息队列，增加结果输出
* 重写Cli入口

## [1.10.5]
### Checked
- [x] php单元测试

### Added
* 增加部分模块的单元测试
* 新增通用消息队列 

### Changed
* 删除打包脚本
* 修改错误日志的存放文件名
* 修改静态文件的默认目录
* 修改消息队列基类、WebSocket基类的类名

### Fixed
* Fix 读取延时消息时，取不到延时脚本触发的Warning信息。

## [1.9.15]
### Checked
- [x] php单元测试

### Added
* 消息队列：增加子进程最大处理次数
* 增加Logger服务
* 模型保存验证错误事件

### Changed
* 重构Schedule定时服务
* 删除dump调试方法
* 重写Log工具类
* 重构DB监听服务

### Fixed
* Fix 模型基类 找不到静态方法时不报错的BUG

## [1.9.8]
### Checked
- [x] php单元测试

### Added
* 扩展DB工具类
* 增加工具类接口
* 增加路由目录，路由可以使用多文件进行定义
* 增加只修改某些字段的更新方法

### Changed
* 重写逻辑层FromCache模块 并增加相应单元测试
* 修改DB工具类继承LDB

### Fixed
* 修改调度器不生效的BUG
* Fix 服务容器不兼容php56的BUG

## [1.9.0]
### Checked
- [x] php单元测试

### Added
* 增加是否使用Mongo集合KEY键
* 增加是否使用Redis辅助类KEY键
* 增加Mongo集合支持 需要 phalcon/incubator

### Changed
* 修改依赖注入方式

## [1.8.7]
### Checked
- [x] php单元测试

### Added
* 新增逻辑基础类
* 增加模型元数据redis适配器
* 增加延时消息队列功能
* 增加incr和incrBy扩展方法 支持设置超时时间

### Changed
* 只为app下的一级小写目录增加命名空间注册
* app下小写目录下的文件夹都要首字母大写
* 消息队列修改为主进程管理队列任务，子进程可以循环执行消息
* 修改app()方法
* 修改Controller、Model、Task基类为抽象类

## [1.8.0]
### Checked
- [x] php单元测试

### Added
* 增加日志工具类
* 增加mongo工具类
* 增加Debug工具类
* 增加http接口访问的单元测试
* 增加Task任务脚本配置

### Changed
* 修改用于dispatcher转发 返回json错误的方法
* 修改入口文件

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