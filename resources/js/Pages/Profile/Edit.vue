<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/inertia-vue3';
import CardComponent from "@/Components/CardComponent.vue";

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <CardComponent
                    head-text="Main information:"
                >
                    Your role: {{ $page.props.auth.user.role_name }}
                </CardComponent>

                <CardComponent>

                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </CardComponent>

                <CardComponent>
                    <UpdatePasswordForm class="max-w-xl" />
                </CardComponent>

                <CardComponent>
                    <DeleteUserForm class="max-w-xl" />
                </CardComponent>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
