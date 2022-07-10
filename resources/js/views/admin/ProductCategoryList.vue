<template>
    <div>
        <div class="admin_title">商品分類</div>

        <!-- <div class="d-flex justify-content-end mb-3">
            <router-link class="btn btn-sm btn-primary" :to="{name: 'adminProductCategoryAdd'}">
                新增商品分類
            </router-link>

            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#productCategoryAddModal">
                新增商品分類
            </button>
        </div> -->

        <div class="mb-5 table-responsive custom_horizontal_scrollbar">
            <table class="table table-bordered table-striped align-middle mb-0" style="min-width: 800px;">
                <tbody>
                    <tr class="text-center border-top">
                        <td width="60">項次</td>
                        <td width="160">商品主分類</td>
                        <td>商品子分類</td>
                        <td width="90">排序</td>
                        <td width="80">狀態</td>
                        <td width="120">操作</td>
                    </tr>
                    <tr>
                        <td class="text-end">1</td>
                        <td>商品分類名稱</td>
                        <td>
                            商品子分類名稱1<br>
                            商品子分類名稱2<br>
                            商品子分類名稱3<br>
                            商品子分類名稱4<br>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control text-center" style="width: 70px;" value="0">
                        </td>
                        <td class="text-center">
                            <span style="color: blue;">上架</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-primary">管理</a>
                            <a href="#" class="btn btn-sm btn-danger">刪除</a>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-end">2</td>
                        <td>商品分類名稱</td>
                        <td>商品子分類名稱</td>
                        <td class="text-center">
                            <input type="number" class="form-control text-center" style="width: 70px;" value="0">
                        </td>
                        <td class="text-center">
                            <span style="color: blue;">上架</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="mx-1 text-primary">管理</a>
                            <a href="#" class="mx-1 text-danger">刪除</a>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-end">3</td>
                        <td>商品分類名稱<br>第二行</td>
                        <td>商品子分類名稱</td>
                        <td class="text-center">
                            <input type="number" class="form-control text-center" style="width: 70px;" value="0">
                        </td>
                        <td class="text-center">
                            <span style="color: blue;">上架</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="mx-1 text-primary">管理</a>
                            <a href="#" class="mx-1 text-danger">刪除</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <admin-product-category-add-modal></admin-product-category-add-modal>

        <ul class="pagination flex-wrap mb-4">
            <li class="page-item mx-1 my-1">
                <a class="page-link rounded" href="#">
                    第一頁
                </a>
            </li>

            <li class="page-item mx-1 my-1">
                <a class="page-link rounded" href="#" aria-label="Previous">
                    上一頁
                </a>
            </li>

            <li class="page-item mx-1 my-1"><a class="page-link rounded" href="#">1</a></li>
            <li class="page-item mx-1 my-1"><a class="page-link rounded" href="#">2</a></li>
            <li class="page-item mx-1 my-1"><a class="page-link rounded" href="#">3</a></li>

            <li class="page-item mx-1 my-1">
                <a class="page-link rounded" href="#" aria-label="Next">
                    下一頁
                </a>
            </li>

            <li class="page-item mx-1 my-1">
                <a class="page-link rounded" href="#">
                    最末頁
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'ProducCategoryList',
    }
</script>