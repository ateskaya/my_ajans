<script setup>
import InputError from '@/Components/InputError.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    statusOptions: {
        type: Array,
        default: () => [],
    },
    updateTypeOptions: {
        type: Array,
        default: () => ['genel', 'kilometre_tasi', 'acil'],
    },
});

const statusLabels = {
    planlama: 'Planlama',
    gelistirme: 'Geliştirme',
    test: 'Test',
    canli: 'Canlı',
};

const typeLabels = {
    genel: 'Genel',
    kilometre_tasi: 'Kilometre Taşı',
    acil: 'Acil',
};

const typeClass = {
    genel: 'bg-slate-100 text-slate-700',
    kilometre_tasi: 'bg-blue-100 text-blue-800',
    acil: 'bg-red-100 text-red-800',
};

const fieldClass =
    'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500';

const updateForm = useForm({
    title: '',
    type: 'genel',
    content: '',
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

const submitUpdate = () => {
    updateForm.post(route('admin.client-projects.updates.store', props.project.id), {
        preserveScroll: true,
        onSuccess: () => {
            updateForm.reset();
            updateForm.type = 'genel';
        },
    });
};

const updates = () => props.project.project_updates ?? [];
</script>

<template>
    <Head :title="`Proje: ${project.title}`" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">
                        {{ project.title }}
                    </h1>
                    <p v-if="project.user" class="text-sm text-gray-500">
                        {{ project.user.name }} · {{ project.user.email }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <Link
                        :href="route('admin.client-projects.edit', project.id)"
                        class="inline-flex rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Düzenle
                    </Link>
                    <Link
                        :href="route('admin.client-projects.index')"
                        class="text-sm text-gray-500 hover:text-gray-700"
                    >
                        ← Projeler
                    </Link>
                </div>
            </div>
        </template>

        <!-- Proje özeti -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <span
                        class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                        :class="{
                            'bg-slate-100 text-slate-700': project.status === 'planlama',
                            'bg-blue-100 text-blue-800': project.status === 'gelistirme',
                            'bg-amber-100 text-amber-800': project.status === 'test',
                            'bg-emerald-100 text-emerald-800': project.status === 'canli',
                        }"
                    >
                        {{ statusLabels[project.status] ?? project.status }}
                    </span>
                    <p class="mt-4 max-w-2xl text-sm leading-relaxed text-gray-600">
                        {{ project.description }}
                    </p>
                </div>
                <div class="text-right text-sm text-gray-500">
                    <p v-if="project.target_date">
                        Hedef: {{ formatDate(project.target_date) }}
                    </p>
                    <p v-if="project.staging_url" class="mt-1">
                        <a
                            :href="project.staging_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-blue-600 hover:underline"
                        >
                            Staging
                        </a>
                    </p>
                    <p v-if="project.live_url" class="mt-1">
                        <a
                            :href="project.live_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-blue-600 hover:underline"
                        >
                            Canlı
                        </a>
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <div class="mb-2 flex justify-between text-sm font-medium text-gray-700">
                    <span>İlerleme</span>
                    <span>%{{ project.progress_percentage }}</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-gray-200">
                    <div
                        class="h-full rounded-full bg-blue-600 transition-all"
                        :style="{ width: `${project.progress_percentage}%` }"
                    />
                </div>
            </div>
        </div>

        <!-- Yeni güncelleme -->
        <div class="mt-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900">Yeni Güncelleme Ekle</h2>

            <form class="mt-4 space-y-4" @submit.prevent="submitUpdate">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Başlık *</label>
                        <input
                            v-model="updateForm.title"
                            type="text"
                            required
                            :class="fieldClass"
                        />
                        <InputError class="mt-2" :message="updateForm.errors.title" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tür *</label>
                        <select v-model="updateForm.type" required :class="fieldClass">
                            <option
                                v-for="t in updateTypeOptions"
                                :key="t"
                                :value="t"
                            >
                                {{ typeLabels[t] ?? t }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="updateForm.errors.type" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">İçerik *</label>
                    <textarea
                        v-model="updateForm.content"
                        rows="4"
                        required
                        :class="fieldClass"
                    />
                    <InputError class="mt-2" :message="updateForm.errors.content" />
                </div>

                <button
                    type="submit"
                    class="inline-flex rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 disabled:opacity-60"
                    :disabled="updateForm.processing"
                >
                    {{ updateForm.processing ? 'Ekleniyor...' : 'Güncelleme Yayınla' }}
                </button>
            </form>
        </div>

        <!-- Timeline -->
        <div class="mt-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900">Güncelleme Geçmişi</h2>

            <div v-if="updates().length === 0" class="mt-6 text-sm text-gray-500">
                Henüz güncelleme yok.
            </div>

            <ol v-else class="relative mt-8 border-l-2 border-gray-200 pl-8">
                <li
                    v-for="update in updates()"
                    :key="update.id"
                    class="relative mb-10 last:mb-0"
                >
                    <span
                        class="absolute -left-[2.35rem] top-1 flex h-4 w-4 rounded-full border-2 border-white bg-blue-600 ring-4 ring-blue-100"
                    />
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-sm font-semibold text-gray-900">
                            {{ update.title }}
                        </h3>
                        <span
                            class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium"
                            :class="typeClass[update.type] ?? 'bg-gray-100 text-gray-600'"
                        >
                            {{ typeLabels[update.type] ?? update.type }}
                        </span>
                        <time class="text-xs text-gray-400">
                            {{ formatDate(update.created_at) }}
                        </time>
                    </div>
                    <p class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-gray-600">
                        {{ update.content }}
                    </p>
                </li>
            </ol>
        </div>
    </AdminLayout>
</template>
