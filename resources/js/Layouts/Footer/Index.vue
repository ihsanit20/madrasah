<template>
    <div class="bg-gray-300 py-4 text-sm md:text-base">
        <p class="text-center">
            ©{{ year }} mszannat.com | Developed by Everbd Team
        </p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            year: new Date().getFullYear(),
        };
    },
};
</script>
