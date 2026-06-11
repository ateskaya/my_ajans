<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import LazySection from '@/Components/LazySection.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    services: {
        type: Array,
        required: true,
    },
    caseStudies: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Ana Sayfa" />

    <AgencyLayout>
        <HeroSection />

        <LazySection
            :loader="() => import('@/Components/AnalyzerSection.vue')"
            min-height="28rem"
        />

        <LazySection
            :loader="() => import('@/Components/TechStackSection.vue')"
            min-height="12rem"
        />

        <LazySection
            :loader="() => import('@/Components/ServicesSection.vue')"
            :services="services"
            min-height="24rem"
        />

        <LazySection
            :loader="() => import('@/Components/VisionSection.vue')"
            min-height="16rem"
        />

        <LazySection
            :loader="() => import('@/Components/RoiCalculator.vue')"
            min-height="20rem"
        />

        <LazySection
            :loader="() => import('@/Components/CaseStudiesSection.vue')"
            :case-studies="caseStudies"
            min-height="24rem"
        />

        <LazySection
            :loader="() => import('@/Components/ContactSection.vue')"
            min-height="20rem"
        />
    </AgencyLayout>
</template>
