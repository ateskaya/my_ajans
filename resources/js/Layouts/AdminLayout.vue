<script setup>
import AdminFlashAlert from '@/Components/AdminFlashAlert.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);

const navItems = [
    {
        label: 'Dashboard',
        href: 'admin.dashboard',
        match: ['admin.dashboard', 'admin.dashboard.alt'],
        icon: 'dashboard',
    },
    {
        label: 'Talepler (Leads)',
        href: 'admin.leads.index',
        match: ['admin.leads.index'],
        icon: 'leads',
    },
    {
        label: 'Hizmetler',
        href: 'admin.services.index',
        match: ['admin.services.index', 'admin.services.create', 'admin.services.edit'],
        icon: 'services',
    },
    {
        label: 'Başarı Hikayeleri',
        href: 'admin.case-studies.index',
        match: [
            'admin.case-studies.index',
            'admin.case-studies.create',
            'admin.case-studies.edit',
        ],
        icon: 'case-studies',
    },
    {
        label: 'Müşteriler',
        href: 'admin.clients.index',
        match: ['admin.clients.index', 'admin.clients.create'],
        icon: 'clients',
    },
    {
        label: 'Müşteri Projeleri',
        href: 'admin.client-projects.index',
        match: [
            'admin.client-projects.index',
            'admin.client-projects.create',
            'admin.client-projects.edit',
            'admin.client-projects.show',
        ],
        icon: 'client-projects',
    },
];

const isActive = (item) => item.match.some((name) => route().current(name));
</script>

<template>
    <div class="flex min-h-screen bg-gray-50">
        <aside
            class="sticky top-0 flex h-screen w-64 shrink-0 flex-col border-r border-slate-800 bg-slate-900"
        >
            <div class="flex h-16 items-center border-b border-slate-800 px-6">
                <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
                    <ApplicationLogo
                        class="h-8 w-auto fill-current text-white"
                    />
                    <span class="text-sm font-semibold text-white">Admin</span>
                </Link>
            </div>

            <nav class="flex-1 space-y-1 px-3 py-4">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="route(item.href)"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                    :class="
                        isActive(item)
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-400 hover:bg-slate-800/60 hover:text-white'
                    "
                >
                    <svg
                        v-if="item.icon === 'dashboard'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"
                        />
                    </svg>
                    <svg
                        v-else-if="item.icon === 'leads'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.21a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                        />
                    </svg>
                    <svg
                        v-else-if="item.icon === 'services'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-2.791 2.752L3.75 21"
                        />
                    </svg>
                    <svg
                        v-else-if="item.icon === 'clients'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 2.25 12a6.062 6.062 0 0 1 1.977-4.977M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 2.25a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"
                        />
                    </svg>
                    <svg
                        v-else-if="item.icon === 'client-projects'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-2.12 0l-2.12 2.12M21.75 12v6.75A2.25 2.25 0 0 1 19.5 21.75h-15A2.25 2.25 0 0 1 2.25 19.5V12"
                        />
                    </svg>
                    <svg
                        v-else-if="item.icon === 'case-studies'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-5 w-5 shrink-0"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0 1 16.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.003 6.003 0 0 1-3.77 1.732m0 0a6.003 6.003 0 0 1-3.77-1.732"
                        />
                    </svg>
                    {{ item.label }}
                </Link>
            </nav>

            <div class="space-y-3 border-t border-slate-800 p-4">
                <p
                    v-if="user"
                    class="truncate text-xs text-slate-500"
                    :title="user.email"
                >
                    {{ user.name }}
                </p>
                <Link
                    :href="route('home')"
                    class="block text-xs text-slate-500 transition-colors hover:text-slate-300"
                >
                    ← Ana Site
                </Link>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex w-full items-center justify-center rounded-lg border border-slate-700 px-3 py-2 text-sm font-medium text-slate-300 transition hover:border-red-500/50 hover:bg-red-950/30 hover:text-red-300"
                >
                    Çıkış Yap
                </Link>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header
                class="sticky top-0 z-10 shrink-0 border-b border-gray-200 bg-white/90 backdrop-blur-sm"
            >
                <div
                    class="flex h-16 min-h-16 w-full items-center justify-between gap-4 px-6 lg:px-8"
                >
                    <div class="min-w-0 flex-1">
                        <slot name="header" />
                    </div>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="shrink-0 rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:text-red-600"
                    >
                        Çıkış Yap
                    </Link>
                </div>
            </header>

            <main class="min-w-0 flex-1 p-6 lg:p-8">
                <AdminFlashAlert />
                <slot />
            </main>
        </div>
    </div>
</template>
