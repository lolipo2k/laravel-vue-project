<template>
    <div class="dashboard">
        <b-card-group deck v-if="profile.role ==='employee'">
            <b-card bg-variant="info" text-variant="white" class="dashboard-stat">
                <div class="stat-icon-block">
                    <span style="color: #fff; width: 100%; text-align: center;     font-size: 55px;">&#8381;</span>
                </div>
                <b-card-body>
                    <b-card-text>
                        Баланс
                    </b-card-text>
                    <b-card-title style="line-height: 42px" v-if="profile">
                        {{profile.balance}}
                        <div class="history-balans">всего заработано: {{profile.balance}}</div>
                    </b-card-title>
                </b-card-body>
                <template v-slot:footer>
                    <b-button v-if="profile && profile.balance >= 1000" variant="warning" size="sm"
                              @click="withdraw = true">Запрос на вывод
                    </b-button>
                    <div v-else>
                        Вывод денег с баланса сервиса доступен от 1000 рублей
                    </div>
                </template>
            </b-card>
            <b-card bg-variant="primary" text-variant="white" class="dashboard-stat">
                <blockquote class="card-blockquote">
                    <p>У вас возникли вопросы? Возможно ответы уже есть <a style="color: #fff; text-decoration: underline;
 font-weight: 900" href="/home/faq">здесь</a></p>

                    <footer>
                        <template v-if="profile.moderator && profile.moderator.phone">
                            А еще всегда можно написать своему куратору и уточнить появившийся вопрос.
                        </template>
                        <small v-else>А еще всегда можно написать в службу поддержки</small>
                    </footer>
                </blockquote>
                <b-button v-if="profile.moderator && profile.moderator.phone" target="_blank"
                          :href="'https://wa.me/' + profile.moderator.phone" variant="primary">Написать куратору
                </b-button>
                <b-button v-else href="/home/support" variant="primary">Написать в поддержку</b-button>
            </b-card>
        </b-card-group>

        <div class=" project-list" v-if="profile.role ==='employee'">
            <div class="">
                <b-card-group columns>

                    <b-card bg-variant="primary" text-variant="white">
                        <div v-if="!profile.learned">
                            <h2>Добро пожаловать рядовой!</h2>
                            <div>Выбор проекта будет доступен после проведения инструктажа, пожалуйста подожди немного,
                                с тобой обязательно свяжутся по номеру телефона,
                                указанному в профиле.
                            </div>
                            <br>
                            <div>
                                Пожалуйста, заполни профиль, указав там свой регион и все свои навыки, эта информация
                                будет влиять на решение о прикреплении тебя к проекту.
                            </div>
                        </div>
                        <router-link :to="{name: 'projects-list'}" class="nav-link" v-if="profile.learned">
                            <b-button variant="primary">+ Выбрать новый проект</b-button>
                        </router-link>
                    </b-card>
                    <b-card no-body v-for="(project, index) in myProjects" :key="project.id">
                        <project-card :project="project" :my-project="true"></project-card>
                    </b-card>
                </b-card-group>
            </div>
        </div>

        <div class=" project-list" v-if="profile.role ==='client'">
            <div class="list-header">
                <div class="list-header__text">
                    <h1 v-if="myProjects && myProjects.data">Мои проекты</h1>
                </div>
                <div class="list-header__sort" v-if="myProjects && myProjects.data && myProjects.data.length > 5">
                    <b-dropdown text="Сортировать" size="sm" class="m-2">
                        <b-dropdown-item href="#">Все</b-dropdown-item>
                        <b-dropdown-item href="#">Запущенные</b-dropdown-item>
                        <b-dropdown-item href="#">Остановленные</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>

            <div class="card-body ">
                <b-card-group columns>
                    <b-card bg-variant="primary" text-variant="white">
                        <blockquote class="card-blockquote" v-if="profile && profile.phone_confirmed">
                            <p>У вас возникли вопросы? Возможно ответы уже есть <a style="color: #fff; text-decoration: underline;
 font-weight: 900" href="/home/faq">здесь</a></p>

                            <footer>
                                <small>А еще всегда можно написать в службу <a style="color: #fff; text-decoration: underline;
 font-weight: 900" href="/home/faq">поддержки</a></small>
                            </footer>
                        </blockquote>

                        <router-link v-if="profile && profile.phone_confirmed" :to="{name: 'add-project'}"
                                     class="nav-link">
                            <div class="btn btn-success">
                                <b-icon icon="folder-plus"></b-icon>
                                Добавить проект
                            </div>
                        </router-link>

                        <div v-if="profile && !profile.phone_confirmed">
                            <h5>Заполните профиль</h5>
                            Для добавления первого проекта у вас должен быть заполнен профиль и подтвержден номер
                            телефона.
                            <router-link :to="{name: 'profile'}" class="nav-link">
                                <div class="btn btn-primary">
                                    <b-icon icon="person-fill"></b-icon>
                                    Перейти в профиль
                                </div>
                            </router-link>
                        </div>
                    </b-card>
                    <b-card no-body v-for="(project, index) in myProjects" :key="project.id">
                        <project-card :project="project" :my-project="true"></project-card>
                    </b-card>
                </b-card-group>
            </div>
        </div>

        <b-modal v-model="withdraw">
            <template v-slot:modal-title>
                Запрос на вывод
            </template>
            Пожалуйста, укажите сумму
            <br>
            <p></p>
            <input type="text" v-model="amount" placeholder="1000" style="width: 100%;">
            <p></p>

            <template v-slot:modal-footer>
                <div>
                    <b-button @click="callWithdraw" :disabled="amount > 0 && amount > profile.balance"
                              variant="primary">Запросить
                    </b-button>
                    <b-button @click="withdraw = false">Отмена</b-button>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import ProjectCard from "../project/ProjectCard";

    export default {
        name: "WorkArea",
        components: {ProjectCard},
        data() {
            return {
                amount: 1000,
                withdraw: false,
                stat:
                    {
                        account_balans: 2700,
                        projects_finished: 12,
                    },
            }
        },
        computed: {
            myProjects() {
                let proj = this.$store.getters["projects/projects"]
                if (this.profile && this.profile.role === 'employee') {
                    if (proj && proj.data && proj.data.length) {
                        let arr = proj.data.filter(item => item.my_project);
                        return arr
                    }
                }

                return proj.data

            },
            profile() {
                return this.$store.getters["user/profile"]
            },
        },
        methods: {

            callWithdraw() {
                this.$store.dispatch('user/callWithdraw', {'amount': this.amount}).then((result) => {
                    this.withdraw = false;
                    this.$store.dispatch('user/refreshProfile');
                    this.$bvToast.toast(`Запрос на вывод средств принят и будет обработан в течении 2 рабочих дней`, {
                        title: '',
                        autoHideDelay: 5000,
                    })
                })
            },

        }

    }
</script>

<style scoped>

    .card-title {
        margin-bottom: 5px !important;
    }


    .dashboard .project-list {
        margin-top: 3rem;
    }

    .dashboard-stat {
        margin-top: 3rem;
    }

    .dashboard-stat .card-body {

    }

    .dashboard-stat .card-title {
        font-size: 3rem;
        margin-top: -1rem;
    }

    .stat-icon-block {
        width: 106px;
        height: 106px;
        background: linear-gradient(60deg, #ffa726, #fb8c00);
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, .14), 0 7px 10px -5px rgba(255, 152, 0, .4);
        border-radius: 10px;
        position: absolute;
        top: -2rem;
        display: flex;
        align-items: center;
        text-align: center;
    }

    .dashboard-stat .last-operations {
        margin-bottom: 0.5rem;
        opacity: 0.7;
        font-size: 0.8rem;
    }

    .dashboard .history-balans {
        font-size: 14px;
    }

    .dashboard-stat {
        text-align: right;
    }
</style>
