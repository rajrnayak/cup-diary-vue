<script setup>
import { computed, onMounted, ref } from "vue";
import Pagination from "./Pagination.vue";

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
<template>
    <div class="d-flex justify-content-between align-items-center">
        <div
            class="header-left d-flex justify-content-between align-items-center gap-2"
        >
            <div>
                <select
                    class="form-select"
                    aria-label="Default select example"
                    :value="pagination.per_page"
                    @change="
                        (e) => {
                            emit(
                                'loadData',
                                pagination.current_page,
                                e.target.value
                            );
                        }
                    "
                >
                    <template v-for="(row, index) in perPages">
                        <option :value="row">{{ row }}</option>
                    </template>
                </select>
            </div>
            <div v-if="selectColumns" class="dropdown">
                <button
                    class="btn btn-outline-secondary dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    Columns
                </button>
                <ul class="dropdown-menu m-0 p-0 p-1">
                    <li v-for="(column, index) in columns">
                        <div
                            v-if="!column.isAlwaysShow"
                            class="d-flex gap-3 ms-3"
                        >
                            <input
                                type="checkbox"
                                :id="'select' + column.key"
                                v-model="selectedColumns[column.key]"
                            />
                            <label
                                class="form-check-label"
                                :for="'select' + column.key"
                                >{{ column.name }}</label
                            >
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header-right">
            <div class="btn-group">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Search..."
                    v-model="searchText"
                />
                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    @click="submitSearchFields"
                >
                    Search
                </button>
                <button
                    type="button"
                    class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu m-0 p-0 p-1">
                    <li v-for="(column, index) in searchFields">
                        <div class="d-flex gap-3 ms-3">
                            <input
                                type="checkbox"
                                :id="'search' + column.key"
                                v-model="column.isAllowed"
                            />
                            <label
                                class="form-check-label"
                                :for="'search' + column.key"
                                >{{ column.name }}</label
                            >
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <table class="table my-2">
        <thead class="table-light">
            <tr>
                <template v-for="(column, index) in columns">
                    <th v-if="selectedColumns[column.key] && !columnSorting">
                        {{ column.name }}
                    </th>
                    <th v-if="selectedColumns[column.key] && columnSorting">
                        <div
                            class="d-flex justify-content-between"
                            @click="() => changeSorting(column.key)"
                        >
                            <div>
                                {{ column.name }}
                            </div>
                            <div v-if="!column.notSorted">
                                {{ loadHeader(column.key) }}
                            </div>
                        </div>
                    </th>
                </template>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, index) in data">
                <template v-for="(column, index) in columns">
                    <td v-if="selectedColumns[column.key]">
                        <slot
                            :row="row"
                            :column="column"
                            :name="column.renderBody && column.key"
                        >
                            {{ row[column.key] }}</slot
                        >
                    </td>
                </template>
            </tr>
            <tr v-if="data.length == 0">
                <td colspan="5" class="text-center">No Data</td>
            </tr>
        </tbody>
    </table>
    <div class="d-flex justify-content-between">
        <div class="footer-left">
            {{ pagination.from }} - {{ pagination.to }} of
            {{ pagination.total }} entries.
        </div>
        <div class="footer-right">
            <Pagination :pagination="pagination" @load-data="loadData" />
        </div>
    </div>
</template>
