<script setup>
    import InputField from '@/Components/InputField.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useForm, Link } from "@inertiajs/vue3";
    
    const props = defineProps({
      record: {
        type: Object,
        default: null,
      },
    });
    
    const form = useForm({
      name: props.record.name,
      price: props.record.price,
    });
    
    const submit = () => {
      form.put(`/products/${props.record.id}`);
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
                                    label="Price" 
                                    id="price"
                                    type="number" 
                                    placeholder="Enter Price" 
                                    v-model="form.price"
                                    :error="form.errors.price"
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