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
                    </div>
                </form>
            </CardContent>
            <CardFooter class="flex justify-center items-center">
                <Button @click="handleSubmit">Sign In</Button>
            </CardFooter>
        </Card>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import Label from "@/components/ui/label/Label.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

const fields = reactive({
    username: "",
    password: "",
});

const handleSubmit = () => {};
</script>

<script>
export default {
    layout: DefaultLayout,
};
</script>
