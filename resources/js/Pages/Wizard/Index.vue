<script setup>
import AgencyLayout from '@/Layouts/AgencyLayout.vue';
import ProjectWizard from '@/Components/ProjectWizard.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Proje Başlat" />

    <AgencyLayout>
        <section class="flex min-h-[calc(100vh-12rem)] items-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-4xl">
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-300">
                        Proje Başlatma Sihirbazı
                    </p>
                    <h1 class="mt-2 text-3xl font-bold text-white sm:text-4xl">
                        Fikrinizi Hayata Geçirelim
                    </h1>
                    <p class="mx-auto mt-3 max-w-xl text-slate-300">
                        4 kısa adımda projenizi anlatın; ekibimiz size özel teklif hazırlasın.
                    </p>
                </div>

                <ProjectWizard />
            </div>
        </section>
    </AgencyLayout>
</template>
