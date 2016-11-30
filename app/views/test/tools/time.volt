{% extends "test/master.volt" %}
{% block content %}
    <link rel="stylesheet" href="{{ static_url('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form role="form" method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">TimeStamp</label>
                        <input type="number" class="form-control" name="timestamp" value="{{ time }}">
                        <input type="text" class="form-control" value="{{ res1|default(0) }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">DateTime</label>
                        <input type="text" class="form-control input-append date" name="datetime"
                               value="{{ datetime }}">
                        <input type="text" class="form-control" value="{{ res2|default(0) }}" readonly>

                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
{% endblock %}
{% block js %}
    <script src="{{ static_url('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('.date').datetimepicker();
    </script>
{% endblock %}