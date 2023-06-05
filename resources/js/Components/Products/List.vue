<template>
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Name & Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Categories</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products" :key="product.id">
                <th>{{ product.id }}</th>
                <td>
                    <div>
                        <p class="fs-5">{{ product.name }}</p>
                        <small class="text-muted">{{
                            product.description
                        }}</small>
                    </div>
                </td>
                <td>{{ product.price }}</td>
                <td>
                    <div style="width: 70px; height: 70px">
                        <img
                            :src="product.image_url"
                            :alt="product.name"
                            class="img-thumbnail"
                        />
                    </div>
                </td>
                <td>
                    <ul>
                        <li
                            v-for="category in product.categories"
                            :key="category.id"
                        >
                            {{ category.name }}
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: ["products"],
};
</script>
