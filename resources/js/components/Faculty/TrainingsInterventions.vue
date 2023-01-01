<template>
    <div>
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-8-desktop is-10-tablet">


                    <div class="box">
                        <div class="box-heading">
                            <div class="mb-5">
                                Trainings / Interventions / Certificates
                            </div>
                        </div>

                        <div class="box-body">
                           
                            <div class="buttons is-right">
                                <a class="button is-primary" href="/faculty/trainings-interventions/create">Add training</a>
                            </div>
                            <b-table
                                :data="data"
                                :loading="loading"
                                paginated
                                backend-pagination
                                :total="total"
                                :pagination-rounded="true"
                                :per-page="perPage"
                                @page-change="onPageChange"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page"
                                backend-sorting
                                :default-sort-direction="defaultSortDirection"
                                @sort="onSort">

                                <b-table-column field="learning_dev_id" label="ID" sortable v-slot="props">
                                    {{ props.row.learning_dev_id }}
                                </b-table-column>

                                <b-table-column field="title_learning_dev" label="Training Title" sortable v-slot="props">
                                    {{ props.row.title_learning_dev }}
                                </b-table-column>

                                
                                <b-table-column field="training_date" label="Training Date" sortable v-slot="props">
                                    {{ props.row.date_from }} to {{ props.row.date_to }}
                                </b-table-column>

                                <b-table-column field="no_hours" label="No. of Hours" sortable v-slot="props">
                                    {{ props.row.no_hours }}
                                </b-table-column>

                                <b-table-column field="type_ld" label="Type of LD" sortable v-slot="props">
                                    {{ props.row.type_ld }}
                                </b-table-column>

                                <b-table-column field="sponsored_by" label="Sponsored By" sortable v-slot="props">
                                    {{ props.row.sponsored_by }}
                                </b-table-column>

                                <b-table-column label="Action" v-slot="props">
                                    <div class="is-flex">
                                        <b-tooltip label="Update Information" type="is-warning">
                                            <b-button class="button is-small mr-1 is-warning" icon-right="pencil" tag="a" :href="`/faculty/trainings-interventions/${props.row.learning_dev_id}/edit`"></b-button>
                                        </b-tooltip>

                                        <b-tooltip label="Delete" type="is-danger">
                                            <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.learning_dev_id)"></b-button>
                                        </b-tooltip>
                                        
                                    </div>
                                </b-table-column>
                            </b-table>
                            
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
            data: [],
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

        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/faculty/get-learning-trainings?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },


        // getTrainings(){

        //     const params = [
        //         `sort_by=${this.sortField}.${this.sortOrder}`,
        //         `perpage=${this.perPage}`,
        //         `page=${this.page}`

        //     ].join('&')

        //     axios.get(`/faculty/get-learning-trainings?${params}`).then(res=>{
        //         this.trainings = res.data
        //     }).catch(err=>{
            
        //     })
        // },

        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },


        confirmDelete(learningId){
            this.$buefy.dialog.confirm({
                title: 'DELETE?',
                message: 'Are you sure you want to delete this information?',

                onConfirm: ()=>{
                    axios.delete('/faculty/learning-developments/' + learningId).then(res=>{
                        if(res.data.status === 'deleted'){
                            this.$buefy.toast.open({
                                message: `Deleted successfully.`,
                                type: 'is-primary'
                            })
                            this.loadAsyncData()
                        }
                    });
                }
            });
        },

        
        initData(){
            this.user = JSON.parse(this.propUser)
        }
    },

    mounted(){
        this.loadAsyncData();
    },
    created() {
         this.initData();
    }
}
</script>


<style scoped src="../../../css/training.css">
</style>