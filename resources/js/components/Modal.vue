<script setup>
import { onMounted, ref } from "vue";

const props = defineProps(["title"]);
const emit = defineEmits(["closeModal"]);
const formModal = ref(null);

const open = () => {
    formModal.value.show();
};

const close = () => {
    formModal.value.hide();
    emit("closeModal");
};

onMounted(() => {
    // formModal.value = new Modal(document.getElementById("formModal"));
    formModal.value = new bootstrap.Modal(document.getElementById("formModal"));
});

defineExpose({
    open,
    close,
});
</script>

<template>
    <div>
        <div
            class="modal fade"
            id="formModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            {{ props.title }}
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            @click="close"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer" />
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="close"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
