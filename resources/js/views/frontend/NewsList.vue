<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">最新消息</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-md-6" v-for="new_data in news" :key="new_data.id">
                    <router-link class="news_list" :to="{name: 'news', params: { news_id: new_data.id }}">
                        <div class="news_list_img_wrap">
                            <img :src="new_data.cover_img" class="news_list_img">
                        </div>
                        <div class="news_list_content">
                            <div class="news_list_title">{{ new_data.title }}</div>
                            <div class="news_list_date">{{ new_data.date.replace(/-/g, '/') }}</div>
                            <div class="news_list_summary">{{ new_data.summary }}</div>
                            <div class="news_list_more">繼續閱讀</div>
                        </div>
                    </router-link>
                </div>

                <ul class="pagination custom_pagination justify-content-center flex-wrap mb-4" v-if="total > 0">
                    <li class="page-item m-1" v-if="page != 1">
                        <router-link class="page-link rounded" :to="{name: 'newsList', params: { page: page - 1 }}" aria-label="Previous">
                            <i class="fas fa-angle-left"></i>
                        </router-link>
                    </li>

                    <li class="page-item m-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                        <router-link class="page-link rounded" :to="{name: 'newsList', params: { page: cur_page_num }}">
                            {{ cur_page_num }}
                        </router-link>
                    </li>

                    <li class="page-item m-1" v-if="page != page_num">
                        <router-link class="page-link rounded" :to="{name: 'newsList', params: { page: page + 1 }}" aria-label="Next">
                            <i class="fas fa-angle-right"></i>
                        </router-link>
                    </li>
                </ul>
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.news;
        },
        page() {
            let new_page = this.$route.params.page;
            return (new_page === undefined) ? 1 : new_page;
        }
    },
    watch: {
        page(new_page, old_page) {
            // console.log(old_page);
            this.getNews();
        }
    },
    data() {
        return {
            news: [],
            total: 0,
            limit: 12,
            page_num: 0
        }
    },
    mounted() {
        this.getNews();
    },
    methods: {
        async getNews() {
            const vm = this;

            await axios.get('/news', {
                params: { 
                    page: vm.page,
                    limit: vm.limit
                }
            })
            .then(function (response) {
                console.log(response);

                vm.news = response.data.news;
                vm.total = response.data.total;
                vm.page_num = parseInt(vm.total / vm.limit);
                vm.page_num += (vm.total%vm.limit != 0) ? 1 : 0;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });
        },
    }
}
</script>
