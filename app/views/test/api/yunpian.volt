{% extends "test/master.volt" %}
{% block content %}
    <div>
        <img src="{{ url('/test/api/captcha') }}" alt="">
    </div>
    <div>
        <input type="text" id="code">
        <a onclick="sub()">提交</a>
    </div>
{% endblock %}
{% block js %}
    <script>
        function sub() {
            var code = $("#code").val();
            $.post("{{ url('/test/api/sendMsg/') }}" + code, null, function (jsonData) {
                if (jsonData.status == 1) {
                    alert("请求成功");
                } else {
                    alert("发送失败");
                }
            }, "json");
        }
    </script>
{% endblock %}