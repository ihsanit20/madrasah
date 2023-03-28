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

        <nav-link
            :href="route('students.class.index')"
            :active="route().current('students.*')"
            class="flex items-center gap-2 md:gap-4"
        >
            <ClassSvg class="h-5 w-5 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                শিক্ষার্থী তালিকা
            </span>
        </nav-link>

        <dropdown-nav-link
            :active="
                route().current(
                    '(question-papers|admit-card|seat-plan|results).*'
                )
            "
        >
            <ExamSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                পরীক্ষা সংক্রান্ত
            </span>
            <template #items>
                <nav-link
                    :href="route('question-papers.exams')"
                    :active="route().current('question-papers.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ExamSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        প্রশ্নপত্র
                    </span>
                </nav-link>
                <nav-link
                    :href="route('admit-card.index')"
                    :active="route().current('admit-card.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ExamSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        প্রবেশপত্র
                    </span>
                </nav-link>
                <nav-link
                    :href="route('seat-plan.index')"
                    :active="route().current('seat-plan.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ExamSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        আসন নং
                    </span>
                </nav-link>
                <nav-link
                    :href="route('results.exams')"
                    :active="route().current('results.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ExamSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ফলাফল
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link
            :active="route().current('(admissions).*')"
            :newBadge="true"
        >
            <AdmissionSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ভর্তির আবেদন
            </span>
            <template #items>
                <nav-link
                    :href="route('admissions.admission')"
                    :active="route().current('admissions.admission')"
                    class="flex items-center gap-2 md:gap-4"
                    :newBadge="true"
                >
                    <AdmissionSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন আবেদন
                    </span>
                </nav-link>
                <nav-link
                    :href="route('admissions.index')"
                    :active="route().current('admissions.(index|show|edit)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdmissionSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        আবেদন তালিকা
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('(payments|others).*')">
            <MoneyReceiptSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                টাকা জমার রশিদ
            </span>
            <template #items>
                <nav-link
                    :href="route('payments.create')"
                    :active="route().current('payments.create')"
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
                <nav-link
                    :href="route('payments.index')"
                    :active="route().current('payments.(index|show)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        রশিদ তালিকা
                    </span>
                </nav-link>
                <nav-link
                    :href="route('payments.purpose.index')"
                    :active="route().current('payments.purpose.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        বাবদ সমুহ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('others.purpose.index')"
                    :active="route().current('others.purpose.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        অন্যান্য বাবদ
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <dropdown-nav-link :active="route().current('expenses.*')">
            <PaymentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                ব্যয়/খরচ
            </span>

            <template #items>
                <nav-link
                    :href="route('expenses.create')"
                    :active="route().current('expenses.create')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন ভাউচার
                    </span>
                </nav-link>
                <nav-link
                    :href="route('expenses.index')"
                    :active="route().current('expenses.(index|show|edit)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ভাউচার তালিকা
                    </span>
                </nav-link>
                <nav-link
                    v-if="false"
                    :href="route('expenses.summary')"
                    :active="route().current('expenses.summary')"
                    class="flex items-center gap-2 md:gap-4"
                    :newBadge="true"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ব্যয় সামারি
                    </span>
                </nav-link>
                <nav-link
                    v-if="false"
                    :href="route('expenses.categories.index')"
                    :active="route().current('expenses.categories.*')"
                    class="flex items-center gap-2 md:gap-4"
                    :newBadge="true"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        খাত অনুযায়ী
                    </span>
                </nav-link>
                <nav-link
                    v-if="false"
                    :href="route('expenses.months.index')"
                    :active="route().current('expenses.months.*')"
                    class="flex items-center gap-2 md:gap-4"
                    :newBadge="true"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        মাস অনুযায়ী
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>
        <dropdown-nav-link
            :active="route().current('incomes.*')"
            :newBadge="true"
        >
            <PaymentSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                আয়ের রশিদ
            </span>

            <template #items>
                <nav-link
                    :href="route('incomes.create')"
                    :active="route().current('incomes.create')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        নতুন রশিদ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('incomes.index')"
                    :active="route().current('incomes.(index|show|edit)')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        রশিদ তালিকা
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>
        <dropdown-nav-link
            :active="route().current('(staff).*|staff-attendance-page')"
        >
            <AdminSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                শিক্ষক/স্টাফ
            </span>
            <template #items>
                <nav-link
                    :href="route('staff.index')"
                    :active="route().current('staff.index')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        শিক্ষক/স্টাফ তালিকা
                    </span>
                </nav-link>
                <nav-link
                    :href="route('staff-attendance-page')"
                    :active="route().current('staff-attendance-page')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <AdminSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        শিক্ষক/স্টাফ হাজিরা
                    </span>
                </nav-link>
            </template>
        </dropdown-nav-link>

        <nav-link
            :href="route('summary')"
            :active="route().current('summary')"
            class="flex items-center gap-2 md:gap-4"
        >
            <ScaleIcon class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                আয়-ব্যয় সামারি
            </span>
        </nav-link>

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

        <dropdown-nav-link
            :active="
                route().current(
                    '(classes|fees|designations|categories|admins|settings|purposes|exams).*|staff-list'
                )
            "
            :newBadge="true"
        >
            <SettingsSvg class="h-6 w-6 md:h-8 md:w-8" />
            <span class="-mb-1" :class="{ 'hidden md:block': !navigation }">
                সেটিংস
            </span>
            <template #items>
                <nav-link
                    :href="route('exams.index')"
                    :active="route().current('exams.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <ExamSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        পরীক্ষা তালিকা
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
                    :href="route('purposes.index')"
                    :active="route().current('purposes.*')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <MoneyReceiptSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        অন্যান্য বাবদ
                    </span>
                </nav-link>
                <nav-link
                    :href="route('staff-list')"
                    :active="route().current('staff-list')"
                    class="flex items-center gap-2 md:gap-4"
                >
                    <TeacherSvg class="h-4 w-4 md:h-6 md:w-6" />
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
                <nav-link
                    :href="route('categories.index', [{ type: 1 }])"
                    :active="
                        route().current('categories.*') &&
                        parseInt($page.props.request.type) === 1
                    "
                    class="flex items-center gap-2 md:gap-4"
                    :newBadge="true"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        আয়ের খাত
                    </span>
                </nav-link>
                <nav-link
                    :href="route('categories.index', [{ type: 2 }])"
                    :active="
                        route().current('categories.*') &&
                        parseInt($page.props.request.type) === 2
                    "
                    class="flex items-center gap-2 md:gap-4"
                >
                    <PaymentSvg class="h-4 w-4 md:h-6 md:w-6" />
                    <span
                        class="-mb-1"
                        :class="{ 'hidden md:block': !navigation }"
                    >
                        ব্যয়ের খাত
                    </span>
                </nav-link>
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
                        এ্যাডমিন সেটিং
                    </span>
                </nav-link>
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
            </template>
        </dropdown-nav-link>
    </div>
</template>

<script>
import DropdownNavLink from "@/Components/DropdownNavLink.vue";
import NavLink from "@/Components/NavLink.vue";
import {
    ClipboardListIcon,
    CogIcon,
    HomeIcon,
    IdentificationIcon,
    LibraryIcon,
    MenuIcon,
    ScaleIcon,
} from "@heroicons/vue/outline";
import { Link } from "@inertiajs/inertia-vue3";
import {
    AdminSvg,
    AdmissionSvg,
    ClassSvg,
    ExamSvg,
    MoneyReceiptSvg,
    NoticeSvg,
    PaymentSvg,
    SettingsSvg,
    StudentSvg,
    TeacherSvg,
} from "./SvgIcon";
export default {
    components: {
        Link,
        NavLink,
        ClassSvg,
        StudentSvg,
        AdmissionSvg,
        MoneyReceiptSvg,
        PaymentSvg,
        TeacherSvg,
        AdminSvg,
        NoticeSvg,
        SettingsSvg,
        ExamSvg,
        DropdownNavLink,
        MenuIcon,
        HomeIcon,
        IdentificationIcon,
        LibraryIcon,
        ClipboardListIcon,
        CogIcon,
        ScaleIcon,
    },
    props: {
        navigation: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
