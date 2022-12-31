<template>
    <div>
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-8-desktop is-10-tablet">


                    <div class="box">
                        <div class="box-heading">
                            <div>
                                Trainings / Inteventions / Certificates
                            </div>
                        </div>

                        <div class="box-body">
                           <div class="columns">
                                <div class="column">
                                    <b-field label="Title of Learning Development (Write Full)" label-position="on-border">
                                        <b-input type="text" v-model="fields.title_learning_dev" placeholder="Title of Learning Development (Write Full)"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Inclusive Dates (Attendance)" label-position="on-border">
                                        <b-datepicker v-model="fields.date_from" editable placeholder="From"></b-datepicker>
                                        <b-datepicker v-model="fields.date_to" editable placeholder="To"></b-datepicker>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="No. of hours" label-position="on-border">
                                        <b-input type="text" v-model="fields.no_hours" placeholder="No. of hours"></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Type of LD" label-position="on-border">
                                        <b-input type="text" v-model="fields.type_ld" placeholder="Type of LD"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Conducted / Sponsored By" expanded label-position="on-border">
                                        <b-input type="text" v-model="fields.sponsored_by" expanded placeholder="Conducted / Sponsored By"></b-input>

                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field class="file is-primary" :class="{'has-name': !!fields.file}">
                                        <b-upload v-model="fields.file" class="file-label">
                                            <span class="file-cta">
                                                <b-icon class="file-icon" icon="upload"></b-icon>
                                                <span class="file-label">Click to upload certificate</span>
                                            </span>
                                            <span class="file-name" v-if="fields.file">
                                                {{ fields.file.name }}
                                            </span>
                                        </b-upload>
                                    </b-field>
                                </div>
                            </div>

                            <div class="buttons">
                                <b-button icon-left="content-save" @click="submitTraining" class="button is-primary">
                                    Save Training
                                </b-button>
                            </div>

                            <hr>



                        </div><!--box body -->
                    </div>
                </div>
            </div>
         </section>
    </div>
</template>

<script>

export default{
    props: ['propUser'],
    data(){
        return {
            fields: {},
            errors: {},

            trainings: [],
            total: 0,
            loading: false,
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',
        }
    },

    methods: {

        getTrainings(){

            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`

            ].join('&')

            axios.get(`/faculty/get-learning-trainings?${params}`).then(res=>{
                this.trainings = res.data
            }).catch(err=>{
            
            })
        },

        submitTraining(){
            let ndateFrom = new Date(this.fields.date_from);
            let ndateTo = new Date(this.fields.date_to);

            let dateFrom = ndateFrom.getFullYear() + '-' + (ndateFrom.getMonth() + 1) + '-' + ndateFrom.getDate();
            let dateTo = ndateTo.getFullYear() + '-' + (ndateTo.getMonth() + 1) + '-' + ndateTo.getDate();

            let formData = new FormData();

            formData.append('title_learning_dev', this.fields.title_learning_dev);
            formData.append('date_from', dateFrom);
            formData.append('date_to', dateTo);
            formData.append('no_hours', this.fields.no_hours);
            formData.append('type_ld', this.fields.type_ld);
            formData.append('sponsored_by', this.fields.sponsored_by);
            formData.append('file', this.fields.file);


            axios.post('/faculty/trainings-interventions', formData).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'UPDATED!',
                        message: 'Successfully updated.',
                        type: 'is-success',
                        onConfirm: ()=>{
                            this.loadAsyncData();
                            this.fields = {};
                            this.errors = {}
                        }
                    });
                }

            }).catch(err=>{
            
            })
        },

        initData(){
            this.user = JSON.parse(this.propUser)
        }
    },

    mounted(){
        this.getTrainings();
    },
    created() {
         this.initData();
    }
}
</script>


<style scoped src="../../../css/training.css">
</style>