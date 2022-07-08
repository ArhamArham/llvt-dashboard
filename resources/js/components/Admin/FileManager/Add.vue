<template>
    <div class="content">
        <div class="grid grid-cols-12 mt-8">
            <div class="col-span-12 lg:col-span-8 sm:col-span-12">
                <h2 class="text-lg font-medium truncate mr-5">
                    File Manager Add
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="w-full intro-y box p-5">
                    <div class="flex flex-wrap -mx-3 mb-6">

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="title">
                                Name
                            </label>
                            <div class="flex items-center">
                                <input
                                    class="form-control w-full"
                                    id="title" placeholder="Enter Name" type="text"
                                    v-model="data.name">
                            </div>
                        </div>

                        <div class="w-full px-3 mb-4">
                            <label class="form-label"
                                   for="image">
                                Browse Image
                            </label>
                            <FileUpload
                                id="image"
                                accept_file_types="image/jpeg, image/png, image/svg+xml"
                                label="Browse"
                                max_file_size="1MB"
                                @process="setImage($event,'path')"
                            />
                        </div>

                        <div class="w-full px-3 mb-4" v-if="url">
                            <label class="form-label"
                                   for="url">
                                Url
                            </label>
                            <div class="flex items-center">
                                <input
                                    class="form-control w-full"
                                    id="url" placeholder="" type="text"
                                    readonly
                                    :value="url">

                                <a class="cursor-pointer ml-2" @click="copyUrl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" icon-name="copy" data-lucide="copy"
                                         class="lucide lucide-copy">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-5">
                    <a href="/admin/fileManager"
                       class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                    <button type="submit"
                            class="btn btn-primary w-24"
                            :disabled="btnLoading"
                            @click="onSubmit">Save
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import FileUpload from '../FileUpload'

export default {
    name: "Add",
    components: {
        FileUpload,
    },
    data: function () {
        return {
            data: {
                name: "",
                image: "",
            },
            url: null,
            btnLoading: false
        }
    },
    methods: {
        setImage(img, key) {
            this.data[key] = img
        },
        onSubmit() {
            this.btnLoading = true;
            axios.post('/admin/fileManager', this.data)
                .then(({data}) => {
                    console.log(data)
                    this.url = data
                    this.btnLoading = false;
                    this.$alertify.success('File stored successfully')

                }).catch((error) => {
                this.btnLoading = false;
                if (error.response.status === 422) {
                    this.$alertify.error(Object.values(error.response.data.errors)[0][0])

                } else if (error.response.status == 500) {
                    this.$alertify.error(error.response.data.message)
                }
            })
        },
        copyUrl() {
            const input = document.createElement('input');
            input.setAttribute('value', this.url);
            input.value = this.url;
            document.body.appendChild(input);
            try {
                input.select();
                input.click();
                input.focus();
                document.execCommand('copy');
            } catch (err) {
                console.log('Oops, unable to copy');
            }
            document.body.removeChild(input);
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

.border-radius-15 {
    border-radius: 15px;
}

.close {
    position: absolute;
    right: 12px;
    margin-top: -10px;
}
</style>
