<template>
    <div>
        <div class="admin_title">關於我們</div>

        <form @submit.prevent="updateAbout">
            <div class="mb-4">
                <label class="form-label">內容</label>
                <textarea name="content" rows="5" v-model="content" class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary">更新</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'AboutAddEdit',
        data() {
            return {
                content: '',
                editor: null
            }
        },
        async mounted() {
            await this.getContent();

            ClassicEditor
            .create( document.querySelector('textarea[name=content]'), this.$store.state.admin_setting.ckeditor_config)
            .then( editor => { this.editor = editor; })
            .catch( error => { console.error( error ); });
        },
        methods: {
            async getContent() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                await axios.get('/admin/about')
                .then(function (response) {
                    // console.log(response);
                    vm.content = response.data.content;
                    vm.$store.commit('admin_setting/hideLoading');
                })
                .catch(function(error) {
                    vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            },
            updateAbout() {
                const vm = this;

                vm.$store.commit('admin_setting/showLoading');

                vm.content = vm.editor.getData();
                    
                axios.put('/admin/about?_method=PUT', {
                    content: vm.content,
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
            }
        }
    }
</script>