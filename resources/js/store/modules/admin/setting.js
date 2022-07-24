export default {
    namespaced: true,
    state: {
        loading: false, // loading-spinner 狀態
        content_component_key: '', // 元件 key，更改時強制刷新組件
        sidebar_show: true,
        ckeditor_config: {
            simpleUpload: { // 圖片、檔案上傳設定
                uploadUrl: 'http://127.0.0.1/sweet_smile/public/api/admin/editor/upload',
                uploadUrl: process.env.MIX_API_BASE_URL + '/admin/editor/upload',
                withCredentials: true, // Enable the XMLHttpRequest.withCredentials property.
                headers: { // Headers sent along with the XMLHttpRequest to the upload server.
                    'X-CSRF-TOKEN': 'CSRF-Token',
                    Authorization: '' // 'Bearer <JSON Web Token>'
                }
            },
            link: { // 連結可設定開新視窗 (非 plugin)
                decorators: {
                    isExternal: {
                        mode: 'manual',
                        label: 'Open in a new tab',
                        attributes: {
                            target: '_blank'
                        }
                    }
                }
            },
            htmlSupport: { // 支援 HTML，配合 source editing 編輯內容
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            }
        }
    },
    actions: {
        
    },
    mutations: {
        showLoading(state) {
            state.loading = true;
        },
        hideLoading(state) {
            state.loading = false;
        },
        updateCkeditorConfigAuthorizationToken(state, token) {
            state.ckeditor_config.simpleUpload.headers.Authorization = 'Bearer ' + token;
        },
        updateContentComponentKey(state) {
            const word = "ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz0123456789";
            const word_len = word.length;
            let component_key = "";

            for (let i = 0; i < 16; i++) {
                component_key += word.charAt(Math.floor(Math.random() * word_len));
            }

            state.content_component_key = component_key;
        },
        toggleSiderbar(state, status) {
            state.sidebar_show = status;
        }
    },
    getters: {
        
    },
}