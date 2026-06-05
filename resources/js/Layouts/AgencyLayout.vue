<script setup>
import AiChatWidget from '@/Components/AiChatWidget.vue';
import DeveloperTerminal from '@/Components/DeveloperTerminal.vue';
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-950 text-slate-300">
        <DeveloperTerminal />

        <Navbar />

        <div
            v-if="flashSuccess"
            class="border-b border-emerald-500/30 bg-emerald-950/50 px-4 py-3 text-center text-sm font-medium text-emerald-300"
            role="alert"
        >
            {{ flashSuccess }}
        </div>

        <main class="flex-1">
            <slot />
        </main>

        <Footer />

        <AiChatWidget />
    </div>
</template>
