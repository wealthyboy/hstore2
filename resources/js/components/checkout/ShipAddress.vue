<template>
    <div class="">
            <div v-if="showForm"  id="stored_address"  class="billing-fields__field-wrapper ">
                <form  @submit.prevent="submit" method="POST" class="mt-2"> 
                    <div class="row reduce-gutters" id="add-new-address-form" data-action="/address/create">
                        <p class="form-group reduce-gutters col-lg-6">
                            <label for="first_name">First Name &nbsp;<abbr class="required " title="required">*</abbr></label>
                            <input  :class="{'has-danger': errors.first_name}"  id="firstname" 
                            v-model="form.first_name" 
                            @input="removeError($event)"  
                            @blur="vInput($event)" 
                            type="text" class="form-control required" 
                            name="first_name"
                            >
                            <span class="help-block error  text-danger text-sm-left" v-if="errors.first_name">
                                <strong   class="text-danger">{{ formatError(errors.first_name) }}</strong>
                            </span>
                        </p>
                        <p class="form-group reduce-gutters col-lg-6">
                            <label for="last_name">Last Name &nbsp;<abbr class="required " title="required">*</abbr></label>
                            <input id="lastname"
                                v-model="form.last_name"  
                                :class="{'has-danger': errors.first_name}"   
                                type="text"
                                @input="removeError($event)"  
                                @blur="vInput($event)"  
                                class="form-control required"
                                name="last_name" 
                            >
                            <span class="help-block error  text-danger text-sm-left" v-if="errors.last_name">
                                <strong   class="text-danger">{{ formatError(errors.last_name) }}</strong>
                            </span>
                        </p>

                        

                        <p class="form-group reduce-gutters col-lg-6">
                            <label for="email">Email</label>
                            <input id="email"  v-model="form.email" 
        
                            type="text" class="form-control" 
                            name="email"
                            >
                            
                        </p>
                        <p   class="form-group reduce-gutters col-lg-6">
                            <label for="phone_number">Phone Number &nbsp;<abbr class="required " title="required">*</abbr></label>
                            <input id="phone_number"
                                v-model="form.phone_number"  
                                :class="{'has-danger': errors.phone_number}"   
                                type="text"
                                @input="removeError($event)"  
                                @blur="vInput($event)"  
                                class="form-control required"
                                name="phone_number" 
                            >
                            <span class="help-block error  text-danger text-sm-left" v-if="errors.phone_number">
                                <strong   class="text-danger">{{ formatError(errors.phone_number) }}</strong>
                            </span>
                        </p>
                        <p class="form-group reduce-gutters col-md-12">
                            <label for="address">Address &nbsp;<abbr class="required " title="required">*</abbr></label>
                            <input id="address" 
                                v-model="form.address"
                                @input="removeError($event)"  
                                @blur="vInput($event)"  
                                :class="{'has-danger': errors.address}"   
                                type="text" class="form-control required" 
                                name="address" 
                            >
                            <span   v-if="errors.address">
                                <span   class="text-danger bold help-block">{{ formatError(errors.address) }}</span>
                            </span>
                        </p>
                        <p class="form-group reduce-gutters col-lg-12">
                            <label for="address_2">Address 2</label>
                            <input id="address_2"  v-model="form.address_2"  type="text" class="form-control" name="address_2"  autofocus autocomplete="off">
                        </p>
                        <p class="form-group  reduce-gutters col-lg-6">
                            <label for="locality">City &nbsp;<abbr class="required " title="required">*</abbr></label>
                            <input id="locality" 
                                v-model="form.city" 
                                @input="removeError($event)"  
                                @blur="vInput($event)"  
                                :class="{'has-danger': errors.city}"  
                                type="text" 
                                class="form-control required" 
                                name="city"
                            >
                            <span  v-if="errors.city">
                                <strong  class="text-danger">{{ formatError(errors.city) }}</strong>
                            </span>
                        </p>
                        <p class="form-group  reduce-gutters col-lg-6">
                            <label for="postal_code">Postcode</label>
                            <input id="postal_code" 
                                v-model="form.postal_code" 
                                type="text" class="form-control"
                                name="postal_code"
                            >
                        </p>
                        <p class="form-group reduce-gutters  col-sm-6 select-custom">
                            <label for="shipping_country">Country &nbsp;<abbr class="required" title="required">*</abbr></label>
                            <select @change="getState"  v-model="form.country_id"  name="country_id" id="shipping_country"   class="form-control required" autocomplete="country" tabindex="-1" aria-hidden="true">
                                <option value="" selected="selected">Select a country…</option>
                                <option :value="country.id" v-for="country in locations" :key="country.id">{{ country.name }}</option>
                            </select>
                            <span  class="" role="" v-if="errors.country_id">
                                <strong  class="text-capitalize text-danger"> Please select your country</strong>
                            </span>
                        </p>
                        <p class="form-group reduce-gutters col-sm-6  select-custom">
                            <label for="state_id" class="">State/Region &nbsp;<abbr class="required " title="required">*</abbr></label>
                            <select @change="getShipping"  v-model="form.state_id"  name="state_id" id="state_id" class="form-control required">
                                <option value="" >Select a state</option>
                                <option :value="state.id" v-for="(state,index) in states" :key="state.id" :selected="[index ? 'selected': '']">{{ state.name }}</option>
                            </select>
                            <span  class="text-danger" role="" v-if="errors.state_id">
                                <strong   class="text-danger"> Please select your state</strong>
                            </span>
                        </p>

                        <p class="form-group reduce-gutters text-right col-lg-12 ">
                            <button v-if="!addresses.length" type="submit" class="btn bold  border-raduis-btn btn--lg btn--primary btn--full" name="checkout_place_order" id="place_order" value="Place order" data-value="Place Order">
                                <span  v-if="submiting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Save & Continue
                            </button>
                            <p v-if="addresses.length" class="form-group col-6 col-md-6 text-left">
                                <button type="submit" class="btn btn--primary  border-raduis-btn py-3"  value="Submit">
                                    <span  v-if="submiting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Save 
                                </button>
                            </p>
                            <p v-if="addresses.length" class="form-group col-6 col-md-6 text-right align-items-center d-flex justify-content-end">
                                <a @click.prevent="cancelForm"  class="cancel-form bold color--primary pull-right" href="#">Cancel</a>
                            </p>
                        </p>
                    </div>
                </form>
            </div>

            <div v-if="addresses.length && !showForm"  class="address_details mt-2">
                <a href="#" class="btn btn--primary btn-round btn-lg btn-block mb-3 bold  border-raduis-btn"  @click.prevent="addNewAddress" id="enter-new-address"> + Add Address  </a>
                <ul class="">
                    <li class="mb-3" v-for="(location, index) in addresses" :key="location.id">
                        <div class="shipping-info border border-gray pr-3 pt-3 pl-3">
                            <div class="shipping-address-info">
                                <div  class="bold" id="">{{ location.first_name }} {{ location.last_name }}  </div>
                                <div class="text-muted" v-if="meta.isAdmin"> {{ location.email }} {{ location.phone_number }} </div>
                                <div class="text-muted"> {{ location.address }} {{ location.address2}} </div>
                                <div class="text-muted"> {{ location.city }} ,{{ location.state}}  {{ location.zip }}</div>
                                <div class="text-muted"> {{ location.country }} </div>
                                <p class="mt-2">
                                    <a  @click.prevent="editAddress(index)" data-placement="left"  href="#" class="ml-0 mr-4 btn  border btn-round  bold border-raduis-btn"> 
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a  @click.prevent="makeDefault($event,location.id)"  :id="location.id"  data-placement="left"  href="#" class="mr-4  btn  border btn-round  bold border-raduis-btn make-default"> 
                                        <i  class="fa fa-plus"></i> 
                                        <span  v-if="location.is_active >= 1"> 
                                        Default 
                                        </span>
                                        <span  v-else>
                                            <span v-if="id == location.id" class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>
                                            Use this address
                                        </span> 
                                    </a>
                                    <a  @click.prevent="removeAddress($event,location.id)"  :id="location.id" data-placement="left"  href="#" class="btn  border btn-round  bold border-raduis-btn "> <i class="fa fa-trash"></i>
                                        <span v-if="delete_id == location.id" class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>
                                        Delete
                                    </a>
                                </p>
                            </div>           
                        </div>
                    </li>
                </ul>
            </div>
        
    </div>
</template>
<script>
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
import ErrorMessage from "../messages/components/Error";

export default {
  props: {
    currency: String,
  },
  components: {
    ErrorMessage,
  },
  data() {
    return {
      hideForm: true,
      states: [],
      shipping_companies: [],
      country_states: [],
      submitStatus: null,
      state: "",
      id: null,
      delete_id: null,
      errorsBag: [],
      submiting: false,
      address_id: "",
      error: null,
      form: {
        first_name: "",
        last_name: "",
        customer_first_name: "",
        customer_last_name: "",
        address: "",
        address_2: "",
        city: "", 
        postal_code: "",
        country_id: "",
        state_id: "",
        email: "",
        phone_number: "",
      },
    };
  },
  computed: {
    ...mapGetters({
      locations: "locations",
      shipping: "shipping",
      addresses: "addresses",
      default_shipping: "default_shipping",
      errors: "errors",
      showForm: "showForm",
      meta: "meta",
    }),
  },
  created() {
    this.state = document.getElementById("state_id");
  },
  methods: {
    ...mapActions({
      createAddress: "createAddress",
      updateAddresses: "updateAddresses",
      updateLocations: "updateLocations",
      deleteAddress: "deleteAddress",
      getAddresses: "getAddresses",
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
    }),
    getState: function (evt, edit = false) {
      //console.log(evt)
      let value = evt.target.value;
       console.log( evt.target.value)

      let input = document.querySelectorAll(".required");
      this.clearErrors({ context: this, input: input });
      let state = [];

     // console.log( this.locations)
      //loop through all countries and pluck out their states
      this.locations.forEach((element) => {
        console.log(element.id, value)
        if (value == element.id) {
          state.push(element.states);
        }
      });

      console.log(state)
      this.states = state[0];
    },
    getShipping: function (e) {
      let value = e.target.value;
      let shipping = this.shipping[value];
      this.$store.commit("setDefaultShipping", shipping);
      let input = document.querySelectorAll(".required");
      this.clearErrors({ context: this, input: input });
    },
    formatError(error) {
      return Array.isArray(error) ? error[0] : error;
    },
    removeError(e) {
      let input = document.querySelectorAll(".required");
      if (e.target.name == "country_id") {
        this.form.state = "";
        this.states = this.country_states[e.target.value];
      }
      if (typeof input !== "undefined") {
        this.clearErrors({ context: this, input: input });
      }
    },
    vInput(e) {
      let input = document.querySelectorAll(".required");
      if (typeof input !== "undefined") {
        this.checkInput({ context: this, email: this.form.email, input: e });
      }
    },
    submit: function () {
      let input = document.querySelectorAll(".required");
      this.validateForm({ context: this, input: input });
      this.errorsBag = this.errors;
      if (Object.keys(this.errorsBag).length !== 0) {
        this.error = "Please check for errors";
        return false;
      }
      this.submiting = true;
      if (this.edit) {
        this.updateAddresses({
          form: this.form,
          id: this.address_id,
          context: this,
        }).then((response) => {
          this.showForm = false;
          this.submiting = false;
        });
        return;
      } else {
        this.createAddress({ form: this.form, context: this });
      }
    },
    addNewAddress: function () {
      this.edit = false;
      this.$store.commit("setShowForm", (this.showForm = !this.showForm));
    },
    cancelForm: function () {
      this.$store.commit("setShowForm", (this.showForm = !this.showForm));
      this.edit = false;
    },
    editAddress: function (index) {
      let address = this.addresses[index];
      this.form.first_name = address.first_name;
      this.form.last_name = address.last_name;
      this.form.email = address.email;
      
      this.form.phone_number = address.phone_number;
      this.form.address = address.address;
      this.form.city = address.city;
      this.form.postal_code = address.postal_code;
      this.form.country_id = address.country_id;
      let state = [];
      let ship_prices = [];
      this.getState(address.country_id, true);
      this.form.state_id = address.state_id;
      this.edit = true;
      this.address_id = address.id;
      console.log(address)
      
      this.$store.commit("setShowForm", true);
    },
    removeAddress: function (e, id) {
      this.submiting = true;
      this.delete_id = id;
      this.deleteAddress({
        id: id,
        context: this,
      }).then(() => {
        this.submiting = false;
      });
    },
    makeDefault: function (evt, id) {
      this.id = id;
      axios
        .get("/api/addresses/active/" + id)
        .then((response) => {
          this.$store.dispatch("setADl", response);
          this.submiting = false;
        })
        .catch(() => {});
    },
  },
};
</script>
