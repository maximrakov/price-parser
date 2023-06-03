<template>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="/product" method="GET">
            <div>
                <label for="link" class="block text-sm font-medium leading-6 text-gray-900">Enter Link</label>
                <div class="mt-2">
                    <input id="link" name="link" type="link" autocomplete="link" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-center" />
                </div>
            </div>
            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Search</button>
            </div>
        </form>
    </div>
</template>

<script>
import Layout from "../Shared/Layout.vue";
export default {
    components: {
        Layout
    },
    layout: Layout
}

</script>

<style scoped>

</style>
