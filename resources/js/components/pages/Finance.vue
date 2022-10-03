<template>
    <div>
        <h1>Счета</h1>
        <b-card no-body>
           <table class="table b-table table-striped table-hover">
               <thead>
               <tr>
                   <td>#</td>
                   <td>Дата</td>
                   <td>Наименование</td>
                   <td>Сумма</td>
                   <td>Статус</td>
                   <td></td>
               </tr>
               </thead>
               <tbody>
               <tr v-for="item in invoices" id="item.id" v-if="invoices.length > 0">
                   <td>Ш-{{item.id}}</td>
                   <td>{{item.created_at | moment("DD/MM/YYYY HH:MM") }}</td>
                   <td>{{item.title}}</td>
                   <td>{{item.amount}} руб.</td>
                   <td>
                        <span v-if="item.status == 0">Новый</span>
                        <span v-if="item.status == 1">Ожидается счет</span>
                        <span v-if="item.status == 2">Оплачен</span>
                        <span v-if="item.status == 3">Истек срок платежа</span>
                        <span v-if="item.status == 4">Отменен покупателм</span>
                        <span v-if="item.status == 5">Отменен продавцом</span>
                        <span v-if="item.status == 6">Ожидается оплата</span>
                   </td>
                   <td v-if="item.status && item.status === 2 && item.check">
                       <a :href="item.check" target="_blank"><b-icon icon="card-checklist"></b-icon>Скачать квитанцию</a>
                   </td>
                   <td v-else-if="item.status && item.status === 6">
                        <b-button @click="pay(item.id)" variant="primary" size="sm">Оплатить онлайн</b-button>
                       <a v-if="item.invoice" :href="'/'+item.invoice" target="_blank">  <b-button variant="primary" size="sm">Скачать счет</b-button></a>
                   </td>
                   <td v-else-if="!item.status">
                         <b-button @click="pay(item.id)" variant="primary" size="sm">Оплатить онлайн</b-button>
                   </td>
                   <td v-else></td>
               </tr>
               </tbody>

           </table>
        </b-card>
    </div>
</template>

<script>
    export default {
        name: "Finance",
        data() {
            return {
                items: [
                    {id : 1, number: '3213-Ш', date: '12.12.2020', status: 'оплачен', title: 'Оплата проекта Влдаивосток 2000', amount: 3400, check: 'kvit.pdf'},
                    {id : 2, number: '3243-Ш', date: '12.12.2020', status: 'ожидает оплаты', title: 'Оплата проекта Влдаивосток 2000', amount: 3400, invoice: 'invoice.pdf'},
                    {id : 3, number: '3513-Ш', date: '12.12.2020', status: 'отменен', title: 'Оплата проекта Влдаивосток 2000', amount: 3400},
                    {id : 1, number: '3213-Ш', date: '12.12.2020', status: 'оплачен', title: 'Оплата проекта Влдаивосток 2000', amount: 3400 , check: 'kvit.pdf'},
                    {id : 2, number: '3243-Ш', date: '12.12.2020', status: 'ожидает оплаты', title: 'Оплата проекта Влдаивосток 2000', amount: 3400, invoice: 'invoice.pdf'},
                    {id : 3, number: '3513-Ш', date: '12.12.2020', status: 'отменен', title: 'Оплата проекта Влдаивосток 2000', amount: 3400},
                ]
            }

        },
        created() {
            this.$store.dispatch("user/fetchInvoices");
        },
        computed:{
            invoices () {
                return this.$store.getters["user/userInvoices"]
            },
        },
        methods:{
            pay(id){
                this.$store.dispatch('user/urlInvoices',
                    {
                        "invoice_id": id
                    }).then((result)=>{
                        window.open(result.url, '_blank');
                })
            }
        }
    }
</script>

<style scoped>

</style>
