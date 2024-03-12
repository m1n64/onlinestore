<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <header>
            <h2 class="text-lg font-medium text-gray-900">{{ $props.headText }}</h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ $props.headDesc }}
            </p>
        </header>
        <slot/>
    </div>
</template>

<script>
export default {
    name: "CardComponent",
    props: {
        headText: String|null,
        headDesc: String|null,
    }
}
</script>

<style scoped>

</style>
