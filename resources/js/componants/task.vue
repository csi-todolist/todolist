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
                    console.log(this.data.task);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        updateComputed(id){
            const dataArray = Object.values(this.data.task);
            const item = dataArray.find(({ id }) => id === id)
            console.log(item);
            axios.post('/edit/'+ id, {
                title: item.title,
                user_id: item.user_id,
                description: item.description,
                completed: !item.completed,
                stresseLevel: item.stressLevel,
            })
                .then(response => {
                    this.getData();
                    console.log(item.completed);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        updateData(id) {
            // TROUVE DIRECTEMENT L'ITEM DANS TON TABLEAU (il doit être déjà réactif si tu utilises v-for="item in data.task")
            const item = this.data.task.find(task => task.id === id);
            if (!item) return;

            axios.post('/edit/' + id, {
                title: item.title,
                user_id: item.user_id,
                description: item.description,
                completed: item.completed,
                stresseLevel: item.stressLevel,
            })
            .then(response => {
                console.log(response)
                this.getData();
            })
            .catch(error => {
                console.log(error);
            })
        },
        deleteData(id){
            axios.post('/delete/'+id)
                .then(response =>{
                    this.getData();
                })
                .catch(error =>{
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
        getStressEmoji(level) {
            switch (level) {
                case 1: return '😌'; // Très faible
                case 2: return '🙂'; // Faible
                case 3: return '😐'; // Moyen
                case 4: return '😰'; // Élevé
                case 5: return '😱'; // Très élevé
                default: return '❓';
            }
        },
        getStressBgColor(level) {
            switch (level) {
                case 1: return '#4ade80';   // vert
                case 2: return '#fde047';   // jaune
                case 3: return '#fdba74';   // orange
                case 4: return '#fb7185';   // rose/rouge clair
                case 5: return '#ef4444';   // rouge vif
                default: return '#6b7280';  // gris si inconnu
            }
        }
    },
    mounted(){
        this.getData();
    }
}
</script>

<template>   
    <div class="flex justify-between text-align">
        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Tâches :</h2>
        <button @click="OpenModalAdd()" class="btn">add</button>
    </div>

    <div class="grid-container">
        <div v-for="item in data.task">
            <div class="grid-item">
                <div>
                    <label>titre :</label>
                    <input class="input-paragraph" @change="updateData(item.id)" type="text" v-model="item.title">
                </div>
                <div>
                    <label>description :</label>
                    <input class="input-paragraph" @change="updateData(item.id)" type="text" v-model="item.description">
                </div>
                <div
                    class="stress-badge"
                    :style="{
                    background: getStressBgColor(item.stressLevel),
                    color: '#fff'
                    }"
                >
                    <span class="emoji">{{ getStressEmoji(item.stressLevel) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <div>
                        <label class="custom-checkbox">
                            <input
                            type="checkbox"
                            :checked="item.completed"
                            @change="updateComputed(item.id)"
                            />
                            <span v-if="item.completed">Terminée</span>
                            <span v-else>À faire</span>
                        </label>
                    </div>
                    <button @click="deleteData(item.id)" class="btn">supprimer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
p{
    color: black;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(4, minmax(200px, 1fr));
  gap: 16px; /* Espace entre les éléments */
  padding: 16px;
}

.grid-item {
  border-radius: 12px;
  background-color: gray;
  box-shadow: 0 2px 6px rgba(0,0,0,0.07);
  padding: 24px;
  text-align: center;
  font-size: 1.2rem;
  transition: box-shadow 0.2s;
  text-align: left;
  z-index: 1;
}

.grid-item:hover {
  box-shadow: 0 4px 16px rgba(0,0,0,0.13);
}

.stress-badge {
  display: inline-flex;
  align-items: center;
  font-weight: bold;
  border-radius: 8px;
  padding: 4px 12px;
  margin-top: 10px;
  font-size: 1.1em;
}

.emoji {
  /* margin-left: 8px; */
  font-size: 1.4em;
}

.btn {
  background: linear-gradient(90deg, #4ade80, #22d3ee);
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1em;
  cursor: pointer;
  transition: box-shadow 0.2s, background 0.2s;
  box-shadow: 0 2px 6px rgba(0,0,0,0.07);
}
.btn:hover {
  background: linear-gradient(90deg, #22d3ee, #4ade80);
  box-shadow: 0 4px 16px rgba(0,0,0,0.13);
}

.custom-checkbox {
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  user-select: none;
  z-index: 0;
}

.custom-checkbox input[type="checkbox"] {
  appearance: none;
  -webkit-appearance: none;
  width: 22px;
  height: 22px;
  margin-right: 8px;
  border: 2px solid #4ade80;
  border-radius: 6px;
  background: #fff;
  outline: none;
  position: relative;
  vertical-align: middle;
  transition: background 0.2s, border-color 0.2s;
}

.custom-checkbox input[type="checkbox"]:checked {
  background: #4ade80;
  border-color: #22d3ee;
}

/* Le check parfaitement centré et épais */
.custom-checkbox input[type="checkbox"]:checked::after {
  content: "";
  display: block;
  width: 8px;
  height: 14px;
  border: solid #fff;
  border-width: 0 3px 3px 0;
  position: absolute;
  left: 6px;  /* <--- ajuste horizontalement */
  top: 1px;   /* <--- ajuste verticalement */
  transform: rotate(45deg);
}

.input-paragraph {
  border: none;
  outline: none;
  background: transparent;
  box-shadow: none;
  padding: 0;
  margin: 0;
  font: inherit;
  color: inherit;
  width: 100%;
  min-width: 0;
  /* Si tu veux éviter que le texte déborde */
  word-break: break-word;
  /* Facultatif : un léger padding en bas pour aérer */
  padding-bottom: 2px;
  cursor: pointer;
}
.input-paragraph:focus {
  outline: none;
  border: none;
  background: transparent;
  /* Optionnel : tu peux mettre une légère surbrillance si tu veux */
  /* border-bottom: 1px dashed #888; */
}


</style>