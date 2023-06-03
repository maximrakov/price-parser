<template>
    <div class="container mx-auto my-10">
        <div class="flex flex-col md:flex-row items-center">
            <img class="w-64 h-64 mb-6 md:mb-0 md:mr-6 rounded-lg shadow-lg" :src="image" :alt="product.name">
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

export default {
    data() {
        return {
            image: 'https://via.placeholder.com/400x400',
            hasProduct: this.updateProductExistence(),
        };
    },
    methods: {
        toggleSubscription() {

            const url = this.hasProduct ? 'api/unsubscribeProduct' : 'api/subscribeProduct';
            axios.post(url, {'id': this.product.id});
            this.updateProductExistence()
        },
        updateProductExistence() {
            axios
                .get('api/hasProduct', {params: {'id': this.product.id}})
                .then(response => this.hasProduct = response.data);
        }
    },
    components: {
        Layout
    },
    layout: Layout,
    props: {
        product: Object,
        priceHistory: Array
    },
}
</script>
