<template>
    <div class="hidden border-r   overflow-hidden bg-muted/40 md:block">
        <div class="flex h-full  max-h-screen flex-col gap-2">
            <div
                class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6"
            >
                <Link href="/" class="flex items-center gap-2 font-semibold">
                    <Coffee class="h-6 w-6" />
                    <span class="ps-3">Cup Diary</span>
                </Link>
            </div>
            <div class="flex-1">
                <nav class="grid items-start px-2 text-sm font-medium lg:px-4">
                    <template v-for="(link, index) in links">
                        <Link
                            v-if="link.permission"
                            :href="link.link"
                            :className="[
                                classText,
                                url == link.link
                                    ? 'nav-link text-primary'
                                    : 'nav-link',
                            ]"
                        >
                            <component :is="link.icon" />
                            {{ link.name }}
                        </Link>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>
<script setup>
import {
    ArrowLeftRightIcon,
    BriefcaseBusiness,
    Coffee,
    Home,
    Icon,
    IndianRupee,
    List,
    Lock,
    User,
    Users,
} from "lucide-vue-next";
import { Link, usePage } from "@inertiajs/vue3";

const { url } = usePage();
// const { url } = usePage();
const { givenPermissions } = usePage().props;

const links = [
    {
        name: "Dashboard",
        link: "/",
        icon: Home,
        permission: givenPermissions.admin_dashboard,
    },
    {
        name: "User",
        link: "/user",
        icon: User,
        permission: givenPermissions.user_view,
    },
    {
        name: "Vendor",
        link: "/vendor",
        icon: BriefcaseBusiness,
        permission: givenPermissions.vendor_view,
    },
    {
        name: "Cup List",
        link: "/cup-list",
        icon: List,
        permission: givenPermissions.cupList_view,
    },
    {
        name: "Payment",
        link: "/payment",
        icon: IndianRupee,
        permission: givenPermissions.payment_view,
    },
    {
        name: "Role",
        link: "/role",
        icon: Users,
        permission: givenPermissions.role_view,
    },
    {
        name: "Permission",
        link: "/permission",
        icon: Lock,
        permission: true,
    },
];
const classText =
    "flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary";
</script>
