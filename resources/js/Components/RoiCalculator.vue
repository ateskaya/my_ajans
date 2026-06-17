<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const agency = page.props.agency;

const employeeCount = ref(5);
const hoursPerDay = ref(4);
const hourlyWage = ref(300);

const systemCost = 150000;
const workingDaysPerYear = 250;
const automationEfficiency = 0.8;

const currentAnnualCost = computed(
    () =>
        employeeCount.value *
        hoursPerDay.value *
        hourlyWage.value *
        workingDaysPerYear,
);

const annualSavings = computed(
    () => currentAnnualCost.value * automationEfficiency,
);

const paybackMonths = computed(() => {
    const monthlySavings = annualSavings.value / 12;

    if (monthlySavings <= 0) {
        return null;
    }

    return systemCost / monthlySavings;
});

const currencyFormatter = new Intl.NumberFormat('tr-TR', {
    style: 'currency',
    currency: 'TRY',
    maximumFractionDigits: 0,
});

const numberFormatter = new Intl.NumberFormat('tr-TR', {
    maximumFractionDigits: 0,
});

const formatCurrency = (value) => currencyFormatter.format(value);

const formatPaybackMonths = (months) => {
    if (months === null || !Number.isFinite(months)) {
        return 'hesaplanamıyor';
    }

    if (months < 1) {
        return '1 ayın altında';
    }

    const rounded = Math.round(months * 10) / 10;

    if (rounded === Math.floor(rounded)) {
        return String(Math.floor(rounded));
    }

    return rounded.toLocaleString('tr-TR', {
        minimumFractionDigits: 1,
        maximumFractionDigits: 1,
    });
};
</script>

<template>
    <section class="px-4 py-20 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 text-center">
                <p
                    class="text-sm font-semibold uppercase tracking-widest text-blue-300"
                >
                    ROI Hesaplayıcı
                </p>
                <h2
                    class="mt-2 text-3xl font-bold text-white sm:text-4xl"
                >
                    Otomasyonun Gücünü Hesaplayın
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-slate-300">
                    Operasyonel yüklerinizin şirketinize gerçek maliyetini ve
                    yazılımla ne kadar tasarruf edeceğinizi görün.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Sol: Parametreler -->
                <div
                    class="space-y-8 rounded-2xl border border-slate-800 bg-slate-900/50 p-6 sm:p-8"
                >
                    <div>
                        <div
                            class="mb-3 flex items-center justify-between text-sm font-medium text-slate-300"
                        >
                            <label for="roi-employees">
                                Personel Sayısı
                            </label>
                            <span class="text-blue-300">
                                {{ numberFormatter.format(employeeCount) }}
                            </span>
                        </div>
                        <input
                            id="roi-employees"
                            v-model.number="employeeCount"
                            type="range"
                            min="1"
                            max="50"
                            step="1"
                            class="roi-range w-full accent-blue-500"
                        />
                        <p class="mt-1 text-xs text-slate-300">
                            Manuel iş yapan personel
                        </p>
                    </div>

                    <div>
                        <div
                            class="mb-3 flex items-center justify-between text-sm font-medium text-slate-300"
                        >
                            <label for="roi-hours">
                                Günlük Manuel İş (saat / kişi)
                            </label>
                            <span class="text-blue-300">
                                {{ numberFormatter.format(hoursPerDay) }} saat
                            </span>
                        </div>
                        <input
                            id="roi-hours"
                            v-model.number="hoursPerDay"
                            type="range"
                            min="1"
                            max="12"
                            step="1"
                            class="roi-range w-full accent-blue-500"
                        />
                        <p class="mt-1 text-xs text-slate-300">
                            Personel başı kayıp / tekrarlayan iş süresi
                        </p>
                    </div>

                    <div>
                        <div
                            class="mb-3 flex items-center justify-between text-sm font-medium text-slate-300"
                        >
                            <label for="roi-wage">
                                Ortalama Saatlik Ücret
                            </label>
                            <span class="text-blue-300">
                                {{ formatCurrency(hourlyWage) }}
                            </span>
                        </div>
                        <input
                            id="roi-wage"
                            v-model.number="hourlyWage"
                            type="range"
                            min="100"
                            max="1500"
                            step="50"
                            class="roi-range w-full accent-blue-500"
                        />
                        <p class="mt-1 text-xs text-slate-300">
                            Tam yüklenmiş maliyet (₺/saat)
                        </p>
                    </div>

                    <p class="rounded-lg border border-slate-800 bg-slate-950/60 px-4 py-3 text-xs text-slate-300">
                        Mevcut yıllık operasyonel maliyet (tahmini):
                        <span class="font-medium text-slate-300">
                            {{ formatCurrency(currentAnnualCost) }}
                        </span>
                        · %80 otomasyon verimliliği varsayımı ·
                        {{ numberFormatter.format(workingDaysPerYear) }} iş günü
                    </p>
                </div>

                <!-- Sağ: Sonuç -->
                <div
                    class="flex flex-col rounded-2xl border border-slate-800 bg-slate-900 p-6 transition-colors duration-300 hover:border-green-500/60 sm:p-8"
                >
                    <p
                        class="text-sm font-semibold uppercase tracking-wider text-slate-300"
                    >
                        Yıllık Tahmini Tasarrufunuz
                    </p>
                    <p
                        class="mt-4 text-4xl font-bold leading-none text-green-400 sm:text-5xl lg:text-6xl"
                        style="text-shadow: 0 0 40px rgba(74, 222, 128, 0.35)"
                    >
                        {{ formatCurrency(annualSavings) }}
                    </p>
                    <p class="mt-6 text-sm text-slate-300">
                        Sistem kendini ortalama
                        <span class="font-semibold text-white">
                            {{ formatPaybackMonths(paybackMonths) }}
                        </span>
                        ayda amorti eder
                        <span class="text-slate-300">
                            (örnek sistem yatırımı
                            {{ formatCurrency(systemCost) }})
                        </span>
                    </p>

                    <div class="mt-auto pt-10">
                        <Link
                            :href="route('wizard.index')"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-6 py-3.5 text-sm font-semibold text-white shadow-[0_0_28px_rgba(22,163,74,0.35)] transition hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-slate-900 sm:w-auto"
                        >
                            Bu Tasarrufu Gerçeğe Dönüştürün
                        </Link>
                        <p class="mt-3 text-sm text-slate-300 transition-colors">
                            veya aklınıza takılanları
                            <a
                                :href="agency.whatsappUrl"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-green-400 underline transition-colors hover:text-green-400"
                            >
                                WhatsApp uzmanımıza sorun
                            </a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.roi-range {
    height: 0.5rem;
    cursor: pointer;
    appearance: none;
    border-radius: 9999px;
    background: rgb(30 41 59);
}

.roi-range::-webkit-slider-thumb {
    appearance: none;
    height: 1.25rem;
    width: 1.25rem;
    border-radius: 9999px;
    background: rgb(59 130 246);
    box-shadow: 0 0 12px rgba(59, 130, 246, 0.6);
}

.roi-range::-moz-range-thumb {
    height: 1.25rem;
    width: 1.25rem;
    border: none;
    border-radius: 9999px;
    background: rgb(59 130 246);
    box-shadow: 0 0 12px rgba(59, 130, 246, 0.6);
}
</style>
