<template>
    <div class="space-y-2 bg-white px-2 py-2 md:px-4">
        <nav-link
            :href="route('dashboard')"
            :active="route().current('dashboard')"
            class="flex items-center gap-2 md:gap-4"
        >
            <MenuIcon class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ড্যাশবোর্ড
            </span>
        </nav-link>

        <dropdown-nav-link :active="route().current('(classes||fees).*')">
            <ClassSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ক্লাস/বিভাগ
            </span>
            <template #items>
                <nav-link
                    :href="route('fees.index')"
                    :active="route().current('fees.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ClipboardListIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        প্রদেয় ফি
                    </span>
                </nav-link>
                <nav-link
                    :href="route('classes.index')"
                    :active="route().current('classes.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ClassSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ক্লাস/বিভাগ
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('(students|admissions).*')">
            <StudentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                শিক্ষার্থী
            </span>
            <template #items>
                <nav-link
                    :href="route('students.index')"
                    :active="route().current('students.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        শিক্ষার্থী তালিকা
                    </span>
                </nav-link>
                <nav-link
                    :href="route('admissions.index')"
                    :active="route().current('admissions.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <StudentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ভর্তির আবেদন
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('(payments).*')">
            <MoneyReceiptSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                টাকা জমার রশিদ
            </span>
            <template #items>
                <nav-link
                    :href="route('payments.yearly')"
                    :active="route().current('payments.yearly')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ভর্তিকালীন রশিদ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('payments.monthly')"
                    :active="route().current('payments.monthly')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        মাসিক রশিদ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('payments.new')"
                    :active="route().current('payments.new')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন রশিদ
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link
            :active="route().current('(expenses||categories).*')"
        >
            <PaymentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ব্যয়/খরচ
            </span>

            <template #items>
                <nav-link
                    :href="route('expenses.index')"
                    :active="route().current('expenses.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ব্যয়ের তালিকা
                    </span>
                </nav-link>

                <nav-link
                    :href="route('categories.index')"
                    :active="route().current('categories.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ClipboardListIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ব্যয়ের খাত
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('(staff||designations).*')">
            <TeacherSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                শিক্ষক ও স্টাফ
            </span>

            <template #items>
                <nav-link
                    :href="route('staff.index')"
                    :active="route().current('staff.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        শিক্ষক/স্টাফ
                    </span>
                </nav-link>

                <nav-link
                    :href="route('designations.index')"
                    :active="route().current('designations.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <IdentificationIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        পদবিসমূহ
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <nav-link
            :href="route('notices.index')"
            :active="route().current('notices.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <NoticeSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                নোটিশ বোর্ড
            </span>
        </nav-link>

        <dropdown-nav-link :active="route().current('(settings||admins).*')">
            <SettingsSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                সেটিংস
            </span>
            <template #items>
                <nav-link
                    :href="route('settings.site-setup')"
                    :active="route().current('settings.site-setup')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <CogIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        সাইট সেটিং
                    </span>
                </nav-link>

                <!-- <nav-link
                    :href="route('settings.home-page')"
                    :active="route().current('settings.home-page')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <HomeIcon class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        হোমপেজ সেটিং
                    </span>
                </nav-link> -->

                <nav-link
                    :href="route('admins.index')"
                    :active="route().current('admins.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        Admin
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Components/NavLink.vue";
import {
    MenuIcon,
    HomeIcon,
    IdentificationIcon,
    LibraryIcon,
    ClipboardListIcon,
    CogIcon,
} from "@heroicons/vue/outline";
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
        IdentificationIcon,
        LibraryIcon,
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
        ClipboardListIcon,
        CogIcon,
    },
    props: {
        navigation: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
