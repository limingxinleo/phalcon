{% extends "master.volt" %}
{% block content %}
    <h1>Congratulations!</h1>

    <p>You're now flying with Phalcon. Great things are about to happen!</p>

    <p>You're using limingxinleo\phalcon-project {{ version }}</p>

    <p><img src="{{ static_url('app/images/logo.png') }}" alt=""></p>
{% endblock %}
