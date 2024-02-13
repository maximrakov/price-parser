<template>
    <ul role="list" class="divide-y divide-gray-100">
        <li v-for="product in products" :key="products.name" class="gap-x-6 py-5">
            <div class="flex gap-x-4">
                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="product.image" alt=""/>
                <div class="min-w-0 flex-auto">
                    <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                       v-bind:href="'/product?id=' + product.id">
                        {{ product.name }}</a>
                    <p class="mt-1 truncate text-xs leading-5">Цена: {{ product.price }} рублей</p>
                </div>
            </div>
        </li>
    </ul>
    <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <a :href="gePreviousPageUrl()"
               class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <ChevronLeftIcon class="h-5 w-5" aria-hidden="true"/>
            </a>
            <ul class="inline-flex">
                <li v-for="pageNumber in getPageRange()">
                    <a :class="getClassForPaginationBlock(pageNumber)"
                       v-bind:href="getUrlForPage(pageNumber)">
                        {{ pageNumber }}
                    </a>
                </li>
                <li v-if="pageAmount - currentPage + 1 > elementsOnPage">
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                </li>
                <li>
                    <a v-bind:href="getUrlForPage(pageAmount)" :class="getClassForPaginationBlock(pageAmount)">
                        {{ pageAmount }}
                    </a>
                </li>
                <li>
                    <a :href="getNextPageUrl()"
                       class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true"/>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</template>

<script>
import Layout from "../Shared/Layout.vue";
import {ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/20/solid'

export default {
    name: "Subscriptions",
    components: {
        Layout,
        ChevronLeftIcon,
        ChevronRightIcon
    },
    methods: {
        getPageRange() {
            return Math.min(this.pageAmount - 1, this.currentPage + this.elementsOnPage - 2)
        },
        getClassForPaginationBlock(page) {
            if (page == this.currentPage) {
                return "relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600";
            } else {
                return "relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0";
            }
        },
        getNextPageUrl() {
            return this.getUrlForPage(Math.min(this.pageAmount, this.currentPage + 1));
        },
        gePreviousPageUrl() {
            return this.getUrlForPage(Math.max(1, this.currentPage - 1));
        },
        getUrlForPage(page) {
            return '?page=' + page;
        }
    },
    props: {
        products: Array,
        pageAmount: Number,
        elementsOnPage: Number,
        currentPage: Number
    },
    layout: Layout
}
</script>

<style scoped>

</style>
