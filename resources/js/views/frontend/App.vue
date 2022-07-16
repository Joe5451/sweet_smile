<template>
    <div>
        <main-header></main-header>
        <div class="header_spacing"></div>

        <router-view></router-view>

        <main-footer></main-footer>
        <top-button></top-button>
    </div>
</template>

<script>
export default {
    async mounted() {
        await this.$store.dispatch('app/getData');
    },
}
</script>
