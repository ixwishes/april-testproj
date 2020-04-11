<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">Add New Task</div>
                    <div class="card-body">
                          <div class="form-group row">
                              <label for="task_name" class="col-md-2 col-form-label text-md-right">Name</label>
                                  <input id="task_name" type="text" name="task_name" v-model="name" required>
                          </div>
                          <div class="form-group row">
                              <label for="task_description" class="col-md-2  col-form-label text-md-right">Description</label>
                                  <input id="task_description" type="text" name="task_description" v-model="description" required>
                          </div>
                          <div class="form-group row">
                              <label for="target_date" class="col-md-2 col-form-label text-md-right">Target Completion Date</label>
                                  <input id="target_date" type="date" name="target_date" v-model="target_date" required>
                          </div>
                          <button class="btn btn-primary task-create" @click="create">
                              Add New Task
                          </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
            name: "",
            description: "",
            target_date: ""
          }
        },
        methods: {
          create() {
            this.$emit('create', this.name, this.description, this.target_date);
            this.name = "";
            this.description = "";
            this.target_date = "";
          }
        }
    }
</script>
<style>
  .task-create {
    width: 200px;
  }
</style>
