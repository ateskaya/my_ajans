<script setup>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});

const page = usePage();
const userName = computed(() => page.props.auth?.user?.name ?? 'Müşteri');

const statusLabels = {
    planlama: 'Planlama',
    gelistirme: 'Geliştirme',
    test: 'Test',
    canli: 'Canlı',
};

const statusBadgeClass = {
    planlama: 'border-slate-600 bg-slate-800/80 text-slate-300',
    gelistirme: 'border-blue-500/40 bg-blue-950/50 text-blue-300 shadow-[0_0_20px_rgba(59,130,246,0.2)]',
    test: 'border-amber-500/40 bg-amber-950/40 text-amber-300',
    canli: 'border-emerald-500/40 bg-emerald-950/40 text-emerald-300 shadow-[0_0_20px_rgba(16,185,129,0.2)]',
};

const typeLabels = {
    genel: 'Genel',
    kilometre_tasi: 'Kilometre Taşı',
    acil: 'Acil',
};

const typeDotClass = {
    genel: 'bg-slate-400',
    kilometre_tasi: 'bg-blue-500',
    acil: 'bg-red-500',
};

const formatDate = (dateString) => {
    if (!dateString) {
        return null;
    }

    return new Date(dateString).toLocaleDateString('tr-TR', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
};

const formatDateTime = (dateString) => {
    if (!dateString) {
        return '—';
    }

    return new Date(dateString).toLocaleString('tr-TR', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Proje Kontrol Merkezi" />

    <ClientLayout>
        <div
            class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between"
        >
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                    Müşteri Vitrini
                </p>
                <h1 class="mt-2 text-3xl font-bold text-white sm:text-4xl">
                    Hoş Geldiniz, {{ userName }}
                </h1>
                <p class="mt-2 text-lg text-slate-400">Proje Kontrol Merkezi</p>
                <p class="mt-3 max-w-2xl text-sm text-slate-500">
                    Projelerinizin güncel durumunu, ilerlemesini ve ekip güncellemelerini
                    şeffaf biçimde buradan takip edebilirsiniz.
                </p>
            </div>
            <Link
                :href="route('wizard.index')"
                class="inline-flex shrink-0 items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_0_24px_rgba(37,99,235,0.4)] transition hover:bg-blue-500"
            >
                + Yeni Proje Talebi
            </Link>
        </div>

        <div
            class="mb-8 flex flex-col gap-4 rounded-xl border border-blue-500/30 bg-blue-950/20 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <p class="text-sm text-slate-300">
                Yeni bir yazılım veya otomasyon projesi mi planlıyorsunuz? 4 adımlık
                sihirbaz ile talebinizi iletin; ekibimiz size özel teklif hazırlasın.
            </p>
            <Link
                :href="route('wizard.index')"
                class="inline-flex shrink-0 items-center justify-center rounded-lg border border-blue-500/50 px-4 py-2 text-sm font-medium text-blue-300 transition hover:bg-blue-900/40 hover:text-white"
            >
                Proje Başlatma Sihirbazı →
            </Link>
        </div>

        <div
            v-if="projects.length === 0"
            class="rounded-2xl border border-slate-800 bg-slate-900/50 px-8 py-16 text-center"
        >
            <p class="text-slate-400">
                Henüz size atanmış bir proje bulunmuyor.
            </p>
            <Link
                :href="route('wizard.index')"
                class="mt-6 inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-500"
            >
                İlk Proje Talebinizi Oluşturun
            </Link>
        </div>

        <div v-else class="space-y-10">
            <article
                v-for="project in projects"
                :key="project.id"
                class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-[0_4px_40px_rgba(0,0,0,0.35)] transition hover:border-slate-700"
            >
                <!-- Üst: başlık, durum, tarih, aksiyonlar -->
                <div
                    class="border-b border-slate-800/80 bg-gradient-to-r from-slate-900 via-slate-900 to-slate-950 px-6 py-6 sm:px-8"
                >
                    <div
                        class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
                    >
                        <div>
                            <h2 class="text-2xl font-bold text-white">
                                {{ project.title }}
                            </h2>
                            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-400">
                                {{ project.description }}
                            </p>
                        </div>

                        <div class="flex shrink-0 flex-col items-start gap-3 sm:items-end">
                            <span
                                class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold uppercase tracking-wide"
                                :class="statusBadgeClass[project.status] ?? statusBadgeClass.planlama"
                            >
                                {{ statusLabels[project.status] ?? project.status }}
                            </span>
                            <p
                                v-if="project.target_date"
                                class="text-xs text-slate-500"
                            >
                                Hedef teslim:
                                <span class="font-medium text-slate-300">
                                    {{ formatDate(project.target_date) }}
                                </span>
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <a
                                    v-if="project.staging_url"
                                    :href="project.staging_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center rounded-lg border border-cyan-500/40 bg-cyan-950/30 px-3 py-1.5 text-xs font-semibold text-cyan-300 transition hover:bg-cyan-900/40"
                                >
                                    Test Ortamını Görüntüle
                                </a>
                                <a
                                    v-if="project.live_url"
                                    :href="project.live_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center rounded-lg border border-emerald-500/40 bg-emerald-950/30 px-3 py-1.5 text-xs font-semibold text-emerald-300 transition hover:bg-emerald-900/40"
                                >
                                    Canlıya Git
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İlerleme -->
                <div class="px-6 py-8 sm:px-8">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-slate-400">Proje İlerlemesi</span>
                        <span class="text-2xl font-bold text-blue-400">
                            %{{ project.progress_percentage }}
                        </span>
                    </div>
                    <div
                        class="mt-4 h-4 overflow-hidden rounded-full bg-slate-800"
                    >
                        <div
                            class="progress-bar-fill h-full rounded-full bg-gradient-to-r from-blue-600 to-cyan-400 shadow-[0_0_24px_rgba(59,130,246,0.5)]"
                            :style="{ width: `${project.progress_percentage}%` }"
                        />
                    </div>
                </div>

                <!-- Timeline -->
                <div class="border-t border-slate-800/80 px-6 py-8 sm:px-8">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
                        Proje Güncellemeleri
                    </h3>

                    <div
                        v-if="!(project.updates?.length)"
                        class="mt-6 text-sm text-slate-500"
                    >
                        Henüz paylaşılmış bir güncelleme yok.
                    </div>

                    <ol
                        v-else
                        class="relative mt-8 space-y-0 border-l border-slate-700/80 pl-8"
                    >
                        <li
                            v-for="update in project.updates"
                            :key="update.id"
                            class="relative pb-10 last:pb-0"
                        >
                            <span
                                class="absolute -left-[2.125rem] top-1.5 flex h-3.5 w-3.5 rounded-full ring-4 ring-slate-900"
                                :class="typeDotClass[update.type] ?? 'bg-slate-400'"
                            />
                            <time class="text-xs text-slate-500">
                                {{ formatDateTime(update.created_at) }}
                            </time>
                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                <h4 class="text-base font-semibold text-white">
                                    {{ update.title }}
                                </h4>
                                <span
                                    class="rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wide text-slate-500"
                                >
                                    {{ typeLabels[update.type] ?? update.type }}
                                </span>
                            </div>
                            <p
                                class="mt-2 whitespace-pre-wrap text-sm leading-relaxed text-slate-400"
                            >
                                {{ update.content }}
                            </p>
                        </li>
                    </ol>
                </div>
            </article>
        </div>
    </ClientLayout>
</template>

<style scoped>
.progress-bar-fill {
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
