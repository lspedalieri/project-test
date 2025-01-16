<script setup>
    import InputField from '@/Components/InputField.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm, Link } from "@inertiajs/vue3";
    
    const props = defineProps({
      item: {
        type: Object,
        default: null,
      },
    });
    
    const form = useForm({
      name: props.item.name,
      price: props.item.price,
      description: props.item.description,
      barcode: props.item.barcode,  
      quantity: props.item.quantity,
      restockTime: props.item.restock_time,
    });
    
    const submit = () => {
      form.put(`/products/store/${props.item.id}`);
    };
    </script>
    
    <template>
        <Head title="Manage Products" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <Link href="/products"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Back</button></Link>
                            
                            <form @submit.prevent="submit">
                                <InputField 
                                    label="Name" 
                                    id="name"
                                    type="text" 
                                    placeholder="Enter Name" 
                                    v-model="form.name"
                                    :error="form.errors.name"
                                />
                                <InputField 
                                    label="Description" 
                                    id="description"
                                    type="text" 
                                    placeholder="Enter Description" 
                                    v-model="form.description"
                                    :error="form.errors.description"
                                />                                

                                <InputField 
                                    label="Barcode" 
                                    id="barcode"
                                    type="text" 
                                    placeholder="Enter Barcode" 
                                    v-model="form.barcode"
                                    :error="form.errors.barcode"
                                />                                
                                

                                <InputField 
                                    label="Restock Time" 
                                    id="restock_time"
                                    type="text" 
                                    placeholder="Enter Estimated Restock Time" 
                                    v-model="form.restockTime"
                                    :error="form.errors.restockTime"
                                />                              

                                <InputField 
                                    label="Price" 
                                    id="price"
                                    type="number" 
                                    placeholder="Enter Price" 
                                    v-model="form.price"
                                    :error="form.errors.price"
                                />

                                <InputField 
                                    label="Quantity" 
                                    id="quantity"
                                    type="number" 
                                    placeholder="Enter Quantity" 
                                    v-model="form.quantity"
                                    :error="form.errors.quantity"
                                />                                
    
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 text-white">
                                    Submit
                                </button>
    
                            </form>
    
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>