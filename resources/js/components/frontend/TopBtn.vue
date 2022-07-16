<template>
    <div id="top_btn_wrap">
        <div id="top_btn" @click="toTop">
            <i class="fas fa-chevron-up"></i>
            <span>TOP</span>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        $(window).scroll(function() {
            var scrollTop = $(window).scrollTop();

            if( scrollTop > 200 ) {
                $('#top_btn_wrap').stop().fadeIn();
            } else {
                $('#top_btn_wrap').stop().fadeOut();
            }
        });
    },
    methods: {
        toTop() {
            $("html, body").animate({scrollTop:0}, '500', 'swing' );
        }
    }
}
</script>