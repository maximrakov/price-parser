<template>
    <div v-if="rendered">
        <Disclosure as="nav" class="bg-black h-5" v-slot="open">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                 alt="Your Company"/>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a v-for="item in navigation" :key="item.name" :href="item.href"
                                   :class="[item.current ? 'bg-gray-900 text-white' : 'text-black-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                   :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <div v-if="user">
                                    <p1 class="rounded-md px-3 py-2 text-sm font-medium">Hello, {{ user.name }}</p1>
                                    <a v-for="item in loggedRightPannel" :key="item.name" @click="logout" href="#"
                                       :class="[item.current ? 'bg-gray-900 text-white' : 'text-black-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                       :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                                </div>
                                <div v-else>
                                    <a v-for="item in unloggedRightPannel" :key="item.name" :href="item.href"
                                       :class="[item.current ? 'bg-gray-900 text-white' : 'text-black-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                       :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Disclosure>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <slot></slot>
            </div>
        </main>
    </div>
</template>


<script>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import axios from "axios";

export default {
    name: "Layout",
    components: {},
    methods: {
        logout() {
            axios
                .post('api/logout')
                .then(response => window.location = "/");
        }
    },

    mounted() {
        axios
            .get('api/user')
            .then(response => (this.user = response.data));
        this.rendered = true;
    },
    data() {
        return {
            user: null,
            navigation: [{name: 'Home', href: '/', current: false},
                {name: 'Subscriptions', href: '/subscriptions', current: false},
            ],
            rendered: false,
            active: false,
            open: false,
            unloggedRightPannel: [{name: 'Login', href: '/login', current: false},
                {name: 'Sign Up', href: '/register', current: false},
            ],
            loggedRightPannel: [{name: 'Logout', href: '/', current: false}]
        }
    },
}
</script>
<style scoped>
</style>
