<!DOCTYPE html>
<html>
<head>
    <title>Phalcon PHP Framework</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
</head>
<body>
{% block content %}{% endblock %}
{{ partial("test/footer") }}
<script src="//cdn.lmx0536.cn/xjs/jquery/jquery-1.12.4.min.js"></script>
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdn.lmx0536.cn/xjs/xjs.js"></script>
{% block js %}{% endblock %}
</body>
</html>