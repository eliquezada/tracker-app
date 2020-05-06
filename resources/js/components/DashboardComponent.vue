<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div v-if="active_task" class="no-tasks">
                    <div class="col-sm-12" id="button-track">
                        <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#taskCreate"  @click="selectedTask = tasks">Track Task</button>
                    </div>
                </div>
                <div v-for="(tasks, index) in tasks_date" :key="index">
                    <div v-if="tasks.length > 0" class="mt-3">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <h4 class="pull-left">{{ formatDay(index) }}</h4>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    <li v-for="task in tasks" :key="task.id" class="list-group-item clearfix">
                                        <strong class="timer-name">{{ task.name }} </strong>
                                        <div class="pull-right">
                                        <span v-if="showTimerActiveTask(task)" style="margin-right: 10px">
                                            <strong>{{ startMessage }}</strong>
                                        </span>
                                            <span v-else style="margin-right: 10px">
                                            <strong>{{ calculateTaskTotalTime(task) }}</strong>
                                        </span>
                                        <button  v-if="showTimerActiveTask(task)" class="btn btn-sm btn-danger" @click="stopTimer()">
                                            <i class="glyphicon glyphicon-stop">Stop</i>
                                        </button>
                                        </div>
                                    </li>
                                </ul>
                             </div>
                        </div>
                    </div>
                    <div v-else class="mt-5">
                        <div>Start to track a task</div>
                    </div>
                </div>
                <div class="modal fade" id="taskCreate" role="dialog" >
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Record Task</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="newTaskName" type="text" class="form-control" placeholder="Task name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-bind:disabled="newTaskName === ''" @click="createTask(selectedTask), hideModal()" type="submit" class="btn btn-default btn-primary"><i class="glyphicon glyphicon-play"></i> Start</button>
                             </div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        data() {
            return {
                tasks_date: '',
                tasks: '',
                newTaskName: '',
                startMessage: 'Starting...',
                counter: { seconds: 0, timer: null },
            }
        },
        computed: {
            active_task: function () {
                if (this.counter.timer !== null) {
                    return false
                } else {
                    return true;
                }
            }
        },
        methods: {
            hideModal () {
                $('#taskCreate').modal('hide');
            },

            /**
             * Conditionally pads a number with "0"
             */
            appendLeftNumber: number =>  (number > 9 || number === 0) ? number : "0" + number,

            /**
             * Splits seconds into hours, minutes, and seconds.
             */
            timeFromSeconds: function(seconds) {
                const hours = 3600 > seconds ? 0 : parseInt(seconds / 3600, 10)
                const mins = parseInt(seconds / 60, 10) % 60;
                const secs = seconds % 60;
                return {
                    hours: this.appendLeftNumber(hours),
                    minutes: this.appendLeftNumber(mins),
                    seconds: this.appendLeftNumber(secs),
                }
            },
            /**
             * Format index as date
             */
            formatDay: function (date) {
                return moment(date).format("dddd, MMMM DD YYYY");
            },
            /**
             * Time spent on the task using the timer object.
             */
            calculateTaskTotalTime: function(task) {
                if (task.stopped_at) {
                    let started = moment(task.started_at)
                    let stopped = moment(task.stopped_at)
                    let time = this.timeFromSeconds(
                        parseInt(moment.duration(stopped.diff(started)).asSeconds())
                    )
                    return `${time.hours} hrs | ${time.minutes} mins | ${time.seconds} secs`
                }
                return ''
            },
            /**
             * Check active timer belong to task
             */
            showTimerActiveTask: function (task) {
                return this.counter.timer &&
                    this.counter.timer.id === task.id
            },
            /**
             * Start timer
             */
            startTimer: function (timer) {
                let vm = this
                let started = moment(timer.started_at)
                let stopped = moment(timer.stopped_at)  ?? moment() ;

                vm.counter.timer = timer
                if (vm.counter.timer.stopped_at) {
                    vm.counter.seconds = parseInt(moment.duration(stopped.diff(started)).asSeconds())
                } else {
                    vm.counter.seconds = parseInt(moment.duration(moment().diff(started)).asSeconds())
                }

                vm.counter.ticker = setInterval(() => {
                    const time = vm.timeFromSeconds(++vm.counter.seconds)
                    vm.startMessage = `${time.hours} hrs | ${time.minutes}:${time.seconds}`
                }, 1000)
            },
            /**
             * Stop timer and task stop
             */
            stopTimer: function () {
                window.axios.post(`/tasks/${this.counter.timer.id}/stop`)
                    .then(response => {
                        //loop with 'for in' as index is string date
                        for (let index in this.tasks_date) {
                            this.tasks_date[index].forEach(task => {
                                if (task.id === parseInt(this.counter.timer.id)) {
                                    return task.stopped_at = response.data.stopped_at
                                }
                            })
                        }
                        //Reset counter and stop ticker
                        clearInterval(this.counter.ticker)
                        this.counter = { seconds: 0, timer: null }
                        this.startMessage = 'Starting...'
                        this.active_task = false;

                    })
                    .catch(function (error) {
                        console.log(error.message);
                    });
            },
            /**
             * create task
             */
            createTask: function () {
                window.axios.post('/tasks/store', {name: this.newTaskName})
                    .then(response => {
                        for (let index in this.tasks_date) {
                            this.tasks_date[index].unshift(response.data)
                        }
                        this.startTimer(response.data);
                    })
                    .catch(function (error) {
                        console.log(error.message);
                    });
                this.newTaskName = ''
            }
        },
        /**
         * load list
         */
        created() {
            window.axios.get('/tasks')
                .then(response => {
                this.tasks_date = response.data
                window.axios.get('/task/active').then(response => {
                    if (response.data.id !== undefined) {
                        this.startTimer(response.data)
                    }
                })
            })
        }
    }
</script>

<style scoped>

</style>
