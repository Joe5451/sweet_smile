<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">最新消息</div>
        </div>

        <div class="container mb-80px">
            <div class="row" v-if="is_loading">
                <div class="col-md-6" v-for="index in 12" :key="index">
                    <div class="news_list news_load_list border-0">
                        <div class="news_list_img_wrap">
                            <div class="news_list_img flash w-100"></div>
                        </div>
                        <div class="news_list_content w-100">
                            <div class="news_list_title flash w-100" style="height: 25px;"></div>
                            <div class="news_list_date flash w-100" style="height: 20px;"></div>
                            <div class="news_list_summary overflow-hidden flash w-100 mb-0"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row" v-else>
                <div class="col-md-6" v-for="new_data in news" :key="new_data.id">
                    <router-link class="news_list" :to="{name: 'news', params: { news_id: new_data.id } }">
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
                        <router-link class="page-link rounded" :to="{name: 'newsList', params: { page: parseInt(page) - 1 } }" aria-label="Previous">
                            <i class="fas fa-angle-left"></i>
                        </router-link>
                    </li>

                    <li class="page-item m-1" :class="{ active: (cur_page_num == page) }" v-for="cur_page_num in page_num" :key="cur_page_num">
                        <router-link class="page-link rounded" :to="{name: 'newsList', params: { page: cur_page_num } }">
                            {{ cur_page_num }}
                        </router-link>
                    </li>

                    <li class="page-item m-1" v-if="page != page_num">
                        <router-link class="page-link rounded" :to="{name: 'newsList', params: { page: parseInt(page) + 1 } }" aria-label="Next">
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
        },
        page_num() {
            return Math.ceil(this.total / this.limit);
        }
    },
    watch: {
        page(new_page, old_page) {
            this.getNews();
        }
    },
    data() {
        return {
            is_loading: true,
            news: [],
            total: 0,
            limit: 12
        }
    },
    mounted() {
        this.getNews();
    },
    methods: {
        async getNews() {
            const vm = this;

            vm.is_loading = true;

            await axios.get('/news', {
                params: { 
                    page: vm.page,
                    limit: vm.limit
                }
            })
            .then(function (response) {
                // console.log(response);
                vm.news = response.data.news;
                vm.total = response.data.total;
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });

            vm.is_loading = false;
        },
    }
}
</script>
