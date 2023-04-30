<template>
    <div class="flex items-center">
        <!-- Dropdown -->
        <div class="relative">
            <Dropdown align="right">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            type="button"
                            class="flex items-center gap-1 rounded-md border border-transparent bg-white py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                        >
                            <span class="-mb-0.5 hidden text-blue-900 md:block">
                                <b>সেশন {{ selectedAcademicSession }}</b>
                            </span>

                            <svg
                                class="h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <button
                        v-for="academic_session in $page.props
                            .academic_sessions"
                        :key="academic_session.id"
                        type="button"
                        @click="setSession(academic_session.value)"
                        class="w-full rounded-md py-2 text-center hover:bg-gray-200"
                        :class="{
                            'text-blue-900': session === academic_session.value,
                        }"
                    >
                        <b>সেশন {{ academic_session.bengali }}</b>
                    </button>
                </template>
            </Dropdown>
        </div>
    </div>
</template>

<script>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
export default {
    components: {
        Dropdown,
        DropdownLink,
    },
    created() {
        this.getSession(
            this.currentAcademicSession.value ||
                this.$page.props.current_academic_session.value
        );
    },
    props: {
        currentAcademicSession: {
            type: Object,
            default: {},
        },
        previousAcademicSession: {
            type: Object,
            default: {},
        },
    },
    computed: {
        selectedAcademicSession() {
            let selectedSession = this.$page.props.academic_sessions.find(
                (academic_session) => academic_session.value === this.session
            );

            return selectedSession ? selectedSession.bengali : "";
        },
    },
    data() {
        return {
            session: "",
        };
    },
    methods: {
        setSession(session) {
            // localStorage.setItem("session", session);

            this.setCookie('academic_session', session);

            this.session = session;

            return (window.location.href = this.replaceUrlParam(
                window.location.href,
                "session",
                session
            ));
        },
        setCookie(cname, cvalue, exdays = 1) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        getSession(defaultSession = null) {
            let session = ""; // localStorage.getItem("session");

            if (!session) {
                // localStorage.setItem("session", defaultSession);

                return (this.session = defaultSession);
            }

            return (this.session = session);
        },
        replaceUrlParam(url, paramName, paramValue) {
            if (paramValue == null) {
                paramValue = "";
            }
            var pattern = new RegExp("\\b(" + paramName + "=).*?(&|#|$)");
            if (url.search(pattern) >= 0) {
                return url.replace(pattern, "$1" + paramValue + "$2");
            }
            url = url.replace(/[?#]$/, "");
            return (
                url +
                (url.indexOf("?") > 0 ? "&" : "?") +
                paramName +
                "=" +
                paramValue
            );
        },
    },
};
</script>
