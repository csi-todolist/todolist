<script>
import axios from "axios";
import {closeModal} from "jenesius-vue-modal";

export default {
    name: "createTask",
    props: {
        onClose: Function,
        idUser: Number,
    },
    data(){
        return{
            data: {
                title: "",
                id_user: this.idUser,
                description: "",
                completed: false,
                stresseLevel: null,
            },

        }
    },
    methods: {
        closeModal,
        createTask(){
            axios.post('/create/', {
                title: this.data.title,
                user_id: this.data.id_user,
                description: this.data.description,
                completed: this.data.completed,
                stresseLevel: this.data.stresseLevel
            })
            .then(response => {
                this.onClose();
                this.closeModal();
            })
            .catch(error => {
                console.log(error);
            })
        }
    }
}
</script>


<template>
  <div class="modal">
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Titre
      </label>
      <input v-model="data.title" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="texr">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
        Description
      </label>
      <input v-model="data.description" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="texr">
    </div>
    <div class="flex items-center justify-between">
      <button @click="createTask" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
        valider
      </button>
      <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="closeModal">close</button>
    </div>
  </div>
</template>

<style>
.modal{
    background-color: white;
    border-radius: 15px;
    padding: 25px;
}

button{
    color: black;
}
</style>