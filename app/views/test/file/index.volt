{% extends "test/master.volt" %}
{% block content %}
    <div class="container">
        <form role="form">
            <div class="form-group">
                <label for="exampleInputEmail1">文件地址</label>
                <input type="text" class="form-control" id="path" readonly>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="file">
                <p class="help-block">Example block-level help text here.</p>
            </div>
            <input type="hidden" id="postUrl" value="{{ url('/test/file/upload') }}">
        </form>
    </div>
{% endblock %}
{% block js %}
    <script>
        $("#file").change(function () {
            dump(this);
            var reader = new FileReader;
            reader.readAsDataURL(this.files[0]);
            reader.onload = function (e) {
                dump(e);
                var json = {
                    "data": e.target.result
                };
                var url = $("#postUrl").val();
                $.post(url, json, function (jsonData) {
                    dump(jsonData);
                }, "json");
            };
        });
    </script>
{% endblock %}