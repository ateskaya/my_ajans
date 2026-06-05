<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

const cards = [
    {
        key: 'leads',
        label: 'Toplam Talep',
        description: 'Gelen potansiyel müşteri formları',
        color: 'blue',
    },
    {
        key: 'services',
        label: 'Aktif Hizmet',
        description: 'Yayında olan hizmet sayısı',
        color: 'emerald',
    },
    {
        key: 'caseStudies',
        label: 'Başarı Hikayesi',
        description: 'Vaka çalışması kayıtları',
        color: 'violet',
    },
];

const colorMap = {
    blue: 'border-blue-200 bg-blue-50 text-blue-700',
    emerald: 'border-emerald-200 bg-emerald-50 text-emerald-700',
    violet: 'border-violet-200 bg-violet-50 text-violet-700',
};

const valueMap = {
    blue: 'text-blue-900',
    emerald: 'text-emerald-900',
    violet: 'text-violet-900',
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <h1 class="text-lg font-semibold text-gray-900">
                Dashboard
            </h1>
        </template>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="card in cards"
                :key="card.key"
                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
            >
                <div class="p-6">
                    <div
                        class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold"
                        :class="colorMap[card.color]"
                    >
                        {{ card.label }}
                    </div>
                    <p
                        class="mt-4 text-4xl font-bold tracking-tight"
                        :class="valueMap[card.color]"
                    >
                        {{ stats[card.key] }}
                    </p>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ card.description }}
                    </p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
