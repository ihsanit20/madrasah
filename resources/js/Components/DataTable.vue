<template>
    <div class="flex w-full flex-col gap-4">
        <div class="flex flex-wrap gap-4">
            <template v-if="Object.keys(filters).length">
                <div
                    class="flex w-full sm:w-auto"
                    v-for="(filter, key) in filters"
                    :key="key"
                >
                    <select
                        @change="searchHandler"
                        v-model="filterData[key]"
                        :name="key"
                        class="block w-full max-w-sm shadow-sm focus:outline-none focus:ring-0"
                    >
                        <option value="" selected>
                            {{
                                key
                                    .replaceAll("_", " ")
                                    .toLowerCase()
                                    .replace(/\b[a-z]/g, function (letter) {
                                        return letter.toUpperCase();
                                    })
                            }}
                            (All)
                        </option>
                        <option
                            v-for="(property, index) in filter"
                            :key="index"
                            :value="index"
                        >
                            {{ property }}
                        </option>
                    </select>
                </div>
            </template>
            <div
                v-if="dateFilter"
                class="order-1 ml-auto flex w-full flex-col items-end justify-between gap-2 sm:flex-row lg:order-2 lg:w-auto lg:max-w-xl"
            >
                <div
                    class="flex w-full max-w-sm items-center justify-end gap-1"
                >
                    <select
                        @change="dateSearchHandler"
                        v-model="valueDateFilter"
                        class="block w-full min-w-max cursor-pointer shadow-sm focus:outline-none focus:ring-0"
                    >
                        <option value="">Custom Date</option>
                        <option
                            v-for="(varient, index) in varientDateFilter"
                            :key="index"
                            :value="index"
                        >
                            {{ varient }}
                        </option>
                    </select>
                </div>
                <div
                    class="flex w-full max-w-sm items-center justify-end gap-1"
                >
                    <!-- <label class="w-12 text-right">From</label> -->
                    <input
                        v-show="!valueDateFilter"
                        @input="searchHandler"
                        v-model="dateFrom"
                        :max="this.dateTo"
                        type="date"
                        class="block w-full max-w-xs shadow-sm focus:outline-none focus:ring-0"
                    />
                </div>
                <div
                    class="flex w-full max-w-sm items-center justify-end gap-1"
                >
                    <!-- <label class="w-12 text-right">To</label> -->
                    <input
                        v-show="!valueDateFilter"
                        @input="searchHandler"
                        v-model="dateTo"
                        :min="this.dateFrom"
                        type="date"
                        class="block w-full max-w-xs shadow-sm focus:outline-none focus:ring-0"
                    />
                </div>
            </div>
        </div>
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
import { usePage } from "@inertiajs/vue3";
import Label from "./Label.vue";
import PaginatorLinks from "./PaginatorLinks.vue";
export default {
    components: {
        PaginatorLinks,
        Label,
    },
    computed: {
        request() {
            return (
                usePage().props?.value?.request ||
                usePage().props?.request ||
                {}
            );
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
        dateFilter: {
            type: Boolean,
            default: false,
        },
        varientDateFilter: {
            type: Object,
            default: {
                7: "Last 7 days",
                15: "Last 15 days",
                30: "Last 30 days",
                90: "Last 90 days",
                180: "Last 180 days",
                365: "Last 365 days",
            },
        },
    },
    created() {
        Object.entries(this.filters).forEach(([key, value]) => {
            this.filterData[key] = this.request[key] || "";
        });

        this.dateFrom = this.request.from || "";

        this.dateTo = this.request.to || "";

        this.search = this.request.search || "";
    },
    data() {
        return {
            perpage: this.collections.meta.per_page,
            search: "",
            filterData: {},
            data: {},
            dateFrom: "",
            dateTo: "",
            valueDateFilter: "",
        };
    },
    methods: {
        searchHandler() {
            this.data["perpage"] = this.perpage;

            Object.entries(this.filterData).forEach(([key, value]) => {
                this.data[key] = value;
            });

            this.data["from"] = this.dateFrom;

            this.data["to"] = this.dateTo;

            this.data["search"] = this.search;

            let url = this.route(
                this.routeName || this.route().current(),
                this.clean(this.data)
            );

            localStorage.setItem("historyOfList", url);

            this.$inertia.get(url, {}, { preserveState: true });
        },
        dateSearchHandler(event) {
            const days = parseInt(event.target.value);

            const dateForTo = new Date();

            const dateForFrom = new Date(
                dateForTo.getTime() - days * 24 * 60 * 60 * 1000
            );

            if (days) {
                this.dateFrom = `${dateForFrom.getFullYear()}-${(
                    dateForFrom.getMonth() + 1
                )
                    .toString()
                    .padStart(2, "0")}-${dateForFrom
                    .getDate()
                    .toString()
                    .padStart(2, "0")}`;
                this.dateTo = `${dateForTo.getFullYear()}-${(
                    dateForTo.getMonth() + 1
                )
                    .toString()
                    .padStart(2, "0")}-${dateForTo
                    .getDate()
                    .toString()
                    .padStart(2, "0")}`;
            } else {
                this.dateFrom = "";
                this.dateTo = "";
            }

            this.searchHandler();
        },
        clean(obj) {
            for (var propName in obj) {
                if (
                    obj[propName] === "" ||
                    obj[propName] === null ||
                    obj[propName] === undefined
                ) {
                    delete obj[propName];
                }
            }
            return obj;
        },
    },
};
</script>
