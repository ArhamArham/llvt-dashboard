<template>
    <div class="content">
        <div class="grid grid-cols-12 mt-8">
            <div class="col-span-12 lg:col-span-8 sm:col-span-12">
                <h2 class="text-lg font-medium truncate mr-5">
                    Homepage Setting
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="w-full intro-y box p-5">
                    <div class="flex flex-wrap -mx-3 mb-6">

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="image">
                                Browse Top banner
                            </label>
                            <FileUpload
                                id="image"
                                accept_file_types="image/jpeg, image/png, image/svg+xml"
                                label="Browse"
                                :my-files="setting.topBannerImage"
                                @removeFile="onRemoveFile($event,'topBannerImage')"
                                max_file_size="1MB"
                                @process="setImage($event,'topBannerImage')"
                            />
                        </div>

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="topBannerFirstTitle">
                                Top Banner First Title
                            </label>
                            <div class="flex items-center">
                                <input
                                    class="form-control w-full"
                                    id="topBannerFirstTitle" placeholder="Enter Top Banner First Title" type="text"
                                    v-model="data.topBannerFirstTitle">
                            </div>
                        </div>

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="topBannerSecondTitle">
                                Top Banner Second Title
                            </label>
                            <div class="flex items-center">
                                <input
                                    class="form-control w-full"
                                    id="topBannerSecondTitle" placeholder="Enter Top Banner Second Title" type="text"
                                    v-model="data.topBannerSecondTitle">
                            </div>
                        </div>

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="content">
                                Content
                            </label>
                            <ckeditor v-model="data.content" id="content"></ckeditor>
                        </div>

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="middleContent">
                                Middle Content
                            </label>
                            <ckeditor v-model="data.middleContent" id="middleContent"></ckeditor>
                        </div>

                    </div>
                </div>

                <div class="text-right mt-5">
                    <button type="submit"
                            class="btn btn-primary w-24"
                            :disabled="btnLoading"
                            @click="onSubmit">Update
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import FileUpload from '../FileUpload'

export default {
    name: "Homepage",
    components: {
        FileUpload,
    },
    props: ['setting'],
    data: function () {
        return {
            data: this.setting,
            btnLoading: false
        }
    },
    methods: {
        setImage(img, key) {
            this.data[key] = img
        },
        onRemoveFile(_, type) {
            this.data[type] = "removed"
        },
        onSubmit() {
            this.btnLoading = true;
            axios.post('/admin/setting/homepage', this.data)
                .then(({data}) => {
                    this.btnLoading = false;
                    this.$alertify.success('Homepage setting updated successfully')
                    window.location.reload()

                }).catch((error) => {
                this.btnLoading = false;
                if (error.response.status === 422) {
                    this.$alertify.error(Object.values(error.response.data.errors)[0][0])

                } else if (error.response.status == 500) {
                    this.$alertify.error(error.response.data.message)
                }
            })
        },
    }
}
</script>

<style scoped>
</style>
