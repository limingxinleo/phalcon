{% extends "test/master.volt" %}
{% block content %}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Width</label>
                        <input type="number" class="form-control" id="width" value="100">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Height</label>
                        <input type="number" class="form-control" id="height" value="100">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="file">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="col-md-4">
                <img id="pic" src="" alt="">
            </div>
        </div>
    </div>
{% endblock %}
{% block js %}
    <script>
        var file = $("#file");
        file.on("change", function (e) {
            var w = $("#width").val();
            var h = $("#height").val();
            CanvasCompress(e, w, h, function (data) {
                $("#pic").get(0).src = data;
            });
        });
    </script>
{% endblock %}