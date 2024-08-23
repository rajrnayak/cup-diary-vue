<template>
    <div>Hello From Modal</div>
</template>

<script setup>
import { ref } from "vue";

const open = ref(false);

const openDialog = () => {
    open.value = true;
};

const closeDialog = () => {
    open.value = false;
};

defineExpose({
    openDialog,
    closeDialog,
});
</script>
