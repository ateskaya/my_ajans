<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    leads: {
        type: Array,
        required: true,
    },
});

const formatDate = (dateString) => {
    if (!dateString) {
        return '—';
    }

    return new Date(dateString).toLocaleString('tr-TR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const formatUtm = (lead) => {
    const parts = [lead.utm_source, lead.utm_medium, lead.utm_campaign].filter(
        Boolean,
    );

    return parts.length ? parts.join(' / ') : '—';
};
</script>

<template>
    <Head title="Talepler" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <h1 class="text-lg font-semibold text-gray-900">
                    Talepler (Leads)
                </h1>
                <Link
                    :href="route('admin.dashboard')"
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    Dashboard
                </Link>
            </div>
        </template>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Tarih
                            </th>
                            <th
                                scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                İsim
                            </th>
                            <th
                                scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Şirket
                            </th>
                            <th
                                scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                E-posta / Telefon
                            </th>
                            <th
                                scope="col"
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Bütçe
                            </th>
                            <th
                                scope="col"
                                class="min-w-[280px] px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Mesaj / UTM
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="leads.length === 0">
                            <td
                                colspan="6"
                                class="px-4 py-12 text-center text-sm text-gray-500"
                            >
                                Henüz kayıtlı talep bulunmuyor.
                            </td>
                        </tr>
                        <tr
                            v-for="lead in leads"
                            :key="lead.id"
                            class="transition-colors hover:bg-gray-50"
                        >
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                                {{ formatDate(lead.created_at) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                                {{ lead.name }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                                {{ lead.company_name || '—' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <div>{{ lead.email }}</div>
                                <div
                                    v-if="lead.phone"
                                    class="mt-0.5 text-gray-500"
                                >
                                    {{ lead.phone }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                                {{ lead.budget_range || '—' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <p class="line-clamp-2 text-gray-700">
                                    {{ lead.message }}
                                </p>
                                <p
                                    v-if="formatUtm(lead) !== '—'"
                                    class="mt-2 font-mono text-xs text-blue-600"
                                >
                                    UTM: {{ formatUtm(lead) }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
