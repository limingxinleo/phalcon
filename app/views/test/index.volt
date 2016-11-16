{% extends "test/master.volt" %}
{% block content %}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h3>
                    模型
                </h3>
                <a type="button" class="btn btn-default" href="{{ url('/test/model/index') }}">基本用法</a>
                <a type="button" class="btn btn-default" href="{{ url('/test/model/add') }}">新增</a>
                <a type="button" class="btn btn-default" href="{{ url('/test/model/edit') }}">编辑</a>
                <a type="button" class="btn btn-default" href="{{ url('/test/model/hasMany') }}">HasMany</a>
                <a type="button" class="btn btn-default" href="{{ url('/test/model/sql') }}">DB类</a>
                <a type="button" class="btn btn-default" href="{{ url('/test/model/page?page=1') }}">分页</a>
            </div>
        </div>
    </div>
{% endblock %}