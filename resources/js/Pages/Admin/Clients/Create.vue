<script setup>
import InputError from '@/Components/InputError.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const fieldClass =
    'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.clients.store'));
};
</script>

<template>
    <Head title="Yeni Müşteri" />

    <AdminLayout>
        <template #header>
            <div class="flex w-full items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-900">Yeni Müşteri</h1>
                <Link
                    :href="route('admin.clients.index')"
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Listeye Dön
                </Link>
            </div>
        </template>

        <form
            class="max-w-xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
            @submit.prevent="submit"
        >
            <div>
                <label class="block text-sm font-medium text-gray-700">İsim *</label>
                <input v-model="form.name" type="text" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">E-posta *</label>
                <input v-model="form.email" type="email" required :class="fieldClass" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Şifre *</label>
                <input
                    v-model="form.password"
                    type="password"
                    required
                    minlength="8"
                    :class="fieldClass"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Şifre Tekrar *
                </label>
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    required
                    :class="fieldClass"
                />
            </div>

            <p class="text-xs text-gray-500">
                Müşteri portalına bu bilgilerle giriş yapabilir. Şifreyi güvenli bir kanalla
                iletmeyi unutmayın.
            </p>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="inline-flex rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 disabled:opacity-60"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Kaydediliyor...' : 'Müşteri Oluştur' }}
                </button>
                <Link
                    :href="route('admin.clients.index')"
                    class="inline-flex rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    İptal
                </Link>
            </div>
        </form>
    </AdminLayout>
</template>
