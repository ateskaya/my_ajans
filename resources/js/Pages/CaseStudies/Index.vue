<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import CaseStudiesSection from '@/Components/CaseStudiesSection.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    caseStudies: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Vaka Çalışmaları" />

    <AgencyLayout>
        <PageHeader
            eyebrow="Kanıtlanmış değer"
            title="Başarı Hikayelerimiz"
            description="Gerçek müşteri problemlerini ölçülebilir iş sonuçlarına dönüştürüyoruz."
        />
        <CaseStudiesSection :case-studies="caseStudies" :show-page-link="false" full-page />
    </AgencyLayout>
</template>
