{% extends "test/master.volt" %}
{% block content %}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">文本</label>
                        <textarea class="form-control" rows="3" id="text"></textarea>
                    </div>
                    <a onclick="sub()" class="btn btn-default">Submit</a>
                </form>
            </div>
            <div class="col-md-4">
                <input type="hidden" id="url" value="{{ url('test/tools/showCode2') }}">
                <img id="pic" src="{{ url('test/tools/showCode2') }}" alt="">
            </div>
        </div>
    </div>
{% endblock %}
{% block js %}
    <script>
        function sub() {
            var url = $("#url").val();
            var text = $("#text").val();
            $("#pic").get(0).src = url + "?text=" + text;
        }
    </script>
{% endblock %}