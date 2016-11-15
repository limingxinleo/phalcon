{% extends "master.volt" %}
{% block content %}
    <div>
        {{ url('/test/index/getParams',['a':1,'b':'aaa']) }}
    </div>
{% endblock %}