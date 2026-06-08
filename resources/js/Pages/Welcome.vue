<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import CaseStudiesSection from '@/Components/CaseStudiesSection.vue';
import RoiCalculator from '@/Components/RoiCalculator.vue';
import ContactSection from '@/Components/ContactSection.vue';
import AnalyzerSection from '@/Components/AnalyzerSection.vue';
import HeroSection from '@/Components/HeroSection.vue';
import ServicesSection from '@/Components/ServicesSection.vue';
import VisionSection from '@/Components/VisionSection.vue';
import TechStackSection from '@/Components/TechStackSection.vue';
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
        <AnalyzerSection />
        <TechStackSection />
        <ServicesSection :services="services" />
        <VisionSection />
        <RoiCalculator />
        <CaseStudiesSection :case-studies="caseStudies" />
        <ContactSection />
    </AgencyLayout>
</template>
