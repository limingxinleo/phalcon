<!DOCTYPE html>
<html>
<head>
    <title>Phalcon PHP Framework</title>
    <link rel="stylesheet" href="{{ static_url('lib/bootstrap-3.3.0/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ static_url('lib/bootstrap-3.3.0/css/bootstrap-theme.min.css') }}">
</head>
<body>
{% block content %}{% endblock %}
{{ partial("test/footer") }}
<script src="{{ static_url('lib/jquery-1.12.4/jquery.min.js') }}"></script>
<script src="{{ static_url('lib/bootstrap-3.3.0/js/bootstrap.min.js') }}"></script>
<script src="{{ static_url('lib/xjs/xjs.js') }}"></script>
{% block js %}{% endblock %}
</body>
</html>