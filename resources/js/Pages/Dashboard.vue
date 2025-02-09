<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form
                            class="mt-4"
                            @submit.prevent="createRoom"
                        >
                            <input
                                v-model="roomName"
                                type="text"
                                class="border rounded px-4 py-2"
                                placeholder="Enter room name"
                                required
                            >
                            <button
                                type="submit"
                                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded"
                            >
                                Create Room
                            </button>
                        </form>

                        <div class="mt-6">
                            <h3 class="font-semibold text-lg">Joined Rooms</h3>
                            <ul>
                                <li 
                                    v-for="room in rooms" 
                                    :key="room.id"
                                    class="mt-2"
                                >
                                    <a
                                        :href="`/chat/${room.room_code}`"
                                        class="text-blue-500 hover:underline"
                                    >
                                        {{ room.name }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },

    props: {
        rooms: Array,
    },

    data() {
        return {
            roomName: '',
        };
    },
    
    methods: {
        createRoom() {
            Inertia.post(this.route('create.room'), { name: this.roomName });
        },
    },
};
</script>