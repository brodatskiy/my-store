<script setup>
import { Head } from "@inertiajs/vue3";
import ShopLayout from "@/Layouts/ShopLayout.vue";
import ProductCardLine from "@/Components/ProductCardLine.vue";

const props = defineProps({
    wishes: Array,
});
</script>
<template>
    <Head title="Wishlist" />
    <ShopLayout>
        <h1 class="mb-6 text-center text-2xl font-bold">Wishlist</h1>
        <div
            class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0"
        >
            <div class="w-full">
                <div
                    class="mx-auto max-w-6xl grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4"
                >
                    <ProductCardLine
                        v-for="product in props.wishes"
                        :key="product.id"
                        :product="product"
                    ></ProductCardLine>
                </div>
            </div>
        </div>
    </ShopLayout>
</template>

<style scoped></style>
