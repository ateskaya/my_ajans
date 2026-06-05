<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const statusLabels = {
    planlama: 'Planlama',
    gelistirme: 'Geliştirme',
    test: 'Test',
    canli: 'Canlı',
};

const statusClass = {
    planlama: 'bg-slate-100 text-slate-700',
    gelistirme: 'bg-blue-100 text-blue-800',
    test: 'bg-amber-100 text-amber-800',
    canli: 'bg-emerald-100 text-emerald-800',
};

const inputClass =
    'inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50';

const destroyProject = (id) => {
    if (!confirm('Bu projeyi silmek istediğinize emin misiniz?')) {
        return;
    }

    router.delete(route('admin.client-projects.destroy', id));
};
</script>

<template>
    <Head title="Müşteri Projeleri" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Müşteri Projeleri</h1>
                <Link
                    :href="route('admin.client-projects.create')"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500"
                >
                    Yeni Proje Ekle
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
                                Proje
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Müşteri
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                Durum
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                İlerleme
                            </th>
                            <th
                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"
                            >
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-if="projects.length === 0">
                            <td
                                colspan="5"
                                class="px-4 py-12 text-center text-sm text-gray-500"
                            >
                                Henüz proje eklenmemiş.
                            </td>
                        </tr>
                        <tr
                            v-for="project in projects"
                            :key="project.id"
                            class="transition-colors hover:bg-gray-50"
                        >
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ project.title }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <span v-if="project.user">{{ project.user.name }}</span>
                                <span v-else class="text-gray-400">—</span>
                            </td>
                            <td class="px-4 py-4">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    :class="statusClass[project.status] ?? 'bg-gray-100 text-gray-600'"
                                >
                                    {{ statusLabels[project.status] ?? project.status }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex min-w-[8rem] items-center gap-2">
                                    <div
                                        class="h-2 flex-1 overflow-hidden rounded-full bg-gray-200"
                                    >
                                        <div
                                            class="h-full rounded-full bg-blue-600 transition-all"
                                            :style="{
                                                width: `${project.progress_percentage}%`,
                                            }"
                                        />
                                    </div>
                                    <span class="text-xs font-medium text-gray-600">
                                        %{{ project.progress_percentage }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="route('admin.client-projects.show', project.id)"
                                        :class="inputClass"
                                    >
                                        Detay
                                    </Link>
                                    <Link
                                        :href="route('admin.client-projects.edit', project.id)"
                                        :class="inputClass"
                                    >
                                        Düzenle
                                    </Link>
                                    <button
                                        type="button"
                                        :class="inputClass"
                                        class="text-red-600 hover:bg-red-50"
                                        @click="destroyProject(project.id)"
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
