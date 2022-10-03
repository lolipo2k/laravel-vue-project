<template>
    <div class="card auth-card">
        <b-card-header>
            Регистрация
        </b-card-header>
        <b-card-body>
            <div class="alert alert-danger" v-if="error && !success">
                <p>Не удается завершить регистрацию т.к. есть ошибки в заполнении формы</p>
            </div>
            <div class="alert alert-success" v-if="success">
                <p>Регистрация завершена
<!--                    теперь вы можете-->
<!--                    <router-link :to="{name:'login'}">авторизоваться в кабинете.</router-link>-->
                </p>
            </div>
            <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
                <div class="form-group" v-bind:class="{ 'has-error': error && errors.role }">
                    <label for="name"></label>
                    <b-form-radio-group
                        id="btn-roles"
                        v-model="role"
                        :options="roles"
                        buttons
                        name="role"
                    ></b-form-radio-group>
                    <span class="help-block" v-if="error && errors.role">{{ errors.role }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                    <label for="name">Имя</label>
                    <input type="text" id="name" class="form-control" v-model="name" required>
                    <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && errors.last_name }">
                    <label for="last_name">Фамилия</label>
                    <input type="text" id="last_name" class="form-control" v-model="last_name" required>
                    <span class="help-block" v-if="error && errors.last_name">{{ errors.last_name }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email"
                           required>
                    <span class="help-block" v-if="error && errors.email">{{ errors.email }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && errors.phone }">
                    <label for="email">Телефон</label>
                    <input type="tel" id="phone" class="form-control" placeholder="+79876543210" v-model="phone"
                           required>
                    <span class="help-block" v-if="error && errors.phone">{{ errors.phone }}</span>
                </div>
                <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" class="form-control" v-model="password" required>
                    <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
                </div>
                <div class="">
                    <b-form-checkbox
                        style="margin-bottom: 10px"
                        id="checkbox-1"
                        v-model="termsAgree"
                        name="checkbox-1"
                        value="accepted"
                        unchecked-value="not_accepted"
                    >
                       <template v-if="role == 'client'">Я принимаю <a target="_blank" href="/policy">политику в отношении обработки персональных данных</a> и
                           <a target="_blank" href="/terms">пользовательское соглашение</a> </template>
                       <template v-else>Я принимаю <a target="_blank" href="/policy">политику в отношении обработки персональных данных</a> и
                           <a target="_blank" href="/terms">пользовательское соглашение</a></template>
                    </b-form-checkbox>

                </div>
                <div class="">
                    <b-form-checkbox
                        style="margin-bottom: 10px"
                        id="checkbox-2"
                        v-model="ageAgree"
                        name="checkbox-2"
                        value="accepted"
                        unchecked-value="not_accepted"
                    >
                        <template>Я подтверждаю что мне исполнилось 18 лет </template>
                    </b-form-checkbox>

                </div>
                <div class="text-center">
                    <b-button type="submit" class="btn btn-primary" variant="primary" :disabled="!termsAgree || !ageAgree">Регистрация</b-button>
                </div>
                <div class="text-center my-2">
                    Уже зарегистрированы -
                    <router-link to="/login">нажмите сюда</router-link>
                    чтобы авторизоваться
                </div>
            </form>
        </b-card-body>
    </div>
</template>

<script>
    import {AUTH_REGISTER} from "../../back-routes";
    import {ROLE_CLIENT, ROLE_EMPLOYEE} from "../../store/user/roles";

    export default {
        name: 'Register',
        data() {
            return {
                name: '',
                email: '',
                password: '',
                role: ROLE_CLIENT,
                last_name: '',
                phone: '',
                roles: [
                    {value: ROLE_CLIENT, text: 'Я регистрируюсь как клиент'},
                    {value: ROLE_EMPLOYEE, text: 'Я регистрируюсь как сотрудник'}
                ],
                error: false,
                errors: {},
                success: false,

                termsAgree: false,
                ageAgree: false,
            };
        },
        mounted() {
            let urlRole = this.$route.query.role;
            if(urlRole && urlRole === 'recrut'){
                this.role = ROLE_EMPLOYEE
            }
        },
        methods: {
            register() {
                var app = this
                this.$auth.register({
                    url: AUTH_REGISTER,
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password,
                        last_name: app.last_name,
                        phone: app.phone,
                        role: app.role
                    },
                    success: function () {
                        app.success = true;
                        app.$auth.login({
                            // url: '/wfsa/faf/ad/',
                            params: {
                                email: app.email,
                                password: app.password
                            },
                            success: function () {
                                app.$bus.$emit('userLogin');
                            },
                            rememberMe: true,
                            redirect: '/',
                            fetchUser: true,
                        });
                    },
                    error: function (resp) {
                        app.error = true;
                        app.errors = resp.response.data.errors;
                    },
                    redirect: '/',
                    autoLogin: true,
                    fetchUser: true
                });
            }
        }
    }
</script>

<style scoped>



</style>
