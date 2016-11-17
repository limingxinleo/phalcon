{% extends "master.volt" %}
{% block content %}
    {%- macro sex(id) %}
        {% return id==1?"男":"女" %}
    {%- endmacro %}
    <div>
        {{ url('/test/index/getParams',['a':1,'b':'aaa']) }}
    </div>
    <div>
        {{ static_url('/app/images/limx.jpg') }}
    </div>
    <div>{{ app }}</div>
    <div>{{ app2 }}</div>
    <div>{{ dump([1,2,3]) }}</div>
    <div>{{ sex(2) }}</div>
{% endblock %}