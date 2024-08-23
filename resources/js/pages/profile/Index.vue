<template>
    <div>
        <Card class="mx-auto max-w-md w-100">
            <CardHeader>
                <div class="flex flex-row justify-between items-center">
                    <CardTitle class="text-2xl">Profile</CardTitle>
                    <Edit class="h-6 w-6 hover:cursor-pointer" />
                </div>
            </CardHeader>
            <CardContent>
                <div class="flex flex-col items-center gap-1">
                    <img
                        src="c:\laragon\www\cup-diary\public\storage\images\profile\default-profile.jpeg"
                        height="110"
                        class="border-1 w-25 rounded-full"
                    />
                    <Label class="text-3xl">{{ user.username }}</Label>
                    <span
                        class="rounded-md items-center bg-green-50 mt-1 px-3 py-1 text-lg font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                    >
                        <Label class="text-md">{{ user.role_name }}</Label>
                    </span>
                    <Separator class="my-2 border-1" />
                </div>
                <div class="grid gap-4 mt-2">
                    <div class="grid grid-cols-2 gap-3 items-center">
                        <Label class="text-md font-bold">Name</Label>
                        <Label>
                            {{ user.first_name }} {{ user.last_name }}
                        </Label>
                    </div>
                    <div class="grid grid-cols-2 gap-3 items-center">
                        <Label class="text-md font-bold"> Mobile Number </Label>
                        <Label>{{ user.mobile_number }}</Label>
                    </div>
                    <div class="grid grid-cols-2 gap-3 items-center">
                        <Label class="text-md font-bold">Email</Label>
                        <Label>{{ user.email }}</Label>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
    <Form />
</template>

<script setup>
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Edit } from "lucide-vue-next";
import Label from "@/components/ui/label/Label.vue";
import { Separator } from "@/components/ui/separator";
import { reactive, ref } from "vue";
import Form from "./Form.vue";

const user = reactive({
    username: "admin",
    role_name: "Admin",
    first_name: "Raj",
    last_name: "Nayak",
    mobile_number: 9876543210,
    email: "admin@test.com",
});
</script>
