<template>
    <div v-if="rendered" class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm ">
        <div v-if="hasChatId" class="flex flex-col">
            <div class="text-center lining-nums text-green-600">
                Your telegram registered
            </div>
        </div>
        <div v-else>
            <div class="text-center">
                Откройте <a target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            href="https://t.me/PriceParserPhpBot">Бота</a>
                и введите ваш идентификатор
            </div>
            <div class="text-center lining-nums text-rose-500">
                {{ this.user.code }}
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "../Shared/Layout.vue";
import axios from "axios";

export default {
    data() {
        return {
            user: null,
            rendered: false,
            hasChatId: false
        }
    },
    name: "TelegramBinding",
    components: {
        Layout
    },
    layout: Layout,
    mounted() {
        axios.get('api/user')
            .then(response => {
                this.user = response.data;
                this.rendered = true;
                this.hasChatId = (this.user.chatId !== null);
                if (!this.hasChatId) {
                    axios.post('api/bot');
                }
            });
    },
}
</script>

<style scoped>

</style>
