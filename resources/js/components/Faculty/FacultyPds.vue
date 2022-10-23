<template>
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-8">
                <form @submit.prevent="submit">

                    <div class="box">
                        <div class="box-heading">
                            PERSONAL DATA SHEET
                        </div>

                        <b-steps
                            v-model="activeStep"
                            :animated="isAnimated"
                            :rounded="isRounded"
                            :has-navigation="hasNavigation"
                            :icon-prev="prevIcon"
                            :icon-next="nextIcon"
                            :label-position="labelPosition"
                            :mobile-mode="mobileMode">
                            <b-step-item step="1" label="Account" :clickable="isStepsClickable">

<!--                                <div class="is-size-4 has-text-weight-bold mb-4 has-text-centered">Personal Information</div>-->

                                <div class="separator">
                                    PERSONAL INFORMATION
                                </div>


                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Surname" label-position="on-border"
                                                    :type="this.errors.surname ? 'is-danger':''"
                                                    :message="this.errors.surname ? this.errors.surname[0] : ''">
                                            <b-input type="text" v-model="fields.surname" icon="account"></b-input>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="First Name" label-position="on-border"
                                                :type="this.errors.fname ? 'is-danger':''"
                                                :message="this.errors.fname ? this.errors.fname[0] : ''">
                                            <b-input type="text" v-model="fields.fname" placeholder="First Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-8">
                                        <b-field label="Middle Name" label-position="on-border"
                                                :type="this.errors.mname ? 'is-danger':''"
                                                :message="this.errors.mname ? this.errors.mname[0] : ''">
                                            <b-input type="text" v-model="fields.mname" placeholder="Middle Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Suffix" label-position="on-border"
                                                :type="this.errors.suffix ? 'is-danger':''"
                                                :message="this.errors.suffix ? this.errors.suffix[0] : ''">
                                            <b-input type="text" v-model="fields.suffix" placeholder="Suffix" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">

                                    <div class="column">
                                        <b-field label-position="on-border" label="Birthdate"
                                                 :type="this.errors.date_birth ? 'is-danger':''"
                                                 :message="this.errors.date_birth ? this.errors.date_birth[0] : ''">
                                            <b-datepicker icon="calendar" v-model="fields.date_birth" placeholder="Birthdate"></b-datepicker>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label-position="on-border" label="Place of Birth"
                                                 :type="this.errors.place_birth ? 'is-danger':''"
                                                 :message="this.errors.place_birth ? this.errors.place_birth[0] : ''">
                                            <b-input icon="map-marker-radius" v-model="fields.place_birth" placeholder="Place of Birth"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Sex" expanded label-position="on-border"
                                                 :type="this.errors.sex ? 'is-danger':''"
                                                 :message="this.errors.sex ? this.errors.sex[0] : ''">
                                            <b-select placeholder="Sex" v-model="fields.sex" icon="account" expanded>
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Civil Status" expanded label-position="on-border"
                                                 :type="this.errors.civil_status ? 'is-danger':''"
                                                 :message="this.errors.civil_status ? this.errors.civil_status[0] : ''">
                                            <b-select placeholder="Civil Status" v-model="fields.civil_status" icon="human-non-binary" expanded>
                                                <option v-for="(item, index) in civilStatuses" :key="index" :value="item.civil_status">
                                                    {{ item.civil_status }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label-position="on-border" label="Height(m)"
                                                 :type="this.errors.height ? 'is-danger':''"
                                                 :message="this.errors.height ? this.errors.height[0] : ''">
                                            <b-input icon="human-male-height-variant" v-model="fields.height" placeholder="Height(m)"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label-position="on-border" label="Weight(m)"
                                                 :type="this.errors.weight ? 'is-danger':''"
                                                 :message="this.errors.weight ? this.errors.weight[0] : ''">
                                            <b-input icon="weight" v-model="fields.weight" placeholder="Weight(m)"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Blood Type" expanded label-position="on-border"
                                                 :type="this.errors.blood_type ? 'is-danger':''"
                                                 :message="this.errors.blood_type ? this.errors.blood_type[0] : ''">
                                            <b-select placeholder="Blood Type" v-model="fields.blood_type" icon="water" expanded>
                                                <option value="O">O</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="GSIS" label-position="on-border">
                                            <b-input type="text" placeholder="GSIS" v-model="fields.gsis"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="PAGIBIG" label-position="on-border">
                                            <b-input type="text" placeholder="PAGIBIG" v-model="fields.pagibig"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="PhilHealth" label-position="on-border">
                                            <b-input type="text" placeholder="PhilHealth" v-model="fields.philhealth"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="SSS No." label-position="on-border">
                                            <b-input type="text" placeholder="SSS No." v-model="fields.sss"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="TIN" label-position="on-border">
                                            <b-input type="text" placeholder="TIN" v-model="fields.tin"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Agency No." label-position="on-border">
                                            <b-input type="text" placeholder="Agency No." v-model="fields.agency_no"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Citizenship" expanded label-position="on-border"
                                                 :type="this.errors.citizenship ? 'is-danger':''"
                                                 :message="this.errors.citizenship ? this.errors.citizenship[0] : ''">
                                            <b-select placeholder="Citizenship" v-model="fields.citizenship" icon="account-switch" expanded>
                                                <option v-for="(item, index) in citizenships" :key="index" :value="item.citizenship">
                                                    {{ item.citizenship }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <!-- RESIDENTIAL ADDRESS-->
                                <h2><span>RESIDENTIAL ADDRESS</span></h2>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Province" expanded label-position="on-border"
                                                 :type="this.errors.res_province ? 'is-danger':''"
                                                 :message="this.errors.res_province ? this.errors.res_province[0] : ''">
                                            <b-select v-model="fields.res_province" expanded placeholder="Province" @input="loadResCity">
                                                <option v-for="(item, index) in resProvinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="City/Municipality" expanded label-position="on-border"
                                                 :type="this.errors.res_city ? 'is-danger':''"
                                                 :message="this.errors.res_city ? this.errors.res_city[0] : ''">
                                            <b-select expanded v-model="fields.res_city" placeholder="City" @input="loadResBarangay">
                                                <option v-for="(item, index) in resCities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Barangay" expanded label-position="on-border"
                                                 :type="this.errors.res_barangay ? 'is-danger':''"
                                                 :message="this.errors.res_barangay ? this.errors.res_barangay[0] : ''">
                                            <b-select v-model="fields.res_barangay" expanded placeholder="Barangay">
                                                <option v-for="(item, index) in resBarangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Street" label-position="on-border">
                                            <b-input type="text" v-model="fields.res_street"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="House/Block No" label-position="on-border">
                                            <b-input type="text" v-model="fields.res_houseno_blockno"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Zip Code" label-position="on-border">
                                            <b-input type="text" v-model="fields.res_zipcode"></b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <!-- PERMANENT ADDRESS-->
                                <h2><span>PERMANENT ADDRESS</span></h2>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Province" expanded label-position="on-border"
                                                 :type="this.errors.per_province ? 'is-danger':''"
                                                 :message="this.errors.per_province ? this.errors.per_province[0] : ''">
                                            <b-select v-model="fields.per_province" expanded placeholder="Province" @input="loadPerCity">
                                                <option v-for="(item, index) in perProvinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="City/Municipality" expanded label-position="on-border"
                                                 :type="this.errors.per_city ? 'is-danger':''"
                                                 :message="this.errors.per_city ? this.errors.per_city[0] : ''">
                                            <b-select expanded v-model="fields.per_city" placeholder="City" @input="loadPerBarangay">
                                                <option v-for="(item, index) in perCities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Barangay" expanded label-position="on-border"
                                                 :type="this.errors.per_barangay ? 'is-danger':''"
                                                 :message="this.errors.per_barangay ? this.errors.per_barangay[0] : ''">
                                            <b-select v-model="fields.per_barangay" expanded placeholder="Barangay">
                                                <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Street" label-position="on-border">
                                            <b-input type="text" v-model="fields.per_street"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="House/Block No" label-position="on-border">
                                            <b-input type="text" v-model="fields.per_houseno_blockno"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Zip Code" label-position="on-border">
                                            <b-input type="text" v-model="fields.per_zipcode"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Tel No."
                                                 :type="this.errors.tel_no ? 'is-danger':''"
                                                 :message="this.errors.tel_no ? this.errors.tel_no[0] : ''">
                                            <b-input type="text" v-model="fields.tel_no" icon="email" placeholder="Tel No."></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Contact No."
                                                 :type="this.errors.contact_no ? 'is-danger':''"
                                                 :message="this.errors.contact_no ? this.errors.contact_no[0] : ''">
                                            <b-input type="text" v-model="fields.contact_no" icon=""></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Email"
                                                 :type="this.errors.email ? 'is-danger':''"
                                                 :message="this.errors.email ? this.errors.email[0] : ''">
                                            <b-input type="email" v-model="fields.email" icon="email"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="separator">
                                    FAMILY BACKGROUND
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Spouse Surname" label-position="on-border"
                                                 :type="this.errors.spouse_surname ? 'is-danger':''"
                                                 :message="this.errors.spouse_surname ? this.errors.spouse_surname[0] : ''">
                                            <b-input type="text" v-model="fields.spouse_surname" placeholder="Spouse Surname" icon="account"></b-input>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="Spouse First Name" label-position="on-border"
                                                 :type="this.errors.spouse_fname ? 'is-danger':''"
                                                 :message="this.errors.spouse_fname ? this.errors.spouse_fname[0] : ''">
                                            <b-input type="text" v-model="fields.spouse_fname" placeholder="Spouse First Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-8">
                                        <b-field label="Spouse Middle Name" label-position="on-border"
                                                 :type="this.errors.spouse_mname ? 'is-danger':''"
                                                 :message="this.errors.spouse_mname ? this.errors.spouse_mname[0] : ''">
                                            <b-input type="text" v-model="fields.spouse_mname" placeholder="Spouse Middle Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Spouse Suffix" label-position="on-border"
                                                 :type="this.errors.spouse_suffix ? 'is-danger':''"
                                                 :message="this.errors.spouse_suffix ? this.errors.spouse_suffix[0] : ''">
                                            <b-input type="text" v-model="fields.spouse_suffix" placeholder="Spouse Suffix" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Employer/Business Name" label-position="on-border"
                                                 :type="this.errors.business_name ? 'is-danger':''"
                                                 :message="this.errors.business_name ? this.errors.business_name[0] : ''">
                                            <b-input type="text" v-model="fields.business_name" placeholder="Employer/Business Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Business Address" label-position="on-border"
                                                 :type="this.errors.business_address ? 'is-danger':''"
                                                 :message="this.errors.business_address ? this.errors.business_address[0] : ''">
                                            <b-input type="text" v-model="fields.business_address" placeholder="Business Address" icon="account"></b-input>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="Contact No." label-position="on-border"
                                                 :type="this.errors.business_contact_no ? 'is-danger':''"
                                                 :message="this.errors.business_contact_no ? this.errors.business_contact_no[0] : ''">
                                            <b-input type="text" v-model="fields.business_contact_no" placeholder="Contact No." icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <!--FATHER INFORMATION-->
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Father Surname" label-position="on-border"
                                                 :type="this.errors.father_surname ? 'is-danger':''"
                                                 :message="this.errors.father_surname ? this.errors.father_surname[0] : ''">
                                            <b-input type="text" v-model="fields.father_surname" placeholder="Father Surname" icon="account"></b-input>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="Father First Name" label-position="on-border"
                                                 :type="this.errors.father_fname ? 'is-danger':''"
                                                 :message="this.errors.father_fname ? this.errors.father_fname[0] : ''">
                                            <b-input type="text" v-model="fields.father_fname" placeholder="Father First Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-8">
                                        <b-field label="Father Middle Name" label-position="on-border"
                                                 :type="this.errors.father_mname ? 'is-danger':''"
                                                 :message="this.errors.father_mname ? this.errors.father_mname[0] : ''">
                                            <b-input type="text" v-model="fields.father_mname" placeholder="Father Middle Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Father Suffix" label-position="on-border"
                                                 :type="this.errors.father_suffix ? 'is-danger':''"
                                                 :message="this.errors.father_suffix ? this.errors.father_suffix[0] : ''">
                                            <b-input type="text" v-model="fields.father_suffix" placeholder="Father Suffix" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <!--MOTHER INFORMATION-->
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Mother Maiden Name" label-position="on-border"
                                                 :type="this.errors.mother_maiden_name ? 'is-danger':''"
                                                 :message="this.errors.mother_maiden_name ? this.errors.mother_maiden_name[0] : ''">
                                            <b-input type="text" v-model="fields.mother_maiden_name" placeholder="Mothers Maiden Name" icon="account"></b-input>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="Mother First Name" label-position="on-border"
                                                 :type="this.errors.mother_fname ? 'is-danger':''"
                                                 :message="this.errors.mother_fname ? this.errors.mother_fname[0] : ''">
                                            <b-input type="text" v-model="fields.mother_fname" placeholder="Mother First Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-8">
                                        <b-field label="Mother Middle Name" label-position="on-border"
                                                 :type="this.errors.mother_mname ? 'is-danger':''"
                                                 :message="this.errors.mother_mname ? this.errors.mother_mname[0] : ''">
                                            <b-input type="text" v-model="fields.mother_mname" placeholder="Mother Middle Name" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Mother Suffix" label-position="on-border"
                                                 :type="this.errors.mother_suffix ? 'is-danger':''"
                                                 :message="this.errors.mother_suffix ? this.errors.mother_suffix[0] : ''">
                                            <b-input type="text" v-model="fields.mother_suffix" placeholder="Father Suffix" icon="account"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <h2><span>CHILDREN</span></h2>
                                <div v-for="(item, k) in this.fields.children" :key="k">
                                    <div class="columns">
                                        <div class="column">
                                            <b-field label="Fullname" label-position="on-border">
                                                <b-input type="text" v-model="item.fullname" placeholder="Fullname" required></b-input>
                                            </b-field>
                                        </div>
                                        <div class="column">
                                            <b-field label="Date of Birth (mm/dd/yyyy)" label-position="on-border">
                                                <b-datepicker editable v-model="item.date_birth"
                                                              placeholder="Date Birth" required> </b-datepicker>
                                                <p class="control">
                                                    <b-button @click="removeChild(k)" v-show="k || ( !k && fields.children.length > 0)" type="is-danger" icon-left="delete"></b-button>
                                                </p>
                                            </b-field>
                                        </div>
                                    </div><!--cols-->
                                </div>

                                <b-button @click="addChild" type="is-success mb-4 mt-4" class="is-small" icon-left="plus">ADD</b-button>



                            </b-step-item>

                            <b-step-item step="2" label="Profile" :clickable="isStepsClickable" :type="{'is-success': isProfileSuccess}">
                                <h1 class="title has-text-centered">Profile</h1>
                                Lorem ipsum dolor sit amet.
                            </b-step-item>

                            <b-step-item step="3" :visible="showSocial" label="Social" :clickable="isStepsClickable">
                                <h1 class="title has-text-centered">Social</h1>
                                Lorem ipsum dolor sit amet.
                            </b-step-item>

                            <b-step-item :step="showSocial ? '4' : '3'" label="Finish" :clickable="isStepsClickable" disabled>
                                <h1 class="title has-text-centered">Finish</h1>
                                Lorem ipsum dolor sit amet.
                            </b-step-item>

                            <template
                                v-if="customNavigation"
                                #navigation="{previous, next}">
                                <b-button
                                    outlined
                                    type="is-danger"
                                    icon-pack="fas"
                                    icon-left="backward"
                                    :disabled="previous.disabled"
                                    @click.prevent="previous.action">
                                    Previous
                                </b-button>
                                <b-button
                                    outlined
                                    type="is-success"
                                    icon-pack="fas"
                                    icon-right="forward"
                                    :disabled="next.disabled"
                                    @click.prevent="next.action">
                                    Next
                                </b-button>
                            </template>
                        </b-steps>










                        <div class="buttons is-right">
                            <button class="button is-primary">Register</button>
                        </div>


                    </div> <!--panel-->

                </form>
            </div><!--column-->
        </div><!--cols-->
    </section>
</template>

<script>
export default {

    props: ['propCivils', 'propCitizenships'],

    data(){
        return{

            activeStep: 0,

            showSocial: false,
            isAnimated: true,
            isRounded: true,
            isStepsClickable: false,

            hasNavigation: true,
            customNavigation: false,
            isProfileSuccess: false,

            prevIcon: 'chevron-left',
            nextIcon: 'chevron-right',
            labelPosition: 'bottom',
            mobileMode: 'minimalist',

            fields: {
                children: [],
            },
            errors: {},

            civilStatuses: [],
            citizenships: [],

            resProvinces: [],
            resCities: [],
            resBarangays: [],

            perProvinces: [],
            perCities: [],
            perBarangays: [],
        }
    },
    methods: {
        //ADDRESS
        loadProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.resProvinces = res.data;
                this.perProvinces = res.data;
            })
        },
        loadResCity: function(){
            axios.get('/load-cities?prov=' + this.fields.res_province).then(res=>{
                this.resCities = res.data;
            })
        },

        loadResBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.res_province + '&city_code='+this.fields.res_city).then(res=>{
                this.resBarangays = res.data;
            })
        },
        loadPerCity: function(){
            axios.get('/load-cities?prov=' + this.fields.per_province).then(res=>{
                this.perCities = res.data;
            })
        },

        loadPerBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.per_province + '&city_code='+this.fields.per_city).then(res=>{
                this.perBarangays = res.data;
            })
        },

        initData(){
            this.civilStatuses = JSON.parse(this.propCivils);
            this.citizenships = JSON.parse(this.propCitizenships);

        },

        submit(){
            axios.post('/sign-up', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: "SAVED!",
                        message: 'Register successfully',
                        type: 'is-success',
                        onConfirm: ()=>  window.location = '/'
                    });
                }

            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }else{
                    alert('An error occured.');
                }
            });
        },


        addChild() {
            this.fields.children.push({
                user_id: 0,
                fullname: '',
                date_birth: null,
            });
        },
        removeChild(index){
            //alert(index);
            this.$buefy.dialog.confirm({
                title: 'DELETE?',
                message: 'Are you sure you want to delete this information?',

                onConfirm: ()=>{
                    let childId = this.fields.children[index].user_id;

                    if(childId > 0){
                        axios.delete('/faculty/delete-child/' + childId).then(res=>{
                            if(res.data.status === 'deleted'){
                                this.$buefy.toast.open({
                                    message: `Resident deleted successfully.`,
                                    type: 'is-primary'
                                })
                            }
                        });
                    }
                    //console.log(siblingId);
                    this.fields.children.splice(index, 1);
                }
            });

        },

    },
    mounted() {
        this.initData();
        this.loadProvince();
    }
}
</script>

<style scoped>

    .box-heading{
        font-weight: bold;
        font-size: 1.4em;
        margin: 15px auto;
        text-align: center;
    }

    .box{
        border-top: 5px solid blue;
    }

    .separator{
        background-color: blue;
        padding: 5px 5px 5px 15px;
        font-weight: bold;
        color: white;
        margin-bottom: 25px;
    }


/*    dere lang kubia ang panel color*/
</style>
