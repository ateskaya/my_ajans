<script setup>
import { useLoop } from '@tresjs/core';
import { ref, watch } from 'vue';

const props = defineProps({
    parallax: {
        type: Object,
        default: () => ({ x: 0, y: 0 }),
    },
});

const meshRef = ref(null);

const { onBeforeRender } = useLoop();

onBeforeRender(({ elapsed }) => {
    if (!meshRef.value) {
        return;
    }

    meshRef.value.rotation.x = elapsed * 0.25 + props.parallax.y * 0.12;
    meshRef.value.rotation.y = elapsed * 0.45 + props.parallax.x * 0.12;
    meshRef.value.position.x = props.parallax.x * 0.35;
    meshRef.value.position.y = props.parallax.y * 0.25;
});

watch(
    () => props.parallax,
    () => {
        if (!meshRef.value) {
            return;
        }

        meshRef.value.position.x = props.parallax.x * 0.35;
        meshRef.value.position.y = props.parallax.y * 0.25;
    },
    { deep: true },
);
</script>

<template>
    <TresPerspectiveCamera :position="[3, 3, 3]" :look-at="[0, 0, 0]" />
    <TresAmbientLight :intensity="0.35" />
    <TresDirectionalLight :position="[6, 8, 4]" :intensity="1.8" />

    <TresMesh ref="meshRef">
        <TresTorusKnotGeometry :args="[1, 0.32, 200, 32, 2, 3]" />
        <TresMeshStandardMaterial
            color="#22d3ee"
            :metalness="0.8"
            :roughness="0.2"
            :emissive="'#0e7490'"
            :emissive-intensity="0.35"
        />
    </TresMesh>
</template>
