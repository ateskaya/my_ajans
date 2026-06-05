<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const navLinks = [
    { label: 'Ana Sayfa', href: '/', routeName: 'home', icon: null },
    {
        label: 'Hizmetlerimiz',
        href: null,
        routeName: 'services.index',
        icon: null,
    },
    {
        label: 'Vaka Çalışmaları',
        href: null,
        routeName: 'case-studies.index',
        icon: null,
    },
    { label: 'İçgörüler', href: null, routeName: 'blog.index', icon: null },
    { label: 'Labs', href: null, routeName: 'labs.index', icon: 'labs' },
    { label: 'İletişim', href: null, routeName: 'contact.index', icon: null },
];

const linkHref = (link) => {
    if (link.routeName === 'home') {
        return '/';
    }

    if (link.routeName) {
        return route(link.routeName);
    }

    return link.href;
};

const isActive = (link) => {
    if (link.routeName === 'home') {
        return route().current('/');
    }

    return link.routeName ? route().current(link.routeName) : false;
};
</script>

<template>
    <header
        class="sticky top-0 z-50 border-b border-slate-800 bg-slate-950/80 backdrop-blur-md"
    >
        <nav
            class="mx-auto grid max-w-7xl grid-cols-[auto_1fr_auto] items-center gap-4 px-4 py-4 sm:px-6 lg:px-8"
        >
            <Link href="/" class="flex items-center gap-2">
                <ApplicationLogo
                    class="h-8 w-auto fill-current text-white"
                />
                <span class="hidden text-sm font-semibold tracking-wide text-white sm:inline">
                    Ajans
                </span>
            </Link>

            <ul
                class="hidden items-center justify-center gap-6 lg:gap-8 md:flex"
            >
                <li v-for="link in navLinks" :key="link.label">
                    <Link
                        :href="linkHref(link)"
                        class="inline-flex items-center gap-1.5 text-sm font-medium transition-colors duration-200"
                        :class="
                            isActive(link)
                                ? 'text-blue-400'
                                : link.icon === 'labs'
                                  ? 'text-blue-400 hover:text-blue-300'
                                  : 'text-slate-300 hover:text-blue-400'
                        "
                    >
                        <svg
                            v-if="link.icon === 'labs'"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-4 w-4"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                            />
                        </svg>
                        {{ link.label }}
                    </Link>
                </li>
            </ul>

            <div class="flex items-center justify-end">
                <Link
                    :href="route('wizard.index')"
                    class="inline-flex shrink-0 items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors duration-200 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-950"
                >
                    Projemi Başlat
                </Link>
            </div>
        </nav>
    </header>
</template>
