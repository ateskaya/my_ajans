<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
</script>

<template>
    <div class="min-h-screen bg-slate-950 text-slate-300">
        <header
            class="sticky top-0 z-40 border-b border-slate-800/80 bg-slate-950/90 backdrop-blur-md"
        >
            <div
                class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8"
            >
                <Link
                    :href="route('client.dashboard')"
                    class="flex items-center gap-3"
                >
                    <ApplicationLogo
                        class="h-8 w-auto fill-current text-white"
                    />
                    <span class="hidden text-sm font-semibold text-white sm:inline">
                        Ensar SaaS Factory
                    </span>
                </Link>

                <nav class="flex items-center gap-4 sm:gap-6">
                    <Link
                        :href="route('client.dashboard')"
                        class="text-sm font-medium transition-colors"
                        :class="
                            route().current('client.dashboard')
                                ? 'text-blue-400'
                                : 'text-slate-400 hover:text-white'
                        "
                    >
                        Projelerim
                    </Link>
                    <Link
                        :href="route('wizard.index')"
                        class="text-sm font-medium transition-colors"
                        :class="
                            route().current('wizard.index')
                                ? 'text-blue-400'
                                : 'text-slate-400 hover:text-white'
                        "
                    >
                        Yeni Proje Talebi
                    </Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="rounded-lg border border-slate-700 px-3 py-1.5 text-sm text-slate-400 transition hover:border-slate-500 hover:text-white"
                    >
                        Çıkış Yap
                    </Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            <slot />
        </main>

        <footer class="border-t border-slate-800/60 py-6 text-center text-xs text-slate-600">
            <p v-if="user">{{ user.email }} · Müşteri Portalı</p>
        </footer>
    </div>
</template>
