<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

defineProps({
    hideHeader: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();

const budgetOptions = [
    { value: '', label: 'Bütçe aralığı seçin' },
    { value: '50.000₺ - 100.000₺', label: '50.000₺ - 100.000₺' },
    { value: '100.000₺+', label: '100.000₺+' },
];

const inputClass =
    'mt-1 block w-full rounded-md border border-slate-700 bg-slate-900 px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 transition-colors focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    company_name: '',
    budget_range: '',
    message: '',
    utm_source: '',
    utm_medium: '',
    utm_campaign: '',
});

const showSuccess = computed(() => Boolean(page.props.flash?.success));

const applyUtmFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    form.utm_source = params.get('utm_source') ?? '';
    form.utm_medium = params.get('utm_medium') ?? '';
    form.utm_campaign = params.get('utm_campaign') ?? '';
};

onMounted(() => {
    applyUtmFromUrl();
});

const submit = () => {
    form.post(route('leads.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            applyUtmFromUrl();
        },
    });
};
</script>

<template>
    <section
        id="iletisim"
        class="border-t border-slate-800 px-4 py-20 sm:px-6 lg:px-8"
        :class="{ 'border-t-0': hideHeader }"
    >
        <div class="mx-auto max-w-7xl">
            <div
                v-if="!hideHeader"
                class="mb-12 text-center md:text-left"
            >
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Projenizi Konuşalım
                </h2>
                <p class="mt-3 max-w-2xl text-slate-400">
                    Formu doldurun; Google Ads kampanyalarınızdan gelen
                    talepleri de UTM parametreleriyle birlikte kaydediyoruz.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                <!-- İletişim bilgileri -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold text-white">
                            Doğrudan İletişim
                        </h3>
                        <ul class="mt-4 space-y-3 text-slate-400">
                            <li>
                                <span class="text-slate-500">E-posta:</span>
                                <a
                                    href="mailto:hello@ajans.com"
                                    class="ms-2 text-blue-400 transition-colors hover:text-blue-300"
                                >
                                    hello@ajans.com
                                </a>
                            </li>
                            <li>
                                <span class="text-slate-500">Telefon:</span>
                                <a
                                    href="tel:+902121234567"
                                    class="ms-2 text-blue-400 transition-colors hover:text-blue-300"
                                >
                                    +90 (212) 123 45 67
                                </a>
                            </li>
                            <li>
                                <span class="text-slate-500">Konum:</span>
                                <span class="ms-2">İstanbul, Türkiye</span>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="rounded-xl border border-slate-800 bg-slate-900/40 p-6"
                    >
                        <p class="text-sm leading-relaxed text-slate-400">
                            Kurumsal yazılım, AI entegrasyonu ve ölçeklenebilir
                            web projeleri için teknik ekibimiz 24 saat içinde
                            ön değerlendirme ile dönüş yapar.
                        </p>
                    </div>
                </div>

                <!-- Form -->
                <div>
                    <div
                        v-if="showSuccess"
                        class="mb-6 rounded-lg border border-emerald-500/40 bg-emerald-950/40 px-4 py-3 text-sm font-medium text-emerald-300 shadow-[0_0_20px_rgba(16,185,129,0.15)]"
                        role="alert"
                    >
                        {{ page.props.flash.success }}
                    </div>

                    <form
                        class="space-y-5 rounded-xl border border-slate-800 bg-slate-900/30 p-6 sm:p-8"
                        @submit.prevent="submit"
                    >
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label
                                    for="name"
                                    class="block text-sm font-medium text-slate-300"
                                >
                                    Ad Soyad *
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    :class="inputClass"
                                    placeholder="Adınız Soyadınız"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-medium text-slate-300"
                                >
                                    E-posta *
                                </label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    :class="inputClass"
                                    placeholder="ornek@sirket.com"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>

                            <div>
                                <label
                                    for="phone"
                                    class="block text-sm font-medium text-slate-300"
                                >
                                    Telefon
                                </label>
                                <input
                                    id="phone"
                                    v-model="form.phone"
                                    type="tel"
                                    :class="inputClass"
                                    placeholder="+90 5XX XXX XX XX"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.phone"
                                />
                            </div>

                            <div class="sm:col-span-2">
                                <label
                                    for="company_name"
                                    class="block text-sm font-medium text-slate-300"
                                >
                                    Şirket Adı
                                </label>
                                <input
                                    id="company_name"
                                    v-model="form.company_name"
                                    type="text"
                                    :class="inputClass"
                                    placeholder="Şirketiniz"
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.company_name"
                                />
                            </div>

                            <div class="sm:col-span-2">
                                <label
                                    for="budget_range"
                                    class="block text-sm font-medium text-slate-300"
                                >
                                    Bütçe Aralığı
                                </label>
                                <select
                                    id="budget_range"
                                    v-model="form.budget_range"
                                    :class="inputClass"
                                >
                                    <option
                                        v-for="option in budgetOptions"
                                        :key="option.value"
                                        :value="option.value"
                                    >
                                        {{ option.label }}
                                    </option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.budget_range"
                                />
                            </div>

                            <div class="sm:col-span-2">
                                <label
                                    for="message"
                                    class="block text-sm font-medium text-slate-300"
                                >
                                    Proje Detayı *
                                </label>
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    rows="5"
                                    required
                                    :class="inputClass"
                                    placeholder="Projenizi, hedeflerinizi ve zaman çizelgenizi kısaca anlatın."
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.message"
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(37,99,235,0.35)] transition-all duration-200 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-950 disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Gönderiliyor...</span>
                            <span v-else>Talebi Gönder</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
