<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">最新消息</div>
        </div>

        <div class="container mb-80px">
            <div class="row mb-80px" v-if="news !== null">
                <div class="col-md-5">
                    <img :src="news.cover_img" class="news_content_img">
                </div>
                <div class="col-md-7 ps-lg-5 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-end flex-wrap mb-4">
                        <div class="news_title">{{ news.title }}</div>
                        <div class="news_date">{{ news.date.replace(/-/g, '/')}}</div>
                    </div>

                    <div class="news_summary custom_scrollbar">{{ news.summary }}</div>
                </div>
            </div>

            <div v-else class="row mb-80px">
                <div class="col-md-5">
                    <div class="news_content_img" style="background-color: #EEEEEE;"></div>
                </div>
                <div class="col-md-7 ps-lg-5 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-end flex-wrap mb-4" style="background-color: #EEEEEE; height: 30px;">
                        <div class="news_title"></div>
                        <div class="news_date"></div>
                    </div>

                    <div class="news_summary custom_scrollbar"></div>
                </div>
            </div>

            <div class="ck-content" v-if="news !== null" v-html="news.content"></div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.news;
        },
        news_id() {
            return this.$route.params.news_id;
        }
    },
    watch: {
        news_id(new_id, old_id) {
            this.getNews(new_id);
        }
    },
    data() {
        return {
            // news_id: this.$route.params.news_id,
            news: null,
            // news: {
            //     cover_img: '',
            //     title: '',
            //     date: '',
            //     summary: '',
            //     content: ''
            // }
        }
    },
    async mounted() {
        this.$store.commit('app/setCurrentPage', 'news');
        await this.getNews(this.news_id);
    },
    destroyed() {
        this.$store.commit('app/setCurrentPage', '');
    },
    methods: {
        async getNews(news_id) {
            const vm = this;
            vm.news = null;

            await axios.get('/news/' + news_id)
            .then(function (response) {
                // console.log(response);
                vm.news = response.data.new;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
    }
}
</script>