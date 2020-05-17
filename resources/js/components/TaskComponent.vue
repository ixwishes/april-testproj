<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card to-do">
                    <div class="task-body" v-if="completed == 0">
                      <div>
                        <h3>{{ name }}</h3>
                        <p class="to-do-val">{{ description }}</p>
                        <p class="to-do-val emphasis"><b>Target Date: {{ target_date }}</b></p>
                      </div>
                      <div class="task-btns">
                        <button class="btn btn-primary btn-task complete" @click="update">Mark as Complete</button>
                        <button class="btn btn-secondary btn-task delete" @click="remove">Delete</button>
                      </div>
                    </div>

                    <div class="task-body" v-else>
                      <div>
                        <h3>{{ name }}</h3>
                        <p class="to-do-val">{{ description }}</p>
                      </div>
                      <div class="task-btns">
                        Completed: {{ completed_at }}
                        <button class="btn btn-secondary btn-task" @click="remove">Delete</button>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
          remove() {
            this.$emit('remove', this.id);
          },
          update() {
            this.$emit('update', this.id);
          }
        },
        created() {
          console.log(this.name);
        },
        props: ['id', 'name', 'description', 'target_date', 'completed', 'completed_at']
    }
</script>
<style>
  .to-do-val {
    display: block;
  }

  .emphasis {
    color: #FF0000;
  }

  .task-btns {
    display: flex;
    flex-direction: column;
  }

  .task-body {
    display: flex;
    justify-content: space-between;
    padding: 1.25rem;
  }

  .btn-task {
    margin: 5px auto;
    width: 180px;
  }

  .complete {
    background: #11cf43;
  }
</style>
