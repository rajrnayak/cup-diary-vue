<template>
    <div class="mt-10">
        <Card class="sm:mx-auto sm:w-full sm:max-w-sm">
            <CardHeader>
                <CardTitle class="flex justify-center items-center"
                    >Login</CardTitle
                >
            </CardHeader>
            <CardContent>
                <form>
                    <div class="grid items-center w-full gap-4">
                        <div class="flex flex-col space-y-1.5">
                            <Label for="name">Username</Label>
                            <Input
                                id="username"
                                name="username"
                                type="text"
                                autocomplete="username"
                                v-model="fields.username"
                                placeholder="abc"
                            />
                            <Label
                                v-if="errors.username"
                                class="text-red-500 mt-2"
                                >{{ errors.username[0] }}</Label
                            >
                        </div>
                        <div class="flex flex-col space-y-1.5">
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                name="password"
                                type="password"
                                v-model="fields.password"
                                autocomplete="current-password"
                                placeholder="xyz"
                            />
                        </div>
                        <Label
                            v-if="errors.password"
                            class="text-red-500 mt-2"
                            >{{ errors.password[0] }}</Label
                        >
                    </div>
                    <Label v-if="errors.message" class="text-red-500 mt-2">{{
                        errors.message[0]
                    }}</Label>
                </form>
            </CardContent>
            <CardFooter class="flex justify-center items-center">
                <Button @click="handleSubmit">Sign In</Button>
            </CardFooter>
        </Card>
    </div>
    <Toaster richColors position="top-right" />
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
import { ref, reactive } from "vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import axios from "axios";
import { router, usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import { Toaster } from "@/components/ui/sonner";

const { baseUrl } = usePage().props;

const fields = reactive({
    username: "",
    password: "",
});
const errors = ref({});

const handleSubmit = () => {
    axios
        .post(`${baseUrl}/login-post`, fields)
        .then(function (response) {
            router.visit("/");
            toast.success("successfully logged in");
        })
        .catch(function (error) {
            console.log(error.response.data.errors);
            errors.value = error.response.data.errors;
        });
};
</script>

<script>
export default {
    layout: DefaultLayout,
};
</script>
