<template>
    <div>
        <div class="admin_title">商品管理</div>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="$router.back()">回上一頁</button>
        </div>

        <form @submit.prevent="checkForm">
            <div class="mb-4 img_container" style="max-width: 300px">
                <label class="form-label">商品圖片</label>
                <input type="file" name="product_cover_img" class="dropify" @change="changeFile" data-max-file-size="1M" >
                <div class="invalid-feedback" id="product_cover_img_invalid_feedback"></div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">商品名稱</label>
                <input type="text" name="product_name" v-model="product_name" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="row">
                <div class="col-6 mb-4">
                    <label class="form-label">原價</label>
                    <input type="number" name="original_price" v-model="original_price" class="form-control" placeholder="無原價請空白">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="col-6 mb-4">
                    <label class="form-label">售價</label>
                    <input type="number" name="price" v-model="price" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">狀態</label>
                <div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <!-- 使用 :value="1" 表示值 type 為 number，字串則為 :value="'1'" 或 value="1" -->
                            <input type="radio" name="display" :value="1" v-model="display" class="form-check-input">
                            上架
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" name="display" :value="0" v-model="display" class="form-check-input">
                            下架
                        </label>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">摘要</label>
                <textarea name="summary" rows="5" v-model="summary" class="form-control"></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">介紹</label>
                <textarea name="content" rows="5" v-model="content" class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button type="button" @click="confirmDelete(product_id)" class="btn btn-danger">刪除</button>
                <button class="btn btn-primary">更新</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'ProductUpdateEdit',
        data() {
            return {
                product_id: this.$route.params.product_id,
                product_cover_img_url: '',
                is_product_cover_img_update: false, // 商品封面圖是否更新
                product_cover_img_update_file: null, // 商品封面圖檔案
                product_name: '',
                original_price: '',
                price: '',
                display: 1,
                summary: '',
                content: '',
                editor: null,
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

            // 等待更新 this.product_cover_img_url 再重置 dropify
            await this.getProduct(this.product_id);

            // 重置 dropify 元素，原始碼有以下 methods 但沒有寫在文件
            // https://github.com/JeremyFagis/dropify/issues/22
            // https://github.com/JeremyFagis/dropify/blob/master/dist/js/dropify.js
            let drEventData = drEvent.data('dropify');
            drEventData.resetPreview();
            drEventData.clearElement();
            drEventData.settings.defaultFile = this.product_cover_img_url;
            drEventData.destroy();
            drEventData.init();
            
            // 刪除圖片，在這裡綁定事件避免前面重新初始化 dropify 過程觸發 afterClear 修改 is_product_cover_img_update 為 true
            drEvent.on('dropify.afterClear', function(event, element) {
                vm.product_cover_img_update_file = null;
                vm.is_product_cover_img_update = true;
            });

            ClassicEditor
            .create( document.querySelector('textarea[name=content]'), this.$store.state.admin_setting.ckeditor_config)
            .then( editor => { this.editor = editor; })
            .catch( error => { console.error( error ); });
        },
        methods: {
            changeFile(e) {
                // console.log(e.target.files);
                this.product_cover_img_update_file = e.target.files[0];
                this.is_product_cover_img_update = true;
            },
            async getProduct(product_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/products/' + product_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
                .then(function (response) {
                    let product = response.data.product;

                    vm.product_name = product.product_name;
                    vm.original_price = product.original_price;
                    vm.price = product.price;
                    vm.display = product.display;
                    vm.summary = product.summary;
                    vm.content = product.content;
                    vm.product_cover_img_url = product.product_cover_img;

                    vm.$store.commit('admin_setting/hideLoading');
                    // console.log(response);
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            checkForm() {
                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');
                $('#product_cover_img_invalid_feedback').text('').hide();
                $('input[name=product_cover_img]').parents('.dropify-wrapper').removeClass('border border-danger');

                if (this.is_product_cover_img_update && this.product_cover_img_update_file == null) {
                    $('#product_cover_img_invalid_feedback').text('請上傳商品圖片').show();

                    let element = $('input[name=product_cover_img]');
                    element.parents('.dropify-wrapper').addClass('border border-danger');

                    // 移至元素位置
                    let contentTop = element.offset().top - 120;

                    $([document.documentElement, document.body]).animate({
                        scrollTop: contentTop
                    }, 800, 'swing', function() {
                        element.focus();
                    });
                }
                else if (this.product_name == '')
                    this.alertInvalidMessage($('input[name=product_name]'), '請輸入商品名稱');
                else if (this.price == '')
                    this.alertInvalidMessage($('input[name=price]'), '請輸入售價');
                else {
                    this.content = this.editor.getData();
                    this.updateProduct();
                }
            },
            updateProduct() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                axios.post('/admin/products/' + vm.product_id + '?_method=PUT', {
                    product_cover_img_update_file: vm.product_cover_img_update_file,
                    is_product_cover_img_update: vm.is_product_cover_img_update,
                    product_name: vm.product_name,
                    original_price: vm.original_price,
                    price: vm.price,
                    display: vm.display,
                    summary: vm.summary,
                    content: vm.content,
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
                            title: '商品更新成功',
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
            confirmDelete(product_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteProduct(product_id);
                    } 
                })
            },
            async deleteProduct(product_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/products/' + product_id, {
                    headers: { 'Authorization': 'Bearer ' + vm.$store.state.admin_user.access_token }
                })
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
                                vm.$router.push({name: 'adminProductList'});
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