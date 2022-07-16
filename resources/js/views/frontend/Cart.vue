<template>
    <div class="container mt-5">
        <div class="page_title">購物車內容</div>

        <div class="cart_head d-none d-md-flex">
            <div class="cart_head_item img"></div>
            <div class="cart_head_item name">商品名稱</div>
            <div class="cart_head_item unit_price">單價</div>
            <div class="cart_head_item qty">數量</div>
            <div class="cart_head_item price">小計</div>
            <div class="cart_head_item operate"></div>
        </div>

        <div class="cart_head_mobile d-md-none">商品明細</div>

        <div class="cart_body">
            <div class="cart_row">
                <div class="cart_row_item img">
                    <img src="img/img2.png" class="cart_product_img">
                </div>
                <div class="cart_row_item name">特級巧克力蛋糕</div>
                <div class="cart_row_item unit_price">$500</div>
                <div class="cart_row_item qty">
                    <div class="cart_qty_control">
                        <button class="cart_qty_btn minus">-</button>
                        <input type="number" class="cart_qty_input" value="1">
                        <button class="cart_qty_btn plus">+</button>
                    </div>
                </div>
                <div class="cart_row_item price">$1,500</div>
                <div class="cart_row_item operate">
                    <button class="cart_delete_btn">&times;</button>
                </div>
            </div>

            <div class="cart_row">
                <div class="cart_row_item img">
                    <img src="img/img2.png" class="cart_product_img">
                </div>
                <div class="cart_row_item name">特級巧克力蛋糕特級巧克力蛋糕特級巧克力蛋糕</div>
                <div class="cart_row_item unit_price">$500</div>
                <div class="cart_row_item qty">
                    <div class="cart_qty_control">
                        <button class="cart_qty_btn minus">-</button>
                        <input type="number" class="cart_qty_input" value="1">
                        <button class="cart_qty_btn plus">+</button>
                    </div>
                </div>
                <div class="cart_row_item price">$1,500</div>
                <div class="cart_row_item operate">
                    <button class="cart_delete_btn">&times;</button>
                </div>
            </div>
        </div>

        <div class="row mx-0 cart_price_info_block">
            <div class="col-md-4">
                <div class="cart_price_info">
                    <span class="cart_price_info_title">商品金額小計</span>
                    <span class="cart_price_info_content">$3,500</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart_price_info">
                    <span class="cart_price_info_title">運費</span>
                    <span class="cart_price_info_content">$150</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart_price_info">
                    <span class="cart_price_info_title">總金額</span>
                    <span class="cart_price_info_content active">$3,650</span>
                </div>
            </div>
        </div>

        <div class="page_title">付款資訊</div>

        <div class="payment_info_block px-3 py-4 px-md-5 py-md-5 mb-4 border">
            <div class="payment_info_title">會員資訊</div>

            <div class="mb-3">
                <label class="payment_info_label">會員 Email</label>
                <input type="email" class="form-control">
            </div>

            <div class="mb-4">
                <label class="payment_info_label">非會員購買聯絡 Email</label>
                <input type="email" class="form-control">
            </div>
            
            <div class="payment_info_title">購買人資訊</div>
            
            <div class="mb-3">
                <label class="payment_info_label">姓名</label>
                <input type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label class="payment_info_label">聯絡電話</label>
                <input type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label class="payment_info_label">購買人地址</label>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <select class="form-select">
                            <option value="">縣市</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select class="form-select">
                            <option value="">鄉鎮市區</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" class="form-control" placeholder="郵遞區號" readonly>
                    </div>

                    <div class="col-12 mb-3">
                        <input type="text" class="form-control" placeholder="購買人詳細地址：路/巷/弄/樓">
                    </div>
                </div>
            </div>

            <div class="payment_info_title">收件人資訊</div>

            <div class="d-flex align-items-center mb-4">
                <label class="payment_info_radio_label me-3">
                    <input type="radio" name="receiver_data_type" value="buyer" class="payment_info_radio" checked>
                    <span>同購買人</span>
                </label>
                <label class="payment_info_radio_label">
                    <input type="radio" name="receiver_data_type" value="new_receiver" class="payment_info_radio">
                    <span>新增收件人</span>
                </label>
            </div>

            <div class="p-4 mb-4 payment_info_data" id="receiver_data">
                <p>姓名：Joe</p>
                <p>聯絡電話：0912345678</p>
                <p>收件人地址：411台中市太平區測試地址</p>
            </div>

            <div id="new_receiver_data" style="display:none;">
                <div class="mb-3">
                    <label class="payment_info_label">姓名</label>
                    <input type="text" class="form-control">
                </div>
        
                <div class="mb-3">
                    <label class="payment_info_label">聯絡電話</label>
                    <input type="text" class="form-control">
                </div>
        
                <div class="mb-3">
                    <label class="payment_info_label">收件人地址</label>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <select class="form-select">
                                <option value="">縣市</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select class="form-select">
                                <option value="">鄉鎮市區</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" placeholder="郵遞區號" readonly>
                        </div>
        
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control" placeholder="收件人詳細地址：路/巷/弄/樓">
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment_info_title">備註</div>

            <textarea rows="3" class="form-control custom_scrollbar"></textarea>
        </div>

        <div class="mb-80px d-flex justify-content-center">
            <button class="checkout_btn">送出訂單</button>
        </div>

    </div>
</template>

<script>
export default {
    mounted() {
        $('input[name=receiver_data_type]').change(function() {
            if ($(this).val() == 'buyer') {
                $('#receiver_data').show();
                $('#new_receiver_data').hide();
            } else {
                $('#receiver_data').hide();
                $('#new_receiver_data').show();
            }
        });
    },
}
</script>
