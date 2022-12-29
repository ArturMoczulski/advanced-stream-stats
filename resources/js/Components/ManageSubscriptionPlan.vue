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
      <div>
        Status: {{ userSubscription.active ? "active" : "disabled" }}
      </div>
      <div>
        Started on: {{ userSubscription.start }}
      </div>
      <div v-if="userSubscription.renew">
        Renewing on: {{ userSubscription.end }}
      </div>
      <div v-if="!userSubscription.renew">
        Ending on: {{ userSubscription.end }}
      </div>
    </div>
    <Link :href="route('account.cancel')" v-if="userSubscription.renew">
      Cancel
    </Link>
</template>
