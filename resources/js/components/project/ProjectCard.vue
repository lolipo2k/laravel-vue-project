<template>
    <div v-if="project"
         :class="[project.status === 0 ?'new':'', {'moderate_agree' :  project.status === 1 }, {'moderate_disagree' : project.status === 2 }]"
    >
        <b-card-header>
            <div class="lh17" v-if="project.status === 0">
                Проект проходит модерацию, проверка может занять до 24 часов.
            </div>
            <div class="lh17" v-else-if="project.status === 2">
                <div class="reject-answer">{{project.reject_reason.name}}</div>
            </div>
            <div v-else>
                <div class="block-left">
                    <b-button v-if="profile.role !=='client'" v-b-tooltip.hover title="Стоимость лида" class="cost">
                        <div><span>&#8381;</span> {{profile.own ? Math.round(project.lead_price * 0.57) : Math.round(project.lead_price * 0.7)}}</div>
                    </b-button>
                    <b-button v-if="profile.role !=='client'" v-b-tooltip.hover title="B2B – звонки организациям
B2C – звонки физическим лицам" class="cost">
                        <div class="count">
                            <b-icon icon="lightning"></b-icon>
                            {{checkB(project.b2b)}}
                        </div>
                    </b-button>

                    <b-button v-if="profile.role ==='client'" v-b-tooltip.hover title="Лидов оплачено" class="cost">
                        <div> {{project.leads}}</div>
                    </b-button>
                    <b-button v-if="profile.role ==='client'" v-b-tooltip.hover
                              :title="(project.leads_created && project.leads && project.leads_created > 0 &&
                        project.leads > 0 && project.leads_created/project.leads > 0.7)? 'Лидов сделано. Оплаченные лиды заканчиваются.': ' Лидов сделано'" class="cost"
                              :class="(project.leads_created && project.leads && project.leads_created > 0 &&
                        project.leads > 0 && project.leads_created/project.leads > 0.7)? 'toSmall': '' ">
                        <div > {{project.leads_created}}</div>
                    </b-button>
                </div>

                <div class="block-right">
                    <small class="text-muted date-create" v-if="project.pivot">
                        <b-icon icon="calendar2"></b-icon>
                        {{project.pivot.taken_at | moment("DD/MM/YYYY") }}</small>
                    <small class="text-muted date-create" v-else>
                        <b-icon icon="calendar2"></b-icon>
                        {{project.created_at | moment("DD/MM/YYYY") }}</small>
                    <!--                    <b-badge variant="success">{{project.status}}</b-badge>-->
                </div>
            </div>

        </b-card-header>
        <b-card-body>
            <b-card-title>
                <router-link :to="{name: 'project-detail',params: { id: project.id }}">
                    {{project.company_name}}
                    <span v-if="profile.role ==='client'">
                          <template v-if="profile  && !profile.payment_status">
                            <b-badge variant="danger" style="font-size: 12px;"  v-b-tooltip.hover
                                     title="Оплатите базовый тариф или дождитесь поступления средств, если оплата уже внесена">Проект остановлен
                            </b-badge>
                        </template>
                        <template v-else>
                            <b-badge variant="secondary" style="font-size: 12px;" v-if="project.status === 0">На модерации
                            </b-badge>
                            <b-badge variant="success" style="font-size: 12px;" v-if="project.status === 1">В работе
                            </b-badge>
                            <b-badge variant="danger" style="font-size: 12px;" v-if="project.status === 2">Отклонен
                            </b-badge>
                        </template>
                    </span>

                </router-link>

            </b-card-title>
            <b-card-text v-if="project.comment &&  profile.role ==='client'">

                <b-alert show variant="danger">{{project.comment}}</b-alert>
            </b-card-text>

            <b-card-text v-else>
                {{project.description}}

                <b-button style="display: block; margin-top: 20px"
                    v-if="project.my_project !== 1 && !myProject && profile.learned" variant="success" id="show-btn"
                    @click="$bvModal.show('bv-modal-example-'+ project.id)">Выбрать
                </b-button>
            </b-card-text>
            <!--            <b-card-text>-->
            <!--                <b>Целевая аудитория:</b> {{project.target}}-->
            <!--            </b-card-text>-->
<!--            <b-card-text v-if="(project.my_project === 1 || myProject) &&  profile.role !=='client'">-->
<!--                <b>Перезвонов:</b> 20 <br>-->
<!--                <b>Горячих:</b> 2 <br>-->
<!--                <b>Просрочено:</b> 1 <br>-->
<!--            </b-card-text>-->


            <div>
                <b-modal :id="'bv-modal-example-'+ project.id" hide-footer>
                    <div class="d-block text-center">
                        <p>Я предлагаю свою кандидатуру в проект: {{project.company_name}}</p>
                        <b-alert show variant="danger">Ваш профиль будет рассмотрен модератором. Результат проверки вы
                            получите в уведомлении в течение 24 часов
                        </b-alert>
                    </div>
                    <b-button class="mt-3 btn btn-light" block @click="$bvModal.hide('bv-modal-example-'+ project.id)">
                        Отмена
                    </b-button>
                    <b-button class="mt-3 btn btn-success" block @click="takeProject()">Ок</b-button>
                </b-modal>
            </div>

        </b-card-body>
        <b-card-footer v-if="project.field_id && taxonomy">
            <div class="category-tag">{{findTaxonomy()}}</div>
        </b-card-footer>


    </div>

</template>

<script>
    export default {
        name: "ProjectCard",
        props: {
            project: {
                default: {}
            },
            myProject: false
        },
        mounted() {
            this.$store.dispatch('taxonomy/fetchFields');
        },
        computed: {
            taxonomy() {
                return this.$store.getters["taxonomy/fields"]
            },
            profile() {
                return this.$store.getters["user/profile"]
            },
        },
        methods: {
            checkB(i) {
                if (i && i !== 0) {
                    return 'B2B'
                } else {
                    return 'B2C'
                }
            },
            findTaxonomy() {
                if (this.taxonomy.data) {
                    let category = this.taxonomy.data.filter(el => el.id === this.project.field_id);
                    return category[0].name;
                }
            },
            takeProject() {
                this.$store.dispatch('projects/takeProject', this.project.id)
                    .then(() => {
                        this.makeToast();
                    })
                    .catch(error => {
                        this.makeToast('error');
                    })
            },
            makeToast(error) {
                if (error !== 'error') {
                    this.$bvToast.toast(`Вы отправили заявку на проект ` + this.project.company_name, {
                        title: 'Заявка на проект отправлена',
                        autoHideDelay: 5000,
                    })
                } else {
                    this.$bvToast.toast('При отправке заявки произошла ошибка', {
                        title: 'Заявка отклонена',
                        autoHideDelay: 5000,
                    })
                }
            }
        },
    }
</script>

<style scoped>
    .new {
        opacity: 0.3;
    }

    .moderate_agree {
        border-radius: 10px;
        opacity: 1;
    }

    .moderate_disagree {
        background: #f2d3d2;
        border-radius: 10px;
        opacity: 1;
    }

    .reject-answer {
        color: #fff;
        background-color: #dc3545bd;
        border-color: #dc3545;
        padding: 11px;
        border-radius: 6px;
        text-align: center;
    }

    .category-tag {
        border: 1px solid #007bff;
        width: fit-content;
        padding: 5px 10px;
        border-radius: 20px;
        color: #007bff;
    }
    .toSmall{
        background-color: #e05c68;
    }
</style>
