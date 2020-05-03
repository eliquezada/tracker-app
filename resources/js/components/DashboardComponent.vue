<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="no-tasks" v-if="tasks">
                    <div class="col-sm-12">
                        <h2 class="pull-left project-title">Tasks</h2>
                        <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#taskCreate">Track Task</button>
                    </div>
                </div>
                <div v-if="tasks.length > 0">

                </div>
                <div v-else class="mt-5">
                    <div>Start to track a task</div>
                </div>
                <div class="modal fade" id="taskCreate" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Record Task</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="newTaskName" type="text" class="form-control" id="usrname" placeholder="Task name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" v-bind:disabled="newTaskName === ''" @click="createTask" type="submit" class="btn btn-default btn-primary"><i class="glyphicon glyphicon-play"></i> Start</button>
                            </div>
                        </div>
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
                tasks: '',
                newTaskName: '',
            }
        },
        methods: {
            createTask: function () {
                window.axios.post('/tasks/store', {name: this.newTaskName})
                    .then(response => this.tasks.push(response.data))
                    .catch(function (error) {
                        console.log(error.message);
                    });
                this.newTaskName = ''
            }
        },
        created() {
            window.axios.get('/tasks')
                .then(response => {
                this.tasks = response.data
            })
        },
    }
</script>

<style scoped>

</style>
