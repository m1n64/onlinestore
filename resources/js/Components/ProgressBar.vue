<template>
    <div class="progress-container"
        :style="'--percent-value:'+value+'%' "
    >
        <progress :max="maxValue" :value="value">{{ value }}%</progress>
    </div>
</template>

<script>
export default {
    name: "ProgressBar",
    props: {
        value: Number,
        maxValue: Number|String
    }
}
</script>

<style scoped>
progress {
    opacity: 0;
}
.progress-container {
    position: relative;
    display: inline-block;
    height: 10px;
    border-radius: 6px;
    overflow: hidden;
    @apply bg-gray-200;
}
.progress-container::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: var(--percent-value);
    @apply bg-indigo-600;
}
</style>
