<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10-desktop is-12-tablet">
                    <div class="box">

                        <div class="is-flex mb-2" style="font-size: 20px; font-weight: bold;">LIST OF SEMINARS</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.lname" placeholder="Search Lastname"
                                                 @keyup.native.enter="loadAsyncData"/>
                                        <p class="control">
                                             <b-tooltip label="Search" type="is-success">
                                            <b-button type="is-primary" icon-right="magnify" @click="loadAsyncData"/>
                                             </b-tooltip>
                                        </p>
                                    </b-field>
                                </div>
                            </div>
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

                            <b-table-column field="name" label="Name" sortable v-slot="props">
                                {{ props.row.lname }}, {{  props.row.fname }} {{ props.row.mname }}
                            </b-table-column>

                            <b-table-column field="title_learning_dev" label="Title" sortable v-slot="props">
                                {{ props.row.title_learning_dev }},
                            </b-table-column>

                            <b-table-column field="date_inclusion" label="Date Inclusion" sortable v-slot="props">
                                {{ props.row.date_from }}, {{  props.row.date_to }}
                            </b-table-column>

                            <b-table-column field="no_hours" label="No. Hours" v-slot="props">
                                {{ props.row.no_hours }}
                            </b-table-column>

                            <b-table-column field="type_ld" label="Type of LD" v-slot="props">
                                {{ props.row.type_ld }}
                            </b-table-column>

                            <b-table-column field="sponsored_by" label="Sponsor" v-slot="props">
                                {{ props.row.sponsored_by }}
                            </b-table-column>

                            <b-table-column field="ratings" label="Rating" centered v-slot="props">
                                {{ props.row.ratings }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Rate" type="is-primary">
                                        <b-button class="button is-small mr-1" tag="a" 
                                            icon-right="message-draw" 
                                            @click="rateModal(props.row.learning_dev_id)"></b-button>
                                    </b-tooltip>
                                    <!-- <b-tooltip label="Reset Password" type="is-info">
                                        <b-button class="button is-small mr-1" icon-right="lock" @click="openModalResetPassword(props.row.user_id)"></b-button>
                                    </b-tooltip> -->
                                </div>
                            </b-table-column>
                        </b-table>

                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="modalRate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

           
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Rating</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalRate = false"/>
                    </header>
                    <form @submit.prevent="submitRating">
                        <section class="modal-card-body">
                        
                            
                        
                            <div class="">
                                <div class="column">

                                    <b-field label="Rating">
                                        <b-numberinput
                                            v-model="fields.rating"
                                            :controls="false"
                                            min="1">
                                        </b-numberinput>
                                    </b-field>
                                </div>

                            </div> <!-- div class-->
                        </section>
                        <footer class="modal-card-foot">
                            <button
                                class="button is-success">Submit Rating</button>
                        </footer>
                    </form>
                </div>
           
        </b-modal>
        <!--close modal-->


    </div> <!-- root div -->
</template>

<script>

export default{
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',
          
            search: {
                lname: '',
            },

            modalRate: false,

            errors: {},
            fields: {
                rating: 0
            },

            id: 0,
        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `lname=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/cid/get-seminar-list?${params}`)
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
        /*
        * Handle page-change event
        */
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


        //alert box ask for deletion
        confirmApprove(userid) {
            this.$buefy.dialog.confirm({
                title: 'Approve Account?',
                type: 'is-primary',
                message: 'Are you sure you want to approve this teacher?',
                cancelText: 'Cancel',
                confirmText: 'Approve?',
                onConfirm: () => this.approvedSubmit(userid)
            });
        },
        //execute delete after confirming
        approvedSubmit(userid) {
            axios.post('/hrld/teacher-approve-account/' + userid).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        rateModal(lId){
            this.modalRate = true
            this.id = lId;
        },

        submitRating(){
            axios.post('/cid/submit-rating/' + this.id , this.fields).then(res=>{
                if(res.data.status === 'rated'){
                    this.$buefy.dialog.alert({
                        title: 'Rated!',
                        type: 'is-success',
                        message: 'Successfully rated.'
                    });

                    this.modalRate = false
                    this.loadAsyncData()
                    this.fields.rating = 0;
                }
            }).catch(err=>{
            
            })
        }

    },

    mounted() {
        //this.loadOffices();
        this.loadAsyncData();

    }
}
</script>


<style scoped>
.verified{
        padding: 5px;
        color: white;
        background-color: green;
        font-weight: bold;
        font-size: .8em;
    }
    .unverified{
        padding: 5px;
        color: white;
        background-color: red;
        font-weight: bold;
        font-size: .8em;
    }




</style>
