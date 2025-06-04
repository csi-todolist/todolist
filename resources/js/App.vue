<script>
import Task from './componants/task.vue';
import {container, openModal} from "jenesius-vue-modal";

export default {
    components: {
    Task,
    WidgetContainerModal: container,
  },
  data() {
    return {
      
    }
  }
}
</script>

<template>
  <widget-container-modal />
  <Task />
</template>

<style scoped>

</style>