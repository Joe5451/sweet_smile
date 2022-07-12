<template>
    <div>
        <div class="admin_title">最新消息管理</div>

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-sm btn-info text-white" @click="$router.back()">回上一頁</button>
        </div>

        <form @submit.prevent="checkForm">
            <div class="mb-4 img_container" style="max-width: 300px">
                <label class="form-label">封面圖片</label>
                <input type="file" name="cover_img" class="dropify" @change="changeFile" data-max-file-size="1M">
                <div class="invalid-feedback" id="cover_img_invalid_feedback"></div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">標題</label>
                <input type="text" name="title" v-model="title" class="form-control">
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-4">
                <label class="form-label">日期</label>
                <input type="date" name="date" v-model="date" class="form-control">
                <div class="invalid-feedback"></div>
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
                <label class="form-label">內容</label>
                <textarea name="content" v-model="content" class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button type="button" @click="confirmDelete(news_id)" class="btn btn-danger">刪除</button>
                <button class="btn btn-primary">更新</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'NewsUpdateEdit',
        data() {
            return {
                news_id: this.$route.params.news_id,
                cover_img_url: '',
                is_cover_img_update: false, // 商品封面圖是否更新
                cover_img_update_file: null, // 商品封面圖檔案
                title: '',
                date: '',
                display: 1,
                summary: '',
                content: '',
                editor: null
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

            await this.getNews(this.news_id);

            // 重置 dropify 元素
            let drEventData = drEvent.data('dropify');
            drEventData.resetPreview();
            drEventData.clearElement();
            drEventData.settings.defaultFile = this.cover_img_url;
            drEventData.destroy();
            drEventData.init();

            // 刪除圖片
            drEvent.on('dropify.afterClear', function(event, element) {
                vm.cover_img_update_file = null;
                vm.is_cover_img_update = true;
            });

            ClassicEditor
            .create( document.querySelector('textarea[name=content]'), this.$store.state.admin_setting.ckeditor_config)
            .then( editor => { this.editor = editor; })
            .catch( error => { console.error( error ); });
        },
        methods: {
            changeFile(e) {
                this.cover_img_update_file = e.target.files[0];
                this.is_cover_img_update = true;
            },
            async getNews(news_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/news/' + news_id)
                .then(function (response) {
                    let news = response.data.new;

                    vm.title = news.title;
                    vm.date = news.date;
                    vm.display = news.display;
                    vm.summary = news.summary;
                    vm.content = news.content;
                    vm.cover_img_url = news.cover_img;

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
                $('#cover_img_invalid_feedback').text('').hide();
                $('input[name=cover_img]').parents('.dropify-wrapper').removeClass('border border-danger');
                
                if (this.is_cover_img_update && this.cover_img_update_file == null) {
                    $('#cover_img_invalid_feedback').text('請上傳商品圖片').show();

                    let element = $('input[name=cover_img]');
                    element.parents('.dropify-wrapper').addClass('border border-danger');

                    // 移至元素位置
                    let contentTop = element.offset().top - 120;

                    $([document.documentElement, document.body]).animate({
                        scrollTop: contentTop
                    }, 800, 'swing', function() {
                        element.focus();
                    });
                }
                else if (this.title == '')
                    this.alertInvalidMessage($('input[name=title]'), '請輸入標題');
                else if (this.date == '')
                    this.alertInvalidMessage($('input[name=date]'), '請選擇日期');
                else {
                    this.content = this.editor.getData();
                    this.updateNews();
                }
            },
            updateNews() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');
                    
                axios.post('/admin/news/' + vm.news_id + '?_method=PUT', {
                    cover_img_update_file: vm.cover_img_update_file,
                    is_cover_img_update: vm.is_cover_img_update,
                    title: vm.title,
                    date: vm.date,
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
            confirmDelete(new_id) {
                const vm = this;

                Swal.fire({
                    icon: 'question',
                    title: '確定刪除?',
                    showCancelButton: true,
                    cancelButtonText: '取消',
                    confirmButtonText: '確定',
                }).then((result) => {
                    if (result.isConfirmed) {
                        vm.deleteNews(new_id);
                    } 
                })
            },
            async deleteNews(new_id) {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.delete('/admin/news/' + new_id)
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
                                vm.$router.push({name: 'adminNewsList'});
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