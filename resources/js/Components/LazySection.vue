<script setup>
import { defineAsyncComponent, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    loader: {
        type: Function,
        required: true,
    },
    minHeight: {
        type: String,
        default: '16rem',
    },
    rootMargin: {
        type: String,
        default: '250px 0px',
    },
});

defineOptions({
    inheritAttrs: true,
});

const root = ref(null);
const show = ref(false);
const AsyncComponent = defineAsyncComponent(props.loader);

let observer;

onMounted(() => {
    if (!('IntersectionObserver' in window)) {
        show.value = true;

        return;
    }

    observer = new IntersectionObserver(
        ([entry]) => {
            if (entry?.isIntersecting) {
                show.value = true;
                observer?.disconnect();
            }
        },
        { rootMargin: props.rootMargin },
    );

    if (root.value) {
        observer.observe(root.value);
    }
});

onUnmounted(() => {
    observer?.disconnect();
});
</script>

<template>
    <div ref="root" :style="!show ? { minHeight } : undefined">
        <component :is="AsyncComponent" v-if="show" v-bind="$attrs" />
    </div>
</template>
