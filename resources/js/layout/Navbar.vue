<template>
    <header className="flex h-14 items-center gap-4 border-b bg-muted/40 px-4 lg:h-[60px] lg:px-6 flex justify-end">
        <!-- <Sheet>
                <SheetTrigger asChild>
                    <Button
                        variant="outline"
                        size="icon"
                        className="shrink-0 md:hidden"
                    >
                        <Menu className="h-5 w-5" />
                        <span className="sr-only">Toggle navigation menu</span>
                    </Button>
                </SheetTrigger>
                <SheetContent side="left" className="flex flex-col">
                    <nav className="grid gap-2 text-lg font-medium">
                        <Link
                            href="#"
                            className="flex items-center gap-2 text-lg font-semibold"
                        >
                            <Package2 className="h-6 w-6" />
                            <span className="sr-only">Acme Inc</span>
                        </Link>
                        <Link
                            href="#"
                            className="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                        >
                            <Home className="h-5 w-5" />
                            Dashboard
                        </Link>
                        <Link
                            href="#"
                            className="mx-[-0.65rem] flex items-center gap-4 rounded-xl bg-muted px-3 py-2 text-foreground hover:text-foreground"
                        >
                            <ShoppingCart className="h-5 w-5" />
                            Orders
                            <Badge className="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full">
                                6
                            </Badge>
                        </Link>
                        <Link
                            href="#"
                            className="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                        >
                            <Package className="h-5 w-5" />
                            Products
                        </Link>
                        <Link
                            href="#"
                            className="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                        >
                            <Users className="h-5 w-5" />
                            Customers
                        </Link>
                        <Link
                            href="#"
                            className="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                        >
                            <LineChart className="h-5 w-5" />
                            Analytics
                        </Link>
                    </nav>
                    <div className="mt-auto">
                        <Card>
                            <CardHeader>
                                <CardTitle>Upgrade to Pro</CardTitle>
                                <CardDescription>
                                    Unlock all features and get unlimited access
                                    to our support team.
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <Button size="sm" className="w-full">
                                    Upgrade
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </SheetContent>
            </Sheet> -->
        <div className="w-full flex-1">
            <div className="relative">
                <slot name="toggle" />
            </div>
        </div>
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button variant="outline" size="icon" className="rounded-full">
                    <CircleUser className="h-5 w-5" />
                    <span className="sr-only">Toggle user menu</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>My Account</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <Link href="/profile">
                <DropdownMenuItem>Profile</DropdownMenuItem>
                </Link>
                <Link href="/logout">
                <DropdownMenuItem>Logout</DropdownMenuItem>
                </Link>
                <DropdownMenuSeparator />
            </DropdownMenuContent>
        </DropdownMenu>
    </header>
</template>
<script setup>
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { Button } from "@/components/ui/button";
import { ArrowLeftRightIcon, CircleUser } from "lucide-vue-next";
import { Link, usePage } from "@inertiajs/vue3";

const { url } = usePage();
const { baseUrl } = usePage().props;
</script>
