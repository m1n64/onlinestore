<script setup>
defineProps({
    buttonClick: {
        type: Function,
        default: ()=>{}
    },
    additonal: null
})

</script>
<template>
    <font-awesome-icon icon="fa-regular fa-circle-xmark"
                       class="cursor-pointer hover:text-red-600"
                       @click="buttonClick(additonal)"
    />
</template>
