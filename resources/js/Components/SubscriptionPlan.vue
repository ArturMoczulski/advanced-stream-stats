<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['plan']);
</script>

<template>
    <Link :href="route('subscription_plans.purchase', { id: plan.id })">
      {{ plan.name }} at {{ plan.price }} per {{ plan.billing_cycle }} months
    </Link>
</template>
