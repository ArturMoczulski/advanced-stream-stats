<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['plan']);
</script>

<template>
    <Link :href="route('dashboard')">
      {{ plan.name }} at {{ plan.price }} per {{ plan.billing_cycle }} months
    </Link>
</template>
