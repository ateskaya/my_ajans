<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const visionImage = computed(() =>
    `${(page.props.assetUrl ?? '').replace(/\/$/, '')}/images/vision/banner.webp`,
);
</script>

<template>
    <section
        class="relative w-full overflow-hidden border-y border-slate-800"
        aria-label="Vizyon"
    >
        <div class="relative h-64 sm:h-80 lg:h-96">
            <img
                :src="visionImage"
                alt=""
                width="1200"
                height="798"
                sizes="100vw"
                class="absolute inset-0 h-full w-full object-cover"
                decoding="async"
                loading="lazy"
                fetchpriority="low"
                aria-hidden="true"
            />
            <div class="absolute inset-0 bg-slate-950/70" />

            <div
                class="relative flex h-full items-center justify-center px-6 text-center"
            >
                <p
                    class="max-w-3xl text-lg font-medium leading-relaxed text-white sm:text-xl lg:text-2xl"
                >
                    Kod satırlarının ötesinde, işinizi geleceğe taşıyan otonom
                    sistemler inşa ediyoruz.
                </p>
            </div>
        </div>
    </section>
</template>
