<template>
    <div>
        <div class="admin_title">上方輪播管理</div>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="$router.back()">回上一頁</button>
        </div>

        <form @submit.prevent="checkForm">
            <div class="mb-4 img_container" style="max-width: 300px">
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
                <button type="button" @click="confirmDelete(slider_id)" class="btn btn-danger">刪除</button>
                <button class="btn btn-primary">更新</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'HomeSliderUpdateEdit',
        data() {
            return {
                slider_id: this.$route.params.slider_id,
                slider_img_url: '',
                is_slider_img_update: false, // 商品封面圖是否更新
                slider_img_update_file: null, // 商品封面圖檔案
                link: '',
                sequence: '',
                display: 1,
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

            await this.getSlider(this.slider_id);

            // 重置 dropify 元素
            let drEventData = drEvent.data('dropify');
            drEventData.resetPreview();
            drEventData.clearElement();
            drEventData.settings.defaultFile = this.slider_img_url;
            drEventData.destroy();
            drEventData.init();

            // 刪除圖片
            drEvent.on('dropify.afterClear', function(event, element) {
                vm.slider_img_update_file = null;
                vm.is_slider_img_update = true;
            });
        },
        methods: {
            changeFile(e) {
                this.slider_img_update_file = e.target.files[0];
                this.is_slider_img_update = true;
            },
            async getSlider(slider_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/home_slider/' + slider_id)
                .then(function (response) {
                    // console.log(response);
                    let slider = response.data.slider;

                    vm.link = slider.link;
                    vm.sequence = slider.sequence;
                    vm.display = slider.display;
                    vm.slider_img_url = slider.slider_img;

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
                $('#slider_img_invalid_feedback').text('').hide();
                $('input[name=slider_img]').parents('.dropify-wrapper').removeClass('border border-danger');
                
                if (this.is_slider_img_update && this.slider_img_update_file == null) {
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
                    this.updateSlider();
                }
            },
            updateSlider() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                axios.post('/admin/home_slider/' + vm.slider_id + '?_method=PUT', {
                    slider_img_update_file: vm.slider_img_update_file,
                    is_slider_img_update: vm.is_slider_img_update,
                    link: vm.link,
                    sequence: vm.sequence,
                    display: vm.display
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
                                vm.$store.commit('admin_setting/updateContentComponentKey'); // 更新畫面
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
            confirmDelete(slider_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteSlider(slider_id);
                    } 
                })
            },
            async deleteSlider(slider_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/home_slider/' + slider_id)
                .then(function (response) {
                    vm.$store.commit('admin_setting/hideLoading');
                    // console.log(response);

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '刪除成功',
                            width: 300,
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