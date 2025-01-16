<script setup>
import Pagination from '@/Components/Pagination.vue';
//import PaginationBar from '@/Components/PaginationBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  items: Object,
});

const form = useForm({});

const deletePost = (id) => {
  if (confirm("Are you sure you want to delete this item?")) {
    form.delete(`/products/${id}`).then(() => {
      console.log('Deleted successfully');
    }).catch((error) => {
      console.error('Error deleting:', error);
    });
  }
};
</script>

<template>
    <Head title="Manage Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Products</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link href="products/create"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Product</button></Link>
                        <table class="table-auto w-full">
                            <thead>
                              <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Description</th>
                                <th class="border px-4 py-2">Price</th>
                                <th class="border px-4 py-2">Barcode</th>
                                <th class="border px-4 py-2">Quantity</th>
                                <th class="border px-4 py-2">Restock Time</th>
                                <th class="border px-4 py-2" width="250px">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in items" :key="item.id">
                                  <td class="border px-4 py-2">{{ item.id }}</td>
                                  <td class="border px-4 py-2">{{ item.name }}</td>
                                  <td class="border px-4 py-2">{{ item.description }}</td>
                                  <td class="border px-4 py-2">{{ item.price }}</td>
                                  <td class="border px-4 py-2">{{ item.barcode }}</td>
                                  <td class="border px-4 py-2">{{ item.quantity }}</td>
                                  <td class="border px-4 py-2">{{ item.restock_time }}</td>
                                  <td class="border px-4 py-2">
                                    <Link :href="`products/${item.id}/edit`"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button></Link>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" @click="deletePost(item.id)">Delete</button>
                                  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                 <!-- Pagination Start-->
                 <!-- <div class="mt-6">
                        <Pagination :links="items.links" />
                  </div> -->
                <!-- Pagination End-->
            </div>
        </div>
    </AuthenticatedLayout>
</template>