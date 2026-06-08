<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, onUnmounted, ref } from 'vue';

const url = ref('');
const phone = ref('');
const phase = ref('idle'); // idle | loading | result | error
const loadingMessage = ref('');
const errorMessage = ref('');
const report = ref(null);

const loadingSteps = [
    'Hedef siteye bağlanılıyor...',
    'İçerik çekiliyor...',
    'Gemini AI analizi yapıyor...',
];

let loadingInterval = null;

const scoreColor = computed(() => {
    if (!report.value) {
        return '#3b82f6';
    }
    const s = report.value.score;
    if (s >= 80) {
        return '#22c55e';
    }
    if (s >= 60) {
        return '#3b82f6';
    }
    if (s >= 40) {
        return '#f59e0b';
    }
    return '#ef4444';
});

const scoreRingStyle = computed(() => {
    if (!report.value) {
        return {};
    }
    const pct = report.value.score;
    const color = scoreColor.value;

    return {
        background: `conic-gradient(${color} ${pct * 3.6}deg, rgb(30 41 59) 0deg)`,
    };
});

const resultCards = computed(() => {
    if (!report.value) {
        return [];
    }

    return [
        {
            title: 'SEO Durumu',
            body: report.value.seo_feedback,
            accent: 'border-cyan-500/40 text-cyan-300',
        },
        {
            title: 'Teknik Altyapı',
            body: report.value.tech_feedback,
            accent: 'border-blue-500/40 text-blue-300',
        },
        {
            title: 'AI Potansiyeli',
            body: report.value.ai_potential,
            accent: 'border-violet-500/40 text-violet-300',
        },
    ];
});

const startLoadingAnimation = () => {
    let step = 0;
    loadingMessage.value = loadingSteps[0];

    loadingInterval = setInterval(() => {
        step = (step + 1) % loadingSteps.length;
        loadingMessage.value = loadingSteps[step];
    }, 2200);
};

const stopLoadingAnimation = () => {
    if (loadingInterval) {
        clearInterval(loadingInterval);
        loadingInterval = null;
    }
};

const analyze = async () => {
    errorMessage.value = '';
    const targetUrl = url.value.trim();
    const targetPhone = phone.value.trim();

    if (!targetUrl) {
        errorMessage.value = 'Lütfen bir web sitesi URL\'si girin.';
        phase.value = 'error';

        return;
    }

    const normalizedPhone = targetPhone.replace(/\s/g, '');

    if (!normalizedPhone || normalizedPhone.length < 10) {
        errorMessage.value = 'Lütfen geçerli bir telefon numarası girin.';
        phase.value = 'error';

        return;
    }

    phase.value = 'loading';
    report.value = null;
    startLoadingAnimation();

    try {
        const { data } = await window.axios.post('/analyze-site', {
            url: targetUrl,
            phone: targetPhone,
        });

        report.value = data;
        phase.value = 'result';
    } catch (error) {
        phase.value = 'error';
        errorMessage.value =
            error.response?.data?.message ??
            'Analiz sırasında bir hata oluştu. Lütfen tekrar deneyin.';
    } finally {
        stopLoadingAnimation();
    }
};

const reset = () => {
    phase.value = 'idle';
    report.value = null;
    errorMessage.value = '';
};

onUnmounted(() => {
    stopLoadingAnimation();
});
</script>

<template>
    <section
        id="site-analyzer"
        class="relative overflow-hidden px-4 py-20 sm:px-6 lg:px-8"
    >
        <div
            class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(59,130,246,0.15)_0%,_transparent_60%)]"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-5xl">
            <div
                class="overflow-hidden rounded-2xl border border-blue-500/25 bg-slate-900/60 p-6 shadow-[0_0_60px_rgba(37,99,235,0.15)] backdrop-blur-xl sm:p-10"
            >
                <div class="text-center">
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-400"
                    >
                        AI Sistem Analiz Aracı
                    </p>
                    <h2
                        class="mt-3 text-2xl font-bold text-white sm:text-3xl lg:text-4xl"
                    >
                        Sisteminizin Yapay Zeka ve Ölçeklenebilirlik Analizini
                        Ücretsiz Yapın
                    </h2>
                    <p class="mx-auto mt-4 max-w-2xl text-sm text-slate-400 sm:text-base">
                        URL'nizi girin; Gemini destekli mimarimiz SEO, teknik altyapı ve
                        AI otomasyon potansiyelinizi saniyeler içinde özetlesin.
                    </p>
                </div>

                <!-- Form -->
                <div
                    v-if="phase === 'idle' || phase === 'error'"
                    class="mt-10"
                >
                    <form
                        class="flex flex-col gap-4 lg:flex-row lg:items-end"
                        @submit.prevent="analyze"
                    >
                        <div class="flex-1">
                            <label
                                for="analyzer-url"
                                class="mb-1.5 block text-xs font-medium text-slate-400"
                            >
                                Website URL
                            </label>
                            <input
                                id="analyzer-url"
                                v-model="url"
                                type="text"
                                inputmode="url"
                                autocomplete="url"
                                placeholder="https://sirketiniz.com"
                                class="w-full rounded-lg border border-slate-700/80 bg-slate-950/80 px-4 py-3 text-white placeholder-slate-500 shadow-inner focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30"
                            />
                        </div>
                        <div class="flex-1">
                            <label
                                for="analyzer-phone"
                                class="mb-1.5 block text-xs font-medium text-slate-400"
                            >
                                Telefon Numarası
                            </label>
                            <input
                                id="analyzer-phone"
                                v-model="phone"
                                type="tel"
                                inputmode="tel"
                                autocomplete="tel"
                                placeholder="05XX XXX XX XX"
                                class="w-full rounded-lg border border-slate-700/80 bg-slate-950/80 px-4 py-3 text-white placeholder-slate-500 shadow-inner focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30"
                            />
                        </div>
                        <button
                            type="submit"
                            class="inline-flex shrink-0 items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 px-8 py-3 text-sm font-semibold text-white shadow-[0_0_28px_rgba(59,130,246,0.45)] transition hover:from-blue-500 hover:to-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-slate-900 lg:mb-0"
                        >
                            Sistemi Tara
                        </button>
                    </form>

                    <p
                        v-if="phase === 'error' && errorMessage"
                        class="mt-4 text-center text-sm text-red-400"
                        role="alert"
                    >
                        {{ errorMessage }}
                    </p>
                </div>

                <!-- Loading -->
                <div
                    v-else-if="phase === 'loading'"
                    class="mt-12 flex flex-col items-center py-8"
                >
                    <div
                        class="relative flex h-32 w-32 items-center justify-center"
                        aria-hidden="true"
                    >
                        <span
                            class="absolute inset-0 animate-ping rounded-full border border-cyan-500/40"
                        />
                        <span
                            class="absolute inset-2 animate-pulse rounded-full border-2 border-blue-500/60"
                        />
                        <span
                            class="absolute inset-4 rounded-full border border-cyan-400/30"
                            style="animation: spin 3s linear infinite"
                        />
                        <span
                            class="relative h-3 w-3 rounded-full bg-cyan-400 shadow-[0_0_20px_rgba(34,211,238,0.9)]"
                        />
                    </div>
                    <p
                        class="mt-8 animate-pulse text-center text-sm font-medium text-cyan-300 sm:text-base"
                    >
                        {{ loadingMessage }}
                    </p>
                </div>

                <!-- Result -->
                <div
                    v-else-if="phase === 'result' && report"
                    class="mt-10"
                >
                    <div class="flex flex-col items-center">
                        <div
                            class="relative flex h-40 w-40 items-center justify-center rounded-full p-2"
                            :style="scoreRingStyle"
                        >
                            <div
                                class="flex h-full w-full flex-col items-center justify-center rounded-full bg-slate-950"
                            >
                                <span class="text-4xl font-bold text-white">
                                    %{{ report.score }}
                                </span>
                                <span class="mt-1 text-xs text-slate-400">
                                    Dijital Skor
                                </span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-3"
                    >
                        <article
                            v-for="card in resultCards"
                            :key="card.title"
                            class="rounded-xl border bg-slate-950/50 p-5"
                            :class="card.accent"
                        >
                            <h3 class="text-sm font-semibold uppercase tracking-wider">
                                {{ card.title }}
                            </h3>
                            <p class="mt-3 text-sm leading-relaxed text-slate-300">
                                {{ card.body }}
                            </p>
                        </article>
                    </div>

                    <div
                        class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row"
                    >
                        <Link
                            :href="route('wizard.index')"
                            class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(37,99,235,0.4)] transition hover:bg-blue-500"
                        >
                            Bu potansiyeli gerçeğe dönüştürmek için hemen görüşelim
                        </Link>
                        <button
                            type="button"
                            class="text-sm text-slate-400 transition hover:text-white"
                            @click="reset"
                        >
                            Yeni analiz yap
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
