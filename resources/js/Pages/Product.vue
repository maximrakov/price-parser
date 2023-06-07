<template>
    <div class="container mx-auto my-10">
        <div class="flex flex-col md:flex-row items-center">
            <img class="w-64 h-64 mb-6 md:mb-0 md:mr-6 rounded-lg shadow-lg" :src="image" :alt="product.name">
                        <Dialog v-if="showDialog">
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
                                        @click="closeDialog">
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
                    <td class="border px-4 py-2">{{ price.time }}</td>
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
            showDialog: false,
            image: 'https://via.placeholder.com/400x400',
            hasProduct: null,
            user: null
        };
    },
    methods: {
        toggleSubscription() {
            if (this.user['chatId'] === null) {
                this.showDialog = true;
            }
            let url = 'api/user/' + this.user.id + '/product/' + this.product.id;
            if (this.hasProduct) {
                axios.delete(url);
            } else {
                axios.post(url);
            }
            this.updateProductExistence()
        },

        closeDialog() {
            this.showDialog = false;
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
                console.log(this.user);
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
