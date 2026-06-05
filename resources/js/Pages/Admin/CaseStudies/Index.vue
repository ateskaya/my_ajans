<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    caseStudies: {
        type: Array,
        required: true,
    },
});

const actionClass =
    'inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50';

const destroyCaseStudy = (id) => {
    if (!confirm('Bu başarı hikayesini silmek istediğinize emin misiniz?')) {
        return;
    }

    router.delete(route('admin.case-studies.destroy', id));
};
</script>

<template>
    <Head title="Başarı Hikayeleri" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">
                    Başarı Hikayeleri
                </h1>
                <Link
                    :href="route('admin.case-studies.create')"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                >
                    Yeni Başarı Hikayesi
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
                                Müşteri
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Slug
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Öne Çıkan
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="caseStudies.length === 0">
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-gray-500">
                                Henüz başarı hikayesi eklenmemiş.
                            </td>
                        </tr>
                        <tr
                            v-for="study in caseStudies"
                            :key="study.id"
                            class="transition-colors hover:bg-gray-50"
                        >
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ study.title }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ study.client_name }}
                            </td>
                            <td class="px-4 py-4 font-mono text-sm text-gray-600">
                                {{ study.slug }}
                            </td>
                            <td class="px-4 py-4">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    :class="
                                        study.is_featured
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'bg-gray-100 text-gray-600'
                                    "
                                >
                                    {{ study.is_featured ? 'Evet' : 'Hayır' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="route('admin.case-studies.edit', study.id)"
                                        :class="actionClass"
                                    >
                                        Düzenle
                                    </Link>
                                    <button
                                        type="button"
                                        :class="actionClass"
                                        class="text-red-600 hover:bg-red-50"
                                        @click="destroyCaseStudy(study.id)"
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
