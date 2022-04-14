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

        <dropdown-nav-link
            :active="route().current('settings.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <SettingsSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                Settings
            </span>
            <template #items>
                <nav-link
                    :href="route('settings.index')"
                    :active="route().current('settings.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <HomeIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        Home Page
                    </span>
                </nav-link>

                <nav-link href="/" class="flex items-center gap-2 md:gap-4">
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        Admin &amp; Role
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Components/NavLink.vue";
import { MenuIcon, HomeIcon } from "@heroicons/vue/outline";
import DropdownNavLink from "@/Components/DropdownNavLink.vue";
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
        HomeIcon,
        ClassSvg,
        StudentSvg,
        AdmissionSvg,
        MoneyReceiptSvg,
        PaymentSvg,
        TeacherSvg,
        AdminSvg,
        NoticeSvg,
        SettingsSvg,
        DropdownNavLink,
    },
    props: {
        navigation: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
