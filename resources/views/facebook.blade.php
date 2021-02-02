<x-app-layout>
    @php $user = Auth::user() @endphp

    <div id="vue-source">
    @if(!$user->facebook_token || !$user->facebook_page)
        <div class="flex justify-between text-sm text-left text-red-600 bg-red-200 border border-red-400 min-h-12 flex items-center p-4 rounded-md" role="alert">
            <div>{{ __('Your account does not have Facebook credentials') }}</div>
        </div>
    @else
        <div v-show="pageReady" style="display: none" class="rounded-md editor mx-auto sm:w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 max-w-2xl relative overflow-hidden">

            <div v-if="loading" class="absolute left-0 top-0 h-full w-full bg-white z-50 flex items-center justify-center bg-opacity-90">
                <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-32 w-32"></div>
            </div>


            <div v-if="error" class="flex justify-between text-sm text-left text-red-600 bg-red-200 border border-red-400 min-h-12 flex items-center p-4 rounded-md mb-4" role="alert">
                <div>@{{ error }}</div>
                <a class="cursor-pointer" v-on:click="error = false">X</a>
            </div>

            <div v-if="finished" class="flex justify-between text-sm text-left text-green-600 bg-green-200 border border-green-400 min-h-12 flex items-center p-4 rounded-md mb-4" role="alert">
                <div>{{ __('Your post was uploaded successfully.') }}</div>
                <a class="cursor-pointer" v-on:click="finished = false">X</a>
            </div>

            <textarea v-model="message" class="rounded-md rounded-b-none shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" spellcheck="false" placeholder="{{ __('Type here what you want to post') }}" rows="4"></textarea>

            <div class="rounded-md rounded-t-none shadow-sm border border-gray-300 overflow-hidden border-t-0 relative">
                <template v-if="fileSrc">
                    <a v-on:click="resetImage" class="cursor-pointer absolute right-1 top-1 bg-red-50 text-red-500 font-bold rounded-xl px-2 bg-opacity-50">X</a>
                    <img  v-bind:src="fileSrc" class="block" />
                </template>

                <div v-else class="flex items-center justify-center rounded-md border-gray-600 py-6 my-3">
                    <label
                        class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg tracking-wide sm:border border-blue cursor-pointer hover:bg-blue hover:text-indigo-800">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                        </svg>
                        <span class="mt-2">{{ __('Select a file') }}</span>
                        <input ref="image" v-on:change="loadImage" type='file' class="hidden"/>
                    </label>
                </div>
            </div>

            <div class="buttons flex justify-end pt-4 pb-2">
                <x-button v-on:click="reset" type="button" class="ml-3 mr-3" v-bind:disabled="formEmpty" v-bind:class="{'cursor-not-allowed': formEmpty}">
                    {{ __('Clear') }}
                </x-button>
                <x-button v-on:click="submit" type="button" class="ml-3" class="bg-indigo-500 hover:bg-indigo-700" v-bind:disabled="formEmpty" v-bind:class="{'cursor-not-allowed': formEmpty}">
                    {{ __('Post') }}
                </x-button>
            </div>

            <div>
                <div class="font-bold">{{ __('Third party components:') }}</div>
                <div>
                    <template v-for="(url, label) in cmps">
                        <a class="underline inline-block mr-1 text-indigo-400"  v-bind:key="url" target="_blank" v-bind:href="url">
                            @{{ label }}
                        </a>
                    </template>
                </div>
            </div>

        </div>
    @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script>
        window.addEventListener('load', () => {

            const app = new Vue({
                el: '#vue-source',
                data() {
                    return {
                        pageReady: false,
                        message: null,
                        fileSrc: null,
                        blobData: null,
                        error: null,
                        loading: false,
                        finished: false,
                        pageId: null,
                        accessToken: null,

                        cmps: {
                            'Post Making Form': 'https://tailwindcomponents.com/component/post-making-form',
                            'Tailwind Css File Upload': 'https://codepen.io/shuvroroy/pen/VEJGpX',
                            'Simple Alerts': 'https://tailwindcomponents.com/component/simple-alerts'
                        }
                    }
                },

                computed: {
                    formEmpty () {
                        return !this.blobData && (!this.message || !this.message.trim())
                    },

                    endpointType () {
                        return this.blobData ? 'photos' : 'feed'
                    },

                    hasCredentials () {
                        return this.accessToken && this.pageId && this.accessToken.trim() && this.pageId.trim()
                    }
                },

                methods: {
                    reset (finished = false) {
                        this.message = null
                        this.error = null
                        this.resetImage()
                        if (!finished) {
                            this.finished = false
                        }
                    },

                    resetImage () {
                        this.fileSrc = null
                        this.blobData = null
                    },

                    loadImage (e) {
                        if (e.target.files && e.target.files[0]) {
                            const file = e.target.files[0];
                            this.fileSrc = URL.createObjectURL(file)

                            const fileReader = new FileReader();
                            fileReader.readAsArrayBuffer(file);
                            fileReader.onloadend = () => this.blobData = new Blob([fileReader.result])
                        }
                    },

                    submit () {
                        if (!this.formEmpty) {
                            const formData = new FormData()

                            this.fetchCredentials()
                                .then(() => {
                                    formData.append('access_token', this.accessToken)
                                    if (this.blobData) {
                                        formData.append('source', this.blobData)
                                    }
                                    if (this.message) {
                                        formData.append('message', this.message)
                                    }

                                    return this.send(formData)
                                })
                                .then(() => this.reset(true))
                                .catch(err => this.error = err)

                        }
                    },

                    fetchCredentials () {
                        this.loading = true
                        if (!this.hasCredentials) {
                            return fetch('/facebook/credentials')
                                .then(response => response.json())
                                .catch(() => null)
                                .then(data => {
                                    if (data) {
                                        this.accessToken = data.accessToken
                                        this.pageId = data.pageId
                                    }
                                    return Promise.resolve()
                                })
                        } else {
                            return Promise.resolve()
                        }
                    },

                    send (formData) {
                        if (!this.hasCredentials) {
                            this.loading = false
                            return Promise.reject('Missing Facebook credentials!')
                        }

                        return fetch(`https://graph.facebook.com/${this.pageId}/${this.endpointType}`, { body: formData, method: 'post' })
                            .then(response => response.json())
                            .then(data => {
                                this.loading = false
                                if (data.id) {
                                    this.finished = true
                                    return Promise.resolve()
                                } else {
                                    return Promise.reject(data.error.message)
                                }
                            })
                    }
                },

                mounted () {
                    this.pageReady = true
                }
            })

        })
    </script>

    <style>
        .loader {
            border-top-color: #3730A3;
            animation: spinner 1.5s linear infinite;
        }

        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

</x-app-layout>
