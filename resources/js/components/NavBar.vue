<template>
    <div class="sidebar">
        <b-navbar type="dark" variant="dark" class="custom-navbar">
            <div class="user-profile-block">
                <router-link :to="{name: 'profile'}">
                    <div class="avatar-container" style="position: relative;">
                        <div class="learned" v-if="profile && profile.learned"
                             v-b-tooltip.hover
                             title="Инструктаж успешно пройден"
                        >
                            <b-icon icon="star-fill" ></b-icon>
                        </div>
                        <div v-if="!profile.avatar" class="avatar"
                             :style="{ 'background-image': 'url(/images/nophoto.jpg)' }"></div>
                        <div v-else class="avatar"
                             :style="{ 'background-image': 'url(/' + profile.avatar + ')' }"></div>
                        <b-button v-if="profile && (profile.role === 'client' && !profile.phone_confirmed) ||
                                    (profile.role !== 'client' && (!profile.field_categories || profile.field_categories.length < 1))"
                                  class="profile-notification" v-b-tooltip.hover
                                  title="Ваш профиль не заполнен, пожалуйста заполните все данные о себе">
                        </b-button>
                    </div>

                    <div class="user-name">{{profile.name}} {{profile.last_name}}</div>
                </router-link>

                <div v-if="profile && profile.role ==='client'" style=" font-size: 12px;">
                    <template v-if="profile.payment_status == 0" >
                                     <span class="account-not-paid" style="color: red;">Аккаунт не оплачен (все проекты остановлены)
                                        <b-button v-b-tooltip.hover
                                                  title="При неоплаченном аккаунте работа по всем вашим проектам останавливается даже если баланс лидов еще не исчерпан."
                                                  class="help-icon">
                                            <div class="count">
                                                <b-icon icon="exclamation-circle" style="color: red"></b-icon>
                                            </div>
                                        </b-button>
                                     </span>
                    </template>
                    <template v-else>
                        <span class="account-paid" style="color: gold;">Аккаунт оплачен до ({{profile.active_to | moment("DD/MM/YYYY  HH:mm") }})</span>
                    </template>

                    <div>
                        Общий баланс лидов:

                        {{allLeadsPaid}} руб.
                    </div>
                </div>

            </div>

            <b-navbar-nav>
                <router-link :to="{path: '/'}" class="nav-link" v-if="profile.role ==='employee'">
                    <b-icon icon="laptop"></b-icon>
                    <span class="menu-item-text">
                         Рабочий стол
                    </span>

                </router-link>
                <router-link :to="{path: '/'}" class="nav-link" v-if="profile.role ==='client'">
                    <b-icon icon="collection"></b-icon>
                    <span class="menu-item-text">
                         Мои проекты
                    </span>
                </router-link>


                <!--                <router-link :to="{name: 'projects-list'}" class="nav-link">-->
                <!--                    <b-icon icon="file-check"></b-icon>-->
                <!--                    Мои проекты-->
                <!--                </router-link>-->
                <router-link :to="{name: 'projects-list'}" class="nav-link"
                             v-if="profile.role ==='employee' && profile.learned">
                    <b-icon icon="columns-gap"></b-icon>
                    <span class="menu-item-text">
                          Доступные проекты
                    </span>
                </router-link>
                <router-link :to="{name: 'notifications'}" class="nav-link">
                    <b-icon icon="exclamation-triangle"></b-icon>
                    <span class="menu-item-text">
                          Уведомления
                    </span>

                </router-link>
                <router-link :to="{path: '/finance'}" class="nav-link" v-if="profile.role ==='client'">
                    <b-icon icon="credit-card"></b-icon>
                    <span class="menu-item-text">
                         Финансы
                    </span>
                </router-link>
                <router-link :to="{name: 'profile'}" class="nav-link">
                    <b-icon icon="person-fill"></b-icon>
                    <span class="menu-item-text">
                          Профиль
                    </span>

                </router-link>
                <router-link :to="{name: 'FAQ'}" class="nav-link">
                    <b-icon icon="question-circle"></b-icon>
                    <span class="menu-item-text">
                           FAQ
                    </span>
                </router-link>

                <router-link :to="{name: 'support'}" class="nav-link">
                    <b-icon icon="chat-dots"></b-icon>
                    <span class="menu-item-text">
                           Помощь
                    </span>
                </router-link>

                <!--                <router-link :to="{name: 'analytics'}" class="nav-link">-->
                <!--                    <b-icon icon="clipboard-data"></b-icon>-->
                <!--                    Аналитика-->
                <!--                </router-link>-->
                <!--                <router-link :to="{name: 'settings'}" class="nav-link">-->
                <!--                    <b-icon icon="gear-fill" aria-hidden="true"></b-icon>-->
                <!--                    Настройки-->
                <!--                </router-link>-->
                <router-link to="/logout" class="nav-link">
                    <b-icon icon="door-closed" aria-hidden="true"></b-icon>
                    <span class="menu-item-text">
                            Выход
                    </span>
                </router-link>
            </b-navbar-nav>
            <div class="nav-bg"></div>
        </b-navbar>

    </div>
</template>

<script>
    export default {
        name: "NavBar",
        computed: {
            profile() {
                return this.$store.getters["user/profile"]
            },
            myProjects () {
                return this.$store.getters["projects/projects"]
            },

            allLeadsPaid(){
                let allLeads = 0;
                if(this.myProjects && this.myProjects.data && this.myProjects.data.length){
                    for (let i = 0; i <= this.myProjects.data.length; i++){
                        let lead = this.myProjects.data[i];
                        if(this.myProjects.data[i] && this.myProjects.data[i].leads){
                            allLeads = Number(allLeads) + ((Number(lead.leads) - Number(lead.leads_created)) * lead.lead_price)
                        }
                    }
                }
                return allLeads;
            }
        },
        created() {
            this.$store.dispatch('user/refreshProfile').then(() => {
                let settings = {userOnly : true};
                if(this.profile && this.profile.role !=='client'){
                    settings = {}
                }
                    this.$store.dispatch("projects/fetchList", settings);
            })
        },
        mounted() {
        },
        methods: {}
    }
</script>

<style scoped>
    .user-profile-block {
        text-align: center;
        color: #bdbdbd;
        border-bottom: 1px solid #bdbdbd40;
        padding-bottom: 1rem;
        position: relative;
        z-index: 2;
    }


    .user-profile-block .user-name {
        margin-top: 0.5rem;
    }

    .avatar-container {
        width: fit-content;
        position: relative;
        margin: 0 auto;
    }

    .user-profile-block .avatar {
        width: 5rem;
        height: 5rem;
        margin: 0 auto;
        border-radius: 50%;
        background-size: cover;
        background-position: 50%;
        position: relative;
    }

    .profile-notification {
        position: absolute;
        top: 0;
        right: 0;
        width: 20px;
        height: 20px;
        background: red;
        border-radius: 50%;
        padding: 0;
    }

    .user-profile-block a {
        color: #bdbdbd;
        text-decoration: none;
    }

    .navbar {
        position: relative;
        z-index: 2;
    }

    .navbar-nav {
        position: relative;
        z-index: 2;
    }

    .nav-bg {
        content: '';
        width: 15rem;
        height: 100vh;
        display: block;
        background-image: url('https://picsum.photos/900/1200/?image=1002');
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        opacity: 0.2;

    }
    .learned{
        position: absolute;
        top: -0.5rem;
        font-size: 20px;
        color: gold;
        z-index: 9;
    }

</style>
