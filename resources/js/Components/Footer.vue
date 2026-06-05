<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const footerLinks = [
    { label: 'Ana Sayfa', routeName: null, href: '/' },
    { label: 'Hizmetlerimiz', routeName: 'services.index', href: null },
    { label: 'Vaka Çalışmaları', routeName: 'case-studies.index', href: null },
    { label: 'İçgörüler', routeName: 'blog.index', href: null },
    { label: 'Labs', routeName: 'labs.index', href: null },
    { label: 'İletişim', routeName: 'contact.index', href: null },
];

const linkHref = (link) =>
    link.routeName ? route(link.routeName) : link.href;
</script>

<template>
    <footer class="border-t border-slate-800 bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div
                class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4"
            >
                <div class="space-y-4">
                    <Link href="/" class="inline-flex items-center gap-2">
                        <ApplicationLogo
                            class="h-8 w-auto fill-current text-white"
                        />
                    </Link>
                    <p class="text-sm leading-relaxed text-slate-400">
                        Kurumsal yazılım, yapay zeka ve ölçeklenebilir web
                        sistemleri ile işletmenizin dijital dönüşümünü
                        hızlandırıyoruz.
                    </p>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                        Linkler
                    </h3>
                    <ul class="space-y-2">
                        <li v-for="link in footerLinks" :key="link.label">
                            <Link
                                :href="linkHref(link)"
                                class="text-sm text-slate-400 transition-colors hover:text-blue-400"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                        Hizmetler
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <Link
                                :href="route('services.index')"
                                class="text-sm text-slate-400 transition-colors hover:text-blue-400"
                            >
                                Tüm hizmetlerimiz
                            </Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                        İletişim
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li>
                            <a
                                href="mailto:hello@ajans.com"
                                class="transition-colors hover:text-blue-400"
                            >
                                hello@ajans.com
                            </a>
                        </li>
                        <li>
                            <a
                                href="tel:+902121234567"
                                class="transition-colors hover:text-blue-400"
                            >
                                +90 (212) 123 45 67
                            </a>
                        </li>
                        <li>İstanbul, Türkiye</li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-slate-800 pt-8 sm:flex-row"
            >
                <p class="text-xs text-slate-500">
                    &copy; {{ new Date().getFullYear() }} Yazılım Ajansı. Tüm
                    hakları saklıdır.
                </p>
                <Link
                    :href="route('status.index')"
                    class="inline-flex items-center gap-2 text-xs text-slate-400 transition-colors hover:text-white"
                >
                    <span
                        class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.8)]"
                        aria-hidden="true"
                    />
                    Sistemler Operasyonel
                </Link>
            </div>
        </div>
    </footer>
</template>
