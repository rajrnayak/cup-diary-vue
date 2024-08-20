<script setup>
import {
    BriefcaseBusiness,
    Coffee,
    Home,
    IndianRupee,
    List,
    Lock,
    User,
    Users,
} from "lucide-vue-next";
import { Link, usePage } from "@inertiajs/vue3";

const { url } = usePage();
const { baseUrl } = usePage().props;

// const links = [
//     {
//         name: "Dashboard",
//         link: "/",
//         icon: <Home className="h-4 w-4" />,
//         permission: true,
//     },
//     {
//         name: "User",
//         link: "/user",
//         icon: <User className="h-4 w-4" />,
//         permission: true,
//     },
// {
//     name: "Vendor",
//     link: "/vendor",
//     icon: <BriefcaseBusiness className="h-4 w-4" />,
//     permission: true,
// },
// {
//     name: "Cup List",
//     link: "/cup-list",
//     icon: <List className="h-4 w-4" />,
//     permission: true,
// },
// {
//     name: "Payment",
//     link: "/payment",
//     icon: <IndianRupee className="h-4 w-4" />,
//     permission: true,
// },
// {
//     name: "Role",
//     link: "/role",
//     icon: <Users className="h-4 w-4" />,
//     permission: true,
// },
// {
//     name: "Permission",
//     link: "/permission",
//     icon: <Lock className="h-4 w-4" />,
//     permission: true,
// },
// ];

// const NavLinkComponent = ({ navLink }) => {
//     const classText =
//         "flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary";
//     return (
//         <>
//             <Link
//                 href={`${baseUrl}${navLink.link}`}
//                 className={`${classText} ${
//                     url == navLink.link
//                         ? "nav-link text-primary"
//                         : "nav-link"
//                 }
//                 `}
//             >
//                 {navLink.icon}
//                 {navLink.name}
//             </Link>
//         </>
//     );
// };
</script>

<template>
    <div class="hidden border-r bg-muted/40 md:block">
        <div class="flex h-full max-h-screen flex-col gap-2">
            <div
                class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6"
            >
                <Link href="/" class="flex items-center gap-2 font-semibold">
                    <Coffee class="h-6 w-6" />
                    <span class="">Cup Diary</span>
                </Link>
            </div>
            <div class="flex-1">
                <nav class="grid items-start px-2 text-sm font-medium lg:px-4">
                    <Link
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary nav-link"
                        href="/"
                    >
                        <Home class="h-4 w-4" />
                        Dashboard
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>
