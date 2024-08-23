<script setup>
import { TooltipProvider } from "@/components/ui/tooltip";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import { ArrowLeftRightIcon } from "lucide-vue-next";
import { ref } from 'vue'

let toggleRef = ref(true);

function changeToggle(){
    toggleRef.value = !toggleRef.value
}
</script>

<template>
    <TooltipProvider>
        <div class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
            <Sidebar :toggleRef="toggleRef" />
            <div class="flex flex-col">
                <Navbar>
                    <template #toggle>
                        <ArrowLeftRightIcon @click="changeToggle" />
                    </template>
                </Navbar>
                <main class="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6">
                    <slot />
                </main>
            </div>
        </div>
    </TooltipProvider>
</template>
