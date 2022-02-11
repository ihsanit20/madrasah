<template>
    <Head title="Classes" />

    <app-layout pageTitle="View Class">
        <div class="max-w-2xl rounded border bg-white p-3 shadow md:p-4">
            <div class="flex items-end justify-between">
                <h2 class="flex-shrink text-lg font-bold text-sky-600">
                    {{ data.classes.name }}
                </h2>
                <p
                    class="flex-shrink-0 rounded border px-1 font-semibold text-gray-500"
                >
                    ID: {{ data.classes.id }}
                </p>
            </div>
            <hr class="my-1" />
            <p class="text-xs text-gray-400 md:text-base">
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Reprehenderit id corrupti suscipit aperiam ea deserunt
                perferendis, natus cum maiores, distinctio aliquam est facilis
                pariatur esse officiis aut porro? Excepturi, fugiat.
            </p>
            <div class="py-4">
                <h3 class="bg-gray-200 py-1 px-3 text-gray-700">
                    Subjects &amp; Subject Code
                </h3>
                <div class="grid gap-2 py-2 md:grid-cols-2">
                    <div
                        v-for="(subject, index) in data.classes.subjects"
                        :key="index"
                        class="flex flex-col items-center justify-center rounded p-4 shadow"
                    >
                        <h5 class="text-xs text-gray-500 md:text-sm">
                            {{ subject.name }}
                        </h5>
                        <p class="text-lg font-bold text-gray-700">
                            {{ subject.code }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table-auto rounded border bg-white shadow">
                <show-table-row heading="ID">
                    {{ data.classes.id }}
                </show-table-row>
                <show-table-row heading="Name">
                    {{ data.classes.name }}
                </show-table-row>
                <show-table-row heading="Subjects">
                    <div
                        v-for="(subject, index) in data.classes.subjects"
                        :key="index"
                    >
                        {{ index + 1 }}. {{ subject.name }}
                    </div>
                </show-table-row>
                <show-table-row heading="Action">
                    <div class="flex items-center justify-start gap-1 md:gap-2">
                        <action-button-edit
                            :href="route('classes.edit', data.classes.id)"
                        />
                    </div>
                </show-table-row>
            </table>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ShowTableRow from "@/Components/ShowTableRow.vue";
import ActionButtonEdit from "@/Components/ActionButtonEdit.vue";

export default {
    components: {
        AppLayout,
        Head,
        ShowTableRow,
        ActionButtonEdit,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
    },
};
</script>
