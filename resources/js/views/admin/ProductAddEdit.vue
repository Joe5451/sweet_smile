<template>
    <div>
        <div class="admin_title">商品新增</div>

        <form @submit.prevent="checkForm">
            <div class="mb-4 img_container" style="max-width: 300px">
                <label class="form-label">商品圖片</label>
                <input type="file" name="product_cover_img" class="dropify" @change="changeFile" data-max-file-size="1M">
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
                <button class="btn btn-primary">新增</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'ProductAddEdit',
        data() {
            return {
                product_cover_img: null,
                product_name: '',
                original_price: '',
                price: '',
                display: 1,
                summary: '',
                content: '',
                editor: null,
            }
        },
        mounted() {
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
                vm.product_cover_img = null;
            });

            ClassicEditor
            .create( document.querySelector('textarea[name=content]'), this.$store.state.admin_setting.ckeditor_config)
            .then( editor => { this.editor = editor; })
            .catch( error => { console.error( error ); });
        },
        methods: {
            changeFile(e) {
                this.product_cover_img = e.target.files[0];
                // console.log(e.target.files);
            },
            async checkForm() {
                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');
                $('#product_cover_img_invalid_feedback').text('').hide();
                $('input[name=product_cover_img]').parents('.dropify-wrapper').removeClass('border border-danger');
                
                if (this.product_cover_img == null) {
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
                    this.addProduct();
                }
            },
            addProduct() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                axios.post('/admin/products', {
                    product_cover_img: vm.product_cover_img,
                    product_name: vm.product_name,
                    original_price: vm.original_price,
                    price: vm.price,
                    display: vm.display,
                    summary: vm.summary,
                    content: vm.content,
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.log(response);

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '商品新增成功',
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