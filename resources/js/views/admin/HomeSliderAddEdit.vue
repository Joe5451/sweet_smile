<template>
    <div>
        <div class="admin_title">上方輪播新增</div>

        <form @submit.prevent="checkForm">
            <div class="mb-4">
                <label class="form-label">圖片</label>
                <input type="file" name="slider_img" class="dropify" @change="changeFile" data-max-file-size="1M">
                <div class="invalid-feedback" id="slider_img_invalid_feedback"></div>
            </div>

           <div class="mb-4">
                <label class="form-label">連結</label>
                <input type="text" name="link" v-model="link" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="row mb-3">
                <div class="mb-4 col-sm-6">
                    <label class="form-label">狀態</label>
                    <select v-model="display" class="form-select">
                        <option :value="1">上架</option>
                        <option :value="0">下架</option>
                    </select>
                </div>
                <div class="mb-4 col-sm-6">
                    <label class="form-label">排序</label>
                    <input type="number" name="sequence" class="form-control" v-model.number="sequence">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary ms-auto">新增</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'HomeSliderAddEdit',
        data() {
            return {
                slider_img: null,
                link: '',
                sequence: 0,
                display: 1
            }
        },
        mounted() {
            const vm = this;

            let drEvent = $('.dropify').dropify({
                messages: {
                    'default': '將文件拖放到此處或單擊',
                    'replace': '拖放或點擊替換',
                    'remove':  '刪除',
                    'error':   '糟糕，發生了錯誤'
                }
            });

            // 刪除圖片
            drEvent.on('dropify.afterClear', function(event, element){
                vm.slider_img = null;
            });
        },
        methods: {
            changeFile(e) {
                this.slider_img = e.target.files[0];
                // console.log(e.target.files);
            },
            checkForm() {
                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');
                $('#slider_img_invalid_feedback').text('').hide();
                $('input[name=slider_img]').parents('.dropify-wrapper').removeClass('border border-danger');
                
                if (this.slider_img == null) {
                    $('#slider_img_invalid_feedback').text('請上傳圖片').show();

                    let element = $('input[name=slider_img]');
                    element.parents('.dropify-wrapper').addClass('border border-danger');

                    // 移至元素位置
                    let contentTop = element.offset().top - 120;

                    $([document.documentElement, document.body]).animate({
                        scrollTop: contentTop
                    }, 800, 'swing', function() {
                        element.focus();
                    });
                }
                else if (this.sequence === '')
                    this.alertInvalidMessage($('input[name=sequence]'), '請輸入排序');
                else {
                    this.addHomeSlider();
                }
            },
            addHomeSlider() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                axios.post('/admin/home_slider', {
                    slider_img: vm.slider_img,
                    link: vm.link,
                    sequence: vm.sequence,
                    display: vm.display
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token
                    }
                })
                .then(function (response) {
                    vm.$store.commit('admin_setting/hideLoading');
                    // console.log(response);

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '新增成功',
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
                                vm.$router.push({name: 'adminHomeSliderList'});
                            },
                        });
                    } else if (response.data.status == 'fail') {
                        Swal.fire({
                            icon: 'warning',
                            title: response.data.message,
                            timer: 1500,
                        });
                    }
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            alertInvalidMessage(element, invalid_message) {
                element.addClass('is-invalid');
                element.siblings('.invalid-feedback').text(invalid_message);

                // 移至元素位置
                let contentTop = element.offset().top - 120;

                $([document.documentElement, document.body]).animate({
                    scrollTop: contentTop
                }, 800, 'swing', function() {
                    element.focus();
                });
            }
        }
    }
</script>