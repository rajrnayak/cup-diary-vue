<script setup>
import { onMounted, reactive, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import Card from "../components/Card.vue";
import DataTable from "../components/DataTable.vue";
import UserForm from "./UserForm.vue";

const { baseUrl } = usePage().props;

const users = ref([]);
const user = ref({
    id: null,
    username: "",
    first_name: "",
    last_name: "",
    email: "",
    mobile_number: "1234567890",
});
const formRef = ref(null);

let pagination = reactive({
    current_page: 1,
    per_page: 5,
    total_page: 0,
    from: 0,
    to: 0,
    total: 0,
});

const columns = [
    { key: "id", name: "Id" },
    { key: "username", name: "Username" },
    { key: "first_name", name: "First Name" },
    { key: "last_name", name: "Last Name" },
    { key: "email", name: "Email" },
    {
        key: "action",
        name: "Action",
        renderBody: true,
        isAlwaysShow: true,
        notSorted: true,
    },
];

let searchFields = reactive([
    { key: "username", name: "Username", isAllowed: true },
    { key: "first_name", name: "First Name", isAllowed: true },
    { key: "last_name", name: "Last Name", isAllowed: true },
    { key: "email", name: "Email", isAllowed: true },
]);

const loadData = async (
    page,
    perPage = pagination.per_page,
    searchArray = [],
    sortedColumns = {}
) => {
    await axios
        .post(`${baseUrl}/user/load-data`, {
            per_page_number: perPage,
            page_number: page,
            search_fields: searchArray,
            sorting_columns: sortedColumns,
        })
        .then((response) => {
            users.value = response.data.data;
            pagination = {
                current_page: page,
                per_page: perPage,
                total_page: response.data.last_page,
                from: response.data.from,
                to: response.data.to,
                total: response.data.total,
            };
        })
        .catch((error) => {
            console.log(error);
        });
};

const openFormModal = (value) => {
    if (value) {
        user.value = value;
    }
    formRef.value.openForm();
};

const handleSubmit = () => {
    let data = user.value;
    let fullUrl = user.value.id
        ? `${baseUrl}/user/store-or-update/${user.value.id}`
        : `${baseUrl}/user/store-or-update`;

    axios
        .post(fullUrl, data)
        .then((response) => {
            loadData(pagination.current_page);
            console.log(response.data.message);
            closeModal();
        })
        .catch(function (error) {
            console.log(error.response);
            closeModal();
        });
};

const destroy = (id) => {
    axios
        .get(`user/destroy/${id}`)
        .then((response) => {
            loadData(pagination.current_page);
        })
        .catch(function (error) {
            console.log(error.response);
        });
};

const closeModal = () => {
    user.value = {
        id: null,
        username: "",
        first_name: "",
        last_name: "",
        email: "",
        mobile_number: "1234567890",
    };
};

onMounted(() => {
    loadData(pagination.current_page);
});
</script>
<template>
    <div class="container mt-3">
        <Card>
            <template #header>
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="m-0 p-0">Users</h3>
                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        @click="openFormModal"
                    >
                        Add User
                    </button>
                </div>
            </template>
            <DataTable
                :data="users"
                :columns="columns"
                :pagination="pagination"
                :per-pages="[5, 10, 25, 50, 100]"
                :search-fields="searchFields"
                selectColumns
                columnSorting
                @load-Data="loadData"
            >
                <template #action="actionProps">
                    <div class="d-flex gap-1">
                        <button
                            type="button"
                            class="btn btn-outline-success"
                            @click="() => openFormModal(actionProps.row)"
                        >
                            Edit</button
                        ><button
                            type="button"
                            class="btn btn-outline-danger"
                            @click="() => destroy(actionProps.row.id)"
                        >
                            Delete
                        </button>
                    </div>
                </template>
            </DataTable>
        </Card>
        <UserForm
            ref="formRef"
            :user="user"
            @handle-submit="handleSubmit"
            @close-modal="closeModal"
        />
    </div>
</template>
