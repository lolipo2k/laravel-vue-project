<template>
    <div class="card auth-card">
        <b-card-header>
            Авторизация
        </b-card-header>
        <b-card-body>
            <div class="alert alert-danger" v-if="error">
                <p>{{errors}}</p>
            </div>
            <form autocomplete="off" @submit.prevent="login" method="post">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" class="form-control" placeholder="user@example.com"
                           v-model="email"
                           required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" class="form-control" v-model="password" required>
                </div>

                <div class="text-center">
                    <b-button type="submit">Войти</b-button>
                </div>
                <div class="text-center" style="margin-top: 20px">
                    <a href="/reset">Забыли пароль?</a>
                </div>
                <div class="text-center my-2">
                    Еще нет аккаунта -
                    <router-link to="/register">нажмите сюда</router-link>
                    чтобы зарегистрироваться
                </div>
            </form>
        </b-card-body>
    </div>
</template>

<script>
    import {AUTH_LOGIN} from "../../back-routes";

    export default {
        name: "Login",
        data() {
            return {
                email: null,
                password: null,
                error: false,
                errors: ''
            }
        },
        methods: {
            login() {
                var app = this
                this.$auth.login({
                    // url: '/wfsa/faf/ad/',
                    params: {
                        email: app.email,
                        password: app.password
                    },
                    success: function () {
                        app.success = true
                        app.error = false;
                        app.$bus.$emit('userLogin');
                    },
                    error: function (resp) {
                        app.error = true;
                        app.errors = resp.response.data.msg;
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                });
            },
        }
    }
</script>

<style scoped>

</style>
