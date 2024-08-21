<template>
    <div class="flex justify-between items-center">
        <div class="header-left flex justify-between items-center gap-2">
            <div>
                <Select v-bind="pagination.per_page">
                    <SelectTrigger>
                        <SelectValue
                            :placeholder="pagination.per_page.toString()"
                        />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <template v-for="(row, index) in perPages">
                                <SelectItem :value="row.toString()">
                                    {{ row }}
                                </SelectItem>
                            </template>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </div>
            <div v-if="selectColumns">
                <Popover>
                    <PopoverTrigger
                        className="border-1 p-2 rounded-md flex flex-row items-center gap-1"
                    >
                        Select Columns
                        <ChevronDown class="h-4 w-4" />
                    </PopoverTrigger>
                    <PopoverContent class="w-70 p-0">
                        <template v-for="(column, index) in columns">
                            <div
                                class="grid grid-cols-3 flex flex-row items-center hover:bg-gray-100 cursor-pointer p-1 px-4"
                                v-if="!column.isAlwaysShow"
                            >
                                <Checkbox
                                    :id="'select' + column.key"
                                    className="h-5 w-5 border-1 rounded-md border-blue-400 data-[state=checked]:bg-blue-100"
                                    :checked="selectedColumns[column.key]"
                                    @update:checked="
                                        () =>
                                            (selectedColumns[column.key] =
                                                !selectedColumns[column.key])
                                    "
                                />
                                <Label
                                    class="col-span-2 cursor-pointer"
                                    :for="'select' + column.key"
                                >
                                    {{ column.name }}
                                </Label>
                            </div>
                        </template>
                    </PopoverContent>
                </Popover>
            </div>
        </div>
        <div class="header-right">
            <div class="btn-group">
                <Input
                    type="text"
                    placeholder="Search..."
                    class="border-1 border-grey-500 focus:border-none rounded-r-none"
                    v-model:model-value="searchText"
                />
                <Button
                    variant="flat"
                    class="border-1 border-black rounded-0 p-3 focus:border-none"
                    @click="submitSearchFields"
                >
                    <Search class="h-4 w-4" />
                </Button>
                <Popover>
                    <PopoverTrigger
                        className="p-2 rounded-md rounded-l-none bg-gray-500 text-white flex flex-row items-center"
                    >
                        <ChevronDown class="h-4 w-4" />
                    </PopoverTrigger>
                    <PopoverContent class="w-70 p-0">
                        <template v-for="(column, index) in searchFields">
                            <div
                                class="grid grid-cols-3 flex flex-row items-center hover:bg-gray-100 cursor-pointer p-1 px-4"
                            >
                                <Checkbox
                                    :id="'select' + column.key"
                                    className="h-5 w-5 border-1 rounded-md border-blue-400 data-[state=checked]:bg-blue-100"
                                    :checked="column.isAllowed"
                                    @update:checked="
                                        () =>
                                            (column.isAllowed =
                                                !column.isAllowed)
                                    "
                                />
                                <Label
                                    class="col-span-2 cursor-pointer"
                                    :for="'select' + column.key"
                                >
                                    {{ column.name }}
                                </Label>
                            </div>
                        </template>
                    </PopoverContent>
                </Popover>
            </div>
        </div>
    </div>
    <Table class="my-3 border-1">
        <TableHeader>
            <TableRow>
                <template v-for="(column, index) in columns">
                    <TableHead
                        v-if="columnSorting && selectedColumns[column.key]"
                        class="p-0 m-0 p-2 bg-gray-100"
                    >
                        <div
                            class="flex justify-between items-center"
                            @click="
                                () =>
                                    !column.notSorted &&
                                    changeSorting(column.key)
                            "
                        >
                            <Label class="text-base">
                                {{ column.name }}
                            </Label>
                            <div v-if="!column.notSorted">
                                {{ loadHeader(column.key) }}
                            </div>
                        </div>
                    </TableHead>
                    <TableHead
                        v-if="!columnSorting && selectedColumns[column.key]"
                    >
                        <Label class="text-base">
                            {{ column.name }}
                        </Label>
                    </TableHead>
                </template>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="(row, index) in data">
                <template v-for="(column, index) in columns">
                    <TableCell v-if="selectedColumns[column.key]" class="p-2">
                        <slot
                            :row="row"
                            :column="column"
                            :name="column.renderBody && column.key"
                        >
                            {{ row[column.key] }}</slot
                        >
                    </TableCell>
                </template>
            </TableRow>
            <TableRow v-if="data.length == 0">
                <TableCell colspan="5" class="text-center">No Data</TableCell>
            </TableRow>
        </TableBody>
    </Table>
    <div class="flex justify-between items-center">
        <div class="footerLeft">
            {{ pagination.from }} - {{ pagination.to }} of
            {{ pagination.total }} entries.
        </div>
        <div class="footerRight">
            <Pagination :pagination="pagination" @load-data="loadData" />
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import Pagination from "./Pagination.vue";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import Label from "@/components/ui/label/Label.vue";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { ChevronDown, Search } from "lucide-vue-next";
import Button from "@/components/ui/button/Button.vue";

const emit = defineEmits(["loadData"]);
const props = defineProps({
    data: {
        type: Array,
        default: [],
        required: true,
    },
    columns: {
        type: Array,
        default: [],
        required: true,
    },
    pagination: {
        type: Object,
        default: {},
    },
    selectColumns: {
        type: Boolean,
        default: false,
    },
    perPages: {
        type: Array,
        default: [],
    },
    searchFields: {
        type: Array,
        default: [],
    },
    columnSorting: {
        type: Boolean,
        default: false,
    },
});

let searchText = ref("");
let selectedColumns = ref({});
let sortedColumns = ref({
    id: "ASC",
});

const loadData = (page) => {
    emit("loadData", page);
};

const submitSearchFields = () => {
    let searchArray = [];
    searchText.value != "" &&
        props.searchFields.forEach((row) => {
            if (row.isAllowed) {
                searchArray.push({ name: row.key, text: searchText.value });
            }
        });
    emit("loadData", 1, props.pagination.per_page, searchArray);
};

const loadHeader = (key) => {
    let icon = "";
    icon += sortedColumns.value[key]
        ? Object.keys(sortedColumns.value).indexOf(key) + 1
        : "";
    icon +=
        sortedColumns.value[key] == "ASC"
            ? "A"
            : sortedColumns.value[key] == "DESC"
            ? "D"
            : "N";
    return icon;
};

const changeSorting = (key) => {
    if (sortedColumns.value[key] != undefined) {
        sortedColumns.value[key] == "ASC"
            ? (sortedColumns.value[key] = "DESC")
            : delete sortedColumns.value[key];
    } else {
        sortedColumns.value[key] = "ASC";
    }

    emit("loadData", 1, props.pagination.per_page, [], sortedColumns.value);
};

onMounted(() => {
    props.selectColumns &&
        props.columns.forEach((column) => {
            selectedColumns.value[column.key] =
                !selectedColumns.value[column.key];
        });
});
</script>
