<script setup>
defineProps({
    study: {
        type: Object,
        required: true,
    },
    metricLabels: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div>
        <p class="text-xs font-semibold uppercase tracking-widest text-cyan-500/80">
            Vaka Çalışması
        </p>
        <h3 class="mt-2 text-xl font-bold text-white sm:text-2xl">
            {{ study.title }}
        </h3>
        <p class="mt-1 text-sm font-medium text-blue-400">
            {{ study.client_name }}
        </p>

        <div class="mt-6 space-y-4">
            <div>
                <h4
                    class="mb-1 text-xs font-semibold uppercase tracking-widest text-slate-500"
                >
                    Problem
                </h4>
                <p class="line-clamp-3 text-sm leading-relaxed text-slate-400">
                    {{ study.problem }}
                </p>
            </div>
            <div>
                <h4
                    class="mb-1 text-xs font-semibold uppercase tracking-widest text-slate-500"
                >
                    Çözüm
                </h4>
                <p class="line-clamp-3 text-sm leading-relaxed text-slate-400">
                    {{ study.solution }}
                </p>
            </div>
            <div
                v-if="
                    study.impact_metrics &&
                    Object.keys(study.impact_metrics).length
                "
                class="grid grid-cols-2 gap-3"
            >
                <div
                    v-for="(value, key) in study.impact_metrics"
                    :key="key"
                    class="rounded-lg border border-slate-800/80 bg-slate-900/60 p-3"
                >
                    <p class="text-xs text-slate-500">
                        {{ metricLabels[key] ?? key }}
                    </p>
                    <p class="mt-1 text-lg font-bold text-blue-400">
                        {{ value }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
