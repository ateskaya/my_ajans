<script setup>
import { useLoop } from '@tresjs/core';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    activeIndex: {
        type: Number,
        default: 0,
    },
    morphT: {
        type: Number,
        default: 0,
    },
    scrollProgress: {
        type: Number,
        default: 0,
    },
    mouse: {
        type: Object,
        default: () => ({ x: 0, y: 0 }),
    },
    projectCount: {
        type: Number,
        default: 1,
    },
});

const indices = computed(() =>
    Array.from({ length: props.projectCount }, (_, i) => i),
);

const meshRefs = ref([]);
const pointLightRef = ref(null);

const projectColors = ['#22d3ee', '#3b82f6', '#a78bfa', '#34d399'];

const geometries = [
    { component: 'TresIcosahedronGeometry', args: [1.1, 1] },
    { component: 'TresTorusGeometry', args: [0.85, 0.32, 48, 24] },
    { component: 'TresBoxGeometry', args: [1.4, 1.4, 1.4] },
    { component: 'TresOctahedronGeometry', args: [1.2, 0] },
];

const scaleForIndex = (index) => {
    const active = props.activeIndex;
    const t = props.morphT;

    if (index === active) {
        return Math.max(0.15, 1 - t * 0.85);
    }

    if (index === active + 1 && active + 1 < props.projectCount) {
        return 0.15 + t * 0.85;
    }

    return 0.001;
};

const positionForIndex = (index) => {
    const offset = (index - props.activeIndex) * 2.2;
    const z = -props.scrollProgress * 1.5;

    return [offset * 0.35, Math.sin(index * 1.2) * 0.4, z];
};

const colorForIndex = (index) =>
    projectColors[index % projectColors.length];

const { onBeforeRender } = useLoop();

onBeforeRender(({ delta }) => {
    meshRefs.value.forEach((mesh, index) => {
        if (
            !mesh ||
            index !== props.activeIndex ||
            scaleForIndex(index) < 0.05
        ) {
            return;
        }

        // Yavaş, sabit hız: ~50 sn'de bir tam tur (dikkat dağıtmayan)
        mesh.rotation.y += delta * 0.12;
        mesh.rotation.x += delta * 0.04;
    });

    if (pointLightRef.value) {
        const targetX = props.mouse.x * 4;
        const targetY = props.mouse.y * 3 + 1;
        pointLightRef.value.position.x +=
            (targetX - pointLightRef.value.position.x) * 0.08;
        pointLightRef.value.position.y +=
            (targetY - pointLightRef.value.position.y) * 0.08;
    }
});

watch(
    () => [props.activeIndex, props.morphT],
    () => {
        meshRefs.value.forEach((mesh, index) => {
            if (!mesh) {
                return;
            }

            const s = scaleForIndex(index);
            mesh.scale.set(s, s, s);
            const [x, y, z] = positionForIndex(index);
            mesh.position.set(x, y, z);
        });
    },
    { immediate: true },
);
</script>

<template>
    <TresPerspectiveCamera :position="[0, 0, 6]" :look-at="[0, 0, 0]" />
    <TresAmbientLight :intensity="0.25" />
    <TresDirectionalLight :position="[4, 6, 5]" :intensity="0.6" />

    <TresPointLight
        ref="pointLightRef"
        :position="[mouse.x * 3, mouse.y * 2 + 1, 3]"
        :intensity="2.5"
        color="#67e8f9"
        :distance="18"
        :decay="2"
    />

    <TresMesh
        v-for="index in indices"
        :key="index"
        :ref="(el) => {
            if (el) meshRefs[index] = el;
        }"
        :position="positionForIndex(index)"
        :scale="[scaleForIndex(index), scaleForIndex(index), scaleForIndex(index)]"
    >
        <TresIcosahedronGeometry
            v-if="geometries[index % geometries.length].component === 'TresIcosahedronGeometry'"
            :args="geometries[index % geometries.length].args"
        />
        <TresTorusGeometry
            v-else-if="geometries[index % geometries.length].component === 'TresTorusGeometry'"
            :args="geometries[index % geometries.length].args"
        />
        <TresBoxGeometry
            v-else-if="geometries[index % geometries.length].component === 'TresBoxGeometry'"
            :args="geometries[index % geometries.length].args"
        />
        <TresOctahedronGeometry
            v-else
            :args="geometries[index % geometries.length].args"
        />
        <TresMeshPhysicalMaterial
            :color="colorForIndex(index)"
            :metalness="0.85"
            :roughness="0.15"
            :clearcoat="1"
            :clearcoat-roughness="0.1"
            :emissive="colorForIndex(index)"
            :emissive-intensity="0.25"
            :transparent="scaleForIndex(index) < 0.2"
            :opacity="Math.max(0.35, scaleForIndex(index))"
        />
    </TresMesh>
</template>
