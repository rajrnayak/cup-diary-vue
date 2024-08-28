<template>
    <div class="flex justify-between items-center">
        <div class="header-left flex justify-between items-center gap-2">
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="p-2 flex gap-3">
                        <Label>{{ paginate.perPage }}</Label>
                        <ChevronDown class="w-4 h-4 opacity-50" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-[60px] p-0" align="center">
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <template v-for="(row, index) in perPagesOption">
                            <DropdownMenuItem class="pt-1 hover:bg-gray-100 cursor-pointer"
                                @click="onChangePerPage(row)">{{ row }}</DropdownMenuItem>
                        </template>
                    </DropdownMenuGroup>
                </DropdownMenuContent>
            </DropdownMenu>
            <div v-if="selectColumns">
                <Popover>
                    <PopoverTrigger className="border-1 p-2 rounded-md flex flex-row items-center gap-1">
                        Select Columns
                        <ChevronDown class="h-4 w-4" />
                    </PopoverTrigger>
                    <PopoverContent class="w-70 p-0">
                        <template v-for="(column, index) in columns">
                            <div class="grid grid-cols-3 flex flex-row items-center hover:bg-gray-100 cursor-pointer p-1 px-4"
                                v-if="!column.isAlwaysShow">
                                <Checkbox :id="'select' + column.key"
                                    className="h-5 w-5 border-1 rounded-md border-blue-400 data-[state=checked]:bg-blue-100"
                                    :checked="selectedColumns[column.key]" @update:checked="() =>
                                    (selectedColumns[column.key] =
                                        !selectedColumns[column.key])
                                        " />
                                <Label class="col-span-2 cursor-pointer" :for="'select' + column.key">
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
                <Input type="text" placeholder="Search..."
                    class="border-1 border-grey-500 focus:border-none rounded-r-none"
                    v-model:model-value="searchText" />
                <Button variant="flat" class="border-1 border-black rounded-0 p-3" @click="submitSearchFields">
                    <Search class="h-4 w-4" />
                </Button>
                <Popover>
                    <PopoverTrigger
                        className="p-2 rounded-md rounded-l-none bg-gray-500 text-white flex flex-row items-center">
                        <ChevronDown class="h-4 w-4" />
                    </PopoverTrigger>
                    <PopoverContent class="w-70 p-0">
                        <template v-for="(column, index) in searchFields">
                            <div
                                class="grid grid-cols-3 flex flex-row items-center hover:bg-gray-100 cursor-pointer p-1 px-4">
                                <Checkbox :id="'select' + column.key"
                                    className="h-5 w-5 border-1 rounded-md border-blue-400 data-[state=checked]:bg-blue-100"
                                    :checked="column.isAllowed" @update:checked="() =>
                                    (column.isAllowed =
                                        !column.isAllowed)
                                        " />
                                <Label class="col-span-2 cursor-pointer" :for="'select' + column.key">
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
                    <TableHead v-if="columnSorting && selectedColumns[column.key]" class="p-0 m-0 p-2 bg-gray-100">
                        <div class="flex justify-between items-center">
                            <Label class="text-base">
                                {{ column.name }}
                            </Label>
                            <div v-if="!column.notSorted" @click="() => { column.isSearch = !column.isSearch }">
                                <Search :key="column.key" :tabindex="index" />
                            </div>
                            <div v-if="!column.notSorted" @click="() =>
                                !column.notSorted &&
                                changeSorting(column.key)
                                " class="flex justify-between items-center gap-2">
                                <Label>{{
                                    loadSortedColumnNumber(column.key)
                                    }}</Label>
                                <component :is="loadHeader(column.key)" class="h-4 w-4" />
                            </div>

                        </div>
                    </TableHead>
                    <TableHead v-if="!columnSorting && selectedColumns[column.key]">
                        <Label class="text-base">
                            {{ column.name }}
                        </Label>
                    </TableHead>
                </template>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow>
                <TableCell v-for="(column, index) in columns" :key="column.key">
                    <Input v-if="column.isSearch" type="text" size="10" :id="column.key"
                        v-on:change="event => onChangeSearch(event, column.key, index)" />
                </TableCell>
            </TableRow>
            <TableRow v-for="(row, index) in data">
                <template v-for="(column, index) in columns">
                    <TableCell v-if="selectedColumns[column.key]" class="p-2">
                        <slot :row="row" :column="column" :name="column.renderBody && column.key">
                            {{ row[column.key] }}</slot>
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
            Showing {{ from }} to {{ to }} of
            <b>{{ paginate.total }}</b> Entries
        </div>
        <div class="footerRight">
            <Pagination :paginate="paginate" :totalPage="totalPage" :currentPage="currentPage" @load-data="loadData" />
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import Pagination from "./Pagination.vue";
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
import {
    ArrowDownUp,
    ChevronDown,
    Icon,
    MoveDown,
    MoveUp,
    Search,
    SearchCode,
    SearchSlash,
    SearchXIcon,
} from "lucide-vue-next";
import Button from "@/components/ui/button/Button.vue";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuPortal,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuSubTrigger,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

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
    perPagesOption: {
        type: Array,
        default: [5, 10, 25, 50, 100],
    },
    paginate: {
        type: Object,
        default: {},
    },
    searchFields: {
        type: Array,
        default: [],
    },
    columnSorting: {
        type: Boolean,
        default: false,
    },
    args: {
        type: Object,
        default: {},
    }
});

let currentPage = ref(1);
let searchText = ref("");
let selectedColumns = ref({});
let sortedColumns = ref({
    id: "ASC",
});
let searches = ref({});

const totalPage = computed(() => {
    return Math.ceil(props.paginate.total / props.paginate.perPage)
})

const from = computed(() => {
    return Math.abs(Math.abs((currentPage.value - 1) * props.paginate.perPage) + 1)
})

const to = computed(() => {
    return Math.min(props.paginate.perPage * currentPage.value, props.paginate.total)
})

// const totalPage = ref(Math.ceil(props.paginate.total / props.paginate.perPage))

const loadData = (page) => {
    currentPage.value = page;
    emit("loadData", page, props.paginate.perPage, [], sortedColumns.value);
};

const onChangePerPage = (perPage) => {
    currentPage.value = 1
    emit("loadData", 1, perPage, [], sortedColumns.value);
};

const onChangeSearch = (event, key, index) => {
    searches.value[key] = event.target.value;
    props.columns.map(row => {
        !row.isSearch && delete searches.value[row.key];
    })
    emit("loadData", 1, props.pagination.per_page, searches.value, sortedColumns.value);
    console.log(searches.value, 'search');

}

const submitSearchFields = () => {
    let searchArray = [];
    searchText.value != "" &&
        props.searchFields.forEach((row) => {
            if (row.isAllowed) {
                searchArray.push({ name: row.key, text: searchText.value });
            }
        });
    if (searchText.value != "") {
        currentPage.value = 1
        emit("loadData", 1, props.pagination.per_page, searchArray, sortedColumns.value);
    }
};

const loadSortedColumnNumber = (key) => {
    return sortedColumns.value[key]
        ? Object.keys(sortedColumns.value).indexOf(key) + 1
        : "";
};

const loadHeader = (key) => {
    return sortedColumns.value[key] == "ASC"
        ? MoveUp
        : sortedColumns.value[key] == "DESC"
            ? MoveDown
            : ArrowDownUp;
};

const changeSorting = (key) => {
    if (sortedColumns.value[key] != undefined) {
        sortedColumns.value[key] == "ASC"
            ? (sortedColumns.value[key] = "DESC")
            : delete sortedColumns.value[key];
    } else {
        sortedColumns.value[key] = "ASC";
    }
    currentPage.value = 1
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
