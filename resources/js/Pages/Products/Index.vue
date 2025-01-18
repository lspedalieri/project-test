<script setup>
//import Pagination from '@/Components/Pagination.vue';
//import Pagination from '@/Shared/Pagination.vue';
//import PaginationBar from '@/Components/PaginationBar.vue';
import SearchFilter from '@/Shared/SearchFilter.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';

defineProps({
  items: Object,
  userId: {
    type: Number,
    default: null,        
  }
});
// onMounted(() => {
//   console.log(`the component is now mounted.`)
//   console.log(items);
// })

const form = useForm({});

const deleteItem = (item, userId) => {
  if (confirm("Are you sure you want to delete " + item.name + "?")) {
    form.delete(`/products/delete?id=${item.id}&user_id=${userId}`).then(() => {
      console.log('Deleted successfully');
    }).catch((error) => {
      console.error('Error deleting:', error);
    });
  }
};

const orderItem = (item, userId) => {
  let quantity = document.getElementById("quantity-"+item.id).value;
  if(quantity < 1) {
    alert("Select 1 product");
    return;
  }
  if (confirm("Are you sure you want to buy " + quantity + " " + item.name + "?")) {
    form.put(`/orders/buy?product_id=${item.id}&user_id=${userId}&quantity=${quantity}`).then((response) => {
      console.log('Ordered successfully');
    }).catch((error) => {
      console.error('Error buy:', error);
    });
  }  
};

// const searchField = ref(''); //Should really load it from the query string

// const url = route('products.index');

// watch(searchField, debounce(() => {
// 	router.get(url, {searchField: searchField.value}, {preserveState: true, preserveScroll: true, only: ['items']})
// }, 300));
</script>

<template>
  <div v-if="$page.props.auth.user.roles=='admin'">
    <Head title="Manage Products" />
  </div>
  <div v-else>
    <Head title="Buy Products" />
  </div>

    <AuthenticatedLayout>
        <template #header>
            <h2 v-if="$page.props.auth.user.roles=='admin'" class="font-semibold text-xl text-gray-800 leading-tight">Manage Products</h2>
            <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">Buy Products</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link v-if="$page.props.auth.user.roles=='admin'" href="products/create"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Product</button></Link>
                        <!-- <input type="search" v-model="searchField" > -->
                        <div v-if="$page.props.flash.message" class="alert">
                          {{ $page.props.flash.message }}
                        </div>
                        <table class="table-auto w-full">
                            <thead>
                              <tr>
                                <th v-if="$page.props.auth.user.roles=='admin'" class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Description</th>
                                <th class="border px-4 py-2">Price</th>
                                <th v-if="$page.props.auth.user.roles=='admin'" class="border px-4 py-2">Barcode</th>
                                <th class="border px-4 py-2">Quantity</th>
                                <th v-if="$page.props.auth.user.roles=='admin'" class="border px-4 py-2">Restock Time</th>
                                <th v-if="$page.props.auth.user.roles=='admin'"class="border px-4 py-2" width="250px">Action</th>
                                <th class="border px-4 py-2" width="250px">Buy</th>
                              </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in items" :key="item.id">
                                  <td v-if="$page.props.auth.user.roles=='admin'" class="border px-4 py-2">{{ item.id }}</td>
                                  <td class="border px-4 py-2">{{ item.name }}</td>
                                  <td class="border px-4 py-2">{{ item.description }}</td>
                                  <td class="border px-4 py-2">{{ item.price }}</td>
                                  <td v-if="$page.props.auth.user.roles=='admin'" class="border px-4 py-2">{{ item.barcode }}</td>
                                  <td class="border px-4 py-2">{{ item.quantity }}</td>
                                  <td v-if="$page.props.auth.user.roles=='admin'" class="border px-4 py-2">{{ item.restockTime }}</td>
                                  <td v-if="$page.props.auth.user.roles=='admin'"class="border px-4 py-2">
                                    <Link :href="`products/edit?id=${item.id}`"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button></Link>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" @click="deleteItem(item, userId)">Delete</button>
                                  </td>
                                  <td>
                                    <input type ="number" :id="'quantity-'+item.id" class="form-control font-bold py-2 px-4 rounded ml-2" min="0" :max="item.quantity"/>
                                    <button v-if="item.quantity > 0" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" @click="orderItem(item, userId)">Buy</button>
                                    <span v-else>Not available</span>
                                  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                 <!-- Pagination Start-->
                 <div class="mt-6">
                    <!-- <pagination :links="items.links" /> -->
                  </div> 
                <!-- Pagination End -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>