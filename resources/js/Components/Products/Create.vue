<template>
    <div class="mb-4">
        <h4>Create new product</h4>
    </div>
    <div>
        <form @submit.prevent="handleSubmit">
            <AlertErrors :form="form" message="Please validate your data" />
            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    placeholder="Enter the name"
                    id="name"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea
                    v-model="form.description"
                    class="form-control"
                    id="description"
                    cols="30"
                    rows="3"
                    placeholder="Enter the description"
                    required
                ></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="price">Price</label>
                <input
                    v-model="form.price"
                    type="number"
                    class="form-control"
                    placeholder="Enter the price"
                    id="price"
                    min="0"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label" for="image">Image</label>
                <input
                    type="file"
                    class="form-control"
                    id="image"
                    @change="form.image = $event.target.files[0]"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Categories</label>
                <CategoriesCheckboxTree
                    :categories="categories"
                    v-model="form.selected_categories_ids"
                />
            </div>
            <button :disabled="form.busy" type="submit" class="btn btn-primary">
                Save
            </button>
        </form>
    </div>
</template>

<script>
import CategoriesCheckboxTree from "@/Components/Categories/CheckboxTree.vue";
import axios from "axios";
import VForm from "vform";
import { AlertErrors } from "vform/src/components/bootstrap5";

export default {
    components: {
        CategoriesCheckboxTree,
        AlertErrors,
    },
    emits: ["productCreated"],
    data() {
        return {
            categories: [],
            form: new VForm({
                name: "",
                description: "",
                price: "",
                image: null,
                selected_categories_ids: [],
            }),
        };
    },
    methods: {
        async handleSubmit() {
            await this.form.post("/api/products");

            this.$emit("productCreated");
        },
        async fetchCategories() {
            const res = await axios.get("/api/categories", {
                params: { asTree: true },
            });
            this.categories = res.data.categories;
        },
    },
    mounted() {
        this.fetchCategories();
    },
};
</script>
