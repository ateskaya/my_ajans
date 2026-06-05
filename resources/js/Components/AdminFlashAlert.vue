<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const message = computed(() => page.props.flash?.success);
</script>

<template>
    <div
        v-if="message"
        class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800"
        role="alert"
    >
        {{ message }}
    </div>
</template>
