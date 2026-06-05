<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-enterprise-bg bg-enterprise-gradient pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-accent" />
            </Link>
        </div>

        <div
            class="card-enterprise mt-6 w-full overflow-hidden sm:max-w-md"
        >
            <slot />
        </div>
    </div>
</template>
