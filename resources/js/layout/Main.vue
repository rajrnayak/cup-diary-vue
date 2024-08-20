<script setup>
import { TooltipProvider } from "@/components/ui/tooltip";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
</script>

<template>
    <TooltipProvider>
        <div
            className="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]"
        >
            <Sidebar />
            <div className="flex flex-col">
                <Navbar />
                <main
                    className="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6"
                >
                    <slot />
                </main>
            </div>
        </div>
    </TooltipProvider>
</template>
