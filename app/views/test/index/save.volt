{% extends "master.volt" %}
{% block content %}
    <input type="text" value="{{ name }}" id="name">
    <a onclick="sub()">修改</a>
    <script>
        function sub() {
            var json = {
                "name": $("#name").val()
            };
            $.post('/test/index/postSave', json, function (jsonData) {
                dump(jsonData);
            }, "json");
        }
    </script>
{% endblock %}