<template>
    <div class="container mx-auto my-10">
        <div class="flex flex-col md:flex-row items-center">
            <img class="w-64 h-64 mb-6 md:mb-0 md:mr-6 rounded-lg shadow-lg" :src="product.image" :alt="product.name">
            <Dialog v-if="showPriceDialog">
                <template #title>
                    <h2 class="text-lg font-medium mb-4">При достижении какой цены вас уведомить?</h2>
                    <h1></h1>
                </template>
                <template #body>
                    <input class="w-full px-3 py-2 border border-gray-300 rounded-md" type="number"
                           v-model="notificationPrice" placeholder="Enter a number">
                </template>
                <template #button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg" @click="closePriceDialog">OK</button>
                </template>
            </Dialog>

            <Dialog v-if="showWarnDialog">
                <template #title>
                    <h1>Вы не привязали телеграм</h1>
                </template>
                <template #body>
                    <div>
                        Откройте <a target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    href="/notifications">вкладку Notifications</a>
                        и привяжите телеграм
                    </div>
                </template>
                <template #button>
                    <button type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="closeWarnDialog">
                        Ok
                    </button>
                </template>
            </Dialog>
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold mb-2">{{ product.name }}</h1>
                <div>
                    <button
                        :class="[hasProduct ? 'bg-red-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded' : 'bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']"
                        @click="toggleSubscription">
                        <div v-if="hasProduct">Отписаться</div>
                        <div v-else>Подписаться</div>
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <table class="table-auto w-full">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Price</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(price, index) in priceHistory" :key="index">
                    <td class="border px-4 py-2">{{ price.created_at }}</td>
                    <td class="border px-4 py-2 text">{{ price.price }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import Layout from "../Shared/Layout.vue";
import axios from "axios";
import Dialog from "./Dialog.vue";

export default {
    data() {
        return {
            showPriceDialog: false,
            showWarnDialog: false,
            image: 'https://via.placeholder.com/400x400',
            hasProduct: null,
            user: null,
            notificationPrice: 1
        };
    },
    methods: {
        toggleSubscription() {
            if(this.hasProduct){
                let url = 'api/user/' + this.user.id + '/product/' + this.product.id;
                axios.delete(url).then(response => {this.updateProductExistence();});
            } else {
                this.showPriceDialog = true;
                if (this.user['chatId'] === null) {
                    this.showWarnDialog = true;
                }
            }
        },

        closeWarnDialog() {
            this.showWarnDialog = false;
        },

        closePriceDialog() {
            this.showPriceDialog = false;
            let url = 'api/user/' + this.user.id + '/product/' + this.product.id;
            axios.post(url, {notificationPrice: this.notificationPrice}).then(response => {this.updateProductExistence();});
            this.updateProductExistence();
        },

        updateProductExistence() {
            let url = 'api/user/' + this.user.id + '/product/' + this.product.id;
            axios.get(url)
                .then(response => this.hasProduct = true)
                .catch(response => this.hasProduct = false);
        }
    },
    created() {
        axios.get('api/user')
            .then(response => {
                this.user = response.data;
                this.updateProductExistence();
            });
    },
    components: {
        Layout,
        Dialog
    },
    layout: Layout,
    props: {
        product: Object,
        priceHistory: Array,
    },
}
</script>
