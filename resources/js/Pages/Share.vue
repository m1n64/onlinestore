<script setup>
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {formatDate, isImageByMimeType} from "@/functions/helpers";
import MultimediaView from "@/Components/MultimediaView.vue";

const props = defineProps({
    file: {
        type: Object,
        default: {}
    },
    fileExpired: {
        type: String,
        default: ""
    }
});

</script>

<template>
    <Head :title="'File '+props.file.name"/>

    <GuestLayout>
        <div class="flex flex-col">
            <div>
                <div class="text-xl font-bold">{{ props.file.name }}</div>
                <MultimediaView
                    :link="props.file.full_file_path"
                    :mime-type="props.file.mime_type"
                    class="my-2 w-full"
                />
<!--                <div v-if="isImageByMimeType(props.file.mime_type)">
                    <img :src="props.file.full_file_path" :alt="props.file.name" class="my-2"/>
                </div>-->
                <div class="flex justify-between my-2">
                    <span>
                        <font-awesome-icon icon="fa-solid fa-user"/>
                        {{ props.file.user.name }}
                    </span>

                    <span>
                        <font-awesome-icon icon="fa-regular fa-clock" />
                        {{ formatDate(props.file.created_at) }}
                    </span>
                </div>
                <div class="text-gray-600">Link expired at: {{ formatDate(props.fileExpired) }}</div>
            </div>
            <a :href="props.file.download_link" :download="props.file.name" class="btn main text-center mt-4">Download</a>
        </div>
    </GuestLayout>
</template>

