<template>
    <div>
        <div class="grid grid-cols-12 mt-8">
            <div class="col-span-12 lg:col-span-8 sm:col-span-12">
                <h2 class="text-lg font-medium truncate mr-5">
                    Website Setting
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="w-full intro-y box p-5">
                    <div class="flex flex-wrap -mx-3 mb-6">

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="headerLogo">
                                Browse Header Logo
                            </label>
                            <FileUpload
                                id="headerLogo"
                                accept_file_types="image/jpeg, image/png, image/svg+xml"
                                label="Browse"
                                :my-files="setting.headerLogo"
                                @removeFile="onRemoveFile($event,'headerLogo')"
                                max_file_size="1MB"
                                @process="setImage($event,'headerLogo')"
                            />
                        </div>

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="status">
                                Dark Mode Status
                            </label>
                            <div class="form-switch mt-2">
                                <input type="checkbox"
                                       id="status"
                                       class="form-check-input"
                                       :checked="data.darKMode"
                                       @change="onCheckbox($event,'darKMode')"/>
                            </div>
                        </div>

                        <div class="w-full md:w-1/4 px-3 mb-4">
                            <label class="form-label"
                                   for="footerText">
                                Footer Text
                            </label>
                            <div class="flex items-center">
                                <input
                                    class="form-control w-full"
                                    id="footerText" placeholder="Enter Footer Text" type="text"
                                    v-model="data.footerText">
                            </div>
                        </div>

                        <div class="px-3 mb-3 w-full">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Social Links
                            </h2>
                        </div>

                        <div class="w-full md:w-1/4 px-3 mb-4" v-for="link of socialLinks">
                            <label class="capitalize form-label"
                                   :for="link">
                                {{ link.replaceAll("_", " ") }}
                            </label>
                            <div class="flex items-center">
                                <input
                                    class="form-control w-full"
                                    :id="link" placeholder="Enter Link" type="text"
                                    v-model="data[link]">
                            </div>
                        </div>

                        <div class="w-full md:w-1/4 px-3 mb-4">
                            <label class="capitalize form-label">
                                Color Scheme
                            </label>
                            <div class="flex items-center">
                                <a v-for="(classes,theme) of themes" :key="theme" @click="setTheme(theme)"
                                   :class="`${classes} ${theme == data.currentTheme ? 'border-slate-300' : 'border-white'}`"
                                   class="block w-8 h-8 cursor-pointer rounded-full border-4 mr-1 hover:border-slate-200"></a>
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
    </div>
</template>

<script>

import FileUpload from "../FileUpload";

export default {
    name: "Homepage",
    components: {
        FileUpload,
    },
    props: ['setting', 'categories'],
    data: function () {
        return {
            data: this.setting,
            socialLinks: [
                'facebook_link',
                'instagram_link',
                'linkedin_link',
                'pinterest_link',
            ],
            btnLoading: false,
            themes: {
                "theme-1": "bg-emerald-900 dark:border-darkmode-800/80",
                "theme-2": "bg-blue-800 dark:border-darkmode-600",
                "theme-3": "bg-cyan-900 dark:border-darkmode-600",
                "theme-4": "bg-indigo-900 dark:border-darkmode-600",
                "theme-5": "bg-blue-900 dark:border-darkmode-600",
            }
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
            axios.post('/admin/setting/website', this.data)
                .then(({data}) => {
                    this.btnLoading = false;
                    this.$alertify.success('Website setting updated successfully')
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
        onSelectCategory() {
            return !(this.data.categories?.length && this.data.categories.length >= 4);

        },
        onCheckbox(e, key) {
            this.data[key] = e.target.checked;
        },
        setTheme(e) {
            this.data.currentTheme = e;
        }
    }
}
</script>

<style scoped>
@media (min-width: 768px) {
    .md\:w-1\/2 {
        width: 25%;
    }

    .md\:w-1\/3 {
        width: 33.333333%;
    }

    .md\:w-1\/4 {
        width: 50%;
    }

    .md\:w-1\/5 {
        width: 75%;
    }
}
</style>
