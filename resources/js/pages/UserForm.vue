<template>
    <div>
        <Modal ref="formModal" :title="user.id ? 'Update User' : 'Create User'" @close-modal="closeModal">
            <div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" v-model="props.user.username" />
                </div>
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" v-model="props.user.first_name" />
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" v-model="props.user.last_name" />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" v-model="props.user.email" />
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Mobile Number</label>
                    <input type="number" maxlength="10" class="form-control" id="number"
                        v-model="props.user.mobile_number" />
                </div>
            </div>
            <template #footer>
                <button type="button" class="btn btn-primary" @click="submit">
                    Submit
                </button>
            </template>
        </Modal>
    </div>
</template>
<script setup>
import { ref } from "vue";
import Modal from "../components/Modal.vue";

const formModal = ref(null);
const props = defineProps(["user"]);
const emit = defineEmits(["handleSubmit", "closeModal"]);

const openForm = () => {
    formModal.value.open();
};

const submit = () => {
    emit("handleSubmit");
    formModal.value.close();
};

const closeModal = () => {
    emit("closeModal");
};

defineExpose({
    openForm,
});
</script>
