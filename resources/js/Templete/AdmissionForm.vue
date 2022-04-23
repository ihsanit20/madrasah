<template>
    <div class="bg-white p-10">
        <letter-head :photoFrame="true" />
        <h2 class="mt-4 mb-2 text-center text-2xl font-bold print:text-black">
            ভর্তির আবেদন ফরম
        </h2>
        <div class="flex items-center justify-center gap-4">
            <label class="flex items-center justify-center gap-2">
                <Input type="radio" class="h-3.5 w-3.5 rounded-none" />
                <span>নতুন</span>
            </label>
            <label class="flex items-center justify-center gap-2">
                <Input type="radio" class="h-3.5 w-3.5 rounded-none" />
                <span>পুরাতন</span>
            </label>
        </div>
    </div>
</template>

<script>
import LetterHead from "@/Templete/LetterHead.vue";
import Input from "@/Components/Input.vue";
export default {
    components: {
        LetterHead,
        Input,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
