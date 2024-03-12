<script setup>
import {isImageByMimeType, isAudioByMimeType, isVideoByMimeType} from "@/functions/helpers";

const props = defineProps({
    link: {
        type: String,
        default: ""
    },
    mimeType: {
        type: String,
        default: ""
    }
})
</script>

<template>
    <img class="h-[45%] cursor-pointer" :src="props.link"
         v-if="isImageByMimeType(props.mimeType)">
    <font-awesome-icon icon="fa-regular fa-file-audio"
                       class="text-6xl cursor-pointer h-[45%]"
                       v-else-if="isAudioByMimeType(props.mimeType)"/>
    <font-awesome-icon icon="fa-regular fa-file-video"
                       class="text-6xl cursor-pointer h-[45%]"
                       v-else-if="isVideoByMimeType(props.mimeType)"/>
    <font-awesome-icon icon="fa-regular fa-file-pdf"
                       class="text-6xl cursor-pointer h-[45%]"
                       v-else-if="props.mimeType === 'application/pdf'"/>
    <font-awesome-icon icon="fa-regular fa-file-lines"
                       class="text-6xl cursor-pointer h-[45%]"
                       v-else-if="props.mimeType === 'text/plain'"/>
    <font-awesome-icon icon="fa-regular fa-file-zipper"
                       class="text-6xl cursor-pointer h-[45%]"
                       v-else-if="props.mimeType === 'application/zip'"/>
    <font-awesome-icon icon="fa-regular fa-file"
                       class="text-6xl cursor-pointer h-[45%]"
                       v-else/>
</template>
