{% extends "test/mobile/sui.volt" %}
{% block content %}
    <header class="bar bar-nav">
        <h1 class='title'>微信开发（{{ name }}）</h1>
    </header>
    <div class="content">
        <div class="content-block">
            <p><a href="weixin:" class="button button-fill">打开微信</a></p>
        </div>
    </div>
{% endblock %}