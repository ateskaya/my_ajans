<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    overall_status: {
        type: String,
        required: true,
    },
    uptime_percentage: {
        type: String,
        required: true,
    },
    avg_response_time: {
        type: String,
        required: true,
    },
    active_projects: {
        type: Number,
        required: true,
    },
    autonomous_bots: {
        type: Number,
        required: true,
    },
    uptime_history: {
        type: Array,
        required: true,
    },
});

const metricCards = computed(() => [
    {
        label: 'Uptime',
        value: `%${props.uptime_percentage}`,
        sub: 'Son 30 gün',
    },
    {
        label: 'Ortalama Yanıt Süresi',
        value: props.avg_response_time,
        sub: 'Global edge',
    },
    {
        label: 'Aktif Projeler',
        value: String(props.active_projects),
        sub: 'Vaka çalışmaları',
    },
    {
        label: 'Çalışan Otonom Sistemler',
        value: String(props.autonomous_bots),
        sub: 'Labs — Canlıda',
    },
]);
</script>

<template>
    <Head title="Sistem Durumu" />

    <AgencyLayout>
        <section class="border-b border-slate-800 px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <p
                    class="mb-3 text-sm font-semibold uppercase tracking-widest text-blue-400"
                >
                    Şeffaflık & Güvenilirlik
                </p>
                <h1
                    class="text-4xl font-bold tracking-tight text-white sm:text-5xl"
                >
                    Sistem Durumu
                </h1>

                <div
                    class="mt-8 flex flex-wrap items-center gap-4 rounded-xl border border-emerald-500/30 bg-emerald-950/20 px-6 py-5 shadow-[0_0_40px_rgba(16,185,129,0.12)]"
                >
                    <span
                        class="relative flex h-4 w-4 shrink-0"
                        aria-hidden="true"
                    >
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"
                        />
                        <span
                            class="relative inline-flex h-4 w-4 animate-pulse rounded-full bg-emerald-500 shadow-[0_0_16px_rgba(16,185,129,0.9)]"
                        />
                    </span>
                    <p class="text-2xl font-semibold text-emerald-300 sm:text-3xl">
                        {{ overall_status }}
                    </p>
                </div>
            </div>
        </section>

        <section class="px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="metric in metricCards"
                        :key="metric.label"
                        class="rounded-xl border border-slate-800 bg-slate-900 p-6 shadow-lg shadow-black/20"
                    >
                        <p
                            class="text-xs font-semibold uppercase tracking-wider text-slate-500"
                        >
                            {{ metric.label }}
                        </p>
                        <p
                            class="mt-2 text-3xl font-bold tracking-tight text-white"
                        >
                            {{ metric.value }}
                        </p>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ metric.sub }}
                        </p>
                    </div>
                </div>

                <div
                    class="mt-10 rounded-xl border border-slate-800 bg-slate-900 p-6 sm:p-8"
                >
                    <div
                        class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div>
                            <h2 class="text-lg font-semibold text-white">
                                30 Günlük Uptime Geçmişi
                            </h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Tüm servisler kesintisiz çalışıyor.
                            </p>
                        </div>
                        <p class="text-sm font-medium text-emerald-400">
                            %{{ uptime_percentage }} uptime
                        </p>
                    </div>

                    <div
                        class="mt-8 flex items-end justify-between gap-1 sm:gap-1.5"
                        role="img"
                        aria-label="Son 30 gün kesintisiz çalışma"
                    >
                        <div
                            v-for="(day, index) in uptime_history"
                            :key="index"
                            class="group relative flex flex-1 flex-col items-center"
                        >
                            <div
                                class="h-16 w-full min-w-[3px] max-w-[12px] rounded-sm bg-green-500 transition-colors group-hover:bg-emerald-300 sm:h-20"
                                :title="'Kesintisiz'"
                            />
                            <span
                                class="pointer-events-none absolute -top-9 left-1/2 z-10 hidden -translate-x-1/2 whitespace-nowrap rounded-md border border-slate-700 bg-slate-800 px-2 py-1 text-xs text-slate-200 shadow-lg group-hover:block"
                            >
                                Kesintisiz
                            </span>
                        </div>
                    </div>

                    <div
                        class="mt-4 flex justify-between text-xs text-slate-500"
                    >
                        <span>30 gün önce</span>
                        <span>Bugün</span>
                    </div>
                </div>
            </div>
        </section>
    </AgencyLayout>
</template>
