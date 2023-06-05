<template>
    <div v-for="category in categories" :key="category.id" class="form-check">
        <input
            type="checkbox"
            class="form-check-input"
            :value="category.id"
            :id="'category-' + category.id"
            v-model="selectedCategoriesIds"
        />
        <label class="form-check-label" :for="'category-' + category.id">{{
            category.name
        }}</label>
        <div class="ml-4">
            <CheckboxTree
                v-if="category.children_tree.length"
                :categories="category.children_tree"
                v-model="selectedCategoriesIds"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: ["categories", "modelValue"],
    emits: ["update:modelValue"],
    data() {
        return {
            selectedCategoriesIds: [],
        };
    },
    watch: {
        modelValue: {
            handler() {
                this.selectedCategoriesIds = this.modelValue;
            },
            immediate: true,
        },
        selectedCategoriesIds() {
            this.$emit("update:modelValue", this.selectedCategoriesIds);
        },
    },
};
</script>
