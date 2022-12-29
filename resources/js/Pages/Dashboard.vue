<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Welcome to your Advanced Stream Stats account!</h1>
                        <p>It's good to see you back! You are currently on the <strong>{{ $page.props.auth.subscriptionPlan.name }}</strong> plan.</p>
                    </div>

                    <div class="p-4 text-gray-900">
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                    234 currently watching
                                </div>
                            </div>
                            <div>
                                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                    10,023 total subscribers
                                </div>
                            </div>
                            <div>
                                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                    $234.50 in the last hour
                                </div>
                            </div>
                            <div>
                                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                    400 viewers
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
