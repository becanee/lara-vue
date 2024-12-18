<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 text-gray-600 dark:text-gray-100 bg-slate-200 dark:bg-zinc-800">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <el-card style="width: 100%">
                    <template #header>
                        <div class="card-header">
                            <span>Card</span>
                        </div>
                    </template>
                    <p v-for="o in 4" :key="o" class="text item">
                        {{ "List item " + o }}
                    </p>
                    <template #footer>Footer</template>
                </el-card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
