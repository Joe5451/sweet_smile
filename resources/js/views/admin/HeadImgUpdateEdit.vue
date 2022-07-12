<template>
    <div>
        <div class="admin_title">上方大圖管理</div>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="$router.back()">回上一頁</button>
        </div>

        <form @submit.prevent="checkForm">
            <div class="mb-4">
                <label class="form-label">{{page_name}}</label>
                <input type="file" name="img" class="dropify" @change="changeFile" data-max-file-size="1M">
                <div class="invalid-feedback" id="img_invalid_feedback"></div>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary ms-auto">更新</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'HeadImgUpdateEdit',
        data() {
            return {
                head_img_id: this.$route.params.head_img_id,
                page_name: '',
                img_url: '',
                is_img_update: false, // 圖片是否更新
                img_update_file: null, // 圖片檔案
            }
        },
        async mounted() {
            const vm = this;

            let drEvent = $('.dropify').dropify({
                messages: {
                    'default': '將文件拖放到此處或單擊',
                    'replace': '拖放或點擊替換',
                    'remove':  '刪除',
                    'error':   '糟糕，發生了錯誤'
                }
            });

            await this.getHeadImg(this.head_img_id);

            // 重置 dropify 元素
            let drEventData = drEvent.data('dropify');
            drEventData.resetPreview();
            drEventData.clearElement();
            drEventData.settings.defaultFile = this.img_url;
            drEventData.destroy();
            drEventData.init();

            // 刪除圖片
            drEvent.on('dropify.afterClear', function(event, element) {
                vm.img_update_file = null;
                vm.is_img_update = true;
            });
        },
        methods: {
            changeFile(e) {
                this.img_update_file = e.target.files[0];
                this.is_img_update = true;
            },
            async getHeadImg(head_img_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/head_img/' + head_img_id)
                .then(function (response) {
                    // console.log(response);
                    vm.page_name = response.data.head_img.page_name;
                    vm.img_url = response.data.head_img.img;
                    
                    vm.$store.commit('admin_setting/hideLoading');
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            checkForm() {
                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');
                $('#img_invalid_feedback').text('').hide();
                $('input[name=img]').parents('.dropify-wrapper').removeClass('border border-danger');
                
                if (this.is_img_update && this.img_update_file == null) {
                    $('#img_invalid_feedback').text('請上傳圖片').show();

                    let element = $('input[name=img]');
                    element.parents('.dropify-wrapper').addClass('border border-danger');

                    // 移至元素位置
                    let contentTop = element.offset().top - 120;

                    $([document.documentElement, document.body]).animate({
                        scrollTop: contentTop
                    }, 800, 'swing', function() {
                        element.focus();
                    });
                }
                else {
                    this.updateHeadImg();
                }
            },
            updateHeadImg() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                axios.post('/admin/head_img/' + vm.head_img_id + '?_method=PUT', {
                    img_update_file: vm.img_update_file,
                    is_img_update: vm.is_img_update,
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    vm.$store.commit('admin_setting/hideLoading');
                    // console.log(response);

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '更新成功',
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
                                vm.$router.push({name: 'adminHeadImgList'});
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