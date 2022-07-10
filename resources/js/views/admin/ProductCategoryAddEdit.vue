<template>
    <div>
        <div class="admin_title">商品分類新增</div>

        <form>
            <div class="mb-4">
                <label class="form-label">商品主分類名稱</label>
                <input type="text" class="form-control" v-model="category_name">
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
                    <input type="number" class="form-control" v-model="category_sequence">
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
                        <tr v-for="(subcategory, subcategory_index) in subcategories" :key="subcategory_index">
                            <td>
                                <input type="text" class="form-control" v-model="subcategory.subcategory_name">
                            </td>
                            <td>
                                <span @click="updateCurrentSubCategoryProducts(subcategory.subcategory_products, subcategory_index)" data-bs-toggle="modal" data-bs-target="#subcategoryProductsModal">
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
                                <input type="number" class="form-control text-center" style="width: 70px;" v-model.number="subcategory.subcategory_sequence">
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
                                    <tr v-for="(current_subcategory_product, current_subcategory_product_index) in current_subcategory_products" :key="current_subcategory_product_index">
                                        <td>
                                            <!-- <select v-model="current_subcategory_product.product_id" @change="current_subcategory_product.product_name = product.product_name" class="form-select"> -->
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
        name: 'ProductCategoryAddEdit',
        data() {
            return {
                category_name: '',
                category_display: 1,
                category_sequence: 0,
                subcategories: [
                    {
                        subcategory_name: '',
                        subcategory_display: 1,
                        subcategory_sequence: 0,
                        subcategory_products: []
                    }
                ],
                current_subcategory_products: [],
                current_subcategory_index: null,
                products: []
            }
        },
        mounted() {
            this.getProducts();
        },
        methods: {
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

                    this.subcategories[this.current_subcategory_index].subcategory_products = this.current_subcategory_products;
                    this.current_subcategory_products = [];
                    // console.log(this.subcategories);
                }
            },
            deleteSubCategoryProduct(index) {
                this.current_subcategory_products.splice(index, 1);
            },
            async getProducts() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/products', {
                    params: { 
                        page: 1,
                        limit: null
                    }
                })
                .then(function (response) {
                    // console.log(response);
                    vm.products = response.data.products;
                    vm.$store.commit('admin_setting/hideLoading');
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            addSubCategoryRow() {
                this.subcategories.unshift({
                    subcategory_name: '',
                    subcategory_display: 1,
                    subcategory_sequence: 0,
                    subcategory_products: []
                });
            },
            deleteSubCategoryRow(index) {
                if (this.subcategories.length == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: '至少需含一項子分類',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    return;
                }

                this.subcategories.splice(index, 1);
            }
        }
    }
</script>