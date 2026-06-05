<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    services: {
        type: Array,
        required: true,
    },
});

const inputClass =
    'inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50';

const destroyService = (id) => {
    if (!confirm('Bu hizmeti silmek istediğinize emin misiniz?')) {
        return;
    }

    router.delete(route('admin.services.destroy', id));
};
</script>

<template>
    <Head title="Hizmetler" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Hizmetler</h1>
                <Link
                    :href="route('admin.services.create')"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                >
                    Yeni Hizmet Ekle
                </Link>
            </div>
        </template>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Başlık
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Slug
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                İkon
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Durum
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="services.length === 0">
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-gray-500">
                                Henüz hizmet eklenmemiş.
                            </td>
                        </tr>
                        <tr
                            v-for="service in services"
                            :key="service.id"
                            class="transition-colors hover:bg-gray-50"
                        >
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ service.title }}
                            </td>
                            <td class="px-4 py-4 font-mono text-sm text-gray-600">
                                {{ service.slug }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ service.icon_name }}
                            </td>
                            <td class="px-4 py-4">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    :class="
                                        service.is_active
                                            ? 'bg-emerald-100 text-emerald-800'
                                            : 'bg-gray-100 text-gray-600'
                                    "
                                >
                                    {{ service.is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="route('admin.services.edit', service.id)"
                                        :class="inputClass"
                                    >
                                        Düzenle
                                    </Link>
                                    <button
                                        type="button"
                                        :class="inputClass"
                                        class="text-red-600 hover:bg-red-50"
                                        @click="destroyService(service.id)"
                                    >
                                        Sil
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
