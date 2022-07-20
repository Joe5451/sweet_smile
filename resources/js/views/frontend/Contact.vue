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
                            <router-link :to="{name: 'home'}" class="contact_logo">
                                <img src="img/logo_b.svg" class="contact_logo_img">
                            </router-link>
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
                    <form @submit.prevent="checkForm" class="px-4 py-3">
                        <div class="mb-4">
                            <label class="form-label fw-bold">姓名*</label>
                            <input type="text" name="name" v-model="name" class="form-control" placeholder="請輸入您的姓名">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">電子信箱*</label>
                            <input type="email" name="email" v-model="email" class="form-control" placeholder="請輸入您的電子信箱">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">電話</label>
                            <input type="text" name="phone" v-model="phone" class="form-control" placeholder="請輸入您的電話">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">內容*</label>
                            <textarea name="content" v-model="content" class="form-control" rows="5"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="d-flex justify-content-center mt-5">
                            <button class="submit_btn fw-bold w-auto">發送</button>
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
    },
    data() {
        return {
            name: '',
            email: '',
            phone: '',
            content: ''
        }
    },
    methods: {
        checkForm() {
            $('input, textarea').removeClass('is-invalid');
            $('input, textarea').next('.invalid-feedback').text('');
            
            let check_pass = true;
            
            if (this.name == '') {
                check_pass = false;
                this.showInvalidMessage($('input[name=name]'), '請輸入姓名');
            }

            if (this.email == '') {
                check_pass = false;
                this.showInvalidMessage($('input[name=email]'), '請輸入 Email');
            }

            if (this.content == '') {
                check_pass = false;
                this.showInvalidMessage($('textarea[name=content]'), '請輸入內容');
            }

            if (check_pass) {
                this.createContact();
            } else {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('.is-invalid').offset().top - 160
                }, 800, 'swing');
            }
        },
        async createContact() {
            const vm = this;

            vm.$store.commit('app/showLoading');

            await axios.post('/contact', {
                name: vm.name,
                email: vm.email,
                phone: vm.phone,
                content: vm.content
            })
            .then(function (response) {
                // console.log(response);
                if (response.data.status == 'success') {
                    vm.name = vm.email = vm.phone = vm.content = '';
                    vm.$store.dispatch('app/alertMessage', {icon: 'success', title: '發送成功'});
                } else if (response.data.status == 'fail') {
                    vm.$store.dispatch('app/alertMessage', {title: response.data.message});
                }
            })
            .catch(function(error) {
                console.error("Error: ", error);
            });

            vm.$store.commit('app/hideLoading');
        },
        showInvalidMessage(element, invalid_message) {
            element.addClass('is-invalid');
            element.next('.invalid-feedback').text(invalid_message);
        }
    }
})
</script>
