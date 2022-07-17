<template>
    <div>
        <div class="page_banner" :style="{'backgroundImage': 'url(' + head_img + ')'}">
            <div class="page_banner_title">會員中心</div>
        </div>

        <div class="container mb-80px">
            <div class="border rounded-3 py-5 px-3">
                <div class="page_title">註冊會員</div>

                <form action="" class="mx-auto px-3" style="max-width: 400px;">
                    <div class="d-flex justify-content-center mb-4 fw-bold">
                        已經是會員了? <router-link :to="{ name: 'memberLogin' }" class="ms-2">登入會員</router-link>
                    </div>
                
                    <div class="mb-4">
                        <label class="form-label fw-bold">姓名*</label>
                        <input type="text" class="form-control" placeholder="請輸入您的姓名">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">帳號 (Email)*</label>
                        <input type="text" class="form-control" placeholder="請輸入您的 Email">
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">手機</label>
                        <input type="text" class="form-control" placeholder="請輸入您的手機">
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">密碼*</label>
                        <input type="password" class="form-control" placeholder="請輸入您的密碼">
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label fw-bold">確認密碼*</label>
                        <input type="password" class="form-control" placeholder="請再次輸入您的密碼">
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button type="button" class="submit_btn fw-bold">註冊</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    computed: {
        head_img() {
            return this.$store.state.app.head_img.member;
        }
    }
}
</script>