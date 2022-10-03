<template>
    <div>
        <!--        <a @click="logout" class="pointer-event">Выход</a>-->
    </div>
</template>

<script>
    export default {
        name: "Logout",
        created() {
            this.logout();
        },
        methods: {
            logout() {
                this.$auth.logout();
                this.$router.push('/login');
            }
        },
    }
</script>

<style scoped>

</style>