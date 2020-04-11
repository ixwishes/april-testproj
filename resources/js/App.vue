<template>
  <div id="app">
    <new-task @create="create">
    </new-task>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col" style="margin: 15px auto">
              <h2 class="task-header">Your Tasks</h2>
            </div>
        </div>
    </div>

    <task-component
      v-for="task in tasks"
      v-bind="task"
      :key="task.id"
      @update="update"
      @remove="remove"
    ></task-component>
  </div>
</template>


<script>
  function Task({ id, name, description, target_date, completed, completed_at}) {
    this.id = id;
    this.description = description;
    this.name = name;
    this.target_date = target_date;
    this.completed = completed;
    this.completed_at = completed_at;
  }

  import NewTask from './components/NewTask.vue';
  import TaskComponent from './components/TaskComponent.vue';


  export default {
    data() {
      return {
        tasks: [],
      }
    },
    methods: {
      async create(name, description, target_date) {
        var self = this.tasks;
        axios.post('/api/tasks', {
          name: name,
          description: description,
          target_date: target_date,
          completed: false
        }).then(function(response) {
          var tasks = response.data.tasks;
          tasks.forEach(task => self.unshift(new Task(task)));
        }).catch(function(error) {
          console.log(error);
        });
      },
      async read() {
        var self = this.tasks;
        axios.get('/api/tasks').then(function(response) {
          var tasks = response.data.tasks;
          tasks.forEach(task => self.push(new Task(task)));
        }).catch(function(error) {
          console.log(error);
        });
      },
      async update(id) {
        var self = this.tasks;
        axios.put(`/api/tasks/${id}`, {
          completed: true,
        }).then(function(response) {
          var tasks = response.data.tasks;
          tasks.forEach(function(task) {
            var updatedTask = self.find(t => t.id === task.id);
            updatedTask.completed = true;
            updatedTask.completed_at = task.completed_at;
          });
        }).catch(function(error) {
          console.log(error);
        });
      },
      async remove(id) {
        await axios.delete(`/api/tasks/${id}`);
        let index = this.tasks.findIndex(task => task.id === id);
        this.tasks.splice(index, 1);
      }
    },
    components: {
      NewTask,
      TaskComponent
    },
    created() {
      this.read();
    }
  }
</script>
