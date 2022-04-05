<template>
    <div class="space-y-2 bg-white px-2 py-2 md:px-4">
        <nav-link
            :href="route('dashboard')"
            :active="route().current('dashboard')"
            class="flex items-center gap-2 md:gap-4"
        >
            <MenuIcon class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Dashboard
            </span>
        </nav-link>

        <nav-link
            :href="route('classes.index')"
            :active="route().current('classes.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <ClassSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Classes
            </span>
        </nav-link>

        <nav-link
            :href="route('students.index')"
            :active="route().current('students.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <StudentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Students
            </span>
        </nav-link>

        <!-- <nav-link
            :href="route('admissions.index')"
            :active="route().current('admissions.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <AdmissionSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Admissions
            </span>
        </nav-link> -->

        <nav-link href="/" class="flex items-center gap-2 md:gap-4">
            <MoneyReceiptSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Mony Receipt
            </span>
        </nav-link>

        <nav-link href="/" class="flex items-center gap-2 md:gap-4">
            <PaymentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Payment/Expence
            </span>
        </nav-link>

        <nav-link href="/" class="flex items-center gap-2 md:gap-4">
            <TeacherSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Teachers &amp; Stuff
            </span>
        </nav-link>

        <nav-link href="/" class="flex items-center gap-2 md:gap-4">
            <AdminSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Admin &amp; Role
            </span>
        </nav-link>

        <nav-link href="/" class="flex items-center gap-2 md:gap-4">
            <NoticeSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Notice
            </span>
        </nav-link>

        <nav-link href="/" class="flex items-center gap-2 md:gap-4">
            <SettingsSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Settings
            </span>
        </nav-link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Components/NavLink.vue";
import { MenuIcon } from "@heroicons/vue/outline";
import {
    ClassSvg,
    StudentSvg,
    AdmissionSvg,
    MoneyReceiptSvg,
    PaymentSvg,
    TeacherSvg,
    AdminSvg,
    NoticeSvg,
    SettingsSvg,
} from "./SvgIcon";
export default {
    components: {
        Link,
        NavLink,
        MenuIcon,
        ClassSvg,
        StudentSvg,
        AdmissionSvg,
        MoneyReceiptSvg,
        PaymentSvg,
        TeacherSvg,
        AdminSvg,
        NoticeSvg,
        SettingsSvg,
    },
    props: {
        navigation: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
