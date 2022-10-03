<template>
    <div class="project-detail" v-if="project">
        <div>
            <b-card bg-variant="dark" text-variant="white">
                <div>
                    <h2>{{project.company_name}}
                        <template v-if="profile  && !profile.payment_status">
                            <b-badge variant="danger" style="font-size: 12px;">Оплатите базовый тариф
                                аккаунта в разделе "Профиль"
                            </b-badge>
                            Остановка звонков по проекту - {{project.active_to |moment("DD/MM/YYYY") }}
                        </template>
                        <template v-else>
                            <b-badge variant="secondary" style="font-size: 12px;" v-if="project.status === 0">На
                                модерации
                            </b-badge>
                            <b-badge variant="success" style="font-size: 12px;" v-if="project.status === 1">В работе
                            </b-badge>
                            <b-badge variant="danger" style="font-size: 12px;" v-if="project.status === 2">Отклонен
                            </b-badge>
                        </template>

                    </h2>

                    <div style="margin-left: auto; margin-right: 0;">
                        <small class="text-muted date-create" v-if="project.pivot">
                            <b-icon icon="calendar2"></b-icon>
                            {{project.pivot.taken_at | moment("DD/MM/YYYY") }}</small>
                        <small class="text-muted date-create" v-else>
                            <b-icon icon="calendar2"></b-icon>
                            {{project.created_at | moment("DD/MM/YYYY") }}</small>
                    </div>

                </div>

                <b-alert show variant="danger" v-if="project.status === 0" style="margin-top: 10px">
                    Проект проходит модерацию, проверка может занять до 24 часов.
                </b-alert>

                <b-alert show variant="danger" v-if="project.status === 2" style="margin-top: 10px">
                    {{project.reject_reason.name}}<br>
                    {{project.comment}}
                </b-alert>


                <b-card-text>
                    <div style="margin-top: 10px">
                        {{project.description}}
                    </div>


                    <div class="container" style="padding-left: 0; margin-left: 0;" v-if="profile.role ==='client'">
                        <div class="row">
                            <div class="col-12 lead-state" style="display: flex">
                                <div v-if="profile.role ==='client' && project.leads"
                                     style="margin-top: 15px; margin-bottom: 0">Оплачено лидов: {{project.leads }}
                                </div>
                                <div v-if="profile.role ==='client'" style="margin-top: 15px; margin-bottom: 0">Сделано
                                    лидов: <span>{{project.leads_created }}</span>
                                </div>
                                <div style="margin-top: 15px; margin-bottom: 20px">Цена лида: <span
                                    :class="profile.role !=='client' ? 'fs32' : 'fs20'"><span>&#8381;</span>{{project.lead_price}}</span>
                                </div>
                            </div>
                            <!--                            <div class="col-12 col-md-6" v-if="project.status === 1">-->
                            <!--                                <div v-if="profile.role ==='client' && project.active_to"-->
                            <!--                                     style="margin-top: 15px; margin-bottom: 0">Остановка проекта:-->
                            <!--                                    <b-badge variant="danger" style="font-size: 12px;">{{project.active_to |-->
                            <!--                                        moment("DD/MM/YYYY") }}-->
                            <!--                                    </b-badge>-->
                            <!--                                </div>-->
                            <!--                                <div v-if="profile.role ==='client' && project.payed_to"-->
                            <!--                                     style="margin-top: 15px; margin-bottom: 0">Проект оплачен до: {{project.payed_to |-->
                            <!--                                    moment("DD/MM/YYYY") }}-->
                            <!--                                </div>-->
                            <!--&lt;!&ndash;                                <div v-if="profile.role ==='client' && !project.active_to"&ndash;&gt;-->
                            <!--&lt;!&ndash;                                     style="margin-top: 15px; margin-bottom: 0">&ndash;&gt;-->
                            <!--&lt;!&ndash;                                    <b-button @click="warnVisible = true" variant="danger">Остановить проект</b-button>&ndash;&gt;-->
                            <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                            <!--                            </div>-->
                        </div>
                        <div class="row" v-if="project.leads_created && project.leads && project.leads_created/project.leads > 0.7">
                            <b-button  @click="addBalances = true" style="margin-left: 15px">Добавить балансы проекта</b-button>
                        </div>
                    </div>
                </b-card-text>

            </b-card>
        </div>

        <div class="mt-3">
            <b-card-group deck class="first-line">
                <b-card no-body>
                    <b-tabs card style="min-height: 300px;">
                        <b-tab title="Информация" active>
                            <b-card-text>
                                <b-list-group class="text-left">
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''">
                                        <b>Категория:</b>
                                        {{checkB(project.b2b)}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"
                                                       v-if="project.regions || project.regions.length > 0">
                                        <b>Регионы:</b>
                                        <span
                                            v-for="(region, index) in project.regions">
                                             {{region.name}} ◦
                                        </span></b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>Сайт:</b>
                                        {{project.site_url}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>Тематика:</b>
                                        {{findTaxonomy()}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>ЦА:</b>
                                        {{project.target}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>Почтовый
                                        адрес:</b> {{project.address}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>Фактический
                                        адрес:</b> {{project.real_address}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>Юридический
                                        адрес:</b> {{project.legal_address}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>Директор:</b>
                                        {{project.ceo_name}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>ИНН:</b>
                                        {{project.inn}}
                                    </b-list-group-item>
                                    <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''"><b>КПП:</b>
                                        {{project.kpp}}
                                    </b-list-group-item>
                                </b-list-group>
                            </b-card-text>
                        </b-tab>
                        <b-tab title="Скрипт" v-if="isMyProject || profile.role ==='client'">
                            <b-card-text>Тут текст скрипта</b-card-text>
                        </b-tab>
                        <b-tab title="Критерии лида" v-if="project.criteries && project.criteries.length">
                            <b-card-text>
                                <b-list-group flush class="text-left" v-for="item in project.criteries" :key="item.id">
                                    <b-list-group-item v-if="item !== 4">
                                        {{getCriteriaName(item)}}
                                    </b-list-group-item>
                                    <b-list-group-item v-else>
                                        {{getCriteriaValue()}}
                                    </b-list-group-item>
                                </b-list-group>
                            </b-card-text>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </b-card-group>

            <div v-if="cleanedLeads.length">
                <h3 style="margin-top: 20px">Лиды</h3>
                <b-alert show variant="danger">
                    Обратите внимание, лид автоматически принимается через 48 часов после появления.
                </b-alert>

                <b-card class="text-left" v-for="lead in cleanedLeads" key="cleanedLeads.id">
                    <div class="lead-container">
                        <div>

                            <template v-if="!lead.freezed && !lead.confirmed">
                                <b-icon v-b-tooltip.hover
                                        title="Новый лид"
                                        icon="exclamation-diamond" style="color: gold"></b-icon>
                            </template>
                            <template v-if="lead.freezed">
                                <b-icon v-b-tooltip.hover
                                        title="Лид на ручной проверке"
                                        icon="hourglass" style="color: #00c6ff"></b-icon>
                            </template>
                            <template v-if="lead.confirmed">
                                <b-icon v-b-tooltip.hover
                                        title="Лид принят" icon="check-circle-fill" style="color:#1ae28a;"></b-icon>
                            </template>
                        </div>
                        <!--                        <div class="history">-->
                        <!--                            <b-icon icon="book" @click="showLeadHistory(12)"></b-icon>-->
                        <!--                        </div>-->
                        <div class="lead-id">#{{lead.id}}</div>
                        <div class="lead-date"> {{lead.created_at | moment("DD/MM/YYYY HH:MM") }}</div>
                        <div class="lead-date"> {{lead.base_record.company}}</div>

                        <div class="lead-record">
                            <audio controls>
                                <source src="music.mp3" type="audio/mpeg">
                                <source src="music.ogg" type="audio/ogg">
                            </audio>
                        </div>
                    </div>
                </b-card>

                <p></p>
                <div class="lead-buttons">
                    <b-button class="align-items-center call-later__button" size="sm"
                              @click="rejectLead()">Отклонить лид
                    </b-button>
                </div>

            </div>
        </div>


        <b-modal v-model="showComment">
            {{readCurrentComment}}
        </b-modal>

        <b-modal v-model="warnVisible">
            <template v-slot:modal-title>
                Остановка проекта
            </template>
            Подтвердите остановку проекта. <br>
            Проект будет остановлен через 24 часа, он пропадет из списка доступных для вступление проектов и будет
            заблокирован у исполнителей.
            <template v-slot:modal-footer>
                <div>
                    <b-button @click="stopProject" variant="danger">Подтверждаю остановку</b-button>
                    <b-button @click="warnVisible = false">Отмена</b-button>
                </div>
            </template>
        </b-modal>

        <b-modal v-model="rejectingLead">
            <template v-slot:modal-title>
                Отклонение лида
            </template>
            Пожалуйста укажите номер лида
            <br>
            <p></p>
            <input type="text" v-model="leadRejectingNumber" placeholder="#123456">
            <p></p>
            Пожалуйста укажите по какой причине этот лид не должен быть засчитан:
            <b-form-textarea
                style="margin-top: 10px"
                id="textarea"
                v-model="leadRejectingText"
                placeholder=""
                rows="3"
                max-rows="6"
            ></b-form-textarea>
            <template v-slot:modal-footer>
                <div>
                    <b-button @click="acceptRejecting" :disabled="!leadRejectingText" variant="danger">Отклонить лид
                    </b-button>
                    <b-button @click="rejectingLead = null">Отмена</b-button>
                </div>
            </template>
        </b-modal>

        <b-modal v-model="leadHistory">
            <template v-slot:modal-title>
                История лида
            </template>
            <b-form-textarea
                id="textarea"
                v-model="leadHistoryText"
                placeholder=""
                rows="12"
                max-rows="12"
            ></b-form-textarea>


            <template v-slot:modal-footer>
                <div>
                    <b-button @click="leadHistory = null">Закрыть</b-button>
                </div>
            </template>
        </b-modal>

        <b-modal v-model="addBalances">
            <template v-slot:modal-title>
                Пополнение балансов проекта
            </template>
            <div class="col-md-12">
                <b-form-checkbox v-model="form.base" name="check-button" switch>
                    Добавить еще 400 контактов
                </b-form-checkbox>
            </div>
            <div class="profile-work border-bottom-profile" style="width: 100%; margin-top: 20px; margin-bottom: 20px">
                <div class="col-md-12">
                    <div>Добавить лидов для проекта</div>
                    <b-form-select v-model="form.leads" :options="leadsCountOptions"></b-form-select>
                </div>
            </div>

            <div class="amount-cost">
                <div v-if="form.base" class="col-md-12">
                    <p class="price-option">База: <span>+ 3600 руб.</span></p>
                </div>
                <div class="col-md-12" v-if="form.leads &&  project.lead_price">
                    <p class="price-option">Лиды: <span>+ {{form.leads * project.lead_price}} руб.</span></p>
                </div>
            </div>
            <div class="profile-work border-bottom-profile" style="width: 100%;">
                <div class="col-md-12" v-if="form.leads &&  project.lead_price">
                    <p class="price-option">Всего: <span style="font-weight: 900;">{{costCalculate()}}</span></p>
                </div>
            </div>
            <template v-slot:modal-footer>
                <b-button  @click="pay(2)"
                          :disabled="(leads == 0 && !form.base) || paySended" class="btn-success" block
                          style="display: inline-flex;max-width: fit-content; margin-top: 0;">Оплатить по счету
                </b-button>
                <b-button  @click="pay(1)"
                          :disabled="leads == 0 && !form.base || paySended" class="btn-success" block
                          style="display: inline-flex;max-width: fit-content; margin-top: 0;">Онлайн оплата
                </b-button>
            </template>
        </b-modal>

    </div>
</template>

<script>
    import VueCal from 'vue-cal'
    import 'vue-cal/dist/i18n/ru.js'
    import 'vue-cal/dist/vuecal.css'
    import {LEAD_CRITERION_NAMES} from "../../store/projects/lead-criterias";
    import moment from 'moment';

    export default {
        name: "ProjectDetailClient",
        components: {'vue-cal': VueCal},
        data: function () {
            return {
                warnVisible: false,
                addBalances: false,
                paySended: false,

                rejectingLead: null,
                leadRejectingNumber: '',
                leadRejectingText: '',

                leadHistory: null,
                leadHistoryText: '',

                showComment: false,
                readCurrentComment: '',

                hideBackdrop: true,
                sideCardOpacity: 0.25,
                headerOpt: {isVisible: true, backgroundColor: "#563d7c"},
                bodyOpt: {backgroundColor: ""},
                footerOpt: {isVisible: false, backgroundColor: "green"},

                cleanedLeads: [],

                leadsCountOptions: [
                    {value: 0, text: 0},
                    {value: 5, text: 5},
                    {value: 10, text: 10},
                    {value: 15, text: 15},
                    {value: 20, text: 20},
                ],

                form: {
                    base: true,
                    leads: 10,
                },
            };
        },
        mounted() {
            this.$store.dispatch('taxonomy/fetchFields');
            this.$store.dispatch('projects/fetchProject', this.$route.params.id);
        },
        created() {
            this.$store.dispatch('projects/fetchCallResults',
                {
                    'project_id': this.$route.params.id,
                },
                this.$route.params.id).then(() => {
                this.cleanLeads();
            })
        },
        computed: {
            profile() {
                return this.$store.getters["user/profile"]
            },
            project() {
                let fullProject = this.$store.getters["projects/selected"]
                return fullProject.data
            },
            taxonomy() {
                return this.$store.getters["taxonomy/fields"]
            },
            isMyProject() {
                if (this.project.users.length > 0) {
                    return true
                }
            },
            allCallResults() {
                return this.$store.getters["projects/callResults"]
            },
        },
        methods: {
            moment: function () {
                return moment();
            },
            pay(type){
                this.paySended = true;
                let contacts = 0;
                if(this.form.base){
                    contacts = 1;
                }
                let leads = 0;
                if(this.form.leads && this.form.leads > 0){
                    leads = this.form.leads;
                }

                let invoice = {}
                if (type == 1) {
                    invoice = {
                        "title": this.project.company_name,
                        "project_id": this.project.id,
                        "type": type,
                        "amount": this.costCalculate(),
                        "for_rate": 0,
                        "for_leads": leads,
                        "for_contacts": contacts,
                    }

                    this.$store.dispatch('projects/createInvoice', invoice).then((result)=>{
                        this.$store.dispatch('user/urlInvoices',
                            {
                                "invoice_id": result.id
                            }).then((result)=>{
                            this.$store.dispatch('user/refreshProfile').then(()=>{
                                window.open(result.url, '_blank');
                            })
                        })
                    })
                }else{
                    invoice = {
                        "title": this.project.company_name,
                        "project_id": this.project.id,
                        "type": type,
                        "amount": this.costCalculate(),
                        "for_rate": 0,
                        "for_leads": leads,
                        "for_contacts": contacts,
                    }
                    this.$store.dispatch('projects/createInvoice', invoice).then((result) => {
                        this.$bvToast.toast(`Вы указали оплату по счету, счет будте выставлен и появится в разедле "Финансы`, {
                            title: '',
                            autoHideDelay: 5000,
                        })
                    })
                }

            },
            costCalculate() {
                let cost = 0;
                if (this.form.base) {
                    cost = cost + 3600;
                }

                cost = cost + (this.form.leads * this.project.lead_price)
                return cost;
            },
            findFieldById() {
                if (this.form.field_categories && this.taxonomy.data) {
                    let field = this.taxonomy.data.filter(item => item.id === this.form.field_categories.id);
                    return field[0];
                }
            },

            cleanLeads() {
                if (this.allCallResults && this.allCallResults.length) {
                    this.cleanedLeads = this.allCallResults.filter(item => item.status == 2)
                }
            },

            acceptLead(arg) {
                this.$store.dispatch('projects/acceptLead', {'lead_id': arg}).then((result) => {
                    this.$store.dispatch('projects/fetchProject', this.$route.params.id);
                })
            },
            rejectLead() {
                this.rejectingLead = true;
            },
            acceptRejecting() {
                this.$store.dispatch('projects/rejectLead', {
                    'lead_id': this.rejectingLead,
                    'reject_reason': this.leadRejectingText,

                }).then((result) => {
                    this.$store.dispatch('projects/fetchProject', this.$route.params.id);
                    this.rejectingLead = null;
                })
            },
            showLeadHistory(arg) {
                this.leadHistory = arg;
            },
            stopProject() {
                this.warnVisible = false;
                this.$store.dispatch('projects/stopProject', {'project_id': this.project.id}).then((result) => {
                    this.$store.dispatch('projects/fetchProject', this.$route.params.id);
                })
            },

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
            getCriteriaName(criteriaId) {
                return LEAD_CRITERION_NAMES[criteriaId];
            },
            getCriteriaValue() {
                let str = LEAD_CRITERION_NAMES[4];
                let val = str.replace("_______", this.project.criterion_price);
                let val1 = val.replace("_______", this.project.criterion_month);
                return val1;
            },
            readComment(comment) {
                this.readCurrentComment = comment;
                this.showComment = true;
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;

                if (files[0].size > 1024 * 1024 * 15) {
                    e.preventDefault();
                    alert('Вы пытетесь загрузить слишком большой файл, пожалуйста не используйте файлы больше 15 Мегабайт');
                    return;
                }

                this.$store.dispatch("projects/putBaseFile", files[0])
                    .then((result) => {
                        console.log(result);
                        if (result.data && result.data.data) {
                            this.baseTableData = result;
                            this.form.contacts = result.data.data;
                        }
                    })
            },
            separate(text) {
                let arr = text.split('\n');
                if (arr.length) {
                    return arr
                }
                return text
            },

        }
    }
</script>

<style scoped>
    .recaller {
        margin-top: 20px;
    }

    .recall-item {
        border-radius: 5px;
        margin-bottom: 3px;
        cursor: pointer;
        display: flex;
    }

    .recall-item svg {
        margin-left: auto;
        margin: 5px;
        color: #28a745;
    }

    .recall {
        background-color: #fff;
    }

    .hot-recall {
        background-color: #feca85;
    }

    .late-recall {
        background-color: #ffb2b2;;
    }


    .call-card {
        border: 4px solid #fda655;
        border-radius: 10px;
        background: #fda655;
    }

    .make-call-card {
        display: flex;
        align-items: center;
        max-width: 26rem;
        height: 100%;
        margin: 0 auto;
        font-weight: 700;
        color: #fff;

    }

    .call-later__name {
        padding: 0 1rem 0 0rem;
        max-width: 18rem;
        display: block;
    }

    .prev-text {
        line-height: 15px;
        margin-bottom: 15px;
        display: block;
    }

    .calc-toggler {
        cursor: pointer;
        width: fit-content;
        padding: 5px;
        color: #09d1f1;
        text-decoration: underline;
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .call-later__button {
        float: right;
    }

    .list-group-item.alert-danger {
        background: #ff000026;
    }

    .lead-container {
        display: inline-flex;
        align-items: center;
        width: 100%;
    }

    .lead-buttons {
        margin-left: auto;
    }

    .lead-id {
        font-weight: 900;
        margin-right: 20px;
    }

    .lead-date {
        margin-right: 20px;
    }

    .lead-record {
        margin-right: 20px;
    }

    .history {
        cursor: pointer;
    }

    .history:hover {
        opacity: 0.5;
    }

    .call-title {
        color: #fff;
        font-size: 20px;
        margin-top: 15px;
        margin-bottom: 20px;
        font-weight: 500;
        display: block;
    }

    .right-bottom {
        margin-left: auto;
        display: block;
    }

    .call-result {
        font-size: 15px;
        background: #fff;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 1px 1px 22px 10px #ef821e;
    }

    .call-result .title {
        padding-bottom: 10px;
        font-weight: 700;
    }

    .call-result button {
        margin: 0 auto;
        display: block;
        margin-top: 20px;
    }

    .call-result textarea {
        margin: 0 auto;
        display: block;
        margin-top: 20px;
    }

    .comment-link {
        cursor: pointer;
        text-decoration: underline;
        color: orange;
    }

    .call-card .card-body {
        width: 100%;
    }

    .call-comment {
        padding: 16px;
        background: #fff;
        margin-top: 20px;
    }

    .lead-state div {
        margin-right: 20px;
        font-size: 18px;
        line-height: 25px;
        text-align: center;
    }

    .lead-state div span {
        font-weight: 700;
    }


    .lead-state div:first-child {
        color: #1ae28a;
    }

    .lead-state div:nth-child(2) {
        color: #b3f5c2;
    }

    .lead-state div:nth-child(3) {
        color: #cbeab8;
    }

    @media (max-width: 1000px) {
        .lead-container {
            display: block;
            align-items: center;
            width: 100%;
            text-align: center;
        }

        .lead-record {
            margin-right: 0;
            margin-top: 20px;

        }

        .lead-record audio {
            max-width: 100%;
        }

        .lead-buttons {
            margin: 0 auto;
            display: inline-block;
            margin-top: 20px;
        }
    }


</style>
