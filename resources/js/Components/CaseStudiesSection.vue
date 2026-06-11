<script setup>
import CaseStudyContent from '@/Components/CaseStudyContent.vue';
import { Link, usePage } from '@inertiajs/vue3';

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

const page = usePage();

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

const localCovers = [
    'images/case-studies/ecommerce.webp',
    'images/case-studies/saas-ai.webp',
];

const toAssetUrl = (path) => {
    const base = (page.props.assetUrl ?? '').replace(/\/$/, '');

    return `${base}/${path.replace(/^\//, '')}`;
};

const resolveCoverImage = (study, index) => {
    const cover = study.cover_image;

    if (cover?.includes('unsplash.com')) {
        return toAssetUrl(localCovers[index % localCovers.length]);
    }

    if (cover?.startsWith('http')) {
        return cover;
    }

    if (cover) {
        return cover.startsWith('/')
            ? toAssetUrl(cover.slice(1))
            : toAssetUrl(cover);
    }

    return toAssetUrl(localCovers[index % localCovers.length]);
};
</script>

<template>
    <section
        id="vaka-calismalari"
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
                        class="mb-2 text-sm font-semibold uppercase tracking-widest text-blue-300"
                    >
                        Vaka Çalışmaları
                    </p>
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Başarı Hikayelerimiz ve Yarattığımız Değer
                    </h2>
                    <p class="mt-3 max-w-2xl text-slate-300">
                        Gerçek projelerden ölçülebilir sonuçlar ve iş etkisi.
                    </p>
                </div>
                <Link
                    v-if="showPageLink"
                    :href="route('case-studies.index')"
                    class="shrink-0 text-center text-sm font-medium text-blue-300 transition hover:text-blue-300"
                >
                    Tüm vaka çalışmaları →
                </Link>
            </div>

            <div class="space-y-16">
                <article
                    v-for="(study, index) in caseStudies"
                    :key="study.id"
                    class="grid grid-cols-1 items-center gap-8 lg:grid-cols-2"
                >
                    <div
                        class="overflow-hidden rounded-2xl shadow-[0_0_30px_rgba(59,130,246,0.1)]"
                        :class="index % 2 === 1 ? 'lg:order-2' : ''"
                    >
                        <img
                            :src="resolveCoverImage(study, index)"
                            :alt="study.title"
                            width="900"
                            height="675"
                            sizes="(max-width: 1024px) 100vw, 50vw"
                            class="aspect-[4/3] w-full object-cover transition duration-500 hover:scale-[1.02]"
                            decoding="async"
                            loading="lazy"
                        />
                    </div>
                    <div :class="index % 2 === 1 ? 'lg:order-1' : ''">
                        <CaseStudyContent
                            :study="study"
                            :metric-labels="metricLabels"
                        />
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
