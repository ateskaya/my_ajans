<script setup>
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    services: {
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

const serviceImageFiles = {
    'ozel-yazilim-gelistirme': {
        full: 'software.webp',
        small: 'software-400.webp',
        width: 800,
        height: 534,
    },
    'yapay-zeka-entegrasyonlari': {
        full: 'ai.webp',
        small: 'ai-400.webp',
        width: 800,
        height: 450,
    },
    'olceklenebilir-web-sistemleri': {
        full: 'web.webp',
        small: 'web-400.webp',
        width: 800,
        height: 532,
    },
};

const fallbackFiles = [
    serviceImageFiles['ozel-yazilim-gelistirme'],
    serviceImageFiles['yapay-zeka-entegrasyonlari'],
    serviceImageFiles['olceklenebilir-web-sistemleri'],
];

const toAssetUrl = (path) => {
    const base = (page.props.assetUrl ?? '').replace(/\/$/, '');

    return `${base}/${path.replace(/^\//, '')}`;
};

const resolveImageFiles = (service, index) => {
    if (service.slug && serviceImageFiles[service.slug]) {
        return serviceImageFiles[service.slug];
    }

    return fallbackFiles[index % fallbackFiles.length];
};

const resolveServiceImage = (service, index) => {
    if (service.image_url) {
        return service.image_url;
    }

    return toAssetUrl(`images/services/${resolveImageFiles(service, index).full}`);
};

const resolveServiceSrcSet = (service, index) => {
    if (service.image_url?.startsWith('http')) {
        return undefined;
    }

    const files = resolveImageFiles(service, index);

    return `${toAssetUrl(`images/services/${files.small}`)} 400w, ${toAssetUrl(`images/services/${files.full}`)} 800w`;
};
</script>

<template>
    <section
        id="hizmetler"
        class="border-t border-slate-800 px-4 py-20 sm:px-6 lg:px-8"
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
                        Hizmetler
                    </p>
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Uzmanlık Alanlarımız
                    </h2>
                    <p class="mt-3 max-w-2xl text-slate-300">
                        Görsel odaklı kartlarla hizmetlerimizi keşfedin.
                    </p>
                </div>
                <Link
                    v-if="showPageLink"
                    :href="route('services.index')"
                    class="shrink-0 text-center text-sm font-medium text-blue-300 transition hover:text-blue-300"
                >
                    Tüm hizmetler →
                </Link>
            </div>

            <div
                class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                :class="fullPage ? 'lg:gap-10' : ''"
            >
                <article
                    v-for="(service, index) in services"
                    :key="service.id"
                    class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 transition-all duration-300 hover:border-blue-500/50 hover:shadow-[0_0_40px_rgba(59,130,246,0.12)]"
                >
                    <img
                        :src="resolveServiceImage(service, index)"
                        :srcset="resolveServiceSrcSet(service, index)"
                        sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 400px"
                        :width="resolveImageFiles(service, index).width"
                        :height="resolveImageFiles(service, index).height"
                        :alt="service.title"
                        class="h-48 w-full object-cover opacity-90 transition-opacity duration-300 group-hover:opacity-100"
                        decoding="async"
                        loading="lazy"
                    />

                    <div class="relative px-6">
                        <div
                            v-if="service.icon_svg"
                            class="absolute -top-6 left-6 flex h-12 w-12 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 shadow-lg shadow-blue-900/20"
                            v-html="service.icon_svg"
                        />
                    </div>

                    <div class="px-6 pb-6 pt-10">
                        <h3 class="mb-3 text-xl font-bold text-white">
                            {{ service.title }}
                        </h3>
                        <p class="line-clamp-3 text-slate-300">
                            {{ service.excerpt }}
                        </p>
                        <p
                            v-if="fullPage && service.description"
                            class="mt-3 line-clamp-4 text-sm leading-relaxed text-slate-300"
                        >
                            {{ service.description }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
