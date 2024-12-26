<script setup lang="ts">
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UserDetailDrawer from "@/MyComponents/UserDetailDrawer.vue";
import { Head } from "@inertiajs/vue3";
import { ElTable } from "element-plus";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    userDatas: {
        type: Object,
        default: () => [],
    },
    auth: {
        type: Object,
        required: true,
    },
});

const checkPermission = (permissionName: string) => {
    return props.auth.user.permissions.some(
        (permission: any) => permission.name === permissionName
    );
};

const currentPage2 = ref(props.userDatas.current_page);
const pageSize2 = ref(props.userDatas.per_page);

const handlePrevChange = (val: number) => {
    router.get(props.userDatas.prev_page_url);
};
const handleNextChange = (val: number) => {
    router.get(props.userDatas.next_page_url);
};
</script>

<template>
    <Head title="User Management" />

    <AuthenticatedLayout>
        <div
            class="py-12 bg-slate-200 text-gray-600 dark:bg-zinc-800 dark:text-gray-100"
        >
            <div class="mx-auto max-w-auto px-4 sm:px-6 lg:px-8">
                <el-card>
                    <template #header>
                        <div class="card-header">
                            <span>User Data</span>
                        </div>
                    </template>

                    <el-table :data="userDatas.data" border class="w-full">
                        <el-table-column type="index" width="50" label="#" />
                        <el-table-column prop="name" label="Name" />
                        <el-table-column prop="email" label="Email" />
                        <el-table-column prop="is_active" label="is Active?">
                            <template #default="scope">
                                <div v-if="scope.row.is_active === 1">
                                    <el-text class="mx-1" type="success"
                                        >Active</el-text
                                    >
                                </div>
                                <div v-if="scope.row.is_active !== 1">
                                    <el-text class="mx-1" type="danger"
                                        >Not Active</el-text
                                    >
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column fixed="right" width="100" label="Menu">
                            <template #default="scope">
                                <div
                                    v-if="
                                        checkPermission(
                                            'update_user_management'
                                        )
                                    "
                                >
                                    <UserDetailDrawer :user="scope.row" />
                                </div>
                            </template>
                        </el-table-column>
                    </el-table>

                    <div class="demo-pagination-block mt-5">
                        <el-pagination
                            v-model:current-page="currentPage2"
                            v-model:page-size="pageSize2"
                            :page-sizes="[5, 10, 50, 100]"
                            :disabled="false"
                            :background="true"
                            layout="prev, pager, next, ->, total"
                            :total="props.userDatas.total"
                            @prev-click="handlePrevChange"
                            @next-click="handleNextChange"
                        />
                    </div>
                </el-card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
