<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import PageHeader from '@/Components/PageHeader.vue';
import ServicesSection from '@/Components/ServicesSection.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    services: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Hizmetlerimiz" />

    <AgencyLayout>
        <PageHeader
            eyebrow="Uzmanlık"
            title="Hizmetlerimiz"
            description="İş hedeflerinize uygun, ölçeklenebilir ve sürdürülebilir teknoloji çözümleri."
        />
        <ServicesSection :services="services" :show-page-link="false" full-page />
    </AgencyLayout>
</template>
