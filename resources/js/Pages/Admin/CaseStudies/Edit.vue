<script setup>
import InputError from '@/Components/InputError.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    caseStudy: {
        type: Object,
        required: true,
    },
});

const fieldClass =
    'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500';

const formatMetricsJson = (metrics) => {
    if (!metrics || Object.keys(metrics).length === 0) {
        return '';
    }

    return JSON.stringify(metrics, null, 2);
};

const form = useForm({
    title: props.caseStudy.title,
    slug: props.caseStudy.slug,
    client_name: props.caseStudy.client_name,
    problem: props.caseStudy.problem,
    solution: props.caseStudy.solution,
    cover_image: props.caseStudy.cover_image ?? '',
    impact_metrics_json: formatMetricsJson(props.caseStudy.impact_metrics),
    is_featured: props.caseStudy.is_featured,
});

const submit = () => {
    form.put(route('admin.case-studies.update', props.caseStudy.id));
};
</script>

<template>
    <Head title="Başarı Hikayesi Düzenle" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">
                    Başarı Hikayesi Düzenle
                </h1>
                <Link
                    :href="route('admin.case-studies.index')"
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
                <label class="block text-sm font-medium text-gray-700">Müşteri Adı *</label>
                <input v-model="form.client_name" type="text" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.client_name" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Problem *</label>
                <textarea v-model="form.problem" rows="4" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.problem" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Çözüm *</label>
                <textarea v-model="form.solution" rows="5" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.solution" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Etki Metrikleri (JSON)
                </label>
                <textarea
                    v-model="form.impact_metrics_json"
                    rows="6"
                    :class="`${fieldClass} font-mono`"
                />
                <InputError class="mt-2" :message="form.errors.impact_metrics_json" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kapak Görseli URL</label>
                <input v-model="form.cover_image" type="text" :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.cover_image" />
            </div>

            <div class="flex items-center gap-2">
                <input
                    id="is_featured"
                    v-model="form.is_featured"
                    type="checkbox"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                />
                <label for="is_featured" class="text-sm text-gray-700">Öne Çıkan</label>
                <InputError class="mt-2" :message="form.errors.is_featured" />
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
                    :href="route('admin.case-studies.index')"
                    class="inline-flex rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    İptal
                </Link>
            </div>
        </form>
    </AdminLayout>
</template>
