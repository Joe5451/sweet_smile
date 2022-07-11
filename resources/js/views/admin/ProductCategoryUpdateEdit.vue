<template>
    <div>
        <div class="admin_title">商品分類管理</div>

        <form @submit.prevent="checkForm">
            <div class="mb-4">
                <label class="form-label">商品主分類名稱</label>
                <input type="text" name="category_name" class="form-control" v-model="category_name">
                <div class="invalid-feedback"></div>
            </div>

            <div class="row mb-3">
                <div class="mb-4 col-sm-6">
                    <label class="form-label">狀態</label>
                    <select v-model="category_display" class="form-select">
                        <option :value="1">上架</option>
                        <option :value="0">下架</option>
                    </select>
                </div>
                <div class="mb-4 col-sm-6">
                    <label class="form-label">排序</label>
                    <input type="number" name="category_sequence" class="form-control" v-model.number="category_sequence">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-sm btn-info text-white" @click="addSubCategoryRow">新增子分類</button>
            </div>

            <div class="mb-5 table-responsive custom_horizontal_scrollbar">
                <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                    <tbody id="product_subcategory_container" class="text-center">
                        <tr class="border-top">
                            <td>商品子分類名稱</td>
                            <td>商品</td>
                            <td width="100">狀態</td>
                            <td width="90">排序</td>
                            <td width="80">操作</td>
                        </tr>
                        <tr v-for="(subcategory, subcategory_index) in product_subcategories" :key="'subcategory-' + subcategory.product_subcategory_id">
                            <td>
                                <input type="text" class="form-control subcategory_name" v-model="subcategory.subcategory_name">
                                <div class="invalid-feedback"></div>
                            </td>
                            <td>
                                <span @click="updateCurrentSubCategoryProducts(subcategory.subcategory_products, subcategory_index)" class="text-primary" style="border-bottom: 2px dashed #0d6efd; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#subcategoryProductsModal">
                                    <span v-if="subcategory.subcategory_products.length > 0">
                                        <span v-for="(subcategory_product, subcategory_product_index) in subcategory.subcategory_products" :key="subcategory_product_index">
                                            {{ subcategory_product.product_name }} <br>
                                        </span>
                                    </span>

                                    <span v-else class="text-primary">無</span>
                                </span>
                            </td>
                            <td class="text-center">
                                <select v-model="subcategory.subcategory_display" class="form-select">
                                    <option :value="1" selected>上架</option>
                                    <option :value="0">下架</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control text-center subcategory_sequence" style="width: 70px;" v-model.number="subcategory.subcategory_sequence">
                                <div class="invalid-feedback"></div>
                            </td>
                            <td class="text-center">
                                <button type="button" @click="deleteSubCategoryRow(subcategory_index)" class="btn btn-sm btn-danger">刪除</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary">新增</button>
            </div>
        </form>

        <!-- 子分類綁定商品 modal -->
        <div class="modal fade" tabindex="-1" id="subcategoryProductsModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">綁定商品</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-sm btn-info text-white" @click="addSubCategoryProduct">新增商品</button>
                        </div>

                        <div class="table-responsive custom_horizontal_scrollbar">
                            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                                <tbody id="product_subcategory_products_container" class="text-center">
                                    <tr class="border-top">
                                        <td>商品</td>
                                        <td width="90">排序</td>
                                        <td width="80">操作</td>
                                    </tr>
                                    <tr v-if="current_subcategory_products.length == 0">
                                        <td colspan="3" class="text-center">無</td>
                                    </tr>
                                    <tr v-else v-for="(current_subcategory_product, current_subcategory_product_index) in current_subcategory_products" :key="current_subcategory_product_index">
                                        <td>
                                            <select v-model="current_subcategory_product.product_id" class="form-select">
                                                <option value="">未選擇</option>
                                                <option v-for="(product, product_index) in products" :value="product.id" :key="product_index">{{ product.product_name }}</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" v-model.number="current_subcategory_product.product_sequence" class="form-control text-center" style="width: 70px;">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger" @click="deleteSubCategoryProduct(current_subcategory_product_index)">刪除</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary" @click="checkSubCategoryProduct">確定</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'ProductCategoryUpdateEdit',
        data() {
            return {
                product_category_id: this.$route.params.product_category_id,

                subcateogry_products_modal: null,
                category_name: '',
                category_display: 1,
                category_sequence: 0,
                product_subcategories: [
                    {
                        product_subcategory_id: '', // 綁定 v-for 元素 key
                        subcategory_name: '',
                        subcategory_display: 1,
                        subcategory_sequence: 0,
                        subcategory_products: []
                    }
                ],
                current_subcategory_products: [],
                current_subcategory_index: null,
                products: [],

                category_data: null,
            }
        },
        async mounted() {
            const vm = this;

            let modal_element = document.getElementById('subcategoryProductsModal')
            this.subcateogry_products_modal = new bootstrap.Modal(modal_element);

            vm.$store.commit('admin_setting/showLoading');

            this.getProducts();
            await this.getProductCategory();
            
            vm.$store.commit('admin_setting/hideLoading');
        },
        methods: {
            async getProductsAndProductCategory() {
                this.getProducts();
                await this.getProductCategory();
            },
            updateCurrentSubCategoryProducts(subcategory_products, subcategory_index) {
                // [...] 複製陣列，否則在 js 中陣列也是物件，js 物件為 pass by reference 會指向同一個物件
                this.current_subcategory_products = [...subcategory_products];
                this.current_subcategory_index = subcategory_index;
            },
            addSubCategoryProduct() {
                this.current_subcategory_products.unshift({
                    product_id: '',
                    product_name: '',
                    product_sequence: 0
                });
            },
            checkSubCategoryProduct() {
                $(`#product_subcategory_products_container tr select`).removeClass('is-invalid');
                $(`#product_subcategory_products_container tr input`).removeClass('is-invalid');

                const vm = this;
                let product_id_pass = true;
                let product_sequence_pass = true;

                // 檢查欄位
                this.current_subcategory_products.forEach((current_subcategory_product, index, arr) => {
                    if (current_subcategory_product.product_id === '') {
                        product_id_pass = false;
                        $(`#product_subcategory_products_container tr:eq(${(index + 1)}) select`).addClass('is-invalid');
                    }
                    
                    if (current_subcategory_product.product_sequence === '') {
                        product_sequence_pass = false;
                        $(`#product_subcategory_products_container tr:eq(${(index + 1)}) input`).addClass('is-invalid');
                    }

                    this.products.forEach(product => {
                        if (current_subcategory_product.product_id == product.id) {
                            arr[index].product_name = product.product_name;
                        }
                    });
                });

                if (!product_id_pass || !product_sequence_pass) {
                    let title = '';

                    if (!product_id_pass && !product_sequence_pass) title = '請選擇商品及輸入排序';
                    else if (!product_id_pass) title = '請選擇商品';
                    else title = '請輸入排序';
                    
                    Swal.fire({
                        icon: 'warning',
                        title,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    // 排序
                    this.current_subcategory_products.sort(function (a, b) {
                        return a.product_sequence - b.product_sequence;
                    });

                    this.product_subcategories[this.current_subcategory_index].subcategory_products = this.current_subcategory_products;
                    this.current_subcategory_products = [];

                    this.subcateogry_products_modal.hide(); // 關閉 modal
                }
            },
            checkForm() {
                $('input').removeClass('is-invalid');
                $('input').next('.invalid-feedback').text('');

                let is_subcategory_pass = true;
                
                $('.subcategory_name').each(function () {
                    if ($(this).val() === '') {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').text('請輸入商品子分類名稱');

                        is_subcategory_pass = false;
                    }
                });

                $('.subcategory_sequence').each(function () {
                    if ($(this).val() === '') {
                        $(this).addClass('is-invalid');
                        $(this).siblings('.invalid-feedback').text('請輸入商品子分類排序');

                        is_subcategory_pass = false;
                    }
                });

                if (this.category_name == '')
                    this.alertInvalidMessage($('input[name=category_name]'), '請輸入商品主分類名稱');
                else if (this.category_sequence === '')
                    this.alertInvalidMessage($('input[name=category_sequence]'), '請輸入商品主分類排序');
                else if (!is_subcategory_pass) {
                    return;
                }
                else {
                    this.addProductCategory();
                }
            },
            addProductCategory() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                // 使用 json 字串傳送資料
                let json_data = JSON.stringify({
                    category_name: vm.category_name,
                    category_display: vm.category_display,
                    category_sequence: vm.category_sequence,
                    subcategories: vm.subcategories
                });
                
                axios.post('/admin/product_category', {
                    data: json_data,
                })
                .then(function (response) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.log(response);

                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '新增成功',
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
                                vm.$router.push({name: 'adminProductCategoryList'});
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
            deleteSubCategoryProduct(index) {
                this.current_subcategory_products.splice(index, 1);
            },
            getProducts() {
                const vm = this;

                axios.get('/admin/products', {
                    params: { 
                        page: 1,
                        limit: null
                    }
                })
                .then(function (response) {
                    // console.log(response);
                    vm.products = response.data.products;
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            },
            async getProductCategory() {
                const vm = this;

                await axios.get('/admin/product_category/' + vm.product_category_id)
                .then(function (response) {
                    console.log(response);

                    Object.assign(vm, response.data.product_category);
                    // vm.product_category = response.data.product_category;
                })
                .catch(function(error) {
                    console.error("Error: ", error);
                });
            },
            addSubCategoryRow() {
                this.product_subcategories.unshift({
                    product_subcategory_id: this.getRandomKey(),
                    subcategory_name: '',
                    subcategory_display: 1,
                    subcategory_sequence: 0,
                    subcategory_products: []
                });
            },
            deleteSubCategoryRow(index) {
                if (this.product_subcategories.length == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: '至少需含一項子分類',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    return;
                }

                this.product_subcategories.splice(index, 1);
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
            },
            getRandomKey() {
                const word = "ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz0123456789";
                const word_len = word.length;
                let key = "";

                for (let i = 0; i < 6; i++) {
                    key += word.charAt(Math.floor(Math.random() * word_len));
                }

                return key;
            },
        }
    }
</script>