<script setup>
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
</script>

<template>
    <Card>
        <CardHeader class="bg-slate-100 p-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center"><slot name="headerLeft" /></div>
                <div class="flex items-center"><slot name="headerRight" /></div>
            </div>
        </CardHeader>
        <CardContent class="p-4"><slot /></CardContent>
    </Card>
</template>
