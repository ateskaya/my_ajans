<script setup>
import ProjectGallery3D from '@/Components/ProjectGallery3D.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    caseStudies: {
        type: Array,
        required: true,
    },
    showPageLink: {
        type: Boolean,
        default: true,
    },
    fullPage: {
        type: Boolean,
        default: false,
    },
});

const sectionRef = ref(null);

const metricLabels = {
    speed_increase: 'Hız Artışı',
    conversion_lift: 'Dönüşüm Artışı',
    infrastructure_cost_reduction: 'Altyapı Maliyet Azalması',
    uptime: 'Uptime',
    first_response_time_reduction: 'İlk Yanıt Süresi Azalması',
    support_ticket_volume_reduction: 'Destek Talebi Azalması',
    nps_increase: 'NPS Artışı',
    monthly_ops_savings: 'Aylık Operasyon Tasarrufu',
    cost_reduction: 'Maliyet Azalması',
};
</script>

<template>
    <section
        id="vaka-calismalari"
        ref="sectionRef"
        class="border-t border-slate-800 bg-slate-950 px-4 py-20 sm:px-6 lg:px-8"
        :class="{ 'border-t-0': fullPage }"
    >
        <div class="mx-auto max-w-7xl">
            <div
                v-if="!fullPage"
                class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between"
            >
                <div class="text-center md:text-left">
                    <p
                        class="mb-2 text-sm font-semibold uppercase tracking-widest text-blue-400"
                    >
                        Proje Galaksisi
                    </p>
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Başarı Hikayelerimiz ve Yarattığımız Değer
                    </h2>
                    <p class="mt-3 max-w-2xl text-slate-400">
                        Kaydırın; her vaka çalışması kendi 3D formuna dönüşürken
                        metrikler ve çözümler yanınızda akar.
                    </p>
                </div>
                <Link
                    v-if="showPageLink"
                    :href="route('case-studies.index')"
                    class="shrink-0 text-center text-sm font-medium text-blue-400 transition hover:text-blue-300"
                >
                    Tüm vaka çalışmaları →
                </Link>
            </div>

            <!-- Mobil: üstte 3D önizleme -->
            <div class="mb-10 lg:hidden">
                <ProjectGallery3D
                    :case-studies="caseStudies"
                    :scroll-root="sectionRef"
                />
            </div>

            <div class="relative lg:flex lg:gap-0">
                <!-- Sol: sticky 3D galeri -->
                <aside
                    class="pointer-events-none hidden lg:pointer-events-auto lg:sticky lg:top-20 lg:flex lg:h-[calc(100vh-5rem)] lg:w-1/2 lg:shrink-0 lg:items-center lg:pr-8"
                >
                    <ProjectGallery3D
                        :case-studies="caseStudies"
                        :scroll-root="sectionRef"
                    />
                </aside>

                <!-- Sağ: kaydırılabilir içerik panelleri -->
                <div class="lg:w-1/2 lg:pl-8">
                    <article
                        v-for="study in caseStudies"
                        :key="study.id"
                        class="galaxy-panel flex min-h-[70vh] flex-col justify-center border-b border-slate-800/80 py-16 last:border-b-0 lg:min-h-[85vh]"
                    >
                        <p class="text-xs font-semibold uppercase tracking-widest text-cyan-500/80">
                            Vaka Çalışması
                        </p>
                        <h3 class="mt-2 text-2xl font-bold text-white sm:text-3xl">
                            {{ study.title }}
                        </h3>
                        <p class="mt-2 text-sm font-medium text-blue-400">
                            {{ study.client_name }}
                        </p>

                        <div class="mt-8 space-y-8">
                            <div>
                                <h4
                                    class="mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500"
                                >
                                    Müşteri & Problem
                                </h4>
                                <p class="text-sm leading-relaxed text-slate-400">
                                    {{ study.problem }}
                                </p>
                            </div>

                            <div>
                                <h4
                                    class="mb-2 text-xs font-semibold uppercase tracking-widest text-slate-500"
                                >
                                    Çözüm & Etki
                                </h4>
                                <p class="text-sm leading-relaxed text-slate-400">
                                    {{ study.solution }}
                                </p>

                                <div
                                    v-if="
                                        study.impact_metrics &&
                                        Object.keys(study.impact_metrics).length
                                    "
                                    class="mt-6 grid grid-cols-2 gap-4"
                                >
                                    <div
                                        v-for="(value, key) in study.impact_metrics"
                                        :key="key"
                                        class="rounded-lg border border-slate-800/80 bg-slate-900/60 p-3"
                                    >
                                        <p class="text-xs text-slate-500">
                                            {{ metricLabels[key] ?? key }}
                                        </p>
                                        <p
                                            class="mt-1 text-xl font-bold text-blue-400 sm:text-2xl"
                                        >
                                            {{ value }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</template>
