<template>
    <div>
        <Pagination :total="paginate.total" :sibling-count="1" :items-per-page="paginate.perPage"
            :default-page="currentPage" show-edges>
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                <PaginationFirst @click="$emit('loadData', 1)" />
                <PaginationPrev @click="$emit('loadData', currentPage - 1)" />

                <template v-for="(item, index) in items">
                    <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                        <Button class="w-10 h-10 p-0" :variant="item.value === currentPage
                                ? 'default'
                                : 'outline'
                            " @click="item.value != currentPage && $emit('loadData', item.value)">
                            {{ item.value }}
                        </Button>
                    </PaginationListItem>
                    <PaginationEllipsis v-else :key="item.type" :index="index" />
                </template>

                <PaginationNext @click="$emit('loadData', currentPage + 1)" />
                <PaginationLast @click="$emit('loadData', totalPage)" />
            </PaginationList>
        </Pagination>
    </div>
</template>

<script setup>
const emit = defineEmits(["loadData"]);
const props = defineProps({
    totalPage: {
        type: Number,
    },
    currentPage: {
        type: Number,
        default: 1
    },
    paginate: {
        type: Object,
        default: {}
    }
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
