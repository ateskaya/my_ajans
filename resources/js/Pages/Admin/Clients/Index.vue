<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    clients: {
        type: Array,
        required: true,
    },
});

const formatDate = (dateString) => {
    if (!dateString) {
        return '—';
    }

    return new Date(dateString).toLocaleDateString('tr-TR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    });
};
</script>

<template>
    <Head title="Müşteriler" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Müşteriler</h1>
                <Link
                    :href="route('admin.clients.create')"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                >
                    Yeni Müşteri Ekle
                </Link>
            </div>
        </template>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Ad
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                E-posta
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Proje Sayısı
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Kayıt Tarihi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="clients.length === 0">
                            <td
                                colspan="4"
                                class="px-4 py-12 text-center text-sm text-gray-500"
                            >
                                Henüz müşteri eklenmemiş.
                            </td>
                        </tr>
                        <tr
                            v-for="client in clients"
                            :key="client.id"
                            class="transition-colors hover:bg-gray-50"
                        >
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ client.name }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ client.email }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ client.client_projects_count }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">
                                {{ formatDate(client.created_at) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
