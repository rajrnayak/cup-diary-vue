<template>
    <div>
        <Pagination
            :total="pagination.total"
            :sibling-count="1"
            :items-per-page="pagination.per_page"
            :default-page="pagination.current_page"
            show-edges
        >
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <PaginationFirst @click="$emit('loadData', 1)" />
                <PaginationPrev
                    @click="$emit('loadData', pagination.current_page - 1)"
                />

                <template v-for="(item, index) in items">
                    <PaginationListItem
                        v-if="item.type === 'page'"
                        :key="index"
                        :value="item.value"
                        as-child
                    >
                        <Button
                            class="w-10 h-10 p-0"
                            :variant="
                                item.value === pagination.current_page
                                    ? 'default'
                                    : 'outline'
                            "
                            @click="item.value != pagination.current_page && $emit('loadData', item.value)"
                        >
                            {{ item.value }}
                        </Button>
                    </PaginationListItem>
                    <PaginationEllipsis
                        v-else
                        :key="item.type"
                        :index="index"
                    />
                </template>

                <PaginationNext
                    @click="$emit('loadData', pagination.current_page + 1)"
                />
                <PaginationLast
                    @click="$emit('loadData', pagination.total_page)"
                />
            </PaginationList>
        </Pagination>
    </div>
</template>

<script setup>
const emit = defineEmits(["loadData"]);
const props = defineProps({
    pagination: {
        type: Object,
        default: {},
        required: true,
    },
});

import Button from "@/components/ui/button/Button.vue";
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from "@/components/ui/pagination";
</script>
