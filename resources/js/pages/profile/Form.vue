<template>
    <DialogModal ref="dialogRef">
        <div>Hello</div>
    </DialogModal>
</template>

<script setup>
import DialogModal from "@/js/components/DialogModal.vue";
import { ref } from "vue";

const dialogRef = ref(null);

const openModal = () => {
    dialogRef.value.openDialog();
};

defineExpose({
    openModal,
});
</script>
