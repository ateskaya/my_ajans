<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    services: {
        type: Array,
        required: true,
    },
    showPageLink: {
        type: Boolean,
        default: true,
    },
    fullPage: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <section
        id="hizmetler"
        class="border-t border-slate-800 px-4 py-20 sm:px-6 lg:px-8"
        :class="{ 'border-t-0': fullPage }"
    >
        <div class="mx-auto max-w-7xl">
            <div
                v-if="!fullPage"
                class="mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between"
            >
                <div class="text-center md:text-left">
                    <p
                        class="mb-2 text-sm font-semibold uppercase tracking-widest text-blue-400"
                    >
                        Hizmetler
                    </p>
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Uzmanlık Alanlarımız
                    </h2>
                    <p class="mt-3 max-w-2xl text-slate-400">
                        Görsel odaklı kartlarla hizmetlerimizi keşfedin.
                    </p>
                </div>
                <Link
                    v-if="showPageLink"
                    :href="route('services.index')"
                    class="shrink-0 text-center text-sm font-medium text-blue-400 transition hover:text-blue-300"
                >
                    Tüm hizmetler →
                </Link>
            </div>

            <div
                class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                :class="fullPage ? 'lg:gap-10' : ''"
            >
                <article
                    v-for="service in services"
                    :key="service.id"
                    class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 transition-all duration-300 hover:border-blue-500/50 hover:shadow-[0_0_40px_rgba(59,130,246,0.12)]"
                >
                    <img
                        v-if="service.image_url"
                        :src="service.image_url"
                        :alt="service.title"
                        class="h-48 w-full object-cover opacity-80 transition-opacity duration-300 group-hover:opacity-100"
                        loading="lazy"
                    />
                    <div
                        v-else
                        class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-slate-800 via-slate-900 to-blue-950/40"
                        aria-hidden="true"
                    >
                        <span class="text-xs font-medium uppercase tracking-widest text-slate-500">
                            Görsel yok
                        </span>
                    </div>

                    <div class="relative px-6">
                        <div
                            v-if="service.icon_svg"
                            class="absolute -top-6 left-6 flex h-12 w-12 items-center justify-center rounded-xl border border-slate-700 bg-slate-950 shadow-lg shadow-blue-900/20"
                            v-html="service.icon_svg"
                        />
                    </div>

                    <div class="px-6 pb-6 pt-10">
                        <h3 class="mb-3 text-xl font-bold text-white">
                            {{ service.title }}
                        </h3>
                        <p class="line-clamp-3 text-slate-400">
                            {{ service.excerpt }}
                        </p>
                        <p
                            v-if="fullPage && service.description"
                            class="mt-3 line-clamp-4 text-sm leading-relaxed text-slate-500"
                        >
                            {{ service.description }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
