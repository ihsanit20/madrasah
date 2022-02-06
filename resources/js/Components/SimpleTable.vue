<template>
    <div class="relative overflow-auto">
        <table class="w-full min-w-max table-auto">
            <thead>
                <tr
                    class="bg-blue-600 text-sm uppercase leading-normal text-white"
                >
                    <th
                        v-if="serialColumn"
                        class="bg-blue-600 px-3 py-2 text-left"
                        :class="{ 'sticky left-0': true }"
                    >
                        SL
                    </th>

                    <th
                        v-for="(column, index) in columns"
                        :key="index"
                        class="bg-blue-600 px-3 py-2"
                        :class="{
                            'text-left': column.align == 'left',
                            'text-center': column.align == 'center',
                            'text-right': column.align == 'right',
                            'sticky left-0': column.sticky,
                        }"
                    >
                        {{ column.title }}
                    </th>

                    <slot name="head" />
                </tr>
            </thead>

            <tbody class="bg-white text-sm font-light text-gray-600">
                <tr
                    v-for="(item, index) in collections.data"
                    :key="index"
                    class="border-b border-gray-200 hover:bg-gray-50"
                >
                    <td
                        v-if="serialColumn"
                        class="bg-white px-3 py-2 text-left"
                        :class="{ 'sticky left-0': true }"
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
                    class="border-b border-gray-200 hover:bg-gray-50"
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
