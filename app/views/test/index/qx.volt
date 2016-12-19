{% extends "test/master.volt" %}
{% block content %}
    <a type="button" class="btn btn-default" onclick="sub(1)">成功返回</a>
    <a type="button" class="btn btn-default" onclick="sub(2)">返回失败Ajax</a>
    <a type="button" class="btn btn-default" href="{{ url('/test/index/qx2') }}">返回失败Url</a>
{% endblock %}
{% block js %}
    <script>
        console.log(1);
        function sub(id) {
            var json = {
                "data": "11"
            };
            $.post("/test/index/qx" + id, json, function (jsonData) {
                if (jsonData.status == 1) {
                    alert('success');
                } else {
                    alert('error');
                }
            }, "json");
        }

    </script>
{% endblock %}