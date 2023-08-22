<template>
    <div class="bg-gray-300 py-4 text-sm md:text-base">
        <p class="text-center">
            © {{ year }} {{ route('home').replace('http://', '').replace('https://', '') }} | Developed by <a href="https://www.muaawanah.com">Muaawanah</a>
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
