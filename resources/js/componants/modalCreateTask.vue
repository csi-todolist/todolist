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
                stressLevel: null,
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
                stressLevel: this.data.stressLevel
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
  <div class="modal-overlay" @click.self="closeModal">
    <div class="modal">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
          Titre
        </label>
        <input v-model="data.title" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="text">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Description
        </label>
        <input v-model="data.description" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="text">
      </div>
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
          Stress 
        </label>
        <select v-model="data.stressLevel" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="text">
          <option value="1">😌</option>
          <option value="2">🙂</option>
          <option value="3">😐</option>
          <option value="4">😰</option>
          <option value="5">😱</option>
        </select>
      </div>
      <div class="flex items-center justify-between">
        <button @click="createTask" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
          valider
        </button>
        <button class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="closeModal">close</button>
      </div>
    </div>
  </div>
</template>


<style>
.modal-overlay {
  position: fixed;
  left: 0; top: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.4); /* Fond semi-transparent */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99999 !important;
}

.modal {
  z-index: 1000000 !important;
  position: relative !important;
  background: white;
  border-radius: 18px;
  padding: 30px;
  min-width: 340px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.21);
}

button{
    color: black;
}
</style>