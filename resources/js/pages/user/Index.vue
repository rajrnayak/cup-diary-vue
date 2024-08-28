<template>
    <Card class="sm:mx-auto sm:w-full sm:max-w-md">
        <CardHeader>
            <CardTitle class="flex justify-center items-center"
                >User Form</CardTitle
            >
        </CardHeader>
        <CardContent>
            <form @submit="onSubmit">
                <div class="grid items-center w-full gap-4">
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>Username</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="ab123"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="first_name">
                        <FormItem>
                            <FormLabel>First Name</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="abc"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="last_name">
                        <FormItem>
                            <FormLabel>Last Name</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="xyz"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input
                                    type="email"
                                    placeholder="abc@xyz.com"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="mobile_number">
                        <FormItem>
                            <FormLabel>Mobile Number</FormLabel>
                            <FormControl>
                                <Input
                                    type="text"
                                    placeholder="1234567890"
                                    v-bind="componentField"
                                />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </div>
            </form>
        </CardContent>
        <CardFooter class="flex justify-center items-center">
            <Button type="submit" @click="onSubmit">Submit</Button>
        </CardFooter>
    </Card>
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
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";

import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import { useForm } from "vee-validate";

const formSchema = toTypedSchema(
    z.object({
        username: z.string().min(5).max(20),
        first_name: z.string().max(20),
        last_name: z.string().max(20),
        email: z.string().email(),
        mobile_number: z.string().length(),
    })
);

const form = useForm({
    validationSchema: formSchema,
});

const onSubmit = form.handleSubmit((values) => {
    console.log("form submitted", values);
});
</script>
