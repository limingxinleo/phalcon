<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/mint-ui/lib/style.css">
</head>
<body>
<div id="app">
    <mt-header title="标题过长会隐藏后面的内容啊哈哈哈哈">
        <router-link to="/" slot="left">
            <mt-button icon="back">返回</mt-button>
        </router-link>
        <mt-button icon="more" slot="right"></mt-button>
    </mt-header>
    <mt-button @click.native="handleClick">按钮</mt-button>
</div>
</body>
<!-- 先引入 Vue -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- 引入组件库 -->
<script src="https://unpkg.com/mint-ui/lib/index.js"></script>
<script>
    new Vue({
        el: '#app',
        methods: {
            handleClick: function () {
                this.$toast('Hello world!')
            }
        }
    });
    Vue.$toast("ffff");
    //Vue.$indicator.open('加载中...');
</script>
</html>