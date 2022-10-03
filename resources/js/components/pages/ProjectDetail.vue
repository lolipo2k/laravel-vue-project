<template>
    <div>
        <project-detail-client v-if="profile.role ==='client'"></project-detail-client>
        <project-detail-employ v-if="profile.role !=='client'"></project-detail-employ>

    </div>
</template>

<script>
    import VueCal from 'vue-cal'
    import 'vue-cal/dist/i18n/ru.js'
    import 'vue-cal/dist/vuecal.css'
    import ProjectDetailClient from "./ProjectDetailClient";
    import ProjectDetailEmploy from "./ProjectDetailEmploy";

    export default {
        name: "ProjectDetail",
        components: {ProjectDetailEmploy, ProjectDetailClient, 'vue-cal': VueCal},

        mounted() {

        },
        created() {

        },
        computed: {
            profile() {
                return this.$store.getters["user/profile"]
            },

        },
    }
</script>

<style scoped>


</style>
