<script setup>
    import { onMounted } from 'vue';
    import InputField from '@/Components/InputField.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm, Link } from "@inertiajs/vue3";
    
    //const props = defineProps({ item:Object }); 
    const props = defineProps({
      item: {
        type: Object,
        default: null,
      },
      userId: {
        type: Number,
        default: null,        
      }
    });

    onMounted(() => {
        // const props = defineProps({ id:Number }); // ❌ move to top level
        console.log(props.item.original[0]);
        //let item = props.item.original[0];
    });
    
    const form = useForm({
        id:props.item.original[0].id,
        name: props.item.original[0].name,
        price: props.item.original[0].price,
        description: props.item.original[0].description,
        quantity: props.item.original[0].quantity,
        //barcode: props.item.original[0].barcode,
        restock_time: props.item.original[0].restockTime,
        user_id: props.userId,
    });
    
    const submit = () => {
      form.post(`/products/update/`);
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
                                
                                <!-- <InputField 
                                    label="Barcode" 
                                    id="barcode"
                                    type="text" 
                                    disabled=0
                                    placeholder="Enter Barcode" 
                                    v-model="form.barcode"
                                    :error="form.errors.barcode"
                                />                                 -->
    
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
                                    placeholder="Enter quantity" 
                                    v-model="form.quantity"
                                    :error="form.errors.quantity"
                                />
                                
                                <InputField 
                                    label="Restock Time" 
                                    id="restock_time"
                                    type="number" 
                                    placeholder="Enter Restock Time" 
                                    v-model="form.restock_time"
                                    :error="form.errors.restock_time"
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

    