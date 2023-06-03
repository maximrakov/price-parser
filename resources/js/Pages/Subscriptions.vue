<template>
    <ul role="list" class="divide-y divide-gray-100">
        <li v-for="product in products" :key="products.name" class="gap-x-6 py-5">
            <div class="flex gap-x-4">
                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="product.imageUrl" alt=""/>
                <div class="min-w-0 flex-auto">
                    <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" v-bind:href="'/product/?id=' + product.id" >
                        {{ product.name }}</a>
                    <p class="mt-1 truncate text-xs leading-5">Цена: {{ product.price }} рублей</p>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
import Layout from "../Shared/Layout.vue";

export default {
    name: "Subscriptions",
    components: {
        Layout
    },
    props: {
        products: Array
    },
    layout: Layout
}
</script>

<style scoped>

</style>
