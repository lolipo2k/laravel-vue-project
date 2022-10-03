<template>
    <div class="container emp-profile" v-if="profile">
        <form method="post">
            <div class="row">
                <div class="col-md-5">
                    <a v-if="profile.moderator && profile.moderator.phone" class="profile-edit-btn"
                       :href="'https://wa.me/' + profile.moderator.phone" target="_blank" style="text-decoration: none">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-right-text-fill"
                             fill="#219c32" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353V2zM3.5 3a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
                        </svg>
                        Написать куратору
                    </a>

                </div>
                <div class="col-md-7">

                    <div v-if="!editMode" @click="editModeToggle" class="profile-edit-btn text-right" name="btnAddMore">
                        <svg style="margin-top: -3px;" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil"
                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                            <path fill-rule="evenodd"
                                  d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                        </svg>
                        Редактировать профиль
                    </div>
                    <div v-if="editMode" @click="editModeToggle" class="profile-edit-btn text-right" name="btnAddMore">
                        <svg style="margin-top: -3px; color: red;" width="1em" height="1em" viewBox="0 0 16 16"
                             class="bi bi-backspace" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M6.603 2h7.08a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1h-7.08a1 1 0 0 1-.76-.35L1 8l4.844-5.65A1 1 0 0 1 6.603 2zm7.08-1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1h7.08z"/>
                            <path fill-rule="evenodd"
                                  d="M5.83 5.146a.5.5 0 0 0 0 .708l5 5a.5.5 0 0 0 .707-.708l-5-5a.5.5 0 0 0-.708 0z"/>
                            <path fill-rule="evenodd"
                                  d="M11.537 5.146a.5.5 0 0 1 0 .708l-5 5a.5.5 0 0 1-.708-.708l5-5a.5.5 0 0 1 .707 0z"/>
                        </svg>
                        Отменить изменения
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="profile-img">
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

                        <div class="file btn btn-lg btn-primary">
                            Заменить фото
                            <input type="file" name="file" @change="onFileChange"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="profile-head border-bottom-profile">
                        <h5>
                            {{profile.name}} {{profile.last_name}}

                            <div class="password"><b-icon icon="key" @click="showPassChanger = true"></b-icon>
                                Изменить пароль для входа в аккаунт
                            </div>
                        </h5>
                        <div v-if="profile && profile.role ==='client'">
                            <template v-if="profile.payment_status == 0">
                                     <span class="account-not-paid">Аккаунт не оплачен
                                        <b-button v-b-tooltip.hover title="При неоплаченном аккаунте работа по всем вашим проектам останавливается даже если баланс лидов еще не исчерпан." class="help-icon">
                                            <div class="count">
                                                <b-icon icon="exclamation-circle"></b-icon>
                                            </div>
                                        </b-button>
                                    </span>
                                        <span>
                                            <b-button size="sm" v-if="!showPaymentMethods" @click="showPayment()" :disabled="projectSend" class="btn-success" block style="display: inline-flex;max-width: fit-content;">Оплатить</b-button>
                                            <b-button size="sm" v-if="showPaymentMethods" @click="payTarifInvoice()" :disabled="projectSend" class="btn-success" block style="display: inline-flex;max-width: fit-content;">Оплатить по счету</b-button>
                                            <b-button size="sm"  v-if="showPaymentMethods" @click="payTarifOnline()" :disabled="projectSend" class="btn-success" block style="margin-top: 0; display: inline-flex;max-width: fit-content;">Онлайн оплата</b-button>
                                    </span>
                            </template>
                            <template v-else>
                                <span class="account-paid">Аккаунт оплачен до ({{profile.active_to | moment("DD/MM/YYYY  HH:mm") }})</span>
                            </template>
                        </div>
<!--                        <div v-if="!editMode" class="profile-description">{{form.description}}</div>-->
<!--                        <textarea v-if="editMode" type="text" v-model="form.description"/>-->
                        <!--                        <p class="proile-rating">Опыт : <span>8/10</span></p>-->
                        <!--                        <ul class="nav nav-tabs" id="myTab" role="tablist">-->
                        <!--                            <li class="nav-item">-->
                        <!--                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Про меня</a>-->
                        <!--                            </li>-->
                        <!--&lt;!&ndash;                            <li class="nav-item">&ndash;&gt;-->
                        <!--&lt;!&ndash;                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Уровень</a>&ndash;&gt;-->
                        <!--&lt;!&ndash;                            </li>&ndash;&gt;-->
                        <!--                        </ul>-->
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="tab-content profile-tab border-bottom-profile" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row" v-if="editMode">
                                <div class="col-md-6">
                                    <label>Имя</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="w100" type="text" v-model="form.name">
                                </div>
                            </div>
                            <div class="row" v-if="editMode">
                                <div class="col-md-6">
                                    <label>Фамилия</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="w100" type="text" v-model="form.last_name">
                                </div>
                            </div>
                            <div class="row" v-if="!editMode">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{profile.email}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Телефон</label>
                                </div>
                                <div class="col-md-6">
                                    <span v-if="profile && profile.role ==='client'">
                                            <b-badge @click="confirmPhoneModal" class="confirm-phone" variant="danger"
                                                     style="font-size: 12px;"
                                                     v-if="profile && !profile.phone_confirmed">Телефон не подтвержден</b-badge>
                                            <b-badge variant="success" style="font-size: 12px;"
                                                     v-if="profile && profile.phone_confirmed">Телефон подтвержден</b-badge>
                                    </span>


                                    <p v-if="!editMode">{{profile.phone}}</p>
                                    <input class="w100" v-else-if="profile.role !=='client'" type="text" v-model="form.phone">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label v-if="editMode" class="typo__label">Укажите свой регион</label>
                                    <label v-if="!editMode" class="typo__label">Ваш регион</label>
                                </div>
                                <div class="col-md-6">
<!--                                    {{form}}-->
                                    <p v-if="!editMode && form.region && form.region.name">{{form.region.name}}</p>
                                    <multiselect v-if="editMode" v-model="form.region_id" :options="filteredRegions()"
                                                 placeholder="поиск региона" label="name" track-by="name"></multiselect>
                                </div>

                                <!--                                <pre v-if="form.region" class="language-json"><code>{{ form.region_id.id  }}</code></pre>-->
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-md-12" v-if="profile.role !=='client'">
                    <div class="profile-work border-bottom-profile">
                        <h5>Тематики</h5>
                        <p v-if="editMode">Выберите и регулярно пополняйте тематики, с которыми приходилось работать</p>
                        <div v-if="!editMode" v-for="item in profile.field_categories">{{item.name}}</div>
                        <br/>
                        <div v-if="editMode">
                            <multiselect v-model="form.field_categories" tag-placeholder="Add this as new tag"
                                         placeholder="Search or add a tag" label="value" track-by="id"
                                         :options="filteredCategories()" :multiple="true"></multiselect>
                        </div>

                    </div>
                </div>
                <div class="col-md-12" v-if="profile.role !=='client'">
                    <div class="profile-work border-bottom-profile">
                        <h5>Опыт работы </h5>
                        <p v-if="editMode">Опыт работы - выбери все пункты, в которых у тебя есть опыт</p>
                        <div v-if="!editMode" v-for="item in profile.work_experience">{{item.name}}</div>
                        <br/>

                        <div v-if="editMode" v-for="item in form.workExperience" :key="item.id">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" :id="'Check' + item.id"
                                       v-model="item.checked">
                                <label class="form-check-label" :for="'Check' + item.id">{{item.name}}</label>
                            </div>
                        </div>
                        <br/>
                        <div v-if="editMode">

                        </div>

                    </div>
                </div>

                <div class="col-md-12" v-if="editMode">
                    <b-button class="mt-3 btn btn-success" block @click="saveProfile">Сохранить</b-button>
                </div>
            </div>
        </form>

        <b-modal v-model="showPassChanger">
            <template v-slot:modal-title>
                Изменение пароля для входа


            </template>


            <div>Придумайте надежный пароль <span class="password"><b-icon icon="eye"
                                                                           @click="switchVisibility"></b-icon></span>
            </div>
            <b-form-input :type="passwordFieldType" v-model="pass" placeholder="Введите новый пароль"></b-form-input>
            <div class="error" v-if="firstPassError">{{firstPassError}}</div>
            <b-form-input :type="passwordFieldType" style="margin-top: 20px" v-if="!firstPassError && pass.length > 1"
                          v-model="repeatPass" placeholder="Повторите пароль"></b-form-input>
            <div class="error" v-if="secondPassError">{{secondPassError}}</div>
            <template v-slot:modal-footer>
                <div>
                    <b-button @click="showPassChanger = false">Отменить</b-button>
                    <b-button variant="success"
                              :disabled="pass.length < 5 || repeatPass.length < 5 ||  firstPassError.length > 0 || secondPassError.length > 0"
                              @click="changePass">Сохранить
                    </b-button>
                </div>
            </template>
        </b-modal>

        <b-modal v-model="confirmPhone" v-if="profile.role ==='client'">
            <template v-slot:modal-title>
                Подтверждение номера телефона
            </template>
            На ваш номер: {{profile.phone}} будет отправлено сообщение, введите цифры из этого сообщения в поле ниже.
            <div class="send_code_button" @click="confirmPhoneSendCode" v-if="codeStatus !=='Код отправлен'">
                {{codeStatus}}
            </div>

            <div style="    text-align: center; opacity: 0.5;font-size: 12px;margin-top: 20px;">Код из сообщения</div>
            <input type="text" id="phone_confirm" class="form-control"
                   style=" width: 100px; margin: 0 auto;text-align: center;"
                   v-model="phoneConfirmText"
                   required>
            <template v-slot:modal-footer>
                <div style="margin: 0 auto;">
                    <b-button variant="success" :disabled="phoneConfirmText.length < 4" @click="confirmCode">
                        Подтвердить
                    </b-button>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>

    export default {
        name: "Profile",
        data: function () {
            return {
                showPassChanger: false,
                confirmPhone: false,

                codeStatus: 'Выслать код',

                phoneConfirmText: '',

                editMode: false,
                image: '',

                pass: '',
                firstPassError: '',
                repeatPass: '',
                secondPassError: '',

                passwordFieldType: 'password',

                form: {
                    name: '',
                    description: '',
                    last_name: '',
                    phone: '',
                    region: {},
                    region_id: null,
                    field_categories: [],
                    workExperience: null,
                },
                showPaymentMethods: false,
                projectSend: false,
            }
        },
        created() {
            this.$store.dispatch('taxonomy/fetchWorkExperience')
            this.$store.dispatch('taxonomy/fetchFields')
            this.$store.dispatch('taxonomy/fetchFieldCategories')
            this.$store.dispatch('taxonomy/fetchRegions')

            this.$store.dispatch('user/refreshProfile').then(()=>{
                this.setEditForm();
            })

        },
        mounted() {

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
            }
        },

        methods: {
            confirmPhoneModal() {
                this.confirmPhone = true
            },
            confirmPhoneSendCode() {
                this.codeStatus = 'Код отправлен';
            },
            confirmCode() {
                this.confirmPhone = false;
                if (this.phoneConfirmText === '1234') {
                    this.$bvToast.toast(`Номер телефона подтвержден`, {
                        title: '',
                        autoHideDelay: 5000,
                    })

                    this.$store.dispatch("user/confirmPhone")
                        .then(() => {
                            this.$store.dispatch('user/refreshProfile');
                        })
                } else {
                    this.$bvToast.toast(`Неверный код, номер телефона не подтвержден`, {
                        title: '',
                        autoHideDelay: 5000,
                    })
                }
            },
            changePass() {
                this.$store.dispatch("user/putNewPass", {'new_password': this.pass})
                    .then(() => {
                        // this.$store.dispatch('user/refreshProfile');
                        this.showPassChanger = false;
                        this.$bvToast.toast(`Новый пароль сохранен `, {
                            title: '',
                            autoHideDelay: 5000,
                        })
                    })
            },

            switchVisibility() {
                this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
            },

            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);

                if (files[0].size > 1024 * 1024 * 15) {
                    e.preventDefault();
                    alert('Вы пытетесь загрузить слишком большой файл, пожалуйста не используйте изображения больше 15 Мегабайт');
                    return;
                }

                this.$store.dispatch("user/putAvatar", files[0])
                    .then(() => {
                        this.$store.dispatch('user/refreshProfile');
                    })
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            editModeToggle() {
                this.editMode = !this.editMode;
            },
            setEditForm() {
                if (this.profile) {
                    this.form.name = this.profile.name;
                    this.form.last_name = this.profile.last_name;
                    this.form.phone = this.profile.phone;
                    this.form.description = this.profile.description;
                    this.form.region_id = this.profile.region_id;
                    this.form.region = this.profile.region;

                    this.setCategories();
                }
            },

            experienceFilter() {
                if (this.profile.role !== 'client') {
                    let filter = _.map(this.experience.data, data => {
                        return {
                            id: data.id,
                            name: data.name,
                            checked: (this.profile.work_experience.findIndex(x => x.id === data.id) !== -1)
                        }
                    });

                    this.form.workExperience = filter;
                }
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
            setCategories() {
                let filter = _.map(this.profile.field_categories, data => {
                    return {
                        id: data.id,
                        value: data.name,
                    }
                });
                this.form.field_categories = filter;
            },
            saveProfile() {
                if (this.form.workExperience) {
                    this.form.workExperience = this.form.workExperience.filter(item => item.checked);
                }

                if (this.form.region_id) {
                    this.form.region_id = this.form.region_id.id;
                }

                this.$store.dispatch("user/putProfile", this.form)
                    .then(() => {
                        this.$store.dispatch('user/refreshProfile');
                        this.editMode = false;
                        this.makeToast();
                    })
                    .catch(error => {
                        this.makeToast('error');
                    })
            },
            makeToast(error) {
                if (error !== 'error') {
                    this.$bvToast.toast(`Профиль сохранен `, {
                        title: '',
                        autoHideDelay: 5000,
                    })
                } else {
                    this.$bvToast.toast('При сохраннении произошла ошибка', {
                        title: '',
                        autoHideDelay: 5000,
                    })
                }
            },
            showPayment(){
                this.showPaymentMethods = true
            },
            payTarifOnline(){
                this.projectSend = true;
                let invoice = {
                    "title": 'Оплата тарифа',
                    "project_id": null,
                    "type": 2,
                    "for_rate": 1,
                    "amount": 3800
                }

                this.$store.dispatch('projects/createInvoice', invoice ).then((result)=>{
                    this.$store.dispatch('user/urlInvoices',
                        {
                            "invoice_id": result.id
                        }
                    ).then((result)=>{
                        window.open(result.url, '_blank');
                        this.$store.dispatch('user/refreshProfile').then(()=>{
                            this.setEditForm();
                            this.projectSend = false;
                        })
                    })
                })
            },
            payTarifInvoice(){
                this.projectSend = true;
                let invoice = {
                    "title": 'Оплата тарифа',
                    "project_id": null,
                    "type": 2,
                    "for_rate": 1,
                    "amount": 3800
                }

                this.$store.dispatch('projects/createInvoice', invoice ).then((result)=>{
                    this.$store.dispatch('user/urlInvoices',
                        {
                            "invoice_id": result.id
                        }
                    ).then((result)=>{
                        this.$bvToast.toast(`Запрос на выставление счета отправлен, он появится в разделе "Финансы", вы получите об этом уведомление`, {
                            title: '',
                            autoHideDelay: 5000,
                        })
                        this.projectSend = false;
                    })
                })
            },
        },
        watch: {
            pass() {
                if (this.pass.length < 6) {
                    this.firstPassError = 'Пароль должен быть не менее 6 символов'
                } else {
                    this.firstPassError = ''
                }
            },

            repeatPass() {
                if (this.repeatPass !== this.pass) {
                    this.secondPassError = 'Пароли не совпадают'
                } else {
                    this.secondPassError = ''
                }
            },

            profile(n) {
                this.experienceFilter();
                this.setEditForm();

            },
            experience(n) {
                this.experienceFilter();
                this.setEditForm();
            }
        }
    }
</script>

<style scoped>

    body {
        background: -webkit-linear-gradient(left, #3931af, #00c6ff) !important;
    }

    .password {
        cursor: pointer;
        font-size: 11px;
        margin-top: 9px;
        opacity: 0.5;

    }

    .password .b-icon.bi {
        margin-right: 0.3rem;
    }

    .account-paid{
        padding: 3px 11px;
        border-radius: 4px;
        border: 1px solid #e0e257;
        margin-top: 10px;
        display: block;
        width: fit-content;
    }

    .account-not-paid{
        padding: 3px 11px;
        border-radius: 4px;
        border: 1px solid red;
        color: red;
        margin-top: 10px;
        display: inline-block;
        width: fit-content;
    }


    .password:hover {
        opacity: 0.5;
    }

    .profile-description {
        font-size: 13px;
        color: #818182;
        font-weight: 100;
    }

    .profile-tab input {
        padding-left: 10px;
        color: #3d3b3b;
    }

    .avatar {
        border-radius: 5px;
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        height: 300px;
        background-position: center;
    }

    .emp-profile {
        padding: 3%;
        margin-top: 3%;
        margin-bottom: 3%;
        border-radius: 0.5rem;
        background: #fff;
        max-width: 550px;
    }

    .emp-profile .btn-sm{
        font-size: .775rem;
    }

    .profile-img {
        text-align: center;
        position: relative;
    }
    .learned{
        position: absolute;
        right: 0;
        top: 0;
        font-size: 20px;
        color: gold;
    }

    .profile-img img {
        width: 70%;
        height: 100%;
    }

    .profile-img .file {
        position: relative;
        overflow: hidden;
        margin-top: -20%;
        width: 70%;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #212529b8;
    }

    .profile-img .file input {
        position: absolute;
        opacity: 0;
        right: 0;
        top: 0;
    }

    .profile-head {
        margin-bottom: 20px;
    }

    .emp-profile input {
        margin-bottom: 0.5rem !important;
    }

    .emp-profile input[type=checkbox] {
        margin-bottom: 0 !important;

    }

    .emp-profile .form-check {
        display: flex;
        align-items: center;
    }

    .profile-head h6 {
        color: #0062cc;
    }

    .profile-edit-btn {
        display: block;
        border: none;
        border-radius: 1.5rem;
        width: 100%;
        padding: 2%;
        font-weight: 100;
        color: #6c757d;
        cursor: pointer;
        margin-top: -20px;
        font-size: 14px;
    }

    .proile-rating {
        font-size: 12px;
        color: #818182;
        margin-top: 5%;
    }

    .proile-rating span {
        color: #495057;
        font-size: 15px;
        font-weight: 600;
    }

    .profile-head .nav-tabs {
        margin-bottom: 5%;
    }

    .profile-head .nav-tabs .nav-link {
        font-weight: 600;
        border: none;
    }

    .profile-head .nav-tabs .nav-link.active {
        border: none;
        border-bottom: 2px solid #0062cc;
    }

    .profile-work {
        padding: 0;
        margin-top: 0px;
    }

    .profile-work p {
        font-size: 12px;
        color: #818182;
        font-weight: 600;
    }

    .profile-work a {
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        font-size: 14px;
    }

    .profile-work ul {
        list-style: none;
    }

    .profile-tab label {
        font-weight: 600;
    }

    .profile-tab p {
        font-weight: 600;
        color: #0062cc;
    }

    .confirm-phone:hover {
        cursor: pointer;
        opacity: 0.7;
        transform: scale(1.1, 1.1);
    }

    .send_code_button {
        cursor: pointer;
        width: fit-content;
        background: #c000ff;
        border-radius: 6px;
        line-height: 10px;
        padding: 10px 26px;
        color: #fff;
        margin: 0 auto;
        margin-top: 10px;
        box-shadow: 1px 1px 1px 1px #dadada;
    }

    .send_code_button:hover {
        box-shadow: 1px 1px 5px 3px #dadada;
    }
</style>
