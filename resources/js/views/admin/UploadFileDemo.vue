<template>
    <div>
        <div class="admin_title">檔案上傳範例</div>

        <form @submit.prevent="uploadFile">
            <div class="mb-4">
                <label class="form-label">檔案</label>
                <input type="file" name="demo" class="dropify" @change="changeFile">
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="d-flex justify-content-between py-3">
                <button class="btn btn-primary">上傳</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'UploadFileDemo',
        data() {
            return {
                demo_file: null,
            }
        },
        mounted() {
            $('.dropify').dropify({
                messages: {
                    'default': '將文件拖放到此處或單擊',
                    'replace': '拖放或點擊替換',
                    'remove':  '刪除',
                    'error':   '糟糕，發生了錯誤'
                }
            });
        },
        methods: {
            changeFile(e) {
                this.demo_file = e.target.files[0];

                console.log(this.demo_file);
            },
            async uploadFile() {
                const vm = this;

                await axios.post('/admin/upload_file', {
                    demo: vm.demo_file,
                }, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    console.log(response);
                    
                    // vm.$store.commit('admin_setting/hideLoading');

                    // if (response.data.status == 'success') {
                    //     Swal.fire({
                    //         icon: 'success',
                    //         title: '會員新增成功',
                    //         timer: 1500,
                    //         showConfirmButton: false,
                    //         willClose: () => {
                    //             vm.$router.push({name: 'adminMemberList'});
                    //         },
                    //     });
                    // } else if (response.data.status == 'fail') {
                    //     Swal.fire({
                    //         icon: 'warning',
                    //         title: response.data.message,
                    //         timer: 1500,
                    //     });
                    // }
                })
                .catch(function(error) {
                    // vm.$store.commit('admin_setting/hideLoading');
                    console.error("Error: ", error);
                });
            }
        }
    }
</script>