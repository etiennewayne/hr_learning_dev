<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10-desktop is-12-tablet">
                    <div class="box">

                        <div class="is-flex mb-2" style="font-size: 20px; font-weight: bold;">LIST OF TEACHERS</div>

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

                            <b-table-column field="user_id" label="ID" sortable v-slot="props">
                                {{ props.row.user_id }}
                            </b-table-column>

                            <b-table-column field="username" label="Username" sortable v-slot="props">
                                {{ props.row.username }}
                            </b-table-column>

                            <b-table-column field="lname" label="Name" sortable v-slot="props">
                                {{ props.row.lname }}, {{ props.row.fname }} {{ props.row.mname }}
                            </b-table-column>

                            <b-table-column field="sex" label="Sex" v-slot="props">
                                {{ props.row.sex }}
                            </b-table-column>

                            <b-table-column field="email" label="Email" v-slot="props">
                                {{ props.row.email }}
                            </b-table-column>

                          

                            <b-table-column field="province" label="Residential" v-slot="props">
                                {{ props.row.residential_province.provDesc }}, {{ props.row.residential_city.citymunDesc }}
                            </b-table-column>

                            <b-table-column field="is_verified" label="Verified" centered v-slot="props">
                                <span class="verified" v-if="props.row.is_verified === 1">Verified</span>
                                <span class="unverified" v-else>Unverified</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Approve Account" type="is-primary" v-if="props.row.is_verified === 0">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="thumb-up-outline" @click="confirmApprove(props.row.user_id)"></b-button>
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




    </div>
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

            errors: {},
            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },


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
            axios.get(`/hrld/get-teacher-accounts?${params}`)
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
