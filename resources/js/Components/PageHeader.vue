<script setup>
defineProps({
    eyebrow: {
        type: String,
        default: '',
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <section class="border-b border-slate-800 px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <p
                v-if="eyebrow"
                class="mb-3 text-sm font-semibold uppercase tracking-widest text-blue-300"
            >
                {{ eyebrow }}
            </p>
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">
                {{ title }}
            </h1>
            <p
                v-if="description"
                class="mt-4 max-w-2xl text-lg text-slate-300"
            >
                {{ description }}
            </p>
        </div>
    </section>
</template>
