<template>
    <button
        @click="print"
        type="button"
        class="flex items-center justify-center gap-2 text-sky-600 border border-sky-600 rounded px-4 py-0.5"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5"
            viewBox="0 0 20.346 18.311"
        >
            <path
                d="M20.294,9.586H6.052A3.048,3.048,0,0,0,3,12.638v6.1H7.069v4.069H19.277V18.742h4.069v-6.1A3.048,3.048,0,0,0,20.294,9.586Zm-3.052,11.19H9.1V15.69h8.138Zm3.052-7.121a1.017,1.017,0,1,1,1.017-1.017A1.02,1.02,0,0,1,20.294,13.656ZM19.277,4.5H7.069V8.569H19.277Z"
                transform="translate(-3 -4.5)"
                fill="currentColor"
            />
        </svg>
        <span class="font-bold">প্রিন্ট করুন</span>
    </button>
</template>

<script>
export default {
    components: {},
    methods: {
        print() {
            window.print();
        },
    },
};
</script>
