<template>
    <div>
        <Button @click="openModal">Open</Button>
        <DialogModal ref="formRef">
            <div>Hello</div>
        </DialogModal>
    </div>
</template>

<script setup>
import Button from "@/components/ui/button/Button.vue";
import DialogModal from "@/js/components/DialogModal.vue";
import { ref } from "vue";

const openModal = () => {
    formRef.value.openDialog();
};

const formRef = ref(null);
</script>
