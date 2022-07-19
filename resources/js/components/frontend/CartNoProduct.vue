<template>
    <div class="fw-bold d-flex justify-content-center p-3 align-items-center text-center fs-4" style="height: 300px;">
        您的購物車目前無商品，請前往
        <router-link v-if="first_product_subcategory_id !== null"
        :to="{name: 'productList', params: {subcategory_id: first_product_subcategory_id} }">
            購物商城
        </router-link>
        <span v-else>
            購物商城
        </span>
        選購您想要的商品。
    </div>
</template>

<script>
export default {
   computed: {
        product_categories() {
            return this.$store.state.app.product_categories;
        },
        first_product_subcategory_id() {
            if (this.product_categories.length > 0 && this.product_categories[0].enabled_product_subcategories.length > 0) {
                return this.product_categories[0].enabled_product_subcategories[0].product_subcategory_id;
            } else {
                return null;
            }
        }
    },
}
</script>