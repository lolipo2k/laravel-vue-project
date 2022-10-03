<template>
    <div>
        <div class="list-header__text" style="margin: 0 auto;    width: fit-content;">
            <h2>Добавление нового проекта</h2>
        </div>
        <div class="emp-card adding-project-form">
            <div class="align-center step-title" v-if="curStep < 4">
                ШАГ {{curStep}}
            </div>
            <div class="align-center step-title" v-if="curStep === 4">
                Опции и оплата
            </div>
            <div class="step-content">
                <div v-if="curStep === 1" class="row">
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasName ? 'not_filled':''">
                            <h5>Название проекта</h5>
                            <p>Придумайте короткое и емкое название вашего проекта</p>
                            <div>
                                <input required class="w100" type="text" v-model="form.name"
                                       placeholder="Например: Оптовая продажа пряников">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasCategories ? 'not_filled':''">
                            <h5>Выберите тематику проекта</h5>
                            <p>Не беспокойтесь, если не удалось подобрать точно соответсвующую тематику - вы еще сможете
                                ее подкорректировать с менеджером</p>
                            <div>
                                <multiselect v-model="form.field_categories" tag-placeholder="Add this as new tag"
                                             placeholder="Начните ввод" label="value" track-by="id"
                                             :options="filteredTematics()" :multiple="false"></multiselect>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile">
                            <h5>Целевая аудитория</h5>
                            <p>В данный момент смостоятельный выбор целевой аудитории недоступен, ЦА будет заполнена
                                после звонка менеджера</p>
                            <div>
                                <input class="w100" type="text" placeholder="ЦА будет заполнена позже" disabled>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasRegions ? 'not_filled':''">
                            <h5>Выберите регионы</h5>
                            <p>Выберите те регионы, в которых вы хотите совершать обзвон. Для максимального охвата можно
                                выбрать регион "Россия"</p>
                            <div>
                                <multiselect v-model="form.regions" :options="filteredRegions()"
                                             placeholder="поиск региона" label="name" track-by="name"
                                             :multiple="true"></multiselect>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12" v-if="form.regions">
                        <div class="profile-work border-bottom-profile">
                            <h5>Выберите приоритетные регионы</h5>
                            <p>Не более 5 штук, эти регионы будут отмечены приоритетными по проекту.</p>
                            <div>
                                <b-form-group>
                                    <b-form-checkbox-group
                                        v-model="form.regionsMain"
                                        :options="form.regions"
                                        name="buttons-1"
                                        value-field="id"
                                        button-variant="outline-primary"
                                        text-field="name"
                                        @input="checkCount"
                                        buttons
                                    ></b-form-checkbox-group>
                                </b-form-group>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasB2b ? 'not_filled':''">
                            <h5>Укажите категорию</h5>
                            <div :class="!form.b2b ? 'red-border' : ''">
                                <b-form-group>
                                    <b-form-checkbox-group
                                        v-model="form.b2b"
                                        :options="b2boptions"
                                        buttons
                                        button-variant="outline-primary"
                                        size="lg"
                                        name="buttons-2"
                                    ></b-form-checkbox-group>
                                </b-form-group>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasDescription ? 'not_filled':''">
                            <h5>Кратко опишите проект</h5>
                            <div>
                                <textarea type="text" v-model="form.description"/>
                            </div>

                        </div>
                    </div>
                </div>
                <div v-if="curStep === 2" class="row">
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile">
                            <h5>Выберите критерии лида </h5>
                            <p>Выберите какими параметрами должен обладать лид</p>
                            <p>Мы советуем выбирать все предложенные критерии, чтобы лид был максимально
                                качественным</p>
                            <div>
                                <div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="Check_1"
                                               v-model="form.lead_criteries.lead_criteries_1">
                                        <label class="form-check-label" for="Check_1">{{getCriteriaName(1)}}</label>
                                    </div>
                                    <br/>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="Check_5"
                                               v-model="form.lead_criteries.lead_criteries_5">
                                        <label class="form-check-label" for="Check_5">{{getCriteriaName(5)}}
                                            <input required class="w100"
                                                   style="width: 350px;height: 22px;text-align: center;" type="text"
                                                   v-model="form.lead_criteries.criterion_position" placeholder="">
                                        </label>
                                    </div>
                                    <br/>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="Check_2"
                                               v-model="form.lead_criteries.lead_criteries_2">
                                        <label class="form-check-label" for="Check_2">{{getCriteriaName(2)}}
                                        </label>

                                    </div>
                                    <br/>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="Check_3"
                                               v-model="form.lead_criteries.lead_criteries_3">
                                        <label class="form-check-label" for="Check_3">{{getCriteriaName(3)}}</label>
                                    </div>
                                    <br/>
                                    <div class="form-check"
                                         :class="form.lead_criteries.lead_criteries_4 ? 'not_filled':''">
                                        <input type="checkbox" class="form-check-input" id="Check_4"
                                               v-model="form.lead_criteries.lead_criteries_4">
                                        <label class="form-check-label" for="Check_4">контактное лицо подвердило наличие
                                            минимального бюджета
                                            <input required class="w100"
                                                   style="width: 80px; height: 22px; text-align: center;" type="text"
                                                   v-model="form.lead_criteries.criterion_price" placeholder="">
                                            руб. и отсутствие ограничений к заключению договора в течение
                                            <input required class="w100"
                                                   style="width: 50px;height: 22px;text-align: center;" type="text"
                                                   v-model="form.lead_criteries.criterion_mounth" placeholder="">
                                            месяцев</label>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div v-if="curStep === 3" class="row">
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasFirm ? 'not_filled':''">
                            <h5>Название компании</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.firm"
                                       placeholder="Например: ООО Отважный">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasSite ? 'not_filled':''">
                            <h5>Домен сайта</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.site"
                                       placeholder="Например: www.domen.ru">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasLegalAddress ? 'not_filled':''">
                            <h5>Юридический адрес</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.legal_address"
                                       placeholder="Например: г. Тула, , ул. Оборонная, 35, 3 этаж">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasAddress ? 'not_filled':''">
                            <h5>Фактический адрес</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.firm_address"
                                       placeholder="Например: г. Тула, , ул. Оборонная, 35, 3 этаж">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasPostalAddress ? 'not_filled':''">
                            <h5>Почтовый адрес</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.postal_address"
                                       placeholder="Например: г. Тула, , ул. Оборонная, 35, 3 этаж">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!hasDirector ? 'not_filled':''">
                            <h5>ФИО Генерального директора</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.director"
                                       placeholder="Например: Иванов Иван Иванович">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!form.inn ? 'not_filled':''">
                            <h5>ИНН</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.inn"
                                       placeholder="Например: Иванов Иван Иванович">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="profile-work border-bottom-profile" :class="!form.kpp ? 'not_filled':''">
                            <h5>КПП</h5>
                            <div>
                                <input class="w100" type="text" v-model="form.kpp"
                                       placeholder="Например: Иванов Иван Иванович">
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="curStep === 4" class="row">
                    <div class="profile-work border-bottom-profile" style="width: 100%;">
                        <div class="col-md-12">
                            <b-form-checkbox v-model="form.script" name="check-button" switch>
                                Нужен скрипт (нами будет разработан индивидуальный скрипт)
                            </b-form-checkbox>
                        </div>
                        <div class="col-md-12" v-if="!form.script">
                            <div style="margin-top: 4px">Вставьте свой текст скрипта</div>
                            <textarea
                                placeholder="
Например:
Приветствие:	Здравствуйте, меня зовут *Имя менеджера*!
Выяснение обстоятельств:	Вы недавно были на вебинаре «Английский язык за 100 часов по методу полиглотов». Верно?
А как я могу к вам обращаться?

Говорим о цели звонка и презентуем товар:
Уточняем	Вы были до самого конца?
Если да:
Значит, вы в курсе, что сейчас у нас действуют особые условия: возможность начать обучение, оплатив всего 12 900 или 34 830 рублей за весь курс. Вы уже подали заявку?

Если нет:
Значит, я не зря вам звоню. На вебинаре озвучивалось, что сейчас у нас действуют особые условия: возможность начать обучение, оплатив всего 12 900 или 34 830 рублей за весь курс. Вы уже подали заявку?

Ответ на возможные возражения:	Перечисление аргументированных преимуществ курса
Фиксируем покупку и прощаемся:	Хорошо, *Имя клиента*, в пятницу (вторник) проверьте вашу почту. Мы пришлем приглашение на этот вебинар и дополнительные материалы, которые будут вам интересны.
Присоединяйтесь к нам!

Пожалуйста, не опаздывайте!

Встреча начнется ровно в 21:00 по московскому времени.

До свидания!"
                                name="script" id="" cols="30" rows="10" v-model="form.script_text"></textarea>
                        </div>
                        <div class="col-md-12">
                            <b-form-checkbox v-model="form.base" name="check-button" switch>
                                Нужна база (для проекта будет подобрано 400 контактов)
                            </b-form-checkbox>
                            <p></p>
                            <div v-if="!form.base">
                                <div>
                                    Загрузите файл с базой контактов в формате .csv (размер файла - до 15мб)
                                </div>
                                <div>
                                    <a href="">Скачать образец файла</a>
                                </div>

                                <input type="file" name="file" style="margin-bottom: 1rem" @change="onFileChange"/>

                                <div class="demo"
                                     v-if="baseTableData.data && baseTableData.data.data && baseTableData.data.data.length">
                                    <div>
                                        Образец загруженных данных:
                                        <div>
                                            <small>
                                                Если вы видите некорректные данные, внесите изменения в загружаемый файл
                                                и приложите его снова.
                                            </small>
                                        </div>
                                    </div>
                                    <table class="demo-table">
                                        <tr v-for="(contact,index) in baseTableData.data.data" v-if="index < 15"
                                            class="table-line">
                                            <td>{{contact.company}}</td>
                                            <td style="text-align: right">
                                                <template v-for="name in separate(contact.names)">{{name}}<br>
                                                </template>
                                            </td>
                                            <td>
                                                <template v-for="phone in separate(contact.phones)">{{phone}}<br>
                                                </template>
                                            </td>
                                            <td>{{contact.info}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-work border-bottom-profile" style="width: 100%;">
                        <div class="col-md-12">
                            <p>Укажите количество лидов для проекта</p>
                            <b-form-select v-model="form.leads" :options="leadsCountOptions"></b-form-select>
                        </div>
                    </div>
                    <div class="profile-work border-bottom-profile" style="width: 100%;">
                        <div v-if="form.script" class="col-md-12">
                            <p class="price-option">Скрипт: <span>+ 800 руб.</span></p>
                        </div>
                        <div v-if="form.base" class="col-md-12">
                            <p class="price-option">База: <span>+ 3600 руб.</span></p>
                        </div>
                        <div class="col-md-12" v-if="form.leads && findFieldById()">
                            <p class="price-option">Лиды: <span>+ {{form.leads * findFieldById().price}} руб.</span></p>
                        </div>
                        <div class="col-md-12">
                            <p class="price-option">Базовый аккаунт:
                                <span v-if="profile.payment_status == 0">+ 3800 руб. (в месяц)</span>
                                <span
                                    v-else>+ 0 руб. оплачен до ({{profile.active_to | moment("DD/MM/YYYY  HH:mm") }})</span>
                            </p>
                        </div>
                    </div>
                    <div class="profile-work border-bottom-profile" style="width: 100%;">
                        <div class="col-md-12" v-if="form.leads && findFieldById()">
                            <p class="price-option">Всего: <span style="font-weight: 900;">{{costCalculate}}</span></p>
                        </div>
                    </div>


                </div>

            </div>
            <div class="step-footer align-center">
                <div v-if="!checkRequired">
                    <span
                        style="width: fit-content; font-weight: 400; color: #fff; display: block; margin-bottom: 20px; background-color: red; padding: 5px; border-radius: 5px">Заполните обязательные поля</span>
                </div>
                <div class="navigate-buttons">
                    <b-button v-if="curStep > 1" @click="prev" variant="primary">Назад</b-button>
                    <b-button v-if="curStep < 4" @click="next" variant="primary" :disabled="!checkRequired">Дальше
                    </b-button>
                    <div class="pay-buttons">
                        <b-button v-if="curStep === 4" @click="addProject(2)" :disabled="projectSend"
                                  class="btn-success" block style="display: inline-flex;max-width: fit-content;">
                            Сохранить и оплатить позднее
                        </b-button>
                        <b-button v-if="curStep === 4 && !showPaymentMethods" @click="showPayment()"
                                  :disabled="projectSend" class="btn-success" block
                                  style="display: inline-flex;max-width: fit-content;">Оплатить
                        </b-button>
                        <b-button v-if="curStep === 4 && showPaymentMethods" @click="addProject(2)"
                                  :disabled="projectSend" class="btn-success" block
                                  style="display: inline-flex;max-width: fit-content;">Оплатить по счету
                        </b-button>
                        <b-button v-if="curStep === 4 && showPaymentMethods" @click="addProject(1)"
                                  :disabled="projectSend" class="btn-success" block
                                  style="display: inline-flex;max-width: fit-content;">Онлайн оплата
                        </b-button>
                    </div>

                </div>

            </div>
        </div>

        <b-modal v-model="warnVisible">
            <template v-slot:modal-title>
                Ваш проект создан
            </template>
            В течение 24 часов с вами свяжется ваш менеджер для согласования целевой аудитории и уточнения деталей.
            <br>
            Счет и квитанция будут размещены в разделе <b>Финансы</b>. <br>
            После поступления оплаты проект станет доступен исполнителям.
            <template v-slot:modal-footer>
                <router-link
                    class="mt-3 btn btn-primary"
                    :to="{ path: '/' }"
                    @click.native="warnVisible = false"
                >Все понятно
                </router-link>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import {LEAD_CRITERION_NAMES} from "../../store/projects/lead-criterias";

    export default {
        name: "AddNewProject",
        data: function () {
            return {
                projectSend: false,

                warnVisible: false,

                baseTableData: {},

                curStep: 1,
                stepCount: 5,
                form: {
                    name: '',
                    description: '',
                    regions: null,
                    regionsMain: [],
                    lead_criteries: {
                        lead_criteries_1: false,
                        lead_criteries_2: false,
                        lead_criteries_3: false,
                        lead_criteries_4: false,
                        lead_criteries_5: false,
                        criterion_price: null,
                        criterion_mounth: null,
                        criterion_position: null,
                    },
                    field_categories: null,
                    b2b: null,
                    firm: '',
                    site: '',
                    firm_address: '',
                    legal_address: '',
                    postal_address: '',
                    director: '',
                    inn: '',
                    kpp: '',
                    script: true,
                    base: true,
                    leads: 10,
                    script_text: null,
                    script_file: null,
                    base_file: null,
                    contacts: []
                },
                b2boptions: [
                    {text: 'B2B', value: 'b2b'},
                    {text: 'B2C', value: 'b2c'},
                ],
                leadsCountOptions: [
                    {value: 5, text: 5},
                    {value: 10, text: 10},
                    {value: 15, text: 15},
                    {value: 20, text: 20},
                ],
                showPaymentMethods: false,
            }
        },
        created() {
            this.$store.dispatch('taxonomy/fetchWorkExperience')
            this.$store.dispatch('taxonomy/fetchFields')
            this.$store.dispatch('taxonomy/fetchFieldCategories')
            this.$store.dispatch('taxonomy/fetchRegions')

            this.projectSend = false;

        },
        computed: {
            profile() {
                return this.$store.getters["user/profile"]
            },
            taxonomy() {
                return this.$store.getters["taxonomy/fields"]
            },
            experience() {
                return this.$store.getters["taxonomy/workExperience"]
            },
            regions() {
                return this.$store.getters["taxonomy/regions"]
            },
            fieldCategories() {
                return this.$store.getters["taxonomy/fieldCategories"]
            },

            costCalculate() {
                let cost = 0;
                if (this.form.script) {
                    cost = cost + 800;
                }
                if (this.form.base) {
                    cost = cost + 3600;
                }
                if (this.profile.payment_status == 0) {
                    cost = cost + 3800;
                }

                cost = cost + (this.form.leads * this.findFieldById().price)
                return cost;
            },

            checkRequired() {
                if (this.curStep === 1) {
                    if (this.hasName && this.hasRegions && this.hasCategories && this.hasDescription && this.hasB2b) {
                        return true
                    }
                }
                if (this.curStep === 2) {
                    if (this.form.lead_criteries.lead_criteries_4 && this.form.lead_criteries.criterion_mounth && this.form.lead_criteries.criterion_price) {
                        return true
                    } else if (this.form.lead_criteries.lead_criteries_4) {
                        return false
                    }

                    if (this.form.lead_criteries.lead_criteries_1 || this.form.lead_criteries.lead_criteries_2 || this.form.lead_criteries.lead_criteries_3) {
                        return true
                    }

                }
                if (this.curStep === 3) {
                    if (this.hasFirm && this.hasAddress && this.hasLegalAddress && this.hasPostalAddress && this.hasDirector && this.hasSite && this.form.inn && this.form.kpp) {
                        return true
                    }
                }
                if (this.curStep === 4) {
                    return true
                }
                return false
            },

            hasName() {
                if (this.form.name) {
                    return true
                }
            },

            hasCategories() {
                if (this.form.field_categories) {
                    return true
                }
            },

            hasRegions() {
                if (this.form.regions) {
                    return true
                }
            },

            hasB2b() {
                if (this.form.b2b) {
                    return true
                }
            },
            hasDescription() {
                if (this.form.description) {
                    return true
                }
            },
            hasFirm() {
                if (this.form.firm) {
                    return true
                }
            },
            hasSite() {
                if (this.form.site) {
                    return true
                }
            },
            hasAddress() {
                if (this.form.firm_address) {
                    return true
                }
            },
            hasLegalAddress() {
                if (this.form.legal_address) {
                    return true
                }
            },
            hasPostalAddress() {
                if (this.form.postal_address) {
                    return true
                }
            },
            hasDirector() {
                if (this.form.director) {
                    return true
                }
            },
        },

        methods: {
            next() {
                this.curStep = this.curStep + 1;
            },
            prev() {
                this.curStep = this.curStep - 1;
            },

            getCriteriaName(criteriaId) {
                return LEAD_CRITERION_NAMES[criteriaId];
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

            filteredRegions() {
                let filter = _.map(this.regions.data, data => {
                    return {
                        id: data.id,
                        name: data.name,
                    }
                });
                return filter
            },
            filteredCategories() {
                let filter = _.map(this.fieldCategories.data, data => {
                    return {
                        id: data.id,
                        value: data.name,
                    }
                });
                return filter
            },

            filteredTematics() {
                let filter = _.map(this.taxonomy.data, data => {
                    return {
                        id: data.id,
                        value: data.name,
                    }
                });
                return filter
            },
            setCategories() {
                let filter = _.map(this.profile.field_categories, data => {
                    return {
                        id: data.id,
                        value: data.name,
                    }
                });
                this.form.field_categories = filter;
            },
            findFieldById() {
                if (this.form.field_categories && this.taxonomy.data) {
                    let field = this.taxonomy.data.filter(item => item.id === this.form.field_categories.id);
                    return field[0];
                }

            },

            makeToast() {
                this.$bvToast.toast(`Возможно указать только 5 регионов `, {
                    title: '',
                    autoHideDelay: 5000,
                })
            },

            addProject(pay) {

                this.projectSend = true;
                this.form.b2b = [this.form.b2b];
                this.$store.dispatch('projects/putProject', this.form).then((result) => {

                    let invoice = {}
                    if (result.project.id) {
                        if (pay == 1) {
                            let rate = 0;
                            if(this.profile.payment_status == 0){
                                rate = 1;
                            }
                            let contacts = 0;
                            if(this.form.base){
                                contacts = 1;
                            }
                            let leads = 0;
                            if(this.form.leads && this.form.leads > 0){
                                leads = this.form.leads;
                            }

                            invoice = {
                                "title": this.form.name,
                                "project_id": result.project.id,
                                "type": 1,
                                "amount": this.costCalculate,
                                "for_rate": rate,
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

                        } else {
                            this.warnVisible = true;
                            let rate = 0;
                            if(this.profile.payment_status == 0){
                                rate = 1;
                            }
                            let contacts = 0;
                            if(this.form.base){
                                contacts = 1;
                            }
                            let leads = 0;
                            if(this.form.leads && this.form.leads > 0){
                                leads = this.form.leads;
                            }

                            invoice = {
                                "title": this.form.name,
                                "project_id": result.project.id,
                                "type": 2,
                                "amount": this.costCalculate,
                                "for_rate": rate,
                                "for_leads": leads,
                                "for_contacts": contacts,
                            }
                            this.$store.dispatch('projects/createInvoice', invoice).then((result) => {
                            })
                        }
                    }


                }).catch(error => {
                    this.$bvToast.toast(`Невозможно добавить проект `, {
                        title: '',
                        autoHideDelay: 5000,
                    })
                    this.projectSend = false;

                })

            },

            checkCount(arg) {
                if (arg.length === 6) {
                    this.form.regionsMain.pop();
                    this.makeToast();
                }
            },
            showPayment() {
                this.showPaymentMethods = true
            }
        },

    }
</script>

<style scoped>
    .emp-card {
        padding: 3%;
        border-radius: 0.5rem;
        background: #fff;
        max-width: 680px;
        margin: 0 auto;
    }

    .multiselect__option {
        font-size: 13px !important;
    }

    .step-title {
        text-align: center;
        padding-bottom: 20px;
        font-size: 26px;
        font-weight: 700;
        color: #3a75b5;
    }

    .adding-project-form {

    }

    .adding-project-form .btn {
        border-radius: 5px !important;
        margin-right: 10px;
    }

    .adding-project-form .btn-group {
        display: inline-block !important;
        font-size: 13px !important;
    }

    .adding-project-form .btn-group label {
        font-size: 13px !important;
    }

    .multiselect__tag {
        margin-bottom: 0 !important;
    }

    .price-option span {
        font-size: 20px;
        font-weight: 400;
        color: #28a745;
    }

    .red-border {
        width: fit-content;
        border: 2px solid red;
        height: fit-content;
        border-radius: 7px;
    }

    .red-border .form-group {
        margin-bottom: 0;
    }

    .navigate-buttons {
        display: flex;
        align-items: center;
    }

    .pay-buttons {
        display: inline-flex;
        margin-right: auto;
        margin-right: 0;
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: 100%;
        align-items: center;
    }

    .pay-buttons button {
        font-size: 13px;
    }

    .pay-buttons button {
        margin-top: 0;
        margin-right: 10px;
    }

    .demo-table {
        border: 1px solid #6d6b6b;
        border-radius: 6px;
        width: 100%;
        font-size: 12px;
    }

    .demo-table .table-line {
        border-bottom: 1px solid rgb(109 107 107);
        display: flex;
        justify-content: space-between;
    }

    .demo-table td {
        padding: 4px;
        text-align: left;
        width: 25%;
    }

    .demo {
        background-color: #eae8b8;
        padding: 20px;
        border-radius: 10px;
    }


</style>
