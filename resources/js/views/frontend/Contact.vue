<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">聯絡我們</div>
        </div>

        <div class="container mb-80px">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <div class="h-100 d-flex flex-column justify-content-center align-items-center border border-2 rounded-3 px-4 py-5">
                        <div class="contact_logo_and_link_container">
                            <a href="#" class="contact_logo">
                                <img src="img/logo_b.svg" class="contact_logo_img">
                            </a>
                            <div class="contact_social_link_container">
                                <a href="#" class="contact_social_link">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="contact_social_link">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="contact_social_link">
                                    <i class="fab fa-line"></i>
                                </a>
                            </div>
                        </div>

                        <div class="contact_item_container">
                            <div class="contact_item_title">
                                <i class="fas fa-location-arrow"></i>
                                聯絡資訊
                            </div>
                            <div class="contact_item">
                                <i class="fas fa-phone-alt"></i>
                                00-0000-0000
                            </div>
                            <div class="contact_item">
                                <i class="fas fa-envelope"></i>
                                xxx@email.com
                            </div>
                            <div class="contact_item">
                                <i class="fas fa-map-marker-alt"></i>
                                xxxxxxxxxxxx
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <form class="px-4 py-3">
                        <div class="mb-4">
                            <label class="form-label fw-bold">姓名*</label>
                            <input type="text" class="form-control" placeholder="請輸入您的姓名">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">電子信箱*</label>
                            <input type="email" class="form-control" placeholder="請輸入您的電子信箱">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">電話</label>
                            <input type="text" class="form-control" placeholder="請輸入您的電話">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">內容*</label>
                            <textarea class="form-control" rows="5"></textarea>
                        </div>

                        <div class="d-flex justify-content-center mt-5">
                            <button type="button" class="submit_btn fw-bold w-auto">發送</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
export default({
    computed: {
        head_img() {
            return this.$store.state.app.head_img.contact;
        }
    }
})
</script>
