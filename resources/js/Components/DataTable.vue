<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden">
                    <table
                        class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700"
                    >
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr>
                                <th
                                    v-if="serialColumn"
                                    class="py-3 px-6 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 md:text-sm"
                                >
                                    SL
                                </th>
                                <th
                                    v-for="(column, index) in columns"
                                    :key="index"
                                    class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 md:text-sm"
                                    :class="{
                                        'text-left': column.align == 'left',
                                        'text-center': column.align == 'center',
                                        'text-right': column.align == 'right',
                                    }"
                                >
                                    {{ column.title }}
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
                        >
                            <tr
                                v-for="(item, index) in collections.data"
                                :key="index"
                                class="hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <td
                                    v-if="serialColumn"
                                    class="whitespace-nowrap py-4 px-6 text-xs font-medium text-gray-900 dark:text-white md:text-sm"
                                >
                                    {{
                                        collections.meta.total +
                                        1 -
                                        (collections.meta.from + index)
                                    }}
                                </td>

                                <slot :item="item" />
                            </tr>
                            <tr
                                v-if="!collections.meta.total"
                                class="hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <td
                                    colspan="100"
                                    class="py-3 px-2 text-center text-red-500"
                                >
                                    No data found !!
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div v-if="collections.meta.total && bottomLinks" class="w-full p-1">
        <paginator-links :collections="collections" />
    </div>
</template>

<script>
import Label from "./Label.vue";
import PaginatorLinks from "./PaginatorLinks.vue";
import { usePage } from "@inertiajs/inertia-vue3";
export default {
    components: {
        PaginatorLinks,
        Label,
    },
    computed: {
        request() {
            return usePage().props.value.request;
        },
    },
    props: {
        serialColumn: {
            type: Boolean,
            default: false,
        },
        bottomLinks: {
            type: Boolean,
            default: true,
        },
        collections: {
            type: Object,
            default: {},
        },
        filters: {
            type: Object,
            default: {},
        },
        columns: {
            type: Array,
            default: [],
        },
    },
};
</script>
