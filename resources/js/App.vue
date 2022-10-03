<template>
    <div id="app">
        <transition
                mode="out-in"
                appear-class="animate__animated animate__slideInLeft"
                enter-active-class="animate__animated animate__slideInLeft"
                leave-active-class="animate__animated animate__slideOutLeft"
        >
            <nav-bar v-if="$auth.user() && profile && profile.role"></nav-bar>
        </transition>
        <div class="content-block" :class="!$auth.user() ? 'register':''">
            <transition
                    mode="out-in"
                    appear-class="animate__animated animate__fadeIn"
                    enter-active-class="animate__animated animate__fadeIn"
                    leave-active-class="animate__animated animate__fadeOut"
            >
                <router-view></router-view>
            </transition>
        </div>

        <b-modal v-model="warnVisible" v-if="profile.role ==='employee'">
            <template v-slot:modal-title>
                Добро пожаловать в нашу дружную онлайн-команду
            </template>
            Для начала работы заполни свой профиль, затем ты сможешь
            подать заявку на понравившийся проект
            <template v-slot:modal-footer>
                <router-link
                        class="mt-3 btn btn-primary"
                        :to="{name: 'profile'}"
                        @click.native="warnVisible = false"
                >Перейти в профиль
                </router-link>
            </template>
        </b-modal>
        <b-modal v-model="warnVisible" v-if="profile && profile.role ==='client'">
            <template v-slot:modal-title>
                Добро пожаловать в наш сервис
            </template>
            Для начала работы заполните свой профиль, затем вы сможете завести свой первый проект
            <template v-slot:modal-footer>
                <router-link
                    class="mt-3 btn btn-primary"
                    :to="{name: 'profile'}"
                    @click.native="warnVisible = false"
                >Перейти в профиль
                </router-link>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import NavBar from "./components/NavBar";

    export default {
        name: "App",
        components: {NavBar},
        data() {
            return {
                warnVisible: false
            }
        },
        created() {
            //this.$bus.$on('userLogin', this.warnNewUser);
            this.$store.dispatch('user/refreshProfile').then(()=>{
                this.warnNewUser();
            })


        },
        computed: {
            profile () {
                return this.$store.getters["user/profile"]
            },
        },
        beforeDestroy() {
            this.$bus.$off('userLogin', this.warnNewUser);
        },
        methods: {
            warnNewUser() {
                //if (!this.$store.getters['profile/profileFilled']) {
                if ( this.profile && this.profile.role ==='client' && !this.profile.phone_confirmed) {

                    this.warnVisible = true;
                }
            }
        },
    }
</script>

<style scoped>
    .register {
        margin-left: 0;
    }
</style>
