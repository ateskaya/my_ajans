<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const page = usePage();

const totalSteps = 4;
const currentStep = ref(1);

const projectTypes = [
    'Özel Yazılım Geliştirme',
    'Yapay Zeka (LLM) Entegrasyonu',
    'Otonom Sistem & Web Scraping',
    'SaaS Altyapısı',
];

const timelineOptions = [
    { value: '1-3 Ay', label: '1-3 Ay' },
    { value: '3-6 Ay', label: '3-6 Ay' },
    { value: '6+ Ay', label: '6+ Ay' },
];

const budgetOptions = [
    { value: '50.000₺ - 100.000₺', label: '50.000₺ - 100.000₺' },
    { value: '100.000₺+', label: '100.000₺+' },
    { value: '250.000₺+', label: '250.000₺+' },
    { value: 'Henüz belirlemedim', label: 'Henüz belirlemedim' },
];

const inputClass =
    'mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-slate-200 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

const selectClass =
    'mt-1 block w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

const form = useForm({
    project_type: '',
    message: '',
    budget_range: '',
    timeline: '',
    name: '',
    email: '',
    phone: '',
    utm_source: '',
    utm_medium: '',
    utm_campaign: '',
    source: 'wizard',
});

const progressPercent = computed(() => (currentStep.value / totalSteps) * 100);

const stepLabels = [
    'Proje tipi',
    'Detaylar',
    'Bütçe & takvim',
    'İletişim',
];

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    form.utm_source = params.get('utm_source') ?? '';
    form.utm_medium = params.get('utm_medium') ?? '';
    form.utm_campaign = params.get('utm_campaign') ?? '';

    const user = page.props.auth?.user;
    if (user) {
        form.name = user.name ?? form.name;
        form.email = user.email ?? form.email;
    }
});

const selectProjectType = (type) => {
    form.project_type = type;
};

const validateStep = (step) => {
    form.clearErrors();

    if (step === 1 && !form.project_type) {
        form.setError('project_type', 'Lütfen bir proje tipi seçin.');
        return false;
    }

    if (step === 2 && !form.message.trim()) {
        form.setError('message', 'Lütfen projenizden kısaca bahsedin.');
        return false;
    }

    if (step === 3) {
        if (!form.timeline) {
            form.setError('timeline', 'Lütfen bir zaman çizelgesi seçin.');
            return false;
        }
        if (!form.budget_range) {
            form.setError('budget_range', 'Lütfen bir bütçe aralığı seçin.');
            return false;
        }
    }

    if (step === 4) {
        if (!form.name.trim()) {
            form.setError('name', 'Ad soyad zorunludur.');
            return false;
        }
        if (!form.email.trim()) {
            form.setError('email', 'E-posta zorunludur.');
            return false;
        }
    }

    return true;
};

const nextStep = () => {
    if (!validateStep(currentStep.value)) {
        return;
    }

    if (currentStep.value < totalSteps) {
        currentStep.value += 1;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value -= 1;
    }
};

const submit = () => {
    if (!validateStep(4)) {
        return;
    }

    form.post(route('leads.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // Backend redirects to home with flash success
        },
    });
};
</script>

<template>
    <div
        class="mx-auto w-full max-w-3xl overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-2xl shadow-blue-900/10"
    >
        <!-- Progress -->
        <div class="border-b border-slate-800 px-6 py-5 sm:px-8">
            <div class="flex items-center justify-between text-sm">
                <span class="font-medium text-slate-300">
                    Adım {{ currentStep }} / {{ totalSteps }}
                </span>
                <span class="text-slate-300">{{ stepLabels[currentStep - 1] }}</span>
            </div>
            <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-800">
                <div
                    class="h-full rounded-full bg-blue-500 transition-all duration-500 ease-out"
                    :style="{ width: `${progressPercent}%` }"
                />
            </div>
        </div>

        <form class="px-6 py-8 sm:px-8" @submit.prevent="currentStep === 4 ? submit() : nextStep()">
            <Transition
                mode="out-in"
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="translate-x-6 opacity-0"
                enter-to-class="translate-x-0 opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="translate-x-0 opacity-100"
                leave-to-class="-translate-x-6 opacity-0"
            >
                <!-- Step 1 -->
                <div v-if="currentStep === 1" key="step-1">
                    <h2 class="text-xl font-semibold text-white sm:text-2xl">
                        Odaklanmamız gereken alan hangisi?
                    </h2>
                    <p class="mt-2 text-sm text-slate-300">
                        Projenize en uygun uzmanlık alanını seçin.
                    </p>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <button
                            v-for="type in projectTypes"
                            :key="type"
                            type="button"
                            class="rounded-xl border p-5 text-left transition-all duration-200"
                            :class="
                                form.project_type === type
                                    ? 'border-blue-500 bg-blue-950/40 shadow-[0_0_20px_rgba(59,130,246,0.2)]'
                                    : 'border-slate-700 bg-slate-950 hover:border-slate-500'
                            "
                            @click="selectProjectType(type)"
                        >
                            <span class="text-sm font-semibold text-white">{{ type }}</span>
                        </button>
                    </div>
                    <InputError class="mt-3" :message="form.errors.project_type" />
                </div>

                <!-- Step 2 -->
                <div v-else-if="currentStep === 2" key="step-2">
                    <h2 class="text-xl font-semibold text-white sm:text-2xl">
                        Projenizden kısaca bahsedin
                    </h2>
                    <p class="mt-2 text-sm text-slate-300">
                        Hedefleriniz, kullanıcı kitleniz ve beklediğiniz çıktılar hakkında bilgi verin.
                    </p>

                    <textarea
                        v-model="form.message"
                        rows="8"
                        class="mt-6 w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-200 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Örn: Diyetisyenler için mobil uygulama, randevu ve beslenme takibi..."
                    />
                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <!-- Step 3 -->
                <div v-else-if="currentStep === 3" key="step-3">
                    <h2 class="text-xl font-semibold text-white sm:text-2xl">
                        Bütçe ve zaman çizelgesi
                    </h2>
                    <p class="mt-2 text-sm text-slate-300">
                        Size en doğru teklifi hazırlayabilmemiz için planlamanızı paylaşın.
                    </p>

                    <div class="mt-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300">
                                Hedef takvim
                            </label>
                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">
                                <label
                                    v-for="option in timelineOptions"
                                    :key="option.value"
                                    class="flex cursor-pointer items-center justify-center rounded-lg border px-4 py-3 text-sm font-medium transition"
                                    :class="
                                        form.timeline === option.value
                                            ? 'border-blue-500 bg-blue-950/40 text-white'
                                            : 'border-slate-700 bg-slate-950 text-slate-300 hover:border-slate-500'
                                    "
                                >
                                    <input
                                        v-model="form.timeline"
                                        type="radio"
                                        class="sr-only"
                                        :value="option.value"
                                    />
                                    {{ option.label }}
                                </label>
                            </div>
                            <InputError class="mt-2" :message="form.errors.timeline" />
                        </div>

                        <div>
                            <label
                                for="budget_range"
                                class="block text-sm font-medium text-slate-300"
                            >
                                Bütçe aralığı
                            </label>
                            <select
                                id="budget_range"
                                v-model="form.budget_range"
                                :class="selectClass"
                            >
                                <option value="" disabled>Bütçe aralığı seçin</option>
                                <option
                                    v-for="option in budgetOptions"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.budget_range" />
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div v-else-if="currentStep === 4" key="step-4">
                    <h2 class="text-xl font-semibold text-white sm:text-2xl">
                        Harika, son adıma geldik
                    </h2>
                    <p class="mt-2 text-sm text-slate-300">
                        Teklifinizi nereye iletelim?
                    </p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-300">
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
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300">
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
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-300">
                                Telefon
                            </label>
                            <input
                                id="phone"
                                v-model="form.phone"
                                type="tel"
                                :class="inputClass"
                                placeholder="+90 5XX XXX XX XX"
                            />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                    </div>
                </div>
            </Transition>

            <!-- Actions -->
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-800 pt-6 sm:flex-row sm:justify-between">
                <button
                    v-if="currentStep > 1"
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-700 px-5 py-2.5 text-sm font-semibold text-slate-300 transition hover:border-slate-500 hover:text-white"
                    :disabled="form.processing"
                    @click="prevStep"
                >
                    Geri
                </button>
                <div v-else class="hidden sm:block" />

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-[0_0_20px_rgba(37,99,235,0.35)] transition hover:bg-blue-500 disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Gönderiliyor...</span>
                    <span v-else-if="currentStep === 4">Talebi Gönder</span>
                    <span v-else>İleri</span>
                </button>
            </div>
        </form>
    </div>
</template>
