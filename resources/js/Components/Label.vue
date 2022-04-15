<template>
    <label class="block font-bold text-sm md:text-base text-gray-500">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<script>
export default {
    props: ['value']
}
</script>
