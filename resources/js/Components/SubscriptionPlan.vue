<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['plan']);
</script>

<template>
    <Link :href="route('subscription_plans.purchase', { id: plan.id })">
      <div class="p-4 sm:p-8 bg-sky-100 shadow sm:rounded-lg flow-root hover:bg-sky-200">
        <div class="float-left">
            {{ plan.name }} at {{ plan.price }} per {{ plan.billing_cycle }} months
        </div>
        <div class="float-right ">
          Buy Now
        </div>
      </div>
    </Link>
</template>
