<template>
    <div>
        <div class="filter-container">
            <div>
                <b-field expanded>
                    <b-input type="text" expanded
                        placeholder="Search Lastname"
                        v-model="search.lname"></b-input>
                    <b-select expanded
                              placeholder="Seminars"
                              v-model="search.specialization">
                        <option value="">--NONE--</option>
                        <option v-for="(i, ix) in comboSeminars" :key="ix"
                                :value="i.specialization">{{ i.title }}</option>
                    </b-select>
                    <p class="control">
                        <b-button class="expanded" type="is-primary" label="..." @click="generateList"></b-button>
                    </p>
                </b-field>
                <b-field>

                </b-field>
            </div>
        </div>


        <!--modal create-->
        <b-modal v-model="modalTeacher" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>


            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Teacher List Information</p>
                    <button
                        type="button"
                        class="delete"
                        @click="modalTeacher = false"/>
                </header>
                <form @submit.prevent="submit">
                    <section class="modal-card-body">

                        <div class="">
                            <div class="column">

                                <b-field label="Teacher List Information">
                                    <b-input type="text"
                                        v-model="fields.list_information">
                                    </b-input>
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


        <div class="print-area">
            <div>
                <div>List of Teachers</div>
                <table class="table is-fullwidth is-narrow">
                    <tr>
                        <td></td>
                        <td>Name</td>
                        <td>Sex</td>
                        <td>Civil Status</td>
                        <td>Specialization/Skill</td>
                        <td>No of. Seminars</td>
                    </tr>
                    <tr v-for="(item, index) in data" :key="index">
                        <td>
                            <b-checkbox
                                v-model="item.select"
                            ></b-checkbox>
                        </td>
                        <td>{{  item.lname }}, {{  item.fname }} {{ item.mname }} {{  item.suffix }}</td>
                        <td>{{ item.sex }}</td>
                        <td>{{ item.civil_status }}</td>
                        <td>{{ item.specialization }}</td>
                        <td>{{ item.no_seminars }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="filter-container">
            <div class="buttons is-right">
                <b-button label="Forward List"
                          icon-right="arrow-right"
                          @click="openModalSubmitList"></b-button>
            </div>
        </div>

    </div>
</template>

<script>

export default{
    data(){
        return {
            data: [],

            specialization: '',
            fields: {
                list_information: '',
                teachers: []
            },

            search: {
                lname: '',
                specialization: '',

            },

            modalTeacher: false,
            comboSeminars: [],
        }
    },

    methods: {

        generateList(){
            const params = [
                `lname=${this.search.lname}`,
                `specialization=${this.search.specialization}`,
            ].join('&')

            axios.get(`/generate-list?${params}`).then(res=>{
                this.data = res.data
            }).catch(err=>{

            })
        },

        loadSeminars(){
            axios.get('/cid/get-seminar-specialization-list').then(res=>{
                this.comboSeminars = res.data
            })
        },

        openModalSubmitList(){
            this.modalTeacher = true
        },

        submit(){

            this.data.forEach(el=>{
                if(el.select){
                    //if check, push to fields
                    this.fields.teachers.push({
                        user_id: el.user_id,
                        lname: el.lname,
                        fname: el.fname,
                        mname: el.mname,
                        sex: el.sex,
                        specialization: el.specialization,
                        no_seminars: el.no_seminars,
                    });
                }
            })

            console.log(this.fields)

            axios.post('/cid/submit-teachers-list', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'Saved!',
                        type: 'is-success',
                        message: 'Successfully saved.'
                    });
                }
            })
        }
    },

    mounted(){
        this.loadSeminars()
    }
}
</script>

<style scoped>


    @media print {
        /*.myDivToPrint {*/
        /*    background-color: white;*/
        /*    height: 100%;*/
        /*    width: 100%;*/
        /*    position: fixed;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    margin: 0;*/
        /*    padding: 15px;*/
        /*    font-size: 14px;*/
        /*    line-height: 18px;*/
        /*}*/

        .myDivToPrint{
            margin: 0;
            color: #000;
            background-color: #fff;
            font-size: 14px;
            height: 100%;

        }
        .nprint{
            display: none;
        }
        header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
            display: none;
        }

        .buttons{
            display: none;
        }


        /* // if print display none elements */
        html body{
            background-color: white;
        }

        .footer-container{
            display: none;
        }

        .filter-container{
           display: none;
        }

    }

    .print-area{
        max-width: 816px;
        margin: 30px auto 0;
        background: white;
        margin: auto;
    }
    .filter-container{
        max-width: 816px;
        margin: 30px auto;
        background-color: white;
        padding: 25px;
    }

    .print-area{
        padding: 20px;
    }


</style>
