<script setup>
import ThreeSceneExperience from '@/Components/ThreeSceneExperience.vue';
import { TresCanvas } from '@tresjs/core';
import { onMounted, onUnmounted, ref } from 'vue';

const containerRef = ref(null);
const parallax = ref({ x: 0, y: 0 });

const onMouseMove = (event) => {
    const el = containerRef.value;

    if (!el) {
        return;
    }

    const rect = el.getBoundingClientRect();
    const x = (event.clientX - rect.left) / rect.width - 0.5;
    const y = (event.clientY - rect.top) / rect.height - 0.5;

    parallax.value = {
        x: x * 2,
        y: -y * 2,
    };
};

onMounted(() => {
    window.addEventListener('mousemove', onMouseMove);
});

onUnmounted(() => {
    window.removeEventListener('mousemove', onMouseMove);
});
</script>

<template>
    <div
        ref="containerRef"
        class="pointer-events-none absolute inset-0 z-0 h-full w-full"
        aria-hidden="true"
    >
        <TresCanvas
            clear-color="#020617"
            class="h-full w-full"
            :alpha="false"
        >
            <ThreeSceneExperience :parallax="parallax" />
        </TresCanvas>
    </div>
</template>
