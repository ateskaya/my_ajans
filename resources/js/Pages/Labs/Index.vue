<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const statusStyles = {
    Canlıda: 'border-emerald-500/50 bg-emerald-950/60 text-emerald-300 shadow-[0_0_12px_rgba(16,185,129,0.25)]',
    'Ar-Ge': 'border-orange-500/50 bg-orange-950/60 text-orange-300 shadow-[0_0_12px_rgba(249,115,22,0.2)]',
    Beta: 'border-blue-500/60 bg-blue-950/60 text-blue-300 shadow-[0_0_16px_rgba(59,130,246,0.35)]',
};

const badgeClass = (status) =>
    statusStyles[status] ??
    'border-slate-600 bg-slate-800 text-slate-300';
</script>

<template>
    <Head title="Labs & SaaS Ürünlerimiz" />

    <AgencyLayout>
        <section class="border-b border-slate-800 px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl text-center">
                <p
                    class="mb-3 text-sm font-semibold uppercase tracking-widest text-blue-300"
                >
                    Yazılım Fabrikası
                </p>
                <h1
                    class="text-4xl font-bold tracking-tight text-white sm:text-5xl"
                >
                    Labs & SaaS Ürünlerimiz
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-300">
                    Sadece müşteri projeleri geliştirmiyor, kendi otonom
                    ekosistemlerimizi inşa ediyoruz.
                </p>
            </div>
        </section>

        <section class="px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-2"
                >
                    <article
                        v-for="project in projects"
                        :key="project.id"
                        class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-800 bg-slate-900 p-6 transition-all duration-300 hover:border-blue-500 hover:shadow-[0_8px_30px_rgba(15,23,42,0.6)]"
                    >
                        <span
                            class="absolute right-4 top-4 rounded-full border px-2.5 py-1 text-xs font-semibold uppercase tracking-wide"
                            :class="badgeClass(project.status)"
                        >
                            {{ project.status }}
                        </span>

                        <div class="pr-24">
                            <h2
                                class="text-xl font-bold text-white transition-colors group-hover:text-blue-300"
                            >
                                {{ project.title }}
                            </h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-300">
                                {{ project.short_description }}
                            </p>
                        </div>

                        <ul class="mt-6 flex flex-wrap gap-2">
                            <li
                                v-for="tech in project.tech_stack"
                                :key="tech"
                                class="rounded-md bg-slate-800 px-2.5 py-1 text-xs font-medium text-slate-300"
                            >
                                {{ tech }}
                            </li>
                        </ul>

                        <div
                            v-if="project.project_url"
                            class="mt-6 border-t border-slate-800 pt-4"
                        >
                            <a
                                :href="project.project_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm font-medium text-blue-300 transition-colors hover:text-blue-200"
                                :aria-label="`${project.title} projesini dış sitede incele`"
                            >
                                {{ project.title }} — Projeyi incele
                                <span aria-hidden="true"> →</span>
                            </a>
                        </div>
                    </article>
                </div>

                <div class="mt-12 text-center">
                    <Link
                        :href="route('contact.index')"
                        class="inline-flex items-center rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(37,99,235,0.35)] transition hover:bg-blue-500"
                    >
                        Kendi Projenizi Konuşalım
                    </Link>
                </div>
            </div>
        </section>
    </AgencyLayout>
</template>
