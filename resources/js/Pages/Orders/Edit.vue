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
        notes: props.item.original[0].notes,
        status: props.item.original[0].status,
        user_id: props.userId,
    });
    
    const submit = () => {
      form.post(`/orders/update/`);
    };
    </script>
    
    <template>
        <Head title="Edit Order" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Order</h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <Link href="/orders"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Back</button></Link>
                            
                            <form @submit.prevent="submit">
                                <InputField 
                                    label="Notes" 
                                    id="notes"
                                    type="text" 
                                    placeholder="Enter Notes" 
                                    v-model="form.notes"
                                    :error="form.errors.notes"
                                />
                                <select 
                                    v-model="form.status"
                                    :error="form.errors.status"
                                >
                                    <option disabled value="">Please select one</option>
                                    <option value="ordered">Ordered</option>
                                    <option value="sent">Sent</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                                <div>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 text-white">
                                        Submit
                                    </button>
                                </div>
    
                            </form>
    
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>

    