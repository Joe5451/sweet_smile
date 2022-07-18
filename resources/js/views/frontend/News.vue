<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">最新消息</div>
        </div>

        <div class="container mb-80px" v-if="is_loading">
            <div class="row mb-80px">
                <div class="col-md-5">
                    <div class="news_content_img flash w-100"></div>
                </div>
                <div class="col-md-7 ps-lg-5 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-end flex-wrap mb-4">
                        <div class="news_list_title flash w-100" style="height: 32px;"></div>
                    </div>

                    <div class="news_summary custom_scrollbar overflow-hidden">
                        <div class="flash w-100 my-4" style="height: 20px;"></div>
                        <div class="flash w-100 my-4" style="height: 20px;"></div>
                        <div class="flash w-100 my-4" style="height: 20px;"></div>
                        <div class="flash w-100 my-4" style="height: 20px;"></div>
                        <div class="flash w-100 my-4" style="height: 20px;"></div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flash w-100 mb-4" style="height: 20px;"></div>
                <div class="flash w-100 mb-4" style="height: 20px;"></div>
                <div class="flash w-100 mb-4" style="height: 20px;"></div>
                <div class="flash w-100 mb-4" style="height: 20px;"></div>
                <div class="flash w-100 mb-4" style="height: 20px;"></div>
            </div>
        </div>

        <div class="container mb-80px" v-else>
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
            is_loading: true,
            news: null
        }
    },
    async mounted() {
        this.$store.commit('app/setCurrentPage', 'news');
        this.is_loading = true;

        await this.getNews(this.news_id);

        this.is_loading = false;
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