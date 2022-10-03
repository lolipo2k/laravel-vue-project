<template>
    <div class="card auth-card">
        <b-card-header>
            Сброс пароля
        </b-card-header>
        <b-card-body>
            <div class="alert alert-danger" v-if="error">
                <p>{{errors}}</p>
            </div>
            <form autocomplete="off" @submit.prevent="reset" method="post">
                <div class="form-group">
                    <label for="email">Введите E-mail, указанный при регистрации</label>
                    <input type="email" id="email" class="form-control" placeholder="user@example.com"
                           v-model="email"
                           required>
                </div>

                <div class="text-center">
                    <b-button type="submit">Сбросить пароль</b-button>
                </div>

            </form>
            <div class="text-center buttons-container">
                <a href="/home/login">Вход</a> <a href="/home/register">Регистрация</a>
            </div>
        </b-card-body>
    </div>
</template>

<script>
    import {AUTH_RESET} from "../../back-routes";

    export default {
        name: "Reset",
        data() {
            return {
                email: null,
                password: null,
                error: false,
                errors: ''
            }
        },
        methods: {
            reset() {
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
.buttons-container{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 147px;
    margin: 0 auto;
    margin-top: 15px;
    margin-bottom: 10px;
}
</style>
