<template>
    <div class="modal fade" tabindex="-1" id="productCategoryAddModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">商品分類新增</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">商品主分類名稱</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary">新增</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ProductCategoryAddModal',
        methods: {
            
        }
    }
</script>