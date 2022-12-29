<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import SubscriptionPlan from '@/Components/SubscriptionPlan.vue';

const props = defineProps({
  subscriptionPlan: Object,
  userSubscription: Object
});
</script>

<template>
    <div>
      {{ subscriptionPlan.name }} at {{ subscriptionPlan.price }} per {{ subscriptionPlan.billing_cycle }} months
    </div>
    <div>
      Started on: {{ userSubscription.start }}
      Ending on: {{ userSubscription.end }}
      Status: {{ userSubscription.active ? "active" : "disabled" }}
      Will renew: {{ userSubscription.renew ? "yes" : "no" }}
    </div>
    <Link :href="route('account.cancel')">
      Cancel
    </Link>
</template>
