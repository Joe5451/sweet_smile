<template>
    <div>
        <div class="admin_title">商品分類新增</div>

        <!-- <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="goBack">回上一頁</button>
        </div> -->

        <form>
            <div class="mb-5">
                <label class="form-label">商品主分類名稱</label>
                <input type="text" class="form-control" v-model="category_name">
            </div>

            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-sm btn-info text-white" @click="addSubCategoryRow">新增子分類</button>
            </div>

            <div class="mb-5 table-responsive custom_horizontal_scrollbar">
                <table class="table table-bordered table-striped align-middle mb-0" style="min-width: max-content;">
                    <tbody id="product_subcategory_container">
                        <tr class="border-top">
                            <td>商品子分類名稱</td>
                            <td width="90">排序</td>
                            <td width="80">操作</td>
                        </tr>
                        <tr v-for="(subcategory, index) in subcategories" :key="index">
                            <td>
                                <input type="text" class="form-control" v-model="subcategory.subcategory_name">
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control text-center" style="width: 70px;" v-model="subcategory.subcategory_sequence">
                            </td>
                            <td class="text-center">
                                <button type="button" @click="deleteSubCategoryRow(index)" class="btn btn-sm btn-danger">刪除</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary">新增</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'ProductCategoryAddEdit',
        data() {
            return {
                category_name: '',
                subcategories: [
                    {
                        subcategory_name: '',
                        subcategory_sequence: 0
                    }
                ]
            }
        },
        methods: {
            goBack() {
                this.$router.back();
            },
            addSubCategoryRow() {
                this.subcategories.unshift({
                    subcategory_name: '',
                    subcategory_sequence: 0
                });
            },
            deleteSubCategoryRow(index) {
                if (this.subcategories.length == 1) {
                    alert('至少需含一項子分類!');
                    return;
                }

                this.subcategories.splice(index, 1);
            }
        }
    }
</script>