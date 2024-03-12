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
    <img :src="props.link" v-if="isImageByMimeType(props.mimeType)">
    <audio
        controls
        :src="props.link"
        v-else-if="isAudioByMimeType(props.mimeType)">
    </audio>
    <video
        controls
        :src="props.link"
        v-else-if="isVideoByMimeType(props.mimeType)">
    </video>
</template>

