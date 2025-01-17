<script setup>
import Pagination from '@/Components/Pagination.vue';
//import PaginationBar from '@/Components/PaginationBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
  items: Object,
  userId: {
    type: Number,
    default: null,        
  }
});

const form = useForm({});

const deleteItem = (id, userId) => {
  if (confirm("Are you sure you want to delete this order?")) {
    form.delete(`/orders/delete?id=${id}&user_id=${userId}`).then(() => {
      console.log('Order deleted successfully');
    }).catch((error) => {
      console.error('Error deleting:', error);
    });
  }
};
</script>

<template>
    <Head title="Manage Orders" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Orders</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link href="orders/create"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Order</button></Link>
                        <table class="table-auto w-full">
                            <thead>
                              <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Product Name</th>
                                <th class="border px-4 py-2">Product Price</th>
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
                                  <td class="border px-4 py-2">{{ item.restockTime }}</td>
                                  <td class="border px-4 py-2">
                                    <Link :href="`orders/edit?id=${item.id}`"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button></Link>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" @click="deleteItem(item.id, userId)">Delete</button>
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