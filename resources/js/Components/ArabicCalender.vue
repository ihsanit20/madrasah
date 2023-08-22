<template>
    <div class="flex items-center justify-center overflow-hidden">
        <div class="w-full">
            <div class="rounded-t bg-white px-2 py-3 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <button
                        aria-label="calendar backward"
                        class="text-gray-800 hover:text-gray-400 focus:text-gray-400 dark:text-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-chevron-left"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="15 6 9 12 15 18" />
                        </svg>
                    </button>

                    <div
                        class="flex items-center justify-center gap-2 text-lg font-bold text-brand-950 focus:outline-none dark:text-gray-100"
                    >
                        <span>{{ calendar.currentMonth.bn }}</span>
                        <span>{{ $e2bnumber(calendar.currentYear) }}</span>
                    </div>

                    <div class="flex items-center">
                        <button
                            aria-label="calendar forward"
                            class="text-gray-800 hover:text-gray-400 focus:text-gray-400 dark:text-gray-100"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-chevron-right"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <polyline points="9 6 15 12 9 18" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div
                    class="mt-3 flex items-center justify-between overflow-x-auto"
                >
                    <div class="w-full">
                        <div class="grid grid-cols-7">
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    শনি
                                </p>
                            </div>
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    রবি
                                </p>
                            </div>
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    সোম
                                </p>
                            </div>
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    মঙ্গল
                                </p>
                            </div>
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    বুধ
                                </p>
                            </div>
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    বৃহঃ
                                </p>
                            </div>
                            <div class="flex w-full justify-center">
                                <p
                                    class="text-center text-base font-medium text-gray-800 dark:text-gray-100"
                                >
                                    শুক্র
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-7">
                            <div
                                v-for="n in calendar.startFrom"
                                :key="n"
                                class="flex w-full cursor-pointer justify-center px-2 py-2"
                            ></div>
                            <div
                                v-for="(day, index) in calendar.days"
                                :key="index"
                                class="flex w-full cursor-pointer items-center justify-center py-2"
                            >
                                <div
                                    class="flex h-6 w-6 items-center justify-center rounded-full"
                                    :class="{
                                        'bg-brand-600 text-white':
                                            Number(day) ===
                                            Number(calendar.currentDay),
                                    }"
                                >
                                    {{ $e2bnumber(day) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        calendar: {
            type: Object,
            default: {},
        },
    },
};
</script>
