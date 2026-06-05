<script setup>
import InputError from '@/Components/InputError.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    clients: {
        type: Array,
        required: true,
    },
    statusOptions: {
        type: Array,
        default: () => ['planlama', 'gelistirme', 'test', 'canli'],
    },
});

const statusLabels = {
    planlama: 'Planlama',
    gelistirme: 'Geliştirme',
    test: 'Test',
    canli: 'Canlı',
};

const fieldClass =
    'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500';

const targetDate = props.project.target_date
    ? String(props.project.target_date).slice(0, 10)
    : '';

const form = useForm({
    user_id: props.project.user_id,
    title: props.project.title,
    description: props.project.description,
    status: props.project.status,
    progress_percentage: props.project.progress_percentage,
    staging_url: props.project.staging_url ?? '',
    live_url: props.project.live_url ?? '',
    target_date: targetDate,
});

const submit = () => {
    form.put(route('admin.client-projects.update', props.project.id));
};
</script>

<template>
    <Head :title="`Proje Düzenle: ${project.title}`" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Proje Düzenle</h1>
                <Link
                    :href="route('admin.client-projects.show', project.id)"
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Projeye Dön
                </Link>
            </div>
        </template>

        <form
            class="max-w-3xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
            @submit.prevent="submit"
        >
            <div>
                <label class="block text-sm font-medium text-gray-700">Müşteri *</label>
                <select v-model="form.user_id" required :class="fieldClass">
                    <option
                        v-for="client in clients"
                        :key="client.id"
                        :value="client.id"
                    >
                        {{ client.name }} ({{ client.email }})
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.user_id" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Proje Başlığı *</label>
                <input v-model="form.title" type="text" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Açıklama *</label>
                <textarea
                    v-model="form.description"
                    rows="4"
                    required
                    :class="fieldClass"
                />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Durum *</label>
                    <select v-model="form.status" required :class="fieldClass">
                        <option
                            v-for="status in statusOptions"
                            :key="status"
                            :value="status"
                        >
                            {{ statusLabels[status] ?? status }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.status" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Hedef Tarih</label>
                    <input v-model="form.target_date" type="date" :class="fieldClass" />
                    <InputError class="mt-2" :message="form.errors.target_date" />
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">
                    İlerleme: %{{ form.progress_percentage }}
                </label>
                <input
                    v-model.number="form.progress_percentage"
                    type="range"
                    min="0"
                    max="100"
                    step="1"
                    class="mt-2 w-full accent-blue-600"
                />
                <InputError class="mt-2" :message="form.errors.progress_percentage" />
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Staging URL</label>
                    <input v-model="form.staging_url" type="url" :class="fieldClass" />
                    <InputError class="mt-2" :message="form.errors.staging_url" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Canlı URL</label>
                    <input v-model="form.live_url" type="url" :class="fieldClass" />
                    <InputError class="mt-2" :message="form.errors.live_url" />
                </div>
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="inline-flex rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 disabled:opacity-60"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Kaydediliyor...' : 'Güncelle' }}
                </button>
                <Link
                    :href="route('admin.client-projects.show', project.id)"
                    class="inline-flex rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    İptal
                </Link>
            </div>
        </form>
    </AdminLayout>
</template>
