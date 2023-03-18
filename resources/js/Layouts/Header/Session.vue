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
                            <span class="-mb-0.5 hidden md:block">
                                {{ sessions[session] }}
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
                        v-for="(session_text, session_value) in sessions"
                        :key="session_value"
                        type="button"
                        @click="setSession(session_value)"
                        class="m w-full bg-gray-200 py-2 text-center"
                    >
                        {{ session_text }}
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
        this.getSession();
    },
    data() {
        return {
            session: "",
            sessions: {
                "44-45": "সেশন ১৪৪৪-৪৫",
                "43-44": "সেশন ১৪৪৩-৪৪",
            },
        };
    },
    methods: {
        setSession(session) {
            localStorage.setItem("session", session);

            this.session = session;

            window.location.reload();

            let url = window.location.href;

            url += `${url.indexOf("?") > -1 ? "&" : "?"}session=${session}`;

            window.location.href = url;
        },
        getSession() {
            let session = localStorage.getItem("session");

            if (!session) {
                localStorage.setItem("session", "44-45");

                return (this.session = "44-45");
            }

            return (this.session = session);
        },
    },
};
</script>
