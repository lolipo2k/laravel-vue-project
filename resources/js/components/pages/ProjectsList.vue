<template>
    <div>
        <div class=" project-list">
            <div class="list-header">
                <div class="list-header__text">
                    <h1>Доступные проекты</h1>
                </div>
                <div class="list-header__add" v-if="profile.role !=='employee'">
                    <div class="form-group">
                        <div class="btn btn-success">Добавить новый проект</div>
                    </div>
                </div>
                <div class="list-header__sort">
                    <b-dropdown text="Сортировать" size="sm" class="m-2">
                        <b-dropdown-item href="#">Все</b-dropdown-item>
                        <b-dropdown-item href="#">Свободные</b-dropdown-item>
                        <b-dropdown-item href="#">Занятые</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>

            <div class="card-body">
                <b-card-group columns>
                    <b-card bg-variant="primary" text-variant="white">
                        <blockquote class="card-blockquote">
                            <p>Узнать больше о проекте можно кликнув на ссылку с его названием</p>
                        </blockquote>
                    </b-card>
                    <b-card no-body   v-for="(project, index) in allProjects.data" :key="project.id">
                        <project-card v-if="project.my_project !== 1 && !project.active_to" :project="project"></project-card>
                    </b-card>
                </b-card-group>
            </div>
        </div>
    </div>
</template>

<script>
    import ProjectCard from "../project/ProjectCard";
    export default {
        name: "ProjectsList",
        components: {ProjectCard},
        data() {
            return {

            }
        },
        mounted() {
        },
        computed: {
            allProjects () {
                return this.$store.getters["projects/projects"]
            },
            profile () {
                return this.$store.getters["user/profile"]
            },
        },
        created() {
            this.$store.dispatch("projects/fetchProject", 1);
            //this.$store.dispatch("projects/takeProject", 1);
        },
        methods:{
        },
    }
</script>

<style scoped>


</style>
