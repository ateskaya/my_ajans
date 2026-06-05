<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import ContactSection from '@/Components/ContactSection.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="İletişim" />

    <AgencyLayout>
        <PageHeader
            eyebrow="Projenizi konuşalım"
            title="İletişim"
            description="Formu doldurun; ekibimiz en kısa sürede size dönüş yapsın."
        />
        <ContactSection hide-header />
    </AgencyLayout>
</template>
