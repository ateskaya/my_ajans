<script setup>
import InputError from '@/Components/InputError.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    service: {
        type: Object,
        required: true,
    },
});

const fieldClass =
    'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500';

const form = useForm({
    title: props.service.title,
    slug: props.service.slug,
    excerpt: props.service.excerpt,
    description: props.service.description,
    icon_name: props.service.icon_name,
    is_active: props.service.is_active,
});

const submit = () => {
    form.put(route('admin.services.update', props.service.id));
};
</script>

<template>
    <Head title="Hizmet Düzenle" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Hizmet Düzenle</h1>
                <Link
                    :href="route('admin.services.index')"
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Listeye Dön
                </Link>
            </div>
        </template>

        <form
            class="max-w-3xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
            @submit.prevent="submit"
        >
            <div>
                <label class="block text-sm font-medium text-gray-700">Başlık *</label>
                <input v-model="form.title" type="text" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Slug *</label>
                <input v-model="form.slug" type="text" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.slug" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kısa Açıklama *</label>
                <textarea v-model="form.excerpt" rows="3" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.excerpt" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Detaylı Açıklama *</label>
                <textarea v-model="form.description" rows="8" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">İkon Adı (Heroicons) *</label>
                <input v-model="form.icon_name" type="text" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.icon_name" />
            </div>

            <div class="flex items-center gap-2">
                <input
                    id="is_active"
                    v-model="form.is_active"
                    type="checkbox"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                />
                <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                <InputError class="mt-2" :message="form.errors.is_active" />
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="inline-flex rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 disabled:opacity-60"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Güncelleniyor...' : 'Güncelle' }}
                </button>
                <Link
                    :href="route('admin.services.index')"
                    class="inline-flex rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    İptal
                </Link>
            </div>
        </form>
    </AdminLayout>
</template>
