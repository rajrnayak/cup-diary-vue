<template>
    <Breadcrumb>
        <BreadcrumbList>
            <BreadcrumbItem v-if="home || homeWithLink" class="text-base">
                <BreadcrumbLink v-if="homeWithLink" as-child>
                    <Link href="/"><Home class="h-4 w-4" /></Link>
                </BreadcrumbLink>
                <BreadcrumbPage v-if="home" class="font-medium"
                    ><Home class="h-4 w-4"
                /></BreadcrumbPage>
            </BreadcrumbItem>
            <BreadcrumbSeparator v-if="(home || homeWithLink) && links" />
            <template v-for="(link, index) in links">
                <BreadcrumbSeparator v-if="index > 0" />
                <BreadcrumbItem class="text-base">
                    <BreadcrumbLink v-if="link.link" as-child>
                        <Link :href="link.link">{{ link.name }}</Link>
                    </BreadcrumbLink>
                    <BreadcrumbPage v-else class="font-medium">{{
                        link.name
                    }}</BreadcrumbPage>
                </BreadcrumbItem>
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>

<script setup>
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb";
import { Link } from "@inertiajs/vue3";
import { Home } from "lucide-vue-next";

const props = defineProps({
    links: {
        type: Array,
        default: null,
    },
    home: {
        type: Boolean,
        default: false,
    },
    homeWithLink: {
        type: Boolean,
        default: false,
    },
});
</script>
