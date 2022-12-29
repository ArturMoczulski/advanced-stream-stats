<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SubscriptionPlan from '@/Components/SubscriptionPlan.vue';
import { Head } from '@inertiajs/inertia-vue3';

defineProps({
    plans: Array,
});
</script>

<template>
    <Head title="Purchase Subscription" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Purchase Subscription</h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="mb-4" v-for="plan in plans">
                        <SubscriptionPlan :plan="plan"></SubscriptionPlan>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
