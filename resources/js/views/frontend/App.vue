<template>
    <div>
        <!-- loading-spinner -->
        <div class="loader_container" :class="{'d-none': !loading}">
            <frontend-loader :loading="true" :color="'#FDD835'" :size="18" :margin="'8px'"></frontend-loader>
        </div>

        <main-header></main-header>
        <div class="header_spacing"></div>

        <router-view></router-view>

        <main-footer></main-footer>
        <top-button></top-button>
    </div>
</template>

<script>
export default {
    computed: {
        loading() {
            return this.$store.state.app.loading;
        },
    },
    async mounted() {
        this.$store.commit('app/showLoading');

            this.$store.dispatch('app/getData');
            this.$store.dispatch('app/getProductCategories');

        this.$store.commit('app/hideLoading');
    },
}
</script>
