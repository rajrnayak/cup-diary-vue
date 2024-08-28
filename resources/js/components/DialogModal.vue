<template>
    <!-- top-[50%] left-[50%]
    translate-x-[-50%] translate-y-[-50%] -->
    <Dialog :open="open">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
            </DialogHeader>
            <div>
                <slot />
            </div>
            <DialogFooter class="sm:justify-start">
                <DialogClose as-child>
                    <Button
                        type="button"
                        variant="secondary"
                        @click="closeDialog"
                    >
                        Close
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import { ref } from "vue";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import Button from "@/components/ui/button/Button.vue";
import Label from "@/components/ui/label/Label.vue";

const props = defineProps(["title"]);

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
