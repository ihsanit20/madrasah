<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto border print:border-black">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden">
                    <table
                        class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700 print:divide-black"
                    >
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr>
                                <th
                                    v-if="serialColumn"
                                    class="py-3 px-6 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                                >
                                    SL
                                </th>
                                <th
                                    v-for="(column, index) in columns"
                                    :key="index"
                                    class="py-3 px-6 text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-400 print:text-black md:text-sm"
                                    :class="{
                                        'text-left': column.align == 'left',
                                        'text-center': column.align == 'center',
                                        'text-right': column.align == 'right',
                                    }"
                                >
                                    <div
                                        v-html="column.title"
                                        :class="column.rotate || ''"
                                    ></div>
                                </th>
                                <slot name="header" />
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800 print:divide-black"
                        >
                            <tr
                                v-for="(item, index) in collections"
                                :key="index"
                                class="hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <td
                                    v-if="serialColumn"
                                    class="whitespace-nowrap py-4 px-6 text-xs font-medium text-gray-900 dark:text-white print:text-black md:text-sm"
                                >
                                    {{ index + 1 }}
                                </td>

                                <slot
                                    :item="item"
                                    :index="index"
                                    v-if="
                                        !(
                                            filterRowName &&
                                            item[filterRowName] !=
                                                filterRowValue
                                        )
                                    "
                                />
                            </tr>
                            <tr v-if="totalRow" class="print:text-black">
                                <slot name="totalRow" />
                            </tr>
                            <tr
                                v-if="!Object.keys(collections).length"
                                class="hover:bg-gray-100 dark:hover:bg-gray-700 print:text-black"
                            >
                                <td
                                    colspan="100"
                                    class="py-3 px-2 text-center text-red-500 print:text-black"
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
</template>

<script>
import Label from "./Label.vue";
import PaginatorLinks from "./PaginatorLinks.vue";
export default {
    components: {
        PaginatorLinks,
        Label,
    },
    props: {
        serialColumn: {
            type: Boolean,
            default: false,
        },
        totalRow: {
            type: Boolean,
            default: false,
        },
        collections: {
            type: Object,
            default: {},
        },
        columns: {
            type: Array,
            default: [],
        },
        filterRowName: {
            type: String,
            default: "",
        },
        filterRowValue: "",
    },
};
</script>
