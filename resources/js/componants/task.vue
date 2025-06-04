<script>
import axios from 'axios';
import modalCreateTask from './modalCreateTask.vue';
import {openModal} from "jenesius-vue-modal";

export default {
    name: "task",
    data() {
        return {
        data: [],
        }
    },
    methods: {
        getData(){
            axios.get('/task')
                .then(response => {
                    this.data = response.data;
                    console.log(this.data.user.id);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        OpenModalAdd(){
                const props = {
                    onClose: () => {
                        this.getData();
                    },
                    idUser: this.data.user.id,
                };
                openModal(modalCreateTask, props);
            },

    },
    mounted(){
        this.getData();
    }
}
</script>

<template>   
    <div class="flex justify-between align-center">
        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Tâches :</h2>
        <button @click="OpenModalAdd()">add</button>
    </div>
    <div class="grid grid-cols-4 gap-4">
        <div v-for="item in data.task" class="max-w-sm rounded overflow-hidden shadow-lg bg-gray-500" style="padding: 12px; margin-bottom: 10px;">
        <div>
            <div><strong>titre :</strong> {{ item.title }}</div>
            <div><strong>description :</strong> {{ item.description }}</div>
            <div><strong>etat :</strong> {{ item.completed }}</div>
            <div><strong>stresse :</strong> {{ item.stresseLevel }}</div>
        </div>
    </div>
    </div>
</template>

<style scoped>

</style>