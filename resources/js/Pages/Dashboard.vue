<script setup>
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import AuthWithBgLayout from "@/Layouts/AuthWithBgLayout.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import {computed, ref} from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CardComponent from "@/Components/CardComponent.vue";
import LabelInput from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import _ from "lodash";
import {useToast} from "vue-toastification";
import {formatDate, openInNewTab} from "@/functions/helpers";
import CloseButton from "@/Components/CloseButton.vue";
import Preloader from "@/Components/Preloader.vue";
import MultimediaView from "@/Components/MultimediaView.vue";
import PreviewFile from "@/Components/PreviewFile.vue";
import {getCookie} from "@/cookies";

const props = defineProps({
    folderSlug: {
        type: String,
        default: null
    },
    folders: {
        type: Array,
        default: []
    },
    foldersBreadcrumbs: {
        type: Array,
        default: []
    },
    files: {
        type: Array,
        default: [],
    }
});

const folders = ref(props.folders);
const files = ref(props.files);
const userFilesSize = ref(usePage().props.value.auth.user.files_size);
const fileInfo = ref({
    isLoaded: false,
    id: -1,
    name: "",
    size: 0,
    uploaded: Date.now().toLocaleString(),
    shared: false,
    mimeType: "",
    downloadLink: "",
    downloadTemporaryLink: "",
    sharingLink: "",
});

const showModalFolderName = ref(false);
const folderName = ref("");
const showModalFileUpload = ref(false);
const showFileInfoBlock = ref(false);
const showFileSharingLink = ref(false);
const showModalFileRename = ref(false);

const fileList = ref([]);
const filesList = ref(null);
const fileRenameInput = ref(null);
const newFileName = ref("");
const progressValue = ref(0);

const searchText = ref("");

const toast = useToast();

const configHeaders = {
    "Authorization": `Bearer ${getCookie("__token")}`
};

const showFolderCreate = () => {
    showModalFolderName.value = true;
};

const hideFolderCreate = () => {
    showModalFolderName.value = false;
};

const showFileUpload = () => {
    showModalFileUpload.value = true;
    progressValue.value = 0;
};

const hideFileUpload = () => {
    showModalFileUpload.value = false;
    progressValue.value = 0;
};

const showFileInfo = (id) => {
    showFileInfoBlock.value = true;
    fileInfo.value.isLoaded = false

    axios.get("/api/share/isShared/" + id, {
        headers: configHeaders
    })
        .then((response) => {
            if (!response.data.success) {
                return toast.error(response.data.message);
            }

            const file = files.value.find((el) => el.id === id);

            fileInfo.value = {
                isLoaded: true,
                id: id,
                name: file.name,
                size: file.size,
                uploaded: formatDate(file.created_at),
                shared: response.data.data.inSharing,
                mimeType: file.mime_type,
                downloadLink: file.full_file_path,
                downloadTemporaryLink: response.data.data.downloadUrl,
                sharingLink: route('share', {slug: file.slug}),
            };
        })
};

const hideFileInfoBlock = () => {
    showFileInfoBlock.value = fileInfo.value.isLoaded = false;

};

const createFolder = () => {
    axios.post("/api/folders/create", {
        name: folderName.value,
        folderSlug: props.folderSlug,
    }, {
        headers: configHeaders
    })
        .then((response) => {
            if (response.data.success) {

                folders.value.push(response.data.data);

                folderName.value = "";
                hideFolderCreate();
            }
        })
};

const deleteFolder = (id) => {
    axios.delete("/api/folders/delete/" + id, {
        headers: configHeaders
    })
        .then((response) => {
            if (!response.data.success) {
                return toast.error(response.data.message);
            }
            _.remove(folders.value, (folder) => folder.id === id);
        })
};

const onFileChange = () => {
    fileList.value = [...filesList.value.files];
};

const remove = (i) => {
    fileList.value.splice(i, 1);
};

const dragOver = (event) => {
    event.preventDefault();
    if (!event.currentTarget.classList.contains('border-indigo-600')) {
        event.currentTarget.classList.remove('border-gray-300');
        event.currentTarget.classList.add('border-indigo-600');
    }
};

const dragLeave = (event) => {
    event.currentTarget.classList.add('border-gray-300');
    event.currentTarget.classList.remove('border-progressValueRefindigo-600');
};

const drop = (event) => {
    event.preventDefault();
    filesList.value.files = event.dataTransfer.files;
    onFileChange();

    dragLeave(event);
};

const sendFiles = () => {
    const data = new FormData();

    data.append("folderSlug", props.folderSlug);

    fileList.value.forEach((el, i) => {
        data.append(`files[${i}]`, el);
    });

    axios.post("/api/files/create", data, {
        headers: {...configHeaders, 'Content-Type': 'multipart/form-data'},
        onUploadProgress: (event) => {
            progressValue.value = parseInt(Math.round((event.loaded / event.total) * 100));
        }
    })
        .then((response) => {
            if (!response.data.success) {
                toast.error(response.data.message);
            }
            files.value.push(...response.data.data.files);
            userFilesSize.value = response.data.data.userSize;

            hideFileUpload();
            fileList.value = [];
        })
        .catch((response) => {
            return toast.error(response.message);
        })

};

const shareFile = (id) => {
    showFileSharingLink.value = true;

    axios.post("/api/share/" + id, {}, {
        headers: configHeaders
    })
        .then((response) => {
            if (!response.data.success) {
                return toast.error(response.data.message);
            }

            fileInfo.value.shared = response.data.data.inSharing;
        })
};

const renameFile = (id) => {
    axios.post("/api/files/rename/" + id, {
        name: newFileName.value
    }, {
        headers: configHeaders
    })
        .then((response) => {
            if (!response.data.success) {
                return toast.error(response.data.message);
            }

            fileInfo.value.name = response.data.data.name;
            files.value = files.value.map((el) => {
                return el.id === response.data.data.id ? response.data.data : el;
            });

            showModalFileRename.value = false;
        })
};

const deleteFile = (id) => {
    axios.delete("/api/files/delete/" + id, {
        headers: configHeaders
    })
        .then((response) => {
            if (!response.data.success) {
                return toast.error(response.data.message);
            }

            fileInfo.value.id = -1;
            fileInfo.value.isLoaded = showFileInfoBlock.value = false;

            userFilesSize.value = response.data.data.userSize;
            _.remove(files.value, (file) => file.id === id);
        })
};

</script>

<template>
    <Head title="Main"/>

    <AuthWithBgLayout>
        <div class="flex sm:flex-row flex-col justify-between">
            <div class="">
                <button class="btn sub"
                        :disabled="$page.props.auth.user.max_files_size > -1 ? userFilesSize >= $page.props.auth.user.max_files_size : false"
                        @click="showFileUpload"
                >
                    <font-awesome-icon icon="fa-solid fa-plus"/>
                    Add file
                </button>

                <button class="btn main" @click="showFolderCreate">
                    Add folder
                </button>
            </div>
            <div class="flex justify-between">
                <div class="flex text-lg">
                    <span class="px-2">{{ userFilesSize }}MB</span>
                    <ProgressBar
                        class="w-[40vw] px-2 mt-2"
                        :value="$page.props.auth.user.max_files_size === -1 ? 100 : userFilesSize"
                        :max-value="$page.props.auth.user.max_files_size === -1 ? 1 : $page.props.auth.user.max_files_size"
                    />
                    <span class="px-2">
                        <template v-if="$page.props.auth.user.max_files_size > -1">
                            {{ $page.props.auth.user.max_files_size }}MB
                        </template>
                        <template v-else>
                            <font-awesome-icon icon="fa-solid fa-infinity"/>
                        </template>
                    </span>
                </div>
            </div>
        </div>

        <div>
            <TextInput
                id="searchInDir"
                ref="searchInDir"
                type="text"
                class="my-2 block w-full"
                placeholder="Search files in this dir"
                v-model="searchText"
                @keyup="()=>{$refs.search.focus()}"
            />
        </div>

        <div class="my-3 cursor-pointer">
            <Link class="font-bold hover:border-b-2 hover:border-solid hover:border-b-black" :href="route('dashboard')">
                My documents
            </Link>
            <template v-for="(crumb, key) in props.foldersBreadcrumbs" :key="key">
                <font-awesome-icon class="mx-2" icon="fa-solid fa-chevron-right"/>
                <Link
                    :class="key === props.foldersBreadcrumbs.length-1 ? 'text-gray-500 cursor-default' : 'hover:border-b-2 hover:border-solid hover:border-b-black'"
                    :href="route('dashboard', {'folderSlug': crumb.slug})">
                    {{ crumb.name }}
                </Link>
            </template>
        </div>

        <div class="flex flex-row sm:flex-row flex-col">
            <div class="w-full">
                <div class="flex my-3 flex-wrap">
                    <div class="md:w-[25%] w-[50%] p-2" v-for="(folder, key) in folders" :key="key">
                        <CloseButton :button-click="deleteFolder" :additonal="folder.id"/>
                        <Link class="block float-left hover:text-indigo-600"
                              :href="route('dashboard', {'folderSlug': folder.slug})">
                            <font-awesome-icon icon="fa-regular fa-folder" class="text-6xl cursor-pointer"/>
                            <div class="break-words">
                                {{ folder.name }}
                            </div>
                        </Link>

                    </div>
                </div>

                <div class="flex my-3 flex-wrap">
                    <div class="md:w-[25%] w-[50%] h-[130px] p-2" v-for="(file, key) in files" :key="key"
                         @click="showFileInfo(file.id)">
                        <span>
                            <PreviewFile
                                :link="file.full_file_path"
                                :mime-type="file.mime_type"
                            />
                            <div class="break-words">
                                {{ file.name }}
                            </div>
                        </span>

                    </div>
                </div>
            </div>
            <div class="w-[40%]" v-show="showFileInfoBlock">
                <div v-if="!fileInfo.isLoaded" class="text-center mt-[50%]">
                    <Preloader/>
                </div>
                <template v-else>
                    <div class="flex">

                        <div>
                            <div class="font-bold text-lg mb-3">Information</div>
                            <div class="break-words">Name: {{ fileInfo.name }}</div>
                            <div>Size: {{ fileInfo.size }}MB</div>
                            <div>Uploaded: {{ fileInfo.uploaded }}</div>
                            <div>Shared: {{ fileInfo.shared ? 'Yes' : 'No' }}</div>
                        </div>
                        <div>
                            <CloseButton :button-click="hideFileInfoBlock"/>
                        </div>
                    </div>

                    <MultimediaView
                        :link="fileInfo.downloadLink"
                        :mime-type="fileInfo.mimeType"
                    />

                    <div class="flex flex-col my-2">
                        <a :href="fileInfo.downloadTemporaryLink" :download="fileInfo.name" class="btn main my-2 text-center"
                           target="_self">Download</a>
                        <button class="btn main my-2"
                                @click="()=>{showModalFileRename = true; newFileName = fileInfo.name}">Rename
                        </button>
                        <button class="btn main my-2" @click="shareFile(fileInfo.id)" :disabled="fileInfo.shared">
                            Share
                        </button>
                        <a v-show="fileInfo.shared" @click="showFileSharingLink = true"
                           class="ml-2 cursor-pointer underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Forgot
                            link?</a>
                        <button class="btn sub my-4" @click="deleteFile(fileInfo.id)">Delete</button>
                    </div>
                </template>
            </div>
        </div>


        <Modal :show="showModalFolderName">
            <CardComponent
                head-text="Create folder"
            >
                <LabelInput for="folderName" value="Enter folder name:" class="sr-only"/>
                <TextInput
                    id="folderName"
                    ref="passwordInput"
                    type="text"
                    class="my-2 block w-3/4"
                    placeholder="folder name"
                    v-model="folderName"
                />

                <SecondaryButton @click="hideFolderCreate">Close</SecondaryButton>
                <PrimaryButton @click="createFolder" :disabled="folderName.length === 0">Save</PrimaryButton>
            </CardComponent>
        </Modal>

        <Modal :show="showModalFileUpload">
            <CardComponent
                head-text="Upload file"
            >
                <div class="flex w-full my-3 items-center justify-center text-center">
                    <div class="p-12 bg-gray-100 rounded-lg border-2 border-gray-300" @dragover="dragOver"
                         @dragleave="dragLeave" @drop="drop">
                        <input type="file" multiple name="fields[assetsFieldHandle][]" id="assetsFieldHandle"
                               class="w-px h-px opacity-0 overflow-hidden absolute" @change="onFileChange"
                               ref="filesList"/>

                        <label for="assetsFieldHandle" class="block cursor-pointer">
                            <div>
                                Explain to our users they can drop files in here
                                or <span class="underline">click here</span> to upload their files
                            </div>
                        </label>
                        <ul class="mt-4" v-if="fileList.length" v-cloak>
                            <li class="text-sm p-1" v-for="file in fileList">
                                {{ file.name }}
                                <font-awesome-icon icon="fa-solid fa-xmark"
                                                   class="cursor-pointer ml-2 hover:text-red-600"
                                                   @click="remove(fileList.indexOf(file))"/>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full">
                    <ProgressBar class="w-[100%]" :max-value="100" :value="progressValue"/>
                </div>
                <SecondaryButton @click="hideFileUpload">Close</SecondaryButton>
                <PrimaryButton @click="sendFiles" :disabled="fileList.length === 0">Send</PrimaryButton>
            </CardComponent>
        </Modal>

        <Modal :show="showFileSharingLink">
            <CardComponent
                head-text="Sharing link"
            >
                <TextInput
                    type="text"
                    class="my-2 block w-full"
                    placeholder="folder name"
                    readonly
                    :value="fileInfo.sharingLink"
                />
                <SecondaryButton
                    v-clipboard:copy="fileInfo.sharingLink"
                    v-clipboard:success="()=>{toast.success('Copied')}">Copy
                </SecondaryButton>
                <SecondaryButton @click="openInNewTab(fileInfo.sharingLink)">Open</SecondaryButton>
                <PrimaryButton @click="showFileSharingLink = false">Close</PrimaryButton>
            </CardComponent>
        </Modal>

        <Modal :show="showModalFileRename">
            <CardComponent
                head-text="Rename file"
            >
                <TextInput
                    id="fileRenameInput"
                    type="text"
                    class="my-2 block w-full"
                    placeholder="File name"
                    ref="fileRenameInput"
                    v-model="newFileName"
                />
                <SecondaryButton @click="showModalFileRename = false">Close</SecondaryButton>
                <PrimaryButton @click="renameFile(fileInfo.id)">Save</PrimaryButton>
            </CardComponent>
        </Modal>

        <Modal :show="searchText.length > 0">

            <CardComponent
                head-text="Search files in current dir"
            >
                <div class="flex flex-row">
                    <TextInput
                        id="search"
                        type="text"
                        class="my-2 block w-full"
                        placeholder="Search files in current dir"
                        ref="search"
                        v-model="searchText"
                    />
                    <CloseButton class="mt-5 px-2" :button-click="()=>{searchText = ''}"/>
                </div>

                <div v-for="(file, key) in files.filter((el) => el.name.toLowerCase().indexOf(searchText.toLowerCase()) > -1)" :key="key">
                    <div class="cursor-pointer font-bold my-2 border-b-2 border-solid border-b-gray-200"
                        @click="()=>{showFileInfo(file.id); searchText = ''}"
                    >
                        {{ file.name }}
                    </div>
                </div>
            </CardComponent>
        </Modal>
    </AuthWithBgLayout>
</template>
