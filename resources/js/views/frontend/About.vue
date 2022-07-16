<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">關於我們</div>
        </div>

        <div class="container mb-80px">
            <div class="ck-content" v-html="content"></div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.about;
        },
        content() {
            return this.$store.state.app.about_content;
        },
    }
}
</script>