<script setup>
const technologies = [
    'Laravel 11',
    'Vue 3',
    'Inertia.js',
    'Tailwind CSS',
    'PostgreSQL',
    'AI & LLM Entegrasyonları',
];
</script>

<template>
    <section
        class="border-y border-slate-800/50 bg-slate-900/20 px-4 py-10 sm:px-6 lg:px-8"
    >
        <div class="mx-auto max-w-7xl text-center">
            <p
                class="text-xs font-semibold uppercase tracking-widest text-slate-400"
            >
                Kullandığımız Modern Teknolojiler
            </p>

            <ul
                class="mt-6 flex flex-wrap items-center justify-center gap-6 opacity-70 sm:gap-8"
            >
                <li
                    v-for="tech in technologies"
                    :key="tech"
                    class="text-sm font-medium tracking-wide text-slate-300 transition-opacity duration-200 hover:opacity-100 sm:text-base"
                >
                    {{ tech }}
                </li>
            </ul>
        </div>
    </section>
</template>
