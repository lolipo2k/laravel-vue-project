<template>
    <div class="project-detail" v-if="project">
        <div>
            <b-card bg-variant="dark" text-variant="white">
                <div>
                    <h2>{{project.company_name}}
                    </h2>

                    <div v-if="project.active_to">
                        <b-badge variant="danger" style="font-size: 12px;">Остановка звонков по проекту - {{
                            toShortDate(project.active_to)}}
                        </b-badge>
                    </div>

                    <div style="margin-left: auto; margin-right: 0;">
                        <small class="text-muted date-create" v-if="project.pivot">
                            <b-icon icon="calendar2"></b-icon>
                            Добавлен вам:{{project.pivot.taken_at | moment("DD/MM/YYYY") }}</small>
                        <small class="text-muted date-create" v-else>
                            <b-icon icon="calendar2"></b-icon>
                            Опубликован: {{project.created_at | moment("DD/MM/YYYY") }}</small>
                    </div>
                </div>

                <b-card-text>
                    <div style="margin-top: 10px">
                        {{project.description}}
                    </div>

                    <div class="container" style="padding-left: 0; margin-left: 0;">
                        <div class="row">
                            <div class="col-12 lead-state" style="display: flex">
                                <div v-if="allCallResultsLeads"
                                     style="margin-top: 15px; margin-bottom: 0">Цена лида:
                                    <span>{{profile.own ? Math.round(project.lead_price * 0.57) : Math.round(project.lead_price * 0.7)}} Р</span>
                                </div>
                                <div v-if="allCallResultsLeads"
                                     style="margin-top: 15px; margin-bottom: 0">Лидов:
                                    <span>{{allCallResultsLeads.length}}</span>
                                </div>
                                <div v-if="allCallResultsLeads" style="margin-top: 15px; margin-bottom: 0">
                                    Назначено перезвонов: <span>{{allCallResultsRecalls.length}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-card-text>


                <template v-slot:footer v-if="isMyProject && profile.role !=='client' && hasLateRecalls">
                    <b-alert show variant="danger">У вас есть просроченные отложенные звонки, обработайте их в ближайшее
                        время.
                        Если вы будете часто накапливать просроченные звонки, мы будем вынуждены снять вас с проекта
                    </b-alert>
                </template>
            </b-card>
        </div>
        <template v-if="!project.active_to || (project.active_to && toNormalDate(project.active_to) > moment())">
            <div class="mt-3" v-if="isMyProject && profile.role !=='client'">
                <b-card>
                    <h4><u>Перезвоны</u></h4>
                    <!--                <div @click="toggleDay" class="calc-toggler">-->
                    <!--                    <span>Сегодня</span>-->
                    <!--                </div>-->
                    <VueCardCarousel v-if="listOfTodos.length"
                                     class="vcc mb-4 recaller"
                                     :items="listOfTodos"
                                     :start-index="startIndex"
                                     :hide-backdrop="hideBackdrop"
                                     :side-card-opacity="sideCardOpacity"
                                     :header-options="headerOpt"
                                     :body-options="bodyOpt"
                                     :footer-options="footerOpt"
                    >
                        <template v-slot:header="slotProps">
                            <strong class="float-left text-white">{{
                                slotProps.headerProp.date
                                }}</strong>
                            <b-icon-check-all
                                style="height: 1.5em; width: 1.5em;"
                                class="float-right text-white check-btn"
                                @click="checkAll(slotProps.headerProp)"
                            ></b-icon-check-all>
                        </template>
                        <template v-slot:default="slotProps">
                            <div>

                                <div v-for="todo in slotProps.bodyProp.todos" :class="'recall-item '+todo.type"
                                     @click="startCallRecall(todo)">
                                    {{todo.momentTime | moment("HH:mm")}} | {{ todo.name }}
                                    <b-icon icon="telephone-fill"></b-icon>
                                </div>
                            </div>
                        </template>
                        <template v-slot:footer="slotProps">
                            <strong>Id: {{ slotProps.footerProp.cMainId }}</strong>
                        </template>
                    </VueCardCarousel>
                </b-card>
            </div>
            <div class="mt-3">
                <b-card-group deck class="first-line">
                    <b-card v-if="isMyProject && profile.role !=='client'"
                            class="text-center flex align-items-center call-card">
                        <div v-if="!currentContact" class="make-call-card">
                            <div v-if="project.remain_contacts > 0">
                                <b-card-text class="prev-text">Проект открыт, после нажатия кнопки "Начинаем" вам будет
                                    загружен следующий свободный контакт для звонка.
                                </b-card-text>

                                <b-button variant="success" class="align-items-center" @click="startCall">Начинаем
                                </b-button>
                            </div>
                            <div v-else>
                                <b-card-text class="prev-text">Проект открыт, но у него пока нет новыех контактов для
                                    звонка, возможно, они скоро появятся.
                                </b-card-text>
                            </div>
                        </div>
                        <div v-else>
                            <b-card-text v-if="dialogInProcess">
                                <span class="call-title">Текущий звонок</span>
                            </b-card-text>
                            <b-card-text v-if="!dialogInProcess && !callEnded">
                                <span class="call-title">Начните звонок</span>
                            </b-card-text>
                            <b-card-text v-if="callEnded">
                                <span class="call-title">Зафиксируйте результат</span>
                            </b-card-text>
                            <b-list-group flush class="text-left ">
                                <b-list-group-item>
                                    {{currentContact.company}}
                                    <div class="close" @click="clearCurrentData">
                                        <b-icon icon="x-circle"></b-icon>

                                    </div>
                                </b-list-group-item>
                                <b-list-group-item>
<!--                                    <div class="text-muted text-left" v-if="currentContact.names">Контакт :-->
<!--                                        {{currentContact.names}}-->
<!--                                    </div>-->
                                    <table class="demo-table" >
                                        <tr class="table-line" style="display: flex; align-items: center;">
                                            <td style="display: flex; align-items: center;margin-right: 20px; line-height: 36px;">
                                                <template v-for="name in separate(currentContact.names)" v-if="name && name.length > 0">{{name}}<br>
                                                </template>
                                            </td>
                                            <td style="line-height: 36px;">
                                                <template v-for="phone in separate(currentContact.phones)" v-if="phone && phone.length > 0">
                                                    <div style="display: flex; align-items: center;">
                                                        <span style="margin-left: 10px; margin-right: 20px">{{phone}}</span>

                                                        <b-button v-if="!dialogInProcess && !callEnded" variant="success"
                                                                  @click="callContact(currentContact.id,phone)" style="margin-bottom: 5px"
                                                                  class="align-items-center right-bottom" size="sm">
                                                            <div>
                                                                <b-icon icon="telephone-fill"></b-icon>Звонить
                                                            </div>
                                                        </b-button>
                                                    </div>
                                                </template>
                                            </td>
                                        </tr>
                                    </table>

                                    <br>
                                    <div class="text-muted text-left" v-if="currentContact.info">Примечание к контакту:
                                        {{currentContact.info}}
                                    </div>

                                    <b-button v-if="dialogInProcess" variant="success"
                                              class="align-items-center right-bottom" size="sm" @click="endCall">
                                        <b-icon icon="check-square"></b-icon>
                                        Результат звонка
                                    </b-button>
                                </b-list-group-item>
                                <div v-if="currentComment && !callEnded" class="call-comment">
                                    {{currentComment}}
                                </div>

                                <div class="mt-3" v-if="callEnded">
                                    <b-button-group>
                                        <b-button variant="success" @click="callResults = 1">Ура! Это ЛИД</b-button>
                                        <b-button variant="info" @click="callResults = 2">Перезвонить</b-button>
                                        <b-button variant="outline-primary" @click="callResults = 4">Другой номер</b-button>
                                        <b-button variant="warning" @click="callResults = 3">Сброс номера</b-button>
                                    </b-button-group>
                                </div>
                                <div class="mt-3 call-result" v-if="callResults == 1">
                                    <div class="text-center title">Фиксируем ЛИД</div>
                                    <div>
                                        Если ваш звонок завершился Лидом, оставьте комментарий (если необходимо), и
                                        нажмите
                                        "Отправить лид"
                                        <br>
                                        Запись Вашего разговора будет автоматически приложена к лиду.
                                    </div>
                                    <div>
                                        <textarea name="comment" v-model="currentComment" cols="30" rows="5"></textarea>
                                    </div>

                                    <b-button v-if="callEnded" variant="success"
                                              class="align-items-center text-center" size="sm"
                                              @click="setLead(currentContact.id, currentComment)">
                                        <b-icon icon="check-square"></b-icon>
                                        Отправить лид
                                    </b-button>
                                </div>
                                <div class="mt-3 call-result" v-if="callResults == 2">
                                    <div class="text-center title">Фиксируем Перезвон</div>
                                    <div>
                                        Если ваш звонок завершился тем, что вы назначиили новое время для звонка,
                                        укажите в поле назначенное время и нажмите "Назначить перезвон"
                                    </div>
                                    <div>
                                        <textarea name="comment" v-model="currentComment" cols="30" rows="5"></textarea>
                                    </div>
                                    <div>
                                        <input id="datetime" type="datetime-local" v-model="recallTime">
                                    </div>

                                    <b-button v-if="callEnded && recallTime" variant="success"
                                              class="align-items-center text-center" size="sm"
                                              @click="setRecall(currentContact.id,recallTime,currentComment)">
                                        <b-icon icon="check-square"></b-icon>
                                        Отправить перезвон
                                    </b-button>
                                </div>
                                <div class="mt-3 call-result" v-if="callResults == 3">
                                    <div class="text-center title">Фиксируем Отказ</div>
                                    <div>
                                        Если вы не можете дозвониться и не хотите больше перезванивать по этому номеру,
                                        нажмите кнопку "Отказ", зафиксировав причину "Недозвон"
                                    </div>
                                    <div>
                                        <textarea name="comment" v-model="currentComment" cols="30" rows="5"></textarea>
                                    </div>

                                    <b-button v-if="callEnded" variant="success"
                                              class="align-items-center text-center" size="sm"
                                              @click="setReject(currentContact.id,currentComment)">
                                        <b-icon icon="check-square"></b-icon>
                                        Отказ
                                    </b-button>
                                </div>
                                <div class="mt-3 call-result" v-if="callResults == 4">
                                    <div class="text-center title">Новый номер</div>
                                    <div>
                                        Внести в базу еще один номер для этого контакта
                                    </div>
                                    <template v-for="(input,index) in inputs">
                                        <div>
                                            <div style="margin-bottom: 5px;"><span style=" width: 133px; display: inline-block;">Имя, должность </span><input type="text" :id="input.label+ index+'name'" v-model="input.name" ></div>
                                            <div><span style=" width: 133px; display: inline-block;">Номер телефона</span><input type="text" :id="input.label+ index+'phone'" v-model="input.phone"></div>
                                        </div>
                                    </template>
<!--                                    <button @click="pushInput">Добавить контакт</button>-->

                                    <b-button v-if="callEnded" variant="success"
                                              class="align-items-center text-center" size="sm"
                                              @click="sendNewContacts(currentContact.id)">
                                        <b-icon icon="check-square"></b-icon>
                                        Сохранить
                                    </b-button>
                                </div>
                            </b-list-group>
                        </div>
                    </b-card>
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
                                        <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''">
                                            <b>Тематика:</b>
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
                                        <b-list-group-item :variant="profile.role !=='client' ? 'dark': ''">
                                            <b>Директор:</b>
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
                            <b-tab title="Критерии лида"
                                   v-if="profile.role ==='client' && project.criteries && project.criteries.length">
                                <b-card-text>
                                    <b-list-group class="text-left">
                                        <b-list-group-item v-for="item in project.criteries" :key="item.id">
                                            <template v-if="item !== 4">
                                                {{getCriteriaName(item)}}
                                            </template>
                                            <template v-else>
                                                {{getCriteriaValue()}}
                                            </template>
                                        </b-list-group-item>
                                    </b-list-group>
                                </b-card-text>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </b-card-group>
            </div>


            <div class="mt-3">
                <b-card-group columns>
                    <b-card no-body bg-variant="light" header="Критерии лида" class="text-center"
                            v-if="profile.role !=='client'">
                        <b-card-body>
                        </b-card-body>
                        <b-list-group flush class="text-left" v-for="item in project.criteries" :key="item.id">
                            <b-list-group-item v-if="item !== 4">
                                <small class="text-muted text-left">{{getCriteriaName(item)}}</small>
                            </b-list-group-item>
                            <b-list-group-item v-else>
                                <small class="text-muted text-left">{{getCriteriaValue()}}</small>
                            </b-list-group-item>
                        </b-list-group>
                    </b-card>
                </b-card-group>
            </div>
        </template>
        <template v-else>
            <b-alert show variant="danger" style="margin-top: 1rem">
                К сожалению, в данный момент этот проект остановлен.
            </b-alert>
        </template>


        <div v-if="profile.role !=='client' && allCallResultsMounth && allCallResultsMounth.length">
            <b-card no-body>
                <b-tabs card style="min-height: 300px;">
                    <b-tab title="Результаты сегодня" active
                           v-if="(isMyProject || profile.role ==='client') && allCallResultsToday.length">
                        <b-card-text v-if="allCallResultsToday && allCallResultsToday.length">
                            <table class="table b-table table-striped table-hover">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <td>#Контакта</td>
                                    <td>Дата</td>
                                    <td>Контакт</td>
                                    <td>Результат</td>
                                    <td>Перезвонить</td>
                                    <td>Комментарий</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in allCallResultsToday" :key="item.id">
                                    <td>{{index+1}}</td>
                                    <td>#{{item.base_record_id}}</td>
                                    <td>{{item.created_at | moment("DD/MM/YYYY HH:MM") }}</td>
                                    <td>{{item.base_record.company}}</td>
                                    <td v-if="item.status == 0">Перезвон</td>
                                    <td v-if="item.status == 1">Отказ</td>
                                    <td v-if="item.status == 2">Лид</td>
                                    <td><span v-if="item.next_date">{{toNormalDateTime(item.next_date) }}</span></td>
                                    <td><span v-if="item.comment" class="comment-link"
                                              @click="readComment(item.comment)">Комментарий</span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </b-card-text>
                    </b-tab>
                    <b-tab title="За неделю"
                           v-if="(isMyProject || profile.role ==='client') && allCallResultsWeek.length">
                        <b-card-text v-if="allCallResultsWeek && allCallResultsWeek.length">
                            <table class="table b-table table-striped table-hover">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <td>#Контакта</td>
                                    <td>Дата</td>
                                    <td>Контакт</td>
                                    <td>Результат</td>
                                    <td>Перезвонить</td>
                                    <td>Комментарий</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in allCallResultsWeek" :key="item.id">
                                    <td>{{index+1}}</td>
                                    <td>#{{item.base_record_id}}</td>
                                    <td>{{item.created_at | moment("DD/MM/YYYY HH:MM") }}</td>
                                    <td>{{item.base_record.company}}</td>
                                    <td v-if="item.status == 0">Перезвон</td>
                                    <td v-if="item.status == 1">Отказ</td>
                                    <td v-if="item.status == 2">Лид</td>
                                    <td><span v-if="item.next_date">{{toNormalDateTime(item.next_date) }}</span></td>
                                    <td><span v-if="item.comment" class="comment-link"
                                              @click="readComment(item.comment)">Комментарий</span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </b-card-text>
                    </b-tab>
                    <b-tab title="За месяц"
                           v-if="(isMyProject || profile.role ==='client') && allCallResultsMounth.length">
                        <b-card-text v-if="allCallResultsMounth && allCallResultsMounth.length">
                            <table class="table b-table table-striped table-hover">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <td>#Контакта</td>
                                    <td>Дата</td>
                                    <td>Контакт</td>
                                    <td>Результат</td>
                                    <td>Перезвонить</td>
                                    <td>Комментарий</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in allCallResultsMounth" :key="item.id">
                                    <td>{{index+1}}</td>
                                    <td>#{{item.base_record_id}}</td>
                                    <td>{{item.created_at | moment("DD/MM/YYYY HH:MM") }}</td>
                                    <td>{{item.base_record.company}}</td>
                                    <td v-if="item.status == 0">Перезвон</td>
                                    <td v-if="item.status == 1">Отказ</td>
                                    <td v-if="item.status == 2">Лид</td>
                                    <td><span v-if="item.next_date">{{toNormalDateTime(item.next_date) }}</span></td>
                                    <td><span v-if="item.comment" class="comment-link"
                                              @click="readComment(item.comment)">Комментарий</span>
                                    </td>
                                </tr>
                                </tbody>

                            </table>
                        </b-card-text>
                    </b-tab>
                </b-tabs>
            </b-card>
        </div>

        <b-modal v-model="showComment">
            {{readCurrentComment}}
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

    </div>
</template>

<script>
    import VueCal from 'vue-cal'
    import 'vue-cal/dist/i18n/ru.js'
    import 'vue-cal/dist/vuecal.css'
    import {LEAD_CRITERION_NAMES} from "../../store/projects/lead-criterias";
    import moment from 'moment';

    export default {
        name: "ProjectDetailEmploy",
        components: {'vue-cal': VueCal},
        data: function () {
            return {
                inputs: [
                    {name: '', phone: ''}
                ],
                warnVisible: false,

                rejectingLead: null,
                leadRejectingNumber: '',
                leadRejectingText: '',

                leadHistory: null,
                leadHistoryText: '',

                hasLateRecalls: false,

                callStart: false,
                callEnded: false,
                currentComment: '',
                recallTime: null,
                dialogInProcess: false,
                longCalendar: false,
                selectedEvent: null,

                currentContact: null,
                callResults: null,

                showComment: false,
                readCurrentComment: '',

                listOfTodos: [],
                startIndex: 1,
                hideBackdrop: true,
                sideCardOpacity: 0.25,
                headerOpt: {isVisible: true, backgroundColor: "#563d7c"},
                bodyOpt: {backgroundColor: ""},
                footerOpt: {isVisible: false, backgroundColor: "green"},

                cleanedRecalls: []
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
                    'employee_id': this.profile.id
                },
                this.$route.params.id).then(() => {
                this.cleanRecalls();
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
            allCallResultsLeads() {
                let all = this.$store.getters["projects/callResults"]
                if (all.length) {
                    let filtred = all.filter(item => item.status == 2);
                    return filtred;
                }
                return 0
            },
            allCallResultsRecalls() {
                let all = this.$store.getters["projects/callResults"]
                if (all.length) {
                    let filtred = all.filter(item => item.status == 0);
                    return filtred;
                }
                return 0
            },
            allCallResultsToday() {
                let results = this.$store.getters["projects/callResults"];
                return (results.filter(item => moment(item.created_at) > moment().subtract(1, 'day').endOf('day')));
            },
            allCallResultsWeek() {
                let results = this.$store.getters["projects/callResults"];
                return (results.filter(item => moment(item.created_at) > moment().subtract(7, 'day')));
            },
            allCallResultsMounth() {
                let results = this.$store.getters["projects/callResults"];
                return (results.filter(item => moment(item.created_at) > moment().subtract(30, 'day')));
            },
            time() {
                return moment(this.recallTime).format("YYYY-MM-DDTHH:mm:ss")
            },
        },
        methods: {
            moment: function () {
                return moment();
            },
            pushInput() {
                this.inputs.push({
                    name: '',
                    phone: ''
                })
            },
            sendNewContacts(id){
                if(this.inputs.length){

                    let names = '';
                    let phones = '';
                    let arr = this.inputs;

                    for (let i = 0; i<= arr.length; i++){
                        if(arr[i]){
                            console.log(arr[i].name)
                            names += arr[i].name + '\n';
                            phones += arr[i].phone + '\n';
                        }

                    }
                    let data ={
                        id: id,
                        names: this.currentContact.names + '\n' +  names,
                        phones: this.currentContact.phones + '\n' + phones,
                    }
                    this.$store.dispatch("projects/addSingleContact", data)
                        .then(() => {
                            this.currentContact.names =this.currentContact.names + '\n' +  names
                            this.currentContact.phones =this.currentContact.phones + '\n' +  phones

                            this.callEnded = false;
                            this.callResults = null;
                            this.inputs = [{name: '', phone: ''}]
                        })

                    console.log(data)

                }
            },
            toNormalDateTodo(date) {
                moment.defaultFormat = "YYYY-MM-DD HH:mm:ss";
                // return moment(date, moment.defaultFormat).toDate()
                return moment(date, moment.defaultFormat).toDate().format('DD/MM/YYYY')
            },
            toNormalDateTime(date) {
                moment.defaultFormat = "YYYY-MM-DD HH:mm:ss";
                // return moment(date, moment.defaultFormat).toDate()
                return moment(date, moment.defaultFormat).toDate().format('DD/MM/YYYY HH:mm')
            },
            toNormalDate(date) {
                moment.defaultFormat = "YYYY-MM-DD HH:mm:ss";
                return moment(date, moment.defaultFormat).toDate()
                // return moment(date, moment.defaultFormat).toDate().format('YYYY-MM-DD')
            },
            toShortDate(date) {
                moment.defaultFormat = "YYYY-MM-DD HH:mm:ss";
                return moment(date, moment.defaultFormat).toDate().format('DD-MM-YYYY')
            },
            cleanRecalls() {
                let x = []
                x = this.allCallResults;

                let y = x.sort((a, b) => {
                    return (b.id) - (a.id);
                });

                if (y.length) {
                    let cleanArray = [];
                    for (let i = 0; i <= y.length; i++) {
                        let result = y[i];
                        if (cleanArray.length && result) {
                            if (!cleanArray.find(item => item.base_record_id == result.base_record_id)) {
                                cleanArray.push(result);
                            }
                        } else {
                            cleanArray.push(result);
                        }
                    }
                    cleanArray = cleanArray.filter(function (x) {
                        return x !== undefined && x !== null;
                    });
                    let cleanArrayRecalls = []
                    if (cleanArray && cleanArray.length && this.profile) {
                        cleanArrayRecalls = cleanArray.filter(item => item.employee_id == this.profile.id && item.status == 0)
                    }
                    this.cleanedRecalls = cleanArrayRecalls.filter(function (x) {
                        return x !== undefined && x !== null;
                    });

                    if (this.cleanedRecalls.length) {
                        this.listOfTodos = []
                        setTimeout(() => {
                            this.buildToDosList();
                        }, 2000)
                    }
                }
            },
            buildToDosList() {
                this.listOfTodos = [];
                if (this.cleanedRecalls && this.cleanedRecalls.length) {
                    this.cleanedRecalls = this.cleanedRecalls.sort((a, b) => {
                        return new Date(a.next_date) - new Date(b.next_date);
                    });

                    this.hasLateRecalls = false;
                    for (let i = 0; i <= this.cleanedRecalls.length; i++) {
                        if (this.cleanedRecalls[i] && this.cleanedRecalls[i].next_date) {
                            let recallClass = 'recall'
                            let date = moment(this.cleanedRecalls[i].next_date).format('DD/MM/YYYY');
                            if (moment(this.cleanedRecalls[i].next_date).diff(moment()) < 0) {
                                recallClass = 'late-recall';
                                this.hasLateRecalls = true;
                            }
                            let todo = {
                                id: this.cleanedRecalls[i].id,
                                time: this.cleanedRecalls[i].next_date,
                                momentTime: moment(this.cleanedRecalls[i].next_date).subtract(3, 'hour'),
                                name: this.cleanedRecalls[i].base_record.company,
                                record: this.cleanedRecalls[i].base_record,
                                comment: this.cleanedRecalls[i].comment,
                                completed: false,
                                type: recallClass,
                            };

                            if (this.listOfTodos.length) {
                                if (this.listOfTodos.find(item => item.date == date)) {
                                    let currentDateTodos = this.listOfTodos.find(item => item.date == date);
                                    currentDateTodos.todos.push(todo);
                                } else {
                                    let date = {
                                        date: this.toNormalDateTodo(this.cleanedRecalls[i].next_date),
                                        todos: [todo]
                                    }
                                    this.listOfTodos.push(date);
                                }
                            } else {
                                let date = {
                                    date: this.toNormalDateTodo(this.cleanedRecalls[i].next_date),
                                    todos: [todo]
                                }
                                this.listOfTodos.push(date);
                            }
                        }
                    }
                }
            },
            callContact(contactId, phoneNumber) {
                this.$store.dispatch('projects/callContact',
                    {
                        "contact_id": contactId,
                        "phone_number": phoneNumber
                    }
                ).then((result) => {
                    if (result.status == 'send') {
                        this.dialogInProcess = true;
                    }
                })
            },

            clearCurrentData() {
                this.callResults = null;
                this.recallTime = null;
                this.callEnded = false;
                this.currentContact = null;
                this.currentComment = '';
            },

            setRecall(contactId, date, comment) {
                this.$store.dispatch('projects/setRecall',
                    {
                        "contact_id": contactId,
                        "comment": comment,
                        "next_date": moment(date).format("YYYY-MM-DDTHH:mm:ss")
                    }
                ).then((result) => {
                    this.clearCurrentData();
                    this.$store.dispatch('projects/fetchCallResults', this.$route.params.id).then(() => {
                        this.cleanRecalls();

                    })
                })
            },

            setLead(contactId, comment) {
                this.$store.dispatch('projects/setLead',
                    {
                        "contact_id": contactId,
                        "comment": comment,
                    }
                ).then((result) => {
                    this.clearCurrentData();
                    this.$store.dispatch('projects/fetchCallResults', this.$route.params.id).then(() => {
                        this.cleanRecalls();
                    })
                })
            },
            setReject(contactId, comment) {
                this.$store.dispatch('projects/setReject',
                    {
                        "contact_id": contactId,
                        "comment": comment,
                    }
                ).then((result) => {
                    this.clearCurrentData();
                    this.$store.dispatch('projects/fetchCallResults', this.$route.params.id).then(() => {
                        this.cleanRecalls();
                    })
                })
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
            startCallRecall(contact) {
                this.callStart = true;
                this.currentComment = contact.comment
                this.currentContact = contact.record;
            },
            startCall() {
                this.callStart = true;
                this.$store.dispatch('projects/loadNextNumber', this.project.id).then((result) => {
                    this.currentContact = result.data;
                })
            },
            endCall() {
                this.dialogInProcess = false;
                this.callStart = false;
                this.callEnded = true;
            },
            checkB(i) {
                if (i && i !== 0) {
                    return 'B2B'
                } else {
                    return 'B2C'
                }
            },
            toggleDay() {
                this.startIndex = 4;
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
