<template>
    <tr class="bg-brand-600 text-sm leading-normal">
        <th class="bg-gray-100 p-2 text-right align-top uppercase">
            {{ heading }}
        </th>
        <td class="bg-white p-2 text-left">
            <slot />
        </td>
    </tr>
</template>

<script>
import Label from "./Label.vue";

export default {
    components: {
        Label,
    },
    props: {
        heading: { type: String, default: "" },
    },
};
</script>
