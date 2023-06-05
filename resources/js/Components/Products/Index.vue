<template>
    <div class="row gap-4">
        <div class="col-md-6">
            <div class="mb-4 d-flex justify-content-between">
                <h4>Products list</h4>
                <div class="d-flex gap-3 flex-shrink-0">
                    <select v-model="categoryId" class="form-select">
                        <option :value="null">Filter by category</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <span> Sort by Price </span>
                        <div class="d-flex gap-1">
                            <button
                                @click="updateSort('price', 'asc')"
                                class="btn btn-sm"
                                :class="[
                                    sortIsActive('price', 'asc')
                                        ? 'btn-primary'
                                        : 'btn-light',
                                ]"
                            >
                                <i data-feather="chevron-up" />
                            </button>
                            <button
                                @click="updateSort('price', 'desc')"
                                class="btn btn-sm"
                                :class="[
                                    sortIsActive('price', 'desc')
                                        ? 'btn-primary'
                                        : 'btn-light',
                                ]"
                            >
                                <i data-feather="chevron-down" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <ProductsList :products="products" />
        </div>
        <div class="col-md-4">
            <ProductsCreate @product-created="handleProductCreated" />
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import ProductsList from "@/Components/Products/List.vue";
import ProductsCreate from "@/Components/Products/Create.vue";

const categoryId = ref(null);
const sortBy = ref("price");
const sortOrder = ref("desc");
const categories = ref([]);
const products = ref([]);

const updateSort = (newSortBy, newSortOrder) => {
    sortBy.value = newSortBy;
    sortOrder.value = newSortOrder;
};

const sortIsActive = (sampleSortBy, sampleSortOrder) => {
    return sortBy.value === sampleSortBy && sortOrder.value === sampleSortOrder;
};

const fetchProducts = async () => {
    const res = await axios.get("/api/products", {
        params: {
            categoryId: categoryId.value,
            sortBy: sortBy.value,
            sortOrder: sortOrder.value,
        },
    });
    products.value = res.data.products;
};

const fetchCategories = async () => {
    const res = await axios.get("/api/categories");
    categories.value = res.data.categories;
};

watch([categoryId, sortBy, sortOrder], () => {
    fetchProducts();
});

const handleProductCreated = () => {
    categoryId.value = null;
    fetchProducts();
};

onMounted(() => {
    fetchCategories();
    fetchProducts();
});
</script>
