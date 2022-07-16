<template>
    <div>
        <div class="page_banner">
            <div class="page_banner_title">最新消息</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-md-6" v-for="n in 12" :key="n">
                    <a href="news_content.php" class="news_list">
                        <div class="news_list_img_wrap">
                            <img src="img/banner1.jpg" class="news_list_img">
                        </div>
                        <div class="news_list_content">
                            <div class="news_list_title">歡慶開店上線，運費優惠 $50</div>
                            <div class="news_list_date">2022/06/30</div>
                            <div class="news_list_summary">我們堅持健康、無添加選用上等材料、新鮮製作給客人最好的體驗</div>
                            <div class="news_list_more">繼續閱讀</div>
                        </div>
                    </a>
                </div>

                <div class="d-flex justify-content-center">
                    <ul class="pagination custom_pagination flex-wrap mb-4">
                        <li class="page-item m-1">
                            <a class="page-link rounded" href="#" aria-label="Previous">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>

                        <li class="page-item m-1 active"><a class="page-link rounded" href="#">1</a></li>
                        <li class="page-item m-1"><a class="page-link rounded" href="#">2</a></li>
                        <li class="page-item m-1"><a class="page-link rounded" href="#">3</a></li>

                        <li class="page-item m-1">
                            <a class="page-link rounded" href="#" aria-label="Next">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>
