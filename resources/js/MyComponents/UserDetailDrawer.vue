<script lang="ts" setup>
import {
    ElButton,
    ElMessageBox,
    ComponentSize,
    FormInstance,
    FormRules,
} from "element-plus";
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Swal from 'sweetalert2'

interface RuleForm {
    name: string;
    email: string;
    is_active: number;
}

const props = defineProps({
    user: {
        type: Array,
        default: () => [],
    },
});

const dialogFormVisible = ref(false);
const formLabelWidth = "140px";
const formSize = ref<ComponentSize>("default");
const formData = useForm({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    is_active: props.user.is_active === 1 ? true : false,
});

// Actions
const handleClose = async (done: () => void) => {
    try {
        await ElMessageBox.confirm("Are you sure to close this ?");
        done();
    } catch {
        // User cancelled
    }
};

const cancelClick = () => {
    dialogFormVisible.value = false;
};

const confirmClick = async () => {
    try {
        await ElMessageBox.confirm(
            `Are you confirm update ${formData.name} data ?`
        ).then(() =>
            formData.patch(route("manage.user.update"), {
                onSuccess: () => Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).fire({
                        icon: "success",
                        title: "Updated Successfully!",
                    }),
                  })
        );
        dialogFormVisible.value = false
    } catch {
        // User cancelled
    }
};
</script>

<template>
    <el-button plain @click="dialogFormVisible = true"> Detail </el-button>

    <el-dialog
        v-model="dialogFormVisible"
        :direction="direction"
        :before-close="handleClose"
        class="w-screen"
        title="Detail or Update User Data"
        :show-close="false"
    >
        <el-form class="w-full" label-width="auto" :size="formSize" status-icon>
            <el-form-item label="Username" prop="name">
                <el-input v-model="formData.name" />
            </el-form-item>

            <el-form-item label="Email" prop="email">
                <el-input v-model="formData.email" />
            </el-form-item>

            <el-form-item label="is Active?" prop="is_active">
                <el-switch v-model="formData.is_active" />
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button type="primary" @click="confirmClick">
                    Confirm Update
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>
