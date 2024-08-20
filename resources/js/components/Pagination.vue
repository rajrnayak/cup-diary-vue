<script setup>
const emit = defineEmits(["loadData"]);
const props = defineProps({
    pagination: {
        type: Object,
        default: {},
        required: true,
    },
});
</script>
<template>
    <div>
        <nav>
            <ul class="pagination">
                <li
                    role="button"
                    class="page-item"
                    @click="
                        () => {
                            pagination.current_page > 1 &&
                                emit('loadData', pagination.current_page - 1);
                        }
                    "
                >
                    <a class="page-link">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <template v-for="(page, index) in pagination.total_page">
                    <li
                        role="button"
                        :class="
                            pagination.current_page == page
                                ? 'page-item active'
                                : 'page-item'
                        "
                        @click="$emit('loadData', page)"
                    >
                        <a class="page-link">
                            {{ page }}
                        </a>
                    </li>
                </template>
                <li
                    role="button"
                    class="page-item"
                    @click="
                        () => {
                            pagination.total_page > pagination.current_page &&
                                emit('loadData', pagination.current_page + 1);
                        }
                    "
                >
                    <a class="page-link">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
