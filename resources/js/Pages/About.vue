<template>
    <h1>{{title}}</h1>
</template>

<script>
import Layout from "../Shared/Layout.vue";
export default {
    components: {
        Layout
    },
    props: {
        title: String
    },
    layout: Layout
}

</script>

<style scoped>

</style>
