<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import SubscriptionPlan from '@/Components/SubscriptionPlan.vue';

const props = defineProps({
  subscriptionPlan: Object,
  userSubscription: Object
});
</script>

<template>
    <div class="mb-4">
      {{ subscriptionPlan.name }} at {{ subscriptionPlan.price }} per {{ subscriptionPlan.billing_cycle }} months
    </div>
    <div class="mb-4">
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
      <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full">
        Cancel
      </button>
    </Link>
</template>
