<template>
    <div class="container">
        <img src="/image/logo.png">
        <NuxtLink to="/register">新規登録</NuxtLink>
        <NuxtLink to="/login">ログイン</NuxtLink>
        <Nuxt />
    </div>
</template>

<style scoped>
    .container{
        background-color: #223344;
    }
    img{
        height: 40px;
        padding: 20px;
    }
    a{
        float: right;
        color: #fff;
        margin:30px;
        text-decoration: none;
    }
</style>