<template>
    <div class="bg-white p-10">
        <letter-head />
        <h2 class="mt-4 mb-2 text-center text-2xl font-bold print:text-black">
            {{ data.exam.name }}
        </h2>
    </div>
</template>

<script>
import LetterHead from "@/Templete/LetterHead.vue";
export default {
    components: {
        LetterHead,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
