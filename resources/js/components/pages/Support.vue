<template>
    <div>
        <div class="list-header__text">
            <h1>Обратиться в поддержку</h1>
        </div>
        <b-card no-body class="mb-1" style="padding: 20px">

            <b-form @submit.stop.prevent>
                <label class="sr-only" for="inline-form-input-name">Имя</label>
                <b-input style="margin-bottom: 10px"
                    v-model="form.name"
                    id="inline-form-input-name"
                    class="mb-2"
                    placeholder="Иван Таранов"
                         :state="validationName"
                ></b-input>

                <label class="sr-only" for="inline-form-input-email">Email</label>
                <b-input-group prepend="@" class="mb-2">
                    <b-input v-model="form.email" id="inline-form-input-email" placeholder="email" :state="validationEmail"></b-input>
                </b-input-group>

                <label class="sr-only" for="inline-form-input-phone">Телефон</label>
                <b-input-group prepend="+" class="mb-2">
                    <b-input v-model="form.phone" id="inline-form-input-phone" placeholder="ваш номер телефона" :state="validationPhone"></b-input>
                </b-input-group>

                <label for="feedback-user">Опишите вашу ситуацию </label>
                <b-input v-model="form.text" :state="validation" id="feedback-user"></b-input>
                <b-form-invalid-feedback :state="validation">
                    Ваше сообщение должно быть больше 10 символов
                </b-form-invalid-feedback>
                <b-form-valid-feedback :state="validation">
                    Нам очень жаль, если у вас возникли какие-то сложности, мы постараемся во всем разобраться и ответим вам на указанный email.
                </b-form-valid-feedback>

                <b-button @click="send" variant="primary"  style="margin-top: 20px;" :disabled="!validation || !validationEmail || !validationPhone || !validationName || disableForm">{{formResult}}</b-button>

            </b-form>
        </b-card>
    </div>
</template>

<script>
    export default {
        name: "Support",
        data() {
            return {
                form:{
                    name: '',
                    email: '',
                    phone: '',
                    text: '',
                },

                disableForm: false,

                formResult: 'Отправить',

                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/

            }
        },
        computed: {
            profile () {
                return this.$store.getters["user/profile"]
            },
            validation() {
                return this.form.text.length > 10
            },
            validationEmail() {
                if(this.form.email.length > 0){
                    return this.reg.test(this.form.email);
                }
                else{
                    return false
                }

            },

            validationPhone() {
                return this.form.phone.length > 6
            },

            validationName() {
                return this.form.name.length > 2
            }
        },
        created() {
            this.$store.dispatch('user/refreshProfile').then(()=>{
                if(this.profile.name){
                    this.form.name = this.profile.name;
                }
                if(this.profile.email){
                    this.form.email = this.profile.email;
                }
                if(this.profile.phone){
                    this.form.phone = this.profile.phone;
                }

            })
            this.formResult = 'Отправить';
        },
        methods:{
            send(){
                this.$store.dispatch('user/sendSupport', this.form).then((result)=>{
                   this.formResult = 'Форма отправлена, следующее сообщение можно будет отправить через минуту';
                   this.disableForm = true;

                    setTimeout(function () {
                      this.disableForm = false;
                    }, 60000);

                })
            }
        }

    }
</script>

<style scoped>

</style>
