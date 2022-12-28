<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ManageSubscriptionPlan from '@/Components/ManageSubscriptionPlan.vue';
import { Head } from '@inertiajs/inertia-vue3';

defineProps({
  subscriptionPlan: Object,
  userSubscription: Object
});
</script>

<template>
    <Head title="Billing Plan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Billing Plan</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ManageSubscriptionPlan 
                        :subscriptionPlan="subscriptionPlan"
                        :userSubscription="userSubscription"
                        >
                    </ManageSubscriptionPlan>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
